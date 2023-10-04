<?php
session_start();

// Verificar si existe la variable de sesión del nombre de usuario
if (isset($_SESSION['username'])) {
    // Botón de "Cerrar Sesión"
    $logoutButton = '<a href="../login/cerrar_sesion.php" class="nav-item nav-link">Cerrar Sesión</a>';
} else {
    // Botones de "Login" y "Register"
    $loginButton = '<a href="../login/login.php" class="nav-item nav-link">Login</a>';
    $registerButton = '<a href="../register/register.php" class="nav-item nav-link">Registrar</a>';
}
 // Incluye el archivo de conexión a la base de datos
 require_once('../db_connection/db_connection.php');
// Verificar si existe la variable de sesión del nombre de usuario
if (isset($_SESSION['username'])) {
    // El usuario ha iniciado sesión
    $username = $_SESSION['username']; // Obtener el nombre de usuario de la sesión

    // Realizar una consulta SQL para obtener el correo electrónico del usuario
    $sql = "SELECT correo FROM usuarios WHERE nombre = ?";

    // Crear una nueva conexión a la base de datos
    $conn = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);

    // Verificar si la conexión tuvo éxito
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Preparar la consulta
    $stmt = mysqli_prepare($conn, $sql);

    // Verificar si la preparación de la consulta tuvo éxito
    if ($stmt) {
        // Asociar el parámetro a la consulta
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);

        // Obtener el resultado de la consulta
        mysqli_stmt_bind_result($stmt, $email);

        // Obtener el correo electrónico
        mysqli_stmt_fetch($stmt);

        // Cerrar la consulta y la conexión
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TIENDA</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="../img/d.jpg" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
        <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                   
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold">TIENDA</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                   <?php
    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION['username'])) {
        // El usuario ha iniciado sesión, por lo que muestra el enlace al perfil
        echo '<a href="user.php" class="btn border"><i class="fas fa-user text-primary"></i></a>';
    } else {
        // El usuario no ha iniciado sesión, muestra el enlace a la página de inicio de sesión
        echo '<a href="../../login/login.php" class="btn border"><i class="fas fa-sign-in-alt text-primary"></i></a>';
    }
    ?>
                <a href="../pag/cart.php" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>                    
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
           <div class="col-lg-3 d-none d-lg-block">
               <a class="btn shadow-none d-flex align-items-center justify-content-center bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                  <h6 class="m-0">PERFIL</h6>
               </a>
           </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="../pag/index.php" class="nav-item nav-link active">Inicio</a>
                            <a href="../pag/shop.php" class="nav-item nav-link">Productos</a>                            
                            <?php                 
                              if (isset($_SESSION['username'])) {                                     
                                echo '<a href="../pag/cart.php" class="nav-item nav-link">Carrito</a>';                                
                              } else {                                  
                                echo '<a href="../login/login.php" class="nav-item nav-link">Carrito </a>';                                
                              }
                            ?> 
                            <a href="../pag/contact.php" class="nav-item nav-link">Contacto</a>
                        </div>
                           <div class="navbar-nav ml-auto py-0">
                             <?php
                               if (isset($logoutButton)) {
                                 echo $logoutButton; // Mostrar el botón "Cerrar Sesión" si el usuario ha iniciado sesión
                               } else {
                                   // Mostrar el botón "Login" y "Register" si el usuario no ha iniciado sesión
                                 echo $loginButton; 
                                 echo $registerButton;
                               }
                             ?>
                          </div>
                    </div>
                  </nav>                
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Contenedor principal para el perfil de usuario -->
    <div class="container mt-5">
        <!-- Encabezado con nombre de usuario y correo centrados -->
        <div class="row justify-content-center">
            <div class="col-md-6 text-center border p-4">
                <h2><?php echo $username; ?></h2>
                <p><?php echo $email; ?></p>
            </div>
        </div>

        <!-- Opciones del perfil centradas verticalmente -->
<div class="row justify-content-center mt-3">
    <div class="col-md-6">
        <div class="list-group">
            <a href="../user/personal_information/personal_Info.php" class="list-group-item list-group-item-action text-center">
                Información personal
            </a>
            <a href="../user/security/change_password.php" class="list-group-item list-group-item-action text-center">
                Seguridad
            </a>
            <a href="../user/address/edit_address.php" class="list-group-item list-group-item-action text-center">
                Direcciones
            </a>
            <a href="#" id="eliminarCuentaBtn" class="list-group-item list-group-item-action text-center">
                Eliminar cuenta
            </a>
            <form id="eliminarCuentaForm" action="Delete_account.php" method="POST" style="display: none;">
    <!-- Campo oculto para confirmar la eliminación -->
    <input type="hidden" name="confirmar_eliminar" value="1">
    <!-- Botón "Eliminar cuenta" real -->
    <button type="submit" class="list-group-item list-group-item-action text-center">Confirmar Eliminar Cuenta</button>
</form>
        </div>
    </div>
</div>

<!-- Formulario de eliminación de cuenta (oculto) -->


<script>
document.addEventListener("DOMContentLoaded", function () {
    var eliminarCuentaBtn = document.getElementById("eliminarCuentaBtn");
    var eliminarCuentaForm = document.getElementById("eliminarCuentaForm");

    eliminarCuentaBtn.addEventListener("click", function (e) {
        e.preventDefault();
        
        // Muestra un cuadro de diálogo de confirmación
        var confirmar = confirm("¿Está seguro de que desea eliminar su cuenta? Esta acción no se puede deshacer.");

        // Si el usuario confirma, muestra el formulario de eliminación de cuenta
        if (confirmar) {
            eliminarCuentaForm.style.display = "block";
        } else {
            // Si el usuario cancela, no hace nada
        }
    });
});
</script>
<?php include('../components/footer.php'); ?>
        <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
        <!-- Template Javascript -->
    <script src="../js/main.js"></script>
    </body>
</html>