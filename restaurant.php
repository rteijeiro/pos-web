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
            <th></th> <!-- For delete button -->
        </tr>
    </thead>
    <tbody id="order-table-body">
        <!-- Rows inserted via JS -->
    </tbody>
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
        <button onclick="addToCalc('+')">DTO%</button>
        <button onclick="addToCalc('4')">4</button>
        <button onclick="addToCalc('5')">5</button>
        <button onclick="addToCalc('6')">6</button>
        <button onclick="addToCalc('-')">DTO €</button>
        <button onclick="addToCalc('1')">1</button>
        <button onclick="addToCalc('2')">2</button>
        <button onclick="addToCalc('3')">3</button>
        <button onclick="addToCalc('*')">CAN</button>
        <button onclick="addToCalc('0')">0</button>
        <button onclick="addToCalc('.')">.</button>
        <button onclick="clearCalc()">CLR</button> 
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
                <img src="carta_seccion_3/<?php echo htmlspecialchars($category['img']); ?>"
                     alt="<?php echo htmlspecialchars($category['name']); ?>">
                <span><?= $category['name'] ?></span>
            </div>
        <?php endforeach; ?>
    </div>
    <div id="products-container" class="products-container"></div>
</div>

<!-- Bottom menu buttons -->
<div class="menu-buttons">
    <button>Print</button>
    <button>Cash Payment</button>
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
    let calcInput = "";
    function addToCalc(val) {
        calcInput += val;
        document.getElementById("calc-display").value = calcInput;
    }
    function clearCalc() {
        calcInput = "";
        document.getElementById("calc-display").value = "";
    }
    function applyToTotal() {
        try {
            const result = eval(calcInput);
            alert("Apply: " + result);
            clearCalc();
        } catch {
            alert("Invalid operation");
            clearCalc();
        }
    }
</script>
</body>
</html>
