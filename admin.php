<?php
include 'connection/controller.php';
include 'connection/db.php';

$users = getUsers($pdo);
$allUsers = getAllUsers($pdo);

// Check admin password on submit
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_password'])) {
    $passwordIngresada = $_POST['admin_password'];
    $stmt = $pdo->prepare("SELECT password FROM users WHERE name = 'admin' LIMIT 1");
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && $passwordIngresada === $admin['password']) {
        header("Location: management.php");
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
    <title>Select User</title>
    <link rel="stylesheet" href="css/seccionUno.css">
</head>
<body>

<div class="user-selection-container">
    <h1 class="screen-title">Select User</h1>
    <div class="user-buttons-container">
        <?php foreach ($users as $user): ?>
            <button class="user-button" onclick="window.location.href='tables.php?users=<?= urlencode($user['name']) ?>'">
                <img src="images/app/<?= htmlspecialchars($user['img']) ?>" alt="<?= htmlspecialchars($user['name']) ?>">
                <span><?= htmlspecialchars($user['name']) ?></span>
            </button>
        <?php endforeach; ?>
    </div>
</div>

<!-- Management button -->
<div class="management-footer">
    <button class="user-button" onclick="toggleManagementModal()">
        <img src="images/app/management.png" alt="Management">
        <span>Management</span>
    </button>
</div>

<!-- Management modal with users -->
<div id="management-modal" class="management-modal">
    <div class="management-content">
        <h2>Management Access</h2>
        <div class="user-list">
            <?php foreach ($allUsers as $u): ?>
                <div class="user-row" onclick="handleManagementUser('<?= $u['name'] ?>')">
                    <img src="images/app/<?= htmlspecialchars($u['img']) ?>" alt="<?= $u['name'] ?>">
                    <span><?= htmlspecialchars($u['name']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <button onclick="toggleManagementModal()" class="close-btn">Close</button>
    </div>
</div>

<!-- Admin password modal -->
<div id="admin-password-modal" class="management-modal" style="<?= !empty($error) ? 'display:flex;' : 'display:none;' ?>">
    <div class="management-content">
        <h2>Enter Admin Password</h2>
        <form method="POST">
            <input type="password" name="admin_password" placeholder="Password" required>
            <button type="submit">Enter</button>
            <?php if (!empty($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
        </form>
        <button onclick="document.getElementById('admin-password-modal').style.display='none'" class="close-btn">Cancel</button>
    </div>
</div>
<script src="js/seccionUno.js"></script>
</body>
</html>

