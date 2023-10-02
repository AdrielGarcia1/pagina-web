<?php
// Requiere conexión a la base de datos y sesión iniciada
require_once "../../db_connection/db_connection.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar_eliminar"])) {

    $user = $_SESSION["username"];
    $inactivate_query = "UPDATE usuarios SET estado = 0 WHERE nombre = ?";
    
    // Prepara la consulta
    $stmt = mysqli_prepare($connection, $inactivate_query);
    
    if ($stmt) {
        // Enlaza el parámetro
        mysqli_stmt_bind_param($stmt, "s", $user);
        
        // Ejecuta la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Éxito al marcar al usuario como inactivo
            
            session_destroy(); // Cierra la sesión del usuario
            header("Location:../../login/cerrar_sesion.php"); // Redirige al usuario a la página de inicio de sesión
            exit();
        } else {
            echo "Error al eliminar la cuenta: " . mysqli_stmt_error($stmt);
        }
        
        // Cierra la sentencia preparada
        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta: " . mysqli_error($connection);
    }
}
?>
