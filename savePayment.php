<?php
error_reporting(0);
header('Content-Type: application/json');

include 'connection/db.php';
include 'connection/controller.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['date'], $data['total'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos'
    ]);
    exit;
}

$date = $data['date'];
$total = $data['total'];

$success = savePayments($pdo, $date, $total);

echo json_encode([
    'success' => $success,
    'message' => $success ? 'Pago guardado correctamente' : 'Error al guardar el pago'
]);
