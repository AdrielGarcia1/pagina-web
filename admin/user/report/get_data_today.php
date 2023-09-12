<?php
include_once("../../db_connection/db_connection.php");

$endDateTime = date('Y-m-d H:i:s'); // Hora actual
$startDateTime = date('Y-m-d 00:00:00'); // Comienza a medianoche

$sql = "SELECT DATE_FORMAT(fecha_registro, '%H:00') AS hora, COUNT(*) AS cantidad FROM usuarios WHERE tipo = 'cliente' AND fecha_registro BETWEEN '$startDateTime' AND '$endDateTime' GROUP BY hora";

$resultado = mysqli_query($connection, $sql);

$horas = [];
$cantidades = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $horas[] = $fila['hora'];
    $cantidades[] = $fila['cantidad'];
}

$data = [
    'horas' => $horas,
    'cantidades' => $cantidades,
];

echo json_encode($data);
?>
