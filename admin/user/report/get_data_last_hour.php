<?php
include_once("../../../db_connection/db_connection.php");
$endDateTime = date('Y-m-d H:i:s'); // Hora actual
$startDateTime = date('Y-m-d H:i:s', strtotime('-1 hour')); // Hora hace una hora

$sql = "SELECT DATE_FORMAT(fecha_registro, '%H:%i') AS hora, COUNT(*) AS cantidad FROM usuarios WHERE tipo = 'cliente' AND fecha_registro BETWEEN '$startDateTime' AND '$endDateTime' GROUP BY hora";

$resultado = mysqli_query($connection, $sql);

$horas = [];
$cantidades = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $fechas[] = $fila['hora'];
    $cantidades[] = $fila['cantidad'];
}

// Convierte las fechas al formato deseado (puedes personalizar esto según tus necesidades)
$fechasFormateadas = [];
foreach ($fechas as $fecha) {
    $fechasFormateadas[] = date("Y-m-d H:i:s", strtotime($fecha));
}

// Retorna los datos como JSON para su procesamiento en JavaScript
$data = [
    'hora' => $fechasFormateadas,
    'cantidades' => $cantidades,
];

echo json_encode($data);
?>