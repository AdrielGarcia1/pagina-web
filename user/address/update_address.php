<?php
// Incluye el archivo de conexión a la base de datos
require_once('../../db_connection/db_connection.php');

// Inicia sesión (si aún no se ha iniciado)
session_start();

// Verificar si existe la variable de sesión del nombre de usuario
if (isset($_SESSION['username'])) {
    // Botón de "Cerrar Sesión"
    $logoutButton = '<a href="../../login/cerrar_sesion.php" class="nav-item nav-link">Cerrar Sesión</a>';
} else {
    // Botones de "Login" y "Register"
    $loginButton = '<a href="../../login/login.php" class="nav-item nav-link">Login</a>';
    $registerButton = '<a href="../../register/register.php" class="nav-item nav-link">Register</a>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura los datos del formulario
    $province_id = mysqli_real_escape_string($connection, $_POST["province"]);
    $city = mysqli_real_escape_string($connection, $_POST["city"]);
    $address = mysqli_real_escape_string($connection, $_POST["address"]);

    // Aquí debes obtener el ID del usuario actualmente autenticado usando su nombre de usuario
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        // Realiza una consulta para obtener el id_usuario basado en el nombre de usuario
        $user_query = "SELECT id FROM usuarios WHERE nombre = '$username'";
        $user_result = mysqli_query($connection, $user_query);
        
        if (mysqli_num_rows($user_result) > 0) {
            $user_row = mysqli_fetch_assoc($user_result);
            $user_id = $user_row['id'];
        } else {
            // Maneja el caso si no se encuentra el usuario
            echo "Usuario no encontrado.";
            exit(); // Termina el script
        }
    } else {
        // Si el usuario no ha iniciado sesión, maneja el caso adecuadamente
        echo "Usuario no autenticado.";
        exit(); // Termina el script
    }

    // Prepara la consulta SQL para actualizar la información del usuario
    $update_user_query = "UPDATE direcciones SET id_provincia = $province_id, ciudad_pueblo = '$city', direccion = '$address' WHERE id_usuario = $user_id";

    // Ejecuta la consulta
    if (mysqli_query($connection, $update_user_query)) {
        // Redirige a la página de perfil del usuario o a donde desees
        header("Location: ../user/user_profile.php");
        exit();
    } else {
        echo "Error al actualizar la información del usuario: " . mysqli_error($connection);
    }
}

// Consulta para obtener las provincias desde la base de datos
$get_provinces_query = "SELECT id, nombre_provincia FROM provincias";
$provinces_result = mysqli_query($connection, $get_provinces_query);

// Consulta para obtener los datos actuales de dirección del usuario
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // Realiza una consulta para obtener los datos de dirección basados en el nombre de usuario
    $get_address_query = "SELECT id_provincia, ciudad_pueblo, direccion FROM direcciones INNER JOIN usuarios ON direcciones.id_usuario = usuarios.id WHERE usuarios.nombre = '$username'";
    $result = mysqli_query($connection, $get_address_query);

    // Verifica si se encontraron resultados
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentProvinceId = $row['id_provincia'];
        $currentCity = $row['ciudad_pueblo'];
        $currentAddress = $row['direccion'];
    } else {
        // Si no se encontraron resultados, puedes establecer valores predeterminados o mostrar un mensaje de error
        $currentProvinceId = "";
        $currentCity = "";
        $currentAddress = "";
    }
} else {
    // Maneja el caso si el usuario no ha iniciado sesión
    echo "Usuario no autenticado.";
    exit(); // Termina el script
}

// Cierra la conexión a la base de datos
mysqli_close($connection);
?>