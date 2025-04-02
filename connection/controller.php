<?php

include('db.php');

function getUsers($pdo) {
    try {
        // We make a query to obtain all the data
        $stmt = $pdo->prepare("SELECT * FROM usuarios"); 
        $stmt->execute();

        // Get all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los usuarios: " . $e->getMessage();
        return [];
    }
}

function getCategory($pdo) {
    try {
        // We make a query to obtain all the data
        $stmt = $pdo->prepare("SELECT * FROM categorias");
        $stmt->execute();

        // Get all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los usuarios: " . $e->getMessage();
        return [];
    }
}
function getProduct($pdo) {
    try {
        // We make a query to obtain all the data
        $stmt = $pdo->prepare("SELECT * FROM productos"); 
        $stmt->execute();

        // Get all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los usuarios: " . $e->getMessage();
        return [];
    }
}
?>
