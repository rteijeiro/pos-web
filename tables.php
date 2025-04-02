<?php
// Get the username from the URL parameter, or set it as 'desconocido' if not provided
$usuario = isset($_GET['user']) ? htmlspecialchars($_GET['user']) : 'desconocido';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TPV: <?php echo $usuario; ?></title>
    <link rel="stylesheet" href="../css/tables.css">
</head>
<body>
    <!-- Navigation bar with username and title -->
    <div class="navbar">
        <h1>TPV: <?php echo $usuario; ?></h1>
        <p>Select a table</p>
    </div>

    <!-- Table selection area -->
    <div class="mesas-container">
        <a href="restaurant.php?mesa=1&user=<?php echo urlencode($usuario); ?>" class="mesa-link">
            <div class="mesa-box">Mesa 1</div>
        </a>
        <a href="restaurant.php?mesa=2&user=<?php echo urlencode($usuario); ?>" class="mesa-link">
            <div class="mesa-box">Mesa 2</div>
        </a>
        <a href="restaurant.php?mesa=3&user=<?php echo urlencode($usuario); ?>" class="mesa-link">
            <div class="mesa-box">Mesa 3</div>
        </a>
    </div>
</body>
</html>

