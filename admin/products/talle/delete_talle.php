<?php
// Verificar si se ha enviado un ID de talle válido
if (isset($_POST['talle_id']) && is_numeric($_POST['talle_id'])) {
    // Incluir el archivo de conexión a la base de datos
    include('../../../db_connection/db_connection.php');

    // Sanitizar el ID del talle para prevenir inyección SQL (usar consultas preparadas es una mejor práctica)
    $talle_id = mysqli_real_escape_string($connection, $_POST['talle_id']);

    // Query para eliminar el talle
    $query = "DELETE FROM talles WHERE id = $talle_id";

    // Ejecutar la consulta
    if (mysqli_query($connection, $query)) {
        // Éxito: el talle se eliminó correctamente
        // Puedes redirigir al usuario a la página de lista de talles u otra página
        header('Location: add_talle.php'); // Cambia 'add_talle.php' al nombre de tu página de lista de talles
        exit;
    } else {
        // Error al eliminar el talle
        echo "Error al eliminar el talle: " . mysqli_error($connection);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($connection);
} else {
    // Redirigir al usuario a la página de lista de talles con un mensaje de error
    header('Location: add_talle.php?error=ID_de_talle_no_válido'); // Cambia 'add_talle.php' al nombre de tu página de lista de talles
    exit;
}
?>