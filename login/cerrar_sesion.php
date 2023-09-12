<?php
// Iniciar o reanudar la sesión
session_start();

// Destruir la sesión actual
session_destroy();

// Redirigir a la página de inicio (index.php)
header("Location: ../pag/index.php");
exit; // Asegúrate de que el script se detenga después de la redirección
?>
