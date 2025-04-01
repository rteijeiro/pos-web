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
   
    echo "Nombre: " . $usuario['Nombre'] . "<br>";
    echo "<hr>";
}
?>
