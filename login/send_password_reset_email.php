<?php
// Incluye el archivo de conexión a la base de datos
require_once "../db_connection/db_connection.php";
// Carga la biblioteca PHPMailer
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene el correo electrónico del formulario
    $email = $_POST["email"];

    // Consulta SQL para verificar si el correo electrónico existe en la base de datos
    $sql = "SELECT id FROM usuarios WHERE correo = '$email'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        // El correo electrónico existe en la base de datos

        // Genera una nueva contraseña aleatoria
        $new_password = substr(md5(rand()), 0, 10);

        // Actualiza la contraseña del usuario en la base de datos
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE usuarios SET contrasena = '$hashed_password' WHERE correo = '$email'";
        if ($connection->query($update_sql) === TRUE) {
            // Crea una nueva instancia de PHPMailer
            $mail = new PHPMailer;

            // Indica a PHPMailer que use SMTP
            $mail->isSMTP();

            // Resto de la configuración de PHPMailer...
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->Username = 'garciaadriel65@gmail.com';
            $mail->Password = '13579Mayo_1999';

            // Quién envía el mensaje
            $mail->setFrom('garciaadriel65@gmail.com', 'Adriel');

            // Dirección de respuesta
            $mail->addReplyTo('garciaadriel65@gmail.com', 'Adriel');

            // Agrega el destinatario del formulario
            $mail->addAddress($email, 'Nombre del Destinatario');

            // Asunto del correo
            $mail->Subject = 'Recuperación de contraseña';

            // Contenido HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Body = 'Tu nueva contraseña es: ' . $new_password;

            // Texto alternativo
            $mail->AltBody = 'No olvides suscribirte a nuestro canal.';

            // Intenta enviar el correo electrónico
            if ($mail->send()) {
                echo "Se ha enviado un correo electrónico con la nueva contraseña.";
            } else {
                echo "Error al enviar el correo electrónico: " . $mail->ErrorInfo;
            }
        } else {
            echo "Error al actualizar la contraseña en la base de datos.";
        }
    } else {
        // El correo electrónico no existe en la base de datos
        echo "El correo electrónico ingresado no está registrado en nuestra base de datos.";
    }
}

// Cierra la conexión a la base de datos al final del script si es necesario
$connection->close();
?>