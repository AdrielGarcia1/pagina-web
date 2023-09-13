<?php
include_once("../../../db_connection/db_connection.php");

$startDateTime = date('Y-m-d H:i:s', strtotime('today'));
$endDateTime = date('Y-m-d H:i:s');

$sql = "SELECT HOUR(fecha_registro) AS hora, MINUTE(fecha_registro) AS minuto, COUNT(*) AS cantidad FROM usuarios WHERE tipo = 'cliente'";
$sql .= " AND fecha_registro BETWEEN '$startDateTime' AND '$endDateTime'";
$sql .= " GROUP BY hora, minuto";

$resultado = mysqli_query($connection, $sql);

$horas = [];
$minutos = [];
$cantidades = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $horas[] = $fila['hora'];
    $minutos[] = $fila['minuto'];
    $cantidades[] = $fila['cantidad'];
}

$data = [
    'horas' => $horas,
    'minutos' => $minutos,
    'cantidades' => $cantidades,
];

echo json_encode($data);
?>