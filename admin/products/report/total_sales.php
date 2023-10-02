<?php
session_start();
// Incluye el archivo de conexión a la base de datos
include('../../../db_connection/db_connection.php');

// Establece el encabezado JSON
header('Content-Type: application/json');

// Realiza una consulta SQL para obtener el total de ventas por producto
$sql = "SELECT productos.nombre AS producto, SUM(detalle_venta.cantidad) AS total_ventas
        FROM productos
        INNER JOIN detalle_venta ON productos.id = detalle_venta.producto_id
        GROUP BY productos.nombre";
$result = mysqli_query($connection, $sql);

$productos = array();
$ventas = array();

while ($row = mysqli_fetch_assoc($result)) {
    $productos[] = $row['producto'];
    $ventas[] = $row['total_ventas'];
}

// Crea un array asociativo con los datos
$data = array(
    'productos' => $productos,
    'ventas' => $ventas
);

// Convierte el array a JSON y lo imprime
echo json_encode($data);
?>