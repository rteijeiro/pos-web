<?php
// Get the username from the URL parameter, or set it as 'desconocido' if not provided
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

    <!-- Navigation bar with username -->
    <div class="navbar">
        <h1>TPV: <?php echo $users; ?></h1>
        <p>Select a table</p>
    </div>

    <!-- Table selection area -->
    <div class="mesas-container">
        <div class="mesa-link" onclick="openModal(1)">
            <div class="mesa-box">Table 1</div>
        </div>
        <div class="mesa-link" onclick="openModal(2)">
            <div class="mesa-box">Table 2</div>
        </div>
        <div class="mesa-link" onclick="openModal(3)">
            <div class="mesa-box">Table 3</div>
        </div>
    </div>

    <!-- Modal -->
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

