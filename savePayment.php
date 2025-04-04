<?php
include 'connection/db.php';
include 'connection/controller.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['date'], $data['total'])) {
    echo json_encode(["error" => "Faltan datos en la solicitud"]);
    exit;
}

// Convertir valores
$date = $data['date'];
$total = floatval($data['total']);

$result = savePayments($pdo, $date, $total);

if ($result) {
    echo json_encode(["message" => "Pago guardado con éxito"]);
} else {
    echo json_encode(["error" => "No se pudo guardar el pago"]);
}
?>