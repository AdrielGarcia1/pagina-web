<?php
// Incluye el archivo de conexión a la base de datos
require_once "../db_connection/db_connection.php";

// Inicializa las variables de mensaje de error
$errorPassword = "";
$errorUsername = "";
$errorDNI = "";
$errorEmail = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura los datos del formulario
    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $nombre_real = mysqli_real_escape_string($connection, $_POST["nombre_real"]);
    $apellido = mysqli_real_escape_string($connection, $_POST["apellido"]);
    $numero_telefono = mysqli_real_escape_string($connection, $_POST["numero_telefono"]);
    $codigo_postal = mysqli_real_escape_string($connection, $_POST["codigo_postal"]);
    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $confirm_password = mysqli_real_escape_string($connection, $_POST["confirm_password"]);
    $province_id = $_POST["province"];
    $city = mysqli_real_escape_string($connection, $_POST["city"]);
    $address = mysqli_real_escape_string($connection, $_POST["address"]);
    $dni = mysqli_real_escape_string($connection, $_POST["dni"]);

    // Verifica si las contraseñas coinciden
    if ($password != $confirm_password) {
        $errorPassword = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    } else {
        // Verifica si el nombre de usuario ya existe en la base de datos
        $check_username_query = "SELECT COUNT(*) AS count FROM usuarios WHERE nombre = '$username'";
        $result = mysqli_query($connection, $check_username_query);
        $row = mysqli_fetch_assoc($result);

        // Verifica si el DNI ya está registrado en la base de datos
        $check_dni_query = "SELECT COUNT(*) AS count FROM usuarios WHERE dni = '$dni'";
        $result_dni = mysqli_query($connection, $check_dni_query);
        $row_dni = mysqli_fetch_assoc($result_dni);

        // Verifica si el correo electrónico ya está registrado en la base de datos
        $check_email_query = "SELECT COUNT(*) AS count FROM usuarios WHERE correo = '$email'";
        $result_email = mysqli_query($connection, $check_email_query);
        $row_email = mysqli_fetch_assoc($result_email);

        if ($row['count'] > 0) {
            $errorUsername = "El nombre de usuario ya está en uso. Por favor, elige otro o elige una de las siguientes opciones:";
        } elseif ($row_dni['count'] > 0) {
            $errorDNI = "El DNI ya está registrado. Por favor, ingresa otro.";
        } elseif ($row_email['count'] > 0) {
            $errorEmail = "El correo electrónico ya está registrado. Por favor, usa otro.";
        } else {
            // Hash de la contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepara la consulta SQL para insertar el usuario en la base de datos
            $insert_user_query = "INSERT INTO usuarios (nombre, nombre_real, apellido, numero_telefono, codigo_postal, correo, contrasena, dni, tipo, fecha_registro, estado) 
              VALUES ('$username', '$nombre_real', '$apellido', '$numero_telefono', '$codigo_postal', '$email', '$hashed_password', '$dni', 'cliente', NOW(), 1)";

            // Ejecuta la consulta
            if (mysqli_query($connection, $insert_user_query)) {
                // Obten el ID del usuario recién insertado
                $user_id = mysqli_insert_id($connection);

                // Prepara la consulta SQL para insertar la dirección del usuario
                $insert_address_query = "INSERT INTO direcciones (id_usuario, id_provincia, ciudad_pueblo, direccion) 
                  VALUES ($user_id, $province_id, '$city', '$address')";

                // Ejecuta la consulta
                if (mysqli_query($connection, $insert_address_query)) {
                    // Registro exitoso, redirige a la página de inicio de sesión
                    header("Location: ../login/login.php");
                    exit();
                } else {
                    echo "Error al registrar la dirección del usuario: " . mysqli_error($connection);
                }
            } else {
                echo "Error al registrar el usuario: " . mysqli_error($connection);
            }
        }
    }
}

// Consulta para obtener las provincias desde la base de datos
$get_provinces_query = "SELECT id, nombre_provincia FROM provincias";
$provinces_result = mysqli_query($connection, $get_provinces_query);

// Cierra la conexión a la base de datos
mysqli_close($connection);
?>
