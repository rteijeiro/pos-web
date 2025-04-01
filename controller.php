<?php
// Archivo: get_users.php

include('db.php'); // Asegúrate de incluir el archivo de conexión

function obtenerUsuarios($pdo) {
    try {
        // Hacemos una consulta para obtener todos los usuarios
        $stmt = $pdo->prepare("SELECT * FROM usuarios"); // Cambia 'usuarios' por el nombre de tu tabla
        $stmt->execute();

        // Obtener todos los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los usuarios: " . $e->getMessage();
        return [];
    }
}

function obtenerCategorias($pdo) {
    try {
        // Hacemos una consulta para obtener todas las categorias
        $stmt = $pdo->prepare("SELECT * FROM categorias");
        $stmt->execute();

        // Obtener todos los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los usuarios: " . $e->getMessage();
        return [];
    }
}
function obtenerProductos($pdo) {
    try {
        // Hacemos una consulta para obtener todos los productos
        $stmt = $pdo->prepare("SELECT * FROM productos"); 
        $stmt->execute();

        // Obtener todos los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los usuarios: " . $e->getMessage();
        return [];
    }
}
?>
