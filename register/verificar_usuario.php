<?php
// Incluye el archivo de conexión a la base de datos
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connection, $_POST["username"]);

    // Consulta SQL para verificar si el nombre de usuario ya existe
    $check_username_query = "SELECT COUNT(*) AS count FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $check_username_query);
    $row = mysqli_fetch_assoc($result);

    // Prepara la respuesta en formato JSON
    $response = array();

    if ($row['count'] > 0) {
        $response['existe'] = true;
    } else {
        $response['existe'] = false;
    }

    // Devuelve la respuesta en formato JSON
    echo json_encode($response);
}

// Cierra la conexión a la base de datos
mysqli_close($connection);
?>
