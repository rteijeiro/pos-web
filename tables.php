<?php
$users = isset($_GET['users']) ? htmlspecialchars($_GET['users']) : 'desconocido';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TPV: <?php echo $users; ?></title>
    <link rel="stylesheet" href="css/tables.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar visual -->
        <div class="sidebar">
            <p>TPV: <?php echo $users ?></p>
            <h2>Seleccionar Mesa</h2>
            <button class="establecimiento">Establecimiento</button>
            
        </div>

        <div class="main-content">
            <div class="mapa">
                <?php for ($i = 1; $i <= 9; $i++): ?>
                    <div class="mesa-link" data-mesa="<?= $i ?>">
                        <div class="mesa-box">Mesa <?= $i ?></div>
                    </div>
                <?php endfor; ?>

                <div class="barra">
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <div class="asiento" id="B<?= $i ?>">B<?= $i ?></div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom menu -->
    <div class="menu-inferior">
        <button>Centros de Venta</button>
        <button>Reservas Online</button>
        <button>Otros</button>
        <button>Cerrar Sesión</button>
    </div>

    <!-- Modal para número de comensales -->
    <div class="modal" id="mesaModal">
        <div class="modal-content">
            <h2>TPV: <?php echo $users; ?></h2>
            <p>Number of guests</p>
            <input type="text" id="comensalesInput" class="input-display" readonly>
            <div class="keypad">
                <button onclick="appendNumber('1')">1</button>
                <button onclick="appendNumber('2')">2</button>
                <button onclick="appendNumber('3')">3</button>
                <button onclick="appendNumber('4')">4</button>
                <button onclick="appendNumber('5')">5</button>
                <button onclick="appendNumber('6')">6</button>
                <button onclick="appendNumber('7')">7</button>
                <button onclick="appendNumber('8')">8</button>
                <button onclick="appendNumber('9')">9</button>
                <button onclick="clearInput()">CLR</button>
                <button onclick="appendNumber('0')">0</button>
                <button onclick="confirmMesa()">ENT</button>
            </div>
        </div>
    </div>

    <script src="js/tables.js"></script>
</body>
</html>
