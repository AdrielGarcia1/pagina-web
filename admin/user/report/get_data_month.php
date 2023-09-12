<?php
include_once("../../db_connection/db_connection.php");

$endDateTime = date('Y-m-d H:i:s'); // Hora actual
$startDateTime = date('Y-m-01 00:00:00'); // Comienza el mes actual

$sql = "SELECT DATE_FORMAT(fecha_registro, '%d-%m') AS dia, COUNT(*) AS cantidad FROM usuarios WHERE tipo = 'cliente' AND fecha_registro BETWEEN '$startDateTime' AND '$endDateTime' GROUP BY dia";

$resultado = mysqli_query($connection, $sql);

$dias = [];
$cantidades = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $dias[] = $fila['dia'];
    $cantidades[] = $fila['cantidad'];
}

$data = [
    'dias' => $dias,
    'cantidades' => $cantidades,
];

echo json_encode($data);
?>