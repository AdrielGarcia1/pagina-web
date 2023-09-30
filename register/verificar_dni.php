<?php
// Incluye el archivo de conexión a la base de datos
require_once "../db_connection/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni"])) {
    $dni = mysqli_real_escape_string($connection, $_POST["dni"]);

    // Consulta SQL para verificar si el DNI ya está registrado
    $check_dni_query = "SELECT COUNT(*) AS count FROM usuarios WHERE dni = '$dni'";
    $result_dni = mysqli_query($connection, $check_dni_query);

    if ($result_dni) {
        $row_dni = mysqli_fetch_assoc($result_dni);

        // Comprueba si el DNI ya está registrado
        $response = array("existe" => ($row_dni['count'] > 0));
        echo json_encode($response);
    } else {
        // Error en la consulta
        echo json_encode(array("existe" => false));
    }

    // Cierra la conexión a la base de datos
    mysqli_close($connection);
} else {
    // No se proporcionó un DNI válido
    echo json_encode(array("existe" => false));
}
?>