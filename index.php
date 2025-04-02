<?php
include 'connection/controller.php';
include 'connection/db.php';

$usuarios = getUsers($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seleccionar Usuario - TPV</title>
  <link rel="stylesheet" href="css/seccion 1.css">
</head>
<body>
  <div class="user-selection-container">
    <h1 class="screen-title">Seleccionar Usuario</h1>
    
    <div class="user-buttons-container">
    <?php foreach ($usuarios as $usuario): ?>
        <button class="user-button" onclick="window.location.href='tables.php?usuario=<?php echo urlencode($usuario['nombre']); ?>';">
          <img src="images/app/hd-man.png" alt="<?php echo htmlspecialchars($usuario['nombre']); ?>">
          <span><?php echo htmlspecialchars($usuario['nombre']); ?></span>
        </button>
    <?php endforeach; ?>
    </div>
  </div>

  <script src="js/seccion 1.js"></script>
</body>
</html>
