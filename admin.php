<?php
include 'connection/controller.php';
include 'connection/db.php';

$users = getUsers($pdo);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Users</title>
    <link rel="stylesheet" href="css/seccionUno.css">
    
</head>

<body>

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
            <script src="js/seccionUno.js"></script>
        </div>
</body>

</html>