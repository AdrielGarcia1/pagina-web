<?php
include_once("../../../db_connection/db_connection.php");

$endDateTime = date('Y-m-d H:i:s'); // Hora actual
$startDateTime = date('Y-m-d H:i:s', strtotime('-1 month')); // Hace un mes desde la hora actual

$sql = "SELECT DATE(fecha_registro) AS fecha, COUNT(*) AS cantidad FROM usuarios";
$sql .= " WHERE fecha_registro BETWEEN '$startDateTime' AND '$endDateTime'";
$sql .= " GROUP BY fecha";

$resultado = mysqli_query($connection, $sql);

$fechas = [];
$cantidades = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $fechas[] = date('d-m-Y', strtotime($fila['fecha']));
    $cantidades[] = $fila['cantidad'];
}

$data = [
    'fechas' => $fechas,
    'cantidades' => $cantidades,
];

echo json_encode($data);
?>