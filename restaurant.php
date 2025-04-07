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
            <button>Change Table</button>
            <button>Split Ticket</button>
            <button class="yellow-btn">Payments</button>
            <button>Others</button>
            <button>Log Out</button>
        </div>
    </div>

    <script src="js/restaurant.js"></script>
    <script src="js/calculator.js"></script>
    <script>
        // Add numbers or symbols to calculator
        function addToCalc(val) {
            calcInput += val;
            document.getElementById("calc-display").value = calcInput;
        }

        // Prompt discount input
        function setDiscount(type) {
            const input = prompt(`Enter discount in ${type}`);
            if (!input || isNaN(input)) {
                alert("Invalid input");
                return;
            }
            calcInput = type === '%' ? input + '%' : input + '€';
            document.getElementById("calc-display").value = calcInput;
        }

        // Clear calculator
        function clearCalc() {
            calcInput = "";
            document.getElementById("calc-display").value = "";
        }

        // Apply discount or amount
        function applyToTotal() {
            try {
                let totalPrice = parseFloat(document.getElementById("total-amount").textContent.replace("€", "").trim());
                let newTotal = totalPrice;

                if (calcInput.includes('%')) {
                    const discountPercent = parseFloat(calcInput.replace('%', ''));
                    if (isNaN(discountPercent)) throw new Error("Invalid % discount");
                    newTotal -= totalPrice * (discountPercent / 100);
                } else if (calcInput.includes('€')) {
                    const discountEuro = parseFloat(calcInput.replace('€', ''));
                    if (isNaN(discountEuro)) throw new Error("Invalid € discount");
                    newTotal -= discountEuro;
                } else {
                    const value = parseFloat(calcInput);
                    if (isNaN(value)) throw new Error("Invalid direct input");
                    newTotal = value;
                }

                if (newTotal < 0) newTotal = 0;
                document.getElementById("total-amount").textContent = newTotal.toFixed(2) + " €";
                clearCalc();
            } catch {
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
</body>
</html>
