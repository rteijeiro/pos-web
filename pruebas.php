<?php

//ejemplo de como utilizarlo:

include('db.php'); // Asegúrate de incluir el archivo de conexión
include('controller.php'); // Asegúrate de incluir el archivo de controlador
// Llamamos a la función para obtener los usuarios
$usuarios = obtenerUsuarios($pdo);

// Mostrar los usuarios, por ejemplo:
echo "<pre>";
print_r($usuarios);
echo "</pre>";

//Mostrar solo el nombre de los usuarios
foreach ($usuarios as $usuario) {
   
    echo "Nombre: " . $usuario['nombre'] . "<br>";
    echo "<hr>";
}
$productos = obtenerProductos($pdo);

// Mostrar los usuarios, por ejemplo:
echo "<pre>";
print_r($productos);
echo "</pre>";

//Mostrar solo el nombre de los usuarios
foreach ($productos as $producto) {
   
    echo "Nombre: " . $producto['nombre'] . "<br>";
    echo "<hr>";
}

$categorias = obtenerCategorias($pdo);

// Mostrar los usuarios, por ejemplo:
echo "<pre>";
print_r($categorias);
echo "</pre>";

//Mostrar solo el nombre de los usuarios
foreach ($categorias as $categoria) {
   
    echo "Nombre: " . $categoria['nombre'] . "<br>";
    echo "<hr>";
}
?>
