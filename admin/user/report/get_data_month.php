<?php
// Incluye el archivo de conexión a la base de datos
include_once("../../../db_connection/db_connection.php");

// Consulta SQL para obtener la cantidad de usuarios registrados por mes
$sql = "SELECT DATE_FORMAT(fecha_registro, '%M %Y') AS mes, COUNT(*) AS cantidad FROM usuarios WHERE tipo = 'cliente' GROUP BY mes";
$resultado = mysqli_query($connection, $sql);

$etiquetas = [];
$datosUsuariosRegistrados = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $etiquetas[] = $fila['mes'];
    $datosUsuariosRegistrados[] = $fila['cantidad'];
}

// Datos para devolver como JSON
$data = [
    'etiquetas' => $etiquetas,
    'datos' => $datosUsuariosRegistrados,
];

echo json_encode($data);
?>