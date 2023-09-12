<?php
include_once("../../db_connection/db_connection.php");

$endDateTime = date('Y-m-d H:i:s'); // Hora actual
$startDateTime = date('Y-01-01 00:00:00'); // Comienza el año actual

$sql = "SELECT DATE_FORMAT(fecha_registro, '%m-%Y') AS mes, COUNT(*) AS cantidad FROM usuarios WHERE tipo = 'cliente' AND fecha_registro BETWEEN '$startDateTime' AND '$endDateTime' GROUP BY mes";

$resultado = mysqli_query($connection, $sql);

$meses = [];
$cantidades = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $meses[] = $fila['mes'];
    $cantidades[] = $fila['cantidad'];
}

$data = [
    'meses' => $meses,
    'cantidades' => $cantidades,
];

echo json_encode($data);
?>