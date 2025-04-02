<?php
// Get the username from the URL parameter, or set it as 'desconocido' if not provided
$usuario = isset($_GET['usuario']) ? htmlspecialchars($_GET['usuario']) : 'desconocido';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TPV: <?php echo $usuario; ?></title>
    <link rel="stylesheet" href="/css/tables.css">
</head>
<body>

    <!-- Navigation bar with username -->
    <div class="navbar">
        <h1>TPV: <?php echo $usuario; ?></h1>
        <p>Select a table</p>
    </div>

    <!-- Table selection area -->
    <div class="mesas-container">
        <div class="mesa-link" onclick="openModal(1)">
            <div class="mesa-box">Mesa 1</div>
        </div>
        <div class="mesa-link" onclick="openModal(2)">
            <div class="mesa-box">Mesa 2</div>
        </div>
        <div class="mesa-link" onclick="openModal(3)">
            <div class="mesa-box">Mesa 3</div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="mesaModal">
        <div class="modal-content">
            <h2>TPV: <?php echo $usuario; ?></h2>
            <p>Número de comensales</p>
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
    <script src="../javascript/tables.js"></script>
</body>
</html>

