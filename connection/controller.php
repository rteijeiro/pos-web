<?php

include('db.php');

function getUsers($pdo)
{
    try {
        // We make a query to obtain all the data
        $stmt = $pdo->prepare("SELECT * FROM users WHERE rol='waiter'");
        $stmt->execute();

        // Get all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los users: " . $e->getMessage();
        return [];
    }
}

function getCategory($pdo)
{
    try {
        // We make a query to obtain all the data
        $stmt = $pdo->prepare("SELECT * FROM categories");
        $stmt->execute();

        // Get all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los users: " . $e->getMessage();
        return [];
    }
}
function getProduct($pdo)
{
    try {
        // We make a query to obtain all the data
        $stmt = $pdo->prepare("SELECT * FROM products");
        $stmt->execute();

        // Get all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los users: " . $e->getMessage();
        return [];
    }
}


function getProductsByCategory($pdo, $categoryId)
{
    try {
        $stmt = $pdo->prepare("SELECT name, price, img FROM products WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error en getProductsByCategory: " . $e->getMessage());
        return [];
    }
}

//AJAX
if (isset($_GET['action'])) {
    try {
        switch ($_GET['action']) {
            case 'getProducts':
                if (isset($_GET['category_id'])) {
                    header('Content-Type: application/json');
                    echo json_encode(getProductsByCategory($pdo, $_GET['category_id']));
                    exit;
                }
                break;
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}
//function to save payments
function savePayments($pdo, $date, $total)
{
    try {
        $sql = "INSERT INTO payments (date, total) VALUES (:date, :total)";
        $stmt = $pdo->prepare($sql);

        //assign values to placeholders
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':total', $total, PDO::PARAM_STR);

        //run the query
        return $stmt->execute();
        //die function stops execution and displays error message
    } catch (PDOException $e) {
        die("Error al guardar el pago: " . $e->getMessage());
    }
}

function getAllUsers($pdo)
{
    try {
        // We make a query to obtain all the data
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();

        // Get all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los users: " . $e->getMessage();
        return [];
    }
}

// show users
if (isset($_GET['action']) && $_GET['action'] === 'getAllUser') {
    $stmt = $pdo->prepare("SELECT name, img FROM users WHERE name != 'admin'");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
    exit;
}

//delete user by name
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'deleteUser') {
    $input = json_decode(file_get_contents('php://input'), true);
    $name = $input['name'] ?? '';

    if (!empty($name)) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE name = ?");
        $success = $stmt->execute([$name]);
        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No user specified']);
    }
    exit;
}

//Show products
if (isset($_GET['action']) && $_GET['action'] === 'getProducts') {
    $stmt = $pdo->query("
        SELECT 
            p.name, 
            p.price, 
            c.name AS category_name
        FROM products p
        JOIN categories c ON p.category_id = c.id
    ");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
    exit;
}

//Delete products
if (isset($_GET['action']) && $_GET['action'] === 'deleteProduct' && isset($_GET['name'])) {
    $name = $_GET['name'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE name = ?");
    $success = $stmt->execute([$name]);

    echo json_encode(['success' => $success]);
    exit;
}

// Add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'addProduct') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    $imgName = basename($_FILES['img']['name']);
    $uploadDir = '../carta_seccion_3/';
    $uploadPath = $uploadDir . $imgName;

    // Only move the file if it doesn't already exist
    if (!file_exists($uploadPath)) {
        if (!move_uploaded_file($_FILES['img']['tmp_name'], $uploadPath)) {
            echo json_encode(['success' => false, 'message' => 'Image upload failed']);
            exit;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO products (name, price, category_id, img) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $price, $category_id, $imgName]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit;
}


//function to insert user
function addUser($pdo, $name, $rol, $img)
{
    try {

        $sql = "INSERT INTO users (name, rol, img) 
                VALUES (:name, :rol, :img)";
        // Assign values 
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
        $stmt->bindParam(':img', $img, PDO::PARAM_STR);

        //execute the query
        $success = $stmt->execute();

        //return the appropriate JSON response
        if ($success) {
            return json_encode(['success' => true, 'message' => 'User added successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to add user']);
        }
    } catch (PDOException $e) {
        error_log("Error al insertar usuario: " . $e->getMessage());
        return json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
}
// Add user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'addUser') {
    $name = $_POST['name'];
    $rol = $_POST['rol'];
    // Empty password by default
    $password = '';

    // Handle image upload
    $imgName = basename($_FILES['img']['name']);
    $uploadDir = '../images/app/';
    $uploadPath = $uploadDir . $imgName;

    // Only move the image if it doesn't already exist
    if (!file_exists($uploadPath)) {
        if (!move_uploaded_file($_FILES['img']['tmp_name'], $uploadPath)) {
            echo json_encode([
                'success' => false,
                'message' => 'Image upload failed'
            ]);
            exit;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, password, rol, img) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $password, $rol, $imgName]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }

    exit;
}
