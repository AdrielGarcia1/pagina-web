<?php
include_once("../../../db_connection/db_connection.php");

$startDateTime = date('Y-m-d H:i:s', strtotime('-1 hour'));
$endDateTime = date('Y-m-d H:i:s');

$sql = "SELECT DATE_FORMAT(fecha_registro, '%H:%i') AS minuto, COUNT(*) AS cantidad FROM usuarios WHERE tipo = 'cliente'";
$sql .= " AND fecha_registro BETWEEN '$startDateTime' AND '$endDateTime'";
$sql .= " GROUP BY minuto";

$resultado = mysqli_query($connection, $sql);

$minutos = [];
$cantidades = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $minutos[] = $fila['minuto'];
    $cantidades[] = $fila['cantidad'];
}

$data = [
    'minutos' => $minutos,
    'cantidades' => $cantidades,
];

echo json_encode($data);
?>
