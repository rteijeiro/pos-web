<?php 
include 'connection/controller.php';
include 'connection/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restaurante</title>
    <link rel="stylesheet" href="css/restaurant.css" />
   
</head>
<body>
    <?php
   
    $categories = getCategory($pdo);
    ?>
    
    <!-- Left panel - orders -->
    <div class="left-panel">
        <h2>Pedido Actual</h2>
        <div id="order-list"></div>
        <h3>Total: <span id="total-amount">0.00 €</span></h3>

        <!-- Calculator -->
        <div class="calculator">
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
                <button onclick="applyToTotal()" class="apply-btn">Aplicar</button>
            </div>
        </div>
    </div>

    </div>

    <!-- right panel - Category y Products -->
    <div class="right-panel">
        <div class="categories">
            <?php foreach ($categories as $category): ?>
                <div class="category" 
                     onclick="loadProducts(<?= $category['id'] ?>)">
                    <img src="<?= $category['img'] ?>" alt="<?= $category['name'] ?>">
                    <span><?= $category['name'] ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Container of products -->
        <div id="products-container" class="products-container"></div>
    </div>
    <script src="js/restaurant.js"></script>
    <script src="js/calculator.js"></script>
</body>
</html>