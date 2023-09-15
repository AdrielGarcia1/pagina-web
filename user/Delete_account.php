<?php
// Requiere conexión a la base de datos y sesión iniciada
require_once "../../db_connection/db_connection.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar_eliminar"])) {
    // Aquí debes agregar la lógica para marcar al usuario como inactivo en la base de datos
    // y realizar cualquier otra acción necesaria al eliminar la cuenta

    // Por ejemplo, podrías hacer lo siguiente:
    $user_id = $_SESSION["user_id"];
    $inactivate_query = "UPDATE usuarios SET activo = 0 WHERE id = $user_id";

    if (mysqli_query($connection, $inactivate_query)) {
        // Éxito al marcar al usuario como inactivo
        // Puedes redirigir al usuario a una página de confirmación o cerrar la sesión
        session_destroy(); // Cierra la sesión del usuario
        header("Location: ../login/cerrar_sesion.php"); // Redirige al usuario a la página de inicio de sesión
        exit();
    } else {
        echo "Error al eliminar la cuenta: " . mysqli_error($connection);
    }
}
?>
