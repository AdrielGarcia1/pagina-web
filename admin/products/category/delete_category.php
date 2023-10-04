<?php
// Verificar si se ha enviado un ID de categoría válido
if (isset($_POST['category_id']) && is_numeric($_POST['category_id'])) {
    // Incluir el archivo de conexión a la base de datos
    include('../../../db_connection/db_connection.php');

    // Sanitizar el ID de la categoría para prevenir inyección SQL (usar consultas preparadas es una mejor práctica)
    $category_id = mysqli_real_escape_string($connection, $_POST['category_id']);

    // Query para eliminar la categoría
    $query = "DELETE FROM categorias WHERE id = $category_id";

    // Ejecutar la consulta
    if (mysqli_query($connection, $query)) {
        // Éxito: la categoría se eliminó correctamente
        // Puedes redirigir al usuario a la página de lista de categorías u otra página
        header('Location: add_category.php');
    } else {
        // Error al eliminar la categoría
        echo "Error al eliminar la categoría: " . mysqli_error($connection);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($connection);
} else {
    // Redirigir al usuario a la página de lista de categorías con un mensaje de error
    header('Location: add_category.php?error=ID_de_categoria_no_válido');
    exit();
}
?>