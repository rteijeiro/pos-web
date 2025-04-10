<?php
include 'connection/controller.php';
include 'connection/db.php';
$categories = getCategory($pdo);

$mesa = isset($_GET['mesa']) ? htmlspecialchars($_GET['mesa']) : 'Mesa ?';
$comensales = isset($_GET['comensales']) ? htmlspecialchars($_GET['comensales']) : '?';
$usuario = isset($_GET['user']) ? htmlspecialchars($_GET['user']) : 'Usuario';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TPV Restaurante</title>
    <link rel="stylesheet" href="css/restaurant.css" />
</head>
<script>
    let selectedMesa = "<?= $mesa ?>";
    let calcInput = "";
</script>
<body>
    <div class="container">
        <!-- Left panel - orders -->
        <div class="ticket">
            <div class="ticket-header">
                <h3>Table <?= $mesa ?></h3>
                <span><?= $usuario ?></span><br>
                <span><?= $comensales ?> guests</span>
            </div>

            <!-- Dynamic order table -->
            <table id="order-table">
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="order-table-body"></tbody>
            </table>

            <div class="total">
                <h2>Total <span id="total-amount">0,00 €</span></h2>
            </div>

            <!-- Calculator -->
            <div class="calculator simple-calc">
                <input type="text" id="calc-display" readonly>
                <div class="calc-buttons">
                    <button onclick="addToCalc('7')">7</button>
                    <button onclick="addToCalc('8')">8</button>
                    <button onclick="addToCalc('9')">9</button>
                    <button onclick="setDiscount('%')">DTO%</button>
                    <button onclick="addToCalc('4')">4</button>
                    <button onclick="addToCalc('5')">5</button>
                    <button onclick="addToCalc('6')">6</button>
                    <button onclick="setDiscount('€')">DTO €</button>
                    <button onclick="addToCalc('1')">1</button>
                    <button onclick="addToCalc('2')">2</button>
                    <button onclick="addToCalc('3')">3</button>
                    <button onclick="clearCalc()">CLR</button>
                    <button onclick="addToCalc('0')">0</button>
                    <button onclick="addToCalc('.')">.</button>
                    <button onclick="addToCalc('/')">PREC</button>
                    <button onclick="applyToTotal()" class="apply-btn">Apply</button>
                </div>
            </div>
        </div>

        <!-- Right panel - Categories and products -->
        <div class="right-panel">
            <div class="categories">
                <?php foreach ($categories as $category): ?>
                    <div class="category" onclick="loadProducts(<?= $category['id'] ?>)">
                        <img src="carta_seccion_3/<?php echo htmlspecialchars($category['img']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>">
                        <span><?= $category['name'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div id="products-container" class="products-container"></div>
        </div>

        <!-- Bottom menu buttons -->
        <div class="menu-buttons">
            <button>Print</button>
            <button id="savePaymentBtn">Payment</button>
            <button>Delete Line</button>
            <button>Add Note</button>
            <button>Open Drawer</button>
            <button class="red-btn">Cancel Ticket</button>
            <button>Open Tickets</button>
            <button onclick="changeTable()">Change Table</button>
            <button>Split Ticket</button>
            <button class="yellow-btn">Payments</button>
            <button>Others</button>
            <button>Log Out</button>
            <button onclick="window.location.href='tables.php?user=<?php echo $usuario; ?>'">Back</button>
        </div>
    </div>

    <script src="js/restaurant.js"></script>
    <script src="js/calculator.js"></script>
    <script>
function getTotalPrice() {
  return parseFloat(
    document.getElementById("total-amount").textContent.replace("€", "").trim()
  );
}

function addToCalc(val) {
  if (val === '%' || val === '€') return;
  calcInput += val;
  document.getElementById("calc-display").value = calcInput;
}

function setDiscount(type) {
  if (type === '%') {
    calcInput += '%';
  } else if (type === '€') {
    calcInput += '€';
  }
  document.getElementById("calc-display").value = calcInput;
}

function clearCalc() {
  calcInput = "";
  document.getElementById("calc-display").value = "";
}

function applyToTotal() {
  try {
    let totalPrice = getTotalPrice(); // Get the updated total price from the page
    let newTotal = totalPrice;

    // Apply percentage discount
    if (calcInput.includes('%')) {
      const discountPercent = parseFloat(calcInput.replace('%', '')) / 100;
      newTotal = totalPrice - totalPrice * discountPercent;
    } 
    // Apply fixed discount in euros
    else if (calcInput.includes('€')) {
      const discountEuro = parseFloat(calcInput.replace('€', ''));
      newTotal = totalPrice - discountEuro;
    } 
    // If it is not a percentage or euro, we treat it as a direct price
    else {
      newTotal = parseFloat(calcInput);
      if (isNaN(newTotal)) throw new Error("Invalid number");
    }

    // Validate that the new total is a valid number and is not negative
    if (isNaN(newTotal)) throw new Error("Invalid operation");
    if (newTotal < 0) newTotal = 0;  // Do not allow negative values

    // Update the total on the page
    document.getElementById("total-amount").textContent = newTotal.toFixed(2) + " €";

    // Clean the calculator
    clearCalc();
  } catch (e) {
    alert("Operación inválida");
    clearCalc();
  }
}
        // Save payment
        document.getElementById("savePaymentBtn").addEventListener("click", function () {
            const id = 1;
            const date = new Date().toISOString().split("T")[0];
            const total = parseFloat(document.getElementById("total-amount").textContent.replace("€", "").trim());

            if (isNaN(total) || total <= 0) {
                alert("El total no es válido. Asegúrate de que haya productos en el pedido.");
                return;
            }

            fetch("savePayment.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id, date, total }),
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                localStorage.removeItem('mesa_' + selectedMesa);
                localStorage.removeItem('mesa_' + selectedMesa + '_ocupada');
                window.location.reload();
            })
            .catch(error => {
                alert("Error al procesar el pago: " + error);
            });
        });
    </script>
    <script>
    const comensalesJS = "<?= $comensales ?>";
    const usuarioJS = "<?= $usuario ?>";


    
  function changeTable() {
    const newMesa = prompt("Introduce el número de la nueva mesa:");
    if (!newMesa || newMesa === selectedMesa) return;

    // Verificar si ya existe orden en la nueva mesa
    const newOrderKey = 'mesa_' + newMesa;
    const existingOrder = localStorage.getItem(newOrderKey);
    if (existingOrder && !confirm(`¡La mesa ${newMesa} ya tiene un pedido! ¿Sobreescribir?`)) return;

    // Transferir datos al nuevo localStorage
    const oldMesa = selectedMesa;
    const oldOrderKey = 'mesa_' + oldMesa;
    const oldOrder = localStorage.getItem(oldOrderKey);

    if (oldOrder) {
        localStorage.setItem(newOrderKey, oldOrder);
        localStorage.removeItem(oldOrderKey);
    }

    // Actualizar estado de ocupación
    localStorage.removeItem(`mesa_${oldMesa}_ocupada`);
    localStorage.setItem(`mesa_${newMesa}_ocupada`, 'true');

    // Actualizar variables y UI

    selectedMesa = newMesa;
    
    // Actualizar URL
    window.history.replaceState({}, '', `?mesa=${newMesa}&comensales=${comensalesJS}&user=${usuarioJS}`);

    // Recargar pedido de la nueva mesa
    loadSavedOrder();
}
</script>
</body>
</html>
