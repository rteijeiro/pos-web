<?php
include '../connection/connection.php';

// Show only waiters and waitresses
$consulta = "SELECT Nombre, Img FROM usuarios WHERE Rol = 'camarero' OR Rol = 'camarera'";
$resultado = $conexion->query($consulta);

// Validate admin access when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_password'])) {
    $passwordIngresada = $_POST['admin_password'];

    $stmt = $conexion->prepare("SELECT Clave FROM usuarios WHERE Nombre = 'admin' LIMIT 1");
    $stmt->execute();
    $resultadoAdmin = $stmt->get_result();

    if ($resultadoAdmin && $row = $resultadoAdmin->fetch_assoc()) {
        if ($passwordIngresada === $row['Clave']) {
            header("Location: admin.php");
            exit();
        } else {
            $error = "Incorrect password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Users</title>
    <link rel="stylesheet" href="../css/index.css">
    <script>
        // Toggle the admin login popup visibility
        function toggleAdminPopup() {
            const popup = document.getElementById('admin-popup');
            popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
        }

        // Close popup when clicking outside
        document.addEventListener('click', function(e) {
            const popup = document.getElementById('admin-popup');
            const adminIcon = document.getElementById('admin-icon');

            if (!popup.contains(e.target) && !adminIcon.contains(e.target)) {
                popup.style.display = 'none';
            }
        });
    </script>
</head>
<body>
    <!-- NAVBAR -->
    <div class="navbar">
        <div class="navbar-title">Select User</div>
        <img src="../img/admin.png" alt="Admin" id="admin-icon" onclick="toggleAdminPopup()">
        <div id="admin-popup" class="admin-popup">
            <form method="POST">
                <label>Username: <strong>admin</strong></label><br>
                <input type="password" name="admin_password" placeholder="Password" required>
                <button type="submit">Confirm</button>
                <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
            </form>
        </div>
    </div>

    <!-- USERS -->
    <div class="user-container">
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <a href="tables.php?user=<?php echo urlencode($fila['Nombre']); ?>" class="user-box">
                <img src="../img/<?php echo htmlspecialchars($fila['Img']); ?>" alt="<?php echo htmlspecialchars($fila['Nombre']); ?>">
                <div class="user-name"><?php echo htmlspecialchars($fila['Nombre']); ?></div>
            </a>
        <?php endwhile; ?>
    </div>
</body>
</html>
