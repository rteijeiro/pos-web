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
        $stmt = $pdo->prepare("SELECT name, price FROM products WHERE category_id = ?");
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

