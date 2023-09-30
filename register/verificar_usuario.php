<?php
// Incluye el archivo de conexión a la base de datos
require_once "../db_connection/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"])) {
    $username = mysqli_real_escape_string($connection, $_POST["username"]);

    // Consulta SQL para verificar si el nombre de usuario existe
    $check_username_query = "SELECT COUNT(*) AS count FROM usuarios WHERE nombre = '$username'";
    $result = mysqli_query($connection, $check_username_query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        // Comprueba si el nombre de usuario existe
        if ($row['count'] > 0) {
            // El nombre de usuario ya existe, sugiere alternativas
            $suggestions = generateUsernameSuggestions($connection, $username);
            $response = array("existe" => true, "sugerencias" => $suggestions);
        } else {
            // El nombre de usuario está disponible
            $response = array("existe" => false);
        }

        echo json_encode($response);
    } else {
        // Error en la consulta
        echo json_encode(array("existe" => false));
    }

    // Cierra la conexión a la base de datos
    mysqli_close($connection);
} else {
    // No se proporcionó un nombre de usuario válido
    echo json_encode(array("existe" => false));
}

// Función para generar sugerencias de nombre de usuario
function generateUsernameSuggestions($connection, $baseUsername) {
    $suggestions = array();

    // Agrega tres sugerencias basadas en el "nombre_real" y verifica su disponibilidad
    for ($i = 1; $i <= 3; $i++) {
        $suggestedUsername = $baseUsername . $i;
        $check_query = "SELECT COUNT(*) AS count FROM usuarios WHERE nombre = '$suggestedUsername'";
        $result = mysqli_query($connection, $check_query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row['count'] == 0) {
                // Si el nombre de usuario no existe, agrega la sugerencia
                $suggestions[] = $suggestedUsername;
            }
        }
    }

    return $suggestions;
}
?>
