<?php
include_once("../../../db_connection/db_connection.php");

$startDateTime = date('Y-m-d 00:00:00');
$endDateTime = date('Y-m-d H:i:s');

$sql = "SELECT HOUR(fecha_registro) AS hora, COUNT(*) AS cantidad FROM usuarios WHERE tipo = 'cliente'";
$sql .= " AND fecha_registro BETWEEN '$startDateTime' AND '$endDateTime'";
$sql .= " GROUP BY hora";

$resultado = mysqli_query($connection, $sql);

$horas = [];
$cantidades = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $horas[] = $fila['hora'] . 'h';
    $cantidades[] = $fila['cantidad'];
}

$data = [
    'horas' => $horas,
    'cantidades' => $cantidades,
];

echo json_encode($data);
?>