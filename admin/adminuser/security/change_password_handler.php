<?php
require_once('../../db_connection/db_connection.php');
// Obtener el nombre de usuario actual de la sesión (asegúrate de haber iniciado la sesión previamente)
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
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Resto del código para cambiar la contraseña...
} else {
    // Si el usuario no ha iniciado sesión, maneja el caso adecuadamente
    echo "Usuario no autenticado.";
}

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Crear una nueva conexión a la base de datos
    $conn = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);

    // Verificar si la conexión tuvo éxito
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Consulta para obtener la contraseña actual del usuario
    $sql = "SELECT contrasena FROM usuarios WHERE nombre = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hashedPassword);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Verificar si la contraseña actual es correcta
        if (password_verify($currentPassword, $hashedPassword)) {
            // Verificar si la nueva contraseña y la confirmación coinciden
            if ($newPassword === $confirmPassword) {
                // Hash de la nueva contraseña
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Actualizar la contraseña en la base de datos
                $updateSql = "UPDATE usuarios SET contrasena = ? WHERE nombre = ?";
                $updateStmt = mysqli_prepare($conn, $updateSql);

                if ($updateStmt) {
                    mysqli_stmt_bind_param($updateStmt, "ss", $hashedNewPassword, $username);
                    if (mysqli_stmt_execute($updateStmt)) {
                        $successMessage = "Contraseña actualizada con éxito.";
                    } else {
                        $errorMessage = "Error al actualizar la contraseña: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($updateStmt);
                } else {
                    $errorMessage = "Error en la preparación de la consulta: " . mysqli_error($conn);
                }
            } else {
                $errorMessage = "Las contraseñas nuevas no coinciden.";
            }
        } else {
            $errorMessage = "La contraseña actual es incorrecta.";
        }
    } else {
        $errorMessage = "Error en la preparación de la consulta: " . mysqli_error($conn);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
}
?>