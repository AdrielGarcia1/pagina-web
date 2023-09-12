<?php
include_once("../../../db_connection/db_connection.php");

$sql = "SELECT DATE(fecha_registro) AS fecha, COUNT(*) AS cantidad FROM usuarios WHERE tipo = 'cliente'";
$sql .= " AND fecha_registro >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND fecha_registro <= CURDATE() + INTERVAL 1 DAY";
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
