<?php 
include 'connection/controller.php';
include 'connection/db.php';
$categories = getCategory($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TPV Restaurante</title>
    <link rel="stylesheet" href="css/carta.css" />
</head>
<body>
    <div class="container">
        <!-- Left panel - orders -->
        <div class="ticket">
    <div class="ticket-header">
        <h3>Salón S6</h3>
        <span>Mauricio</span>
    </div>

    <!-- Tabla de pedido dinámica -->
    <table id="order-table">
        <thead>
            <tr>
                <th>Uds</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Total</th>
                <th></th> <!-- Para botón eliminar -->
            </tr>
        </thead>
        <tbody id="order-table-body">
            <!-- Filas se insertan con JS -->
        </tbody>
    </table>

    <div class="total">
        <h2>Total <span id="total-amount">0,00 €</span></h2>
    </div>

    <!-- Calculadora -->
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
            <button onclick="applyToTotal()" class="apply-btn">Aplicar</button>
        </div>
    </div>
</div>


        <!-- Panel derecho - Categorías y productos -->
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

        <!-- Botones inferiores -->
        <div class="menu-botones">
            <button>Imprimir</button>
            <button>Cobrar en Efectivo</button>
            <button>Borrar Línea</button>
            <button>Añadir Nota</button>
            <button>Abrir Cajón</button>
            <button class="red-btn">Cancelar Ticket</button>
            <button>Tickets Abiertos</button>
            <button>Cambiar Mesa</button>
            <button>Dividir Ticket</button>
            <button class="yellow-btn">Pagos</button>
            <button>Otros</button>
            <button>Cerrar Sesión</button>
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
                alert("Aplicar: " + result);
                clearCalc();
            } catch {
                alert("Operación inválida");
                clearCalc();
            }
        }
    </script>
</body>
</html>

