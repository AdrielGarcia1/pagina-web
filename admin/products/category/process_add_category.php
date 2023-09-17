<?php
// Include the database connection
include_once('../../../db_connection/db_connection.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the category name from the form
    $categoryName = mysqli_real_escape_string($connection, $_POST['category_name']);

    // Perform data validation here if needed

    // Insert the new category into the database
    $sql = "INSERT INTO categorias (nombre_categoria) VALUES ('$categoryName')";

    if (mysqli_query($connection, $sql)) {
        // Category added successfully
        header('Location: add_category.php?success=1');
        exit();
    } else {
        // Error adding category
        header('Location: add_category.php?error=1');
        exit();
    }
} else {
    // Redirect to the add_category.php page if the form is not submitted
    header('Location: add_category.php');
    exit();
}
?>
