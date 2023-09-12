<?php
// Incluye el archivo de conexión a la base de datos
include_once("../../../db_connection/db_connection.php");
// Obtiene el valor seleccionado del rango de tiempo (por defecto, se establece como "all" si no se especifica)
$timeRange = isset($_GET['time_range']) ? $_GET['time_range'] : 'all';

// Inicializa las variables de fecha
$startDateTime = '';
$endDateTime = '';

if ($timeRange === 'last_hour') {
    // Calcular el rango de tiempo para la última hora
    $endDateTime = date('Y-m-d H:i:s'); // Hora actual
    $startDateTime = date('Y-m-d H:i:s', strtotime('-1 hour')); // Hora hace una hora
} elseif ($timeRange === 'today') {
    // Calcular el rango de tiempo para el día actual (puedes hacer lo mismo para otras opciones)
    $endDateTime = date('Y-m-d H:i:s'); // Hora actual
    $startDateTime = date('Y-m-d 00:00:00'); // Comienza a medianoche
}

// Consulta SQL para obtener el número de usuarios registrados por fecha
$sql = "SELECT DATE(fecha_registro) AS fecha, COUNT(*) AS cantidad FROM usuarios WHERE tipo = 'cliente'";

// Agrega la condición de rango de tiempo si es diferente de "all"
if ($timeRange !== 'all') {
    $sql .= " AND fecha_registro BETWEEN '$startDateTime' AND '$endDateTime'";
}

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