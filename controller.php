<?php

include('db.php');

function getUsers($pdo) {
    try {
        // We make a query to obtain all the data
        $stmt = $pdo->prepare("SELECT * FROM users WHERE rol='waiter'"); 
        $stmt->execute();

        // Get all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error retrieving users: " . $e->getMessage();
        return [];
    }
}

function getCategory($pdo) {
    try {
        // We make a query to obtain all the data
        $stmt = $pdo->prepare("SELECT * FROM categories");
        $stmt->execute();

        // Get all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error retrieving users: " . $e->getMessage();
        return [];
    }
}
function getProduct($pdo) {
    try {
        // We make a query to obtain all the data
        $stmt = $pdo->prepare("SELECT * FROM products"); 
        $stmt->execute();

        // Get all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error retrieving users: " . $e->getMessage();
        return [];
    }
}
?>
