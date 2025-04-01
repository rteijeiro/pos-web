<?php


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
?>
