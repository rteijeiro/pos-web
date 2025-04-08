<?php
include 'connection/controller.php';
include 'connection/db.php';

// Get categories for select input
$categories = getCategory($pdo);
$roles = getUsers($pdo);

// Get admin name
$stmt = $pdo->prepare("SELECT name FROM users WHERE name = 'admin' LIMIT 1");
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);
$adminName = $admin ? $admin['name'] : 'Admin';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Management Panel</title>
    <link rel="stylesheet" href="css/management.css">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-left">
            <span><?= htmlspecialchars($adminName) ?></span>
        </div>

        <div class="navbar-center">
            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown('user-dropdown')">Users</button>
                <div class="dropdown-content" id="user-dropdown">
                    <a href="#" onclick="showUsers()">Show Users</a>
                    <a href="#" onclick="showAddUserForm()">Register User</a>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown('product-dropdown')">Products</button>
                <div class="dropdown-content" id="product-dropdown">
                    <a href="#" onclick="showProducts()">Show Products</a>
                    <a href="#" onclick="showAddProductForm()">Add Product</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-section" id="main-section"></div>

    <!-- Script Section -->
    <script>
        const categories = <?= json_encode($categories) ?>;
    </script>
    <script>
        const roles = <?= json_encode($roles) ?>;
    </script>
    <script src="js/management.js"></script>
</body>

</html>