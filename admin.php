<?php
include 'connection/controller.php';
include 'connection/db.php';

$users = getUsers($pdo);


// Validate admin access when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_password'])) {
    $passwordIngresada = $_POST['admin_password'];

    $stmt = $pdo->prepare("SELECT password FROM users WHERE name = 'admin' LIMIT 1");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && $passwordIngresada === $row['Clave']) {
        header("Location: admin.php");
        exit();
    } else {
        $error = "Incorrect password";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Users</title>
    <link rel="stylesheet" href="css/seccionUno.css">
    <script>
        // Toggle the admin login popup visibility
        function toggleAdminPopup() {
            const popup = document.getElementById('admin-popup');
            popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
        }

        // Close popup when clicking outside
        document.addEventListener('click', function (e) {
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
                <?php if (!empty($error))
                    echo "<div class='error'>$error</div>"; ?>
            </form>
        </div>
    </div>
    <div class="user-selection-container">
        <h1 class="screen-title">Select User</h1>
        <!-- USERS -->
        <div class="user-buttons-container">
            <?php foreach ($users as $users): ?>
                <button class="user-button"
                    onclick="window.location.href='tables.php?users=<?php echo urlencode($users['name']); ?>';">
                    <img src="images/app/<?php echo htmlspecialchars($users['img']); ?>"
                        alt="<?php echo htmlspecialchars($users['name']); ?>">
                    <span><?php echo htmlspecialchars($users['name']); ?></span>
                </button>
            <?php endforeach; ?>
            <script src="../js/seccion 1.js"></script>
        </div>
</body>

</html>