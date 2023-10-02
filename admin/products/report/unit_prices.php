<?php
// Incluye el archivo de conexión a la base de datos
include('../../db_connection/db_connection.php');

// Realiza una consulta SQL para obtener los montos totales de los precios unitarios por fecha
$sql = "SELECT fecha_compra, SUM(precio_unitario) AS monto_total
        FROM detalle_venta
        GROUP BY fecha_compra";

$result = mysqli_query($connection, $sql);

$montosTotales = array();

while ($row = mysqli_fetch_assoc($result)) {
    $fechaCompra = $row['fecha_compra'];
    $montoTotal = $row['monto_total'];
    $montosTotales[$fechaCompra] = $montoTotal;
}

// Devuelve los datos en formato JSON
echo json_encode($montosTotales);
?>