<?php
$host = 'localhost'; // o la IP del servidor de la base de datos
$dbname = 'tpv'; // nombre de la base de datos
$username = 'root'; // tu usuario de la base de datos
$password = ''; // tu contraseña de la base de datos

try {
    // Conexión a la base de datos usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Para manejar errores
    echo "Conexión exitosa!";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
