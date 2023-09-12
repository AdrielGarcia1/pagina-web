<?php
include_once("../../../db_connection/db_connection.php");

$startDateTime = date('Y-01-01 00:00:00');
$endDateTime = date('Y-m-d H:i:s');

$sql = "SELECT MONTH(fecha_registro) AS mes, COUNT(*) AS cantidad FROM usuarios WHERE tipo = 'cliente'";
$sql .= " AND fecha_registro BETWEEN '$startDateTime' AND '$endDateTime'";
$sql .= " GROUP BY mes";

$resultado = mysqli_query($connection, $sql);

$meses = [
    'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
];
$cantidades = array_fill(0, 12, 0);

while ($fila = mysqli_fetch_assoc($resultado)) {
    $mes = intval($fila['mes']);
    $cantidades[$mes - 1] = $fila['cantidad'];
}

$data = [
    'meses' => $meses,
    'cantidades' => $cantidades,
];

echo json_encode($data);
?>
