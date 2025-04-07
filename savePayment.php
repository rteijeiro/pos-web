<?php
include 'connection/db.php';
include 'connection/controller.php';
//response header
header("Content-Type: application/json");
//define the response in json
$data = json_decode(file_get_contents("php://input"), true);
//checks whether the data have been received
if (!$data || !isset($data['date'], $data['total'])) {
    echo json_encode(["error" => "Faltan datos en la solicitud"]);
    exit;
}

//convert values
$date = $data['date'];
$total = floatval($data['total']);
//saves the payment in the database
$result = savePayments($pdo, $date, $total);

//if it returns true, the payment was saved
if ($result) {
    echo json_encode(["message" => "Pago guardado con éxito"]);
} else {
    echo json_encode(["error" => "No se pudo guardar el pago"]);
}
?>