<?php
// Include the database connection
include_once('../../../db_connection/db_connection.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the talle name from the form
    $talleName = $_POST['talle_name'];

    // Perform data validation here if needed

    // Insert the new talle into the database
    $sql = "INSERT INTO talles (nombre_talle) VALUES ('$talleName')";

    if (mysqli_query($connection, $sql)) {
        // Talle added successfully
        header('Location: add_talle.php?success=1');
        exit();
    } else {
        // Error adding talle
        header('Location: add_talle.php?error=1');
        exit();
    }
} else {
    // Redirect to the add_talle.php page if the form is not submitted
    header('Location: add_talle.php');
    exit();
}
?>
