<?php
// Incluye el archivo de conexión a la base de datos
include_once("../../../db_connection/db_connection.php");

// Consulta SQL para obtener el número de usuarios registrados por fecha
$sql = "SELECT DATE(fecha_registro) AS fecha, COUNT(*) AS cantidad FROM usuarios";
$sql .= " GROUP BY fecha";

// Ejecuta la consulta
$resultado = mysqli_query($connection, $sql);

// Inicializa dos arreglos para almacenar las fechas y cantidades
$fechas = [];
$cantidades = [];

// Procesa los resultados de la consulta
while ($fila = mysqli_fetch_assoc($resultado)) {
    $fechas[] = $fila['fecha'];
    $cantidades[] = $fila['cantidad'];
}

// Convierte las fechas al formato deseado (puedes personalizar esto según tus necesidades)
$fechasFormateadas = [];
foreach ($fechas as $fecha) {
    $fechasFormateadas[] = date("d-m-Y", strtotime($fecha));
}

// Retorna los datos como JSON para su procesamiento en JavaScript
$data = [
    'fechas' => $fechasFormateadas,
    'cantidades' => $cantidades,
];

echo json_encode($data);
?>