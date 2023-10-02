<?php
session_start();

// Verificar si existe la variable de sesión del nombre de usuario
if (isset($_SESSION['username'])) {
    // Botón de "Cerrar Sesión"
    $logoutButton = '<a href="../../login/cerrar_sesion.php" class="nav-item nav-link">Cerrar Sesión</a>';
} else {
    // Botones de "Login" y "Register"
    $loginButton = '<a href="../../login/login.php" class="nav-item nav-link">Login</a>';
    $registerButton = '<a href=".././register/register.php" class="nav-item nav-link">Registrar</a>';
}

// Incluye el archivo de conexión a la base de datos
require_once('../../db_connection/db_connection.php');

// Inicia sesión (si aún no se ha iniciado)
if (isset($_SESSION['username'])) {
    // El usuario ha iniciado sesión
    $username = $_SESSION['username']; // Obtener el nombre de usuario de la sesión

    // Crea una nueva conexión a la base de datos (similar a user.php)
    $conn = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);

    // Verificar si la conexión tuvo éxito
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Realiza la consulta SQL para obtener la información del usuario
    $sql = "SELECT nombre, nombre_real, apellido, numero_telefono, correo, DNI FROM usuarios WHERE nombre = ?";

    // Preparar la consulta
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Asociar el parámetro a la consulta
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);

        // Obtener los resultados de la consulta
        mysqli_stmt_bind_result($stmt, $nombre, $nombre_real, $apellido, $numero_telefono, $correo, $DNI);

        // Obtener los datos del usuario
        mysqli_stmt_fetch($stmt);

        // Cerrar la consulta
        mysqli_stmt_close($stmt);
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
    <link href="../../img/d.jpg" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../../css/style.css" rel="stylesheet">
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
                
            </div>
            <div class="col-lg-3 col-6 text-right">
                   <?php
    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION['username'])) {
        // El usuario ha iniciado sesión, por lo que muestra el enlace al perfil
        echo '<a href="../../user/user.php" class="btn border"><i class="fas fa-user text-primary"></i></a>';
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
                            <a href="../../pag/index.php" class="nav-item nav-link active">Inicio</a>
                            <a href="../../pag/shop.php" class="nav-item nav-link">Productos</a>                          
                            <?php                 
                              if (isset($_SESSION['username'])) {                                     
                                echo '<a href="../../pag/cart.php" class="nav-item nav-link">Carrito</a>';
                                echo ' <a href="../../pag/checkout.php" class="nav-item nav-link">Pagar</a>';
                              } else {                                  
                                echo '<a href="../../login/login.php" class="nav-item nav-link">Carrito </a>';
                                echo '<a href="../../login/login.php" class="nav-item nav-link">Pagar</a>';
                              }
                            ?>   
                            <a href="../../pag/contact.php" class="nav-item nav-link">Contacto</a>
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

        <!--Main content -->
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <h2>Mi Información Personal</h2>

            <!-- Formulario para mostrar y editar datos del usuario -->
            <form action="update_info.php" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre de Usuario:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
                </div>
                <div class="form-group">
                    <label for="nombre_real">Nombre Real:</label>
                    <input type="text" class="form-control" id="nombre_real" name="nombre_real" value="<?php echo $nombre_real; ?>" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $correo; ?>" required>
                </div>
                <div class="form-group">
                    <label for="numero_telefono">Número de Teléfono:</label>
                    <input type="text" class="form-control" id="numero_telefono" name="numero_telefono" value="<?php echo $numero_telefono; ?>" required>
                </div>
                <div class="form-group">
                    <label for="DNI">DNI:</label>
                    <input type="text" class="form-control" id="DNI" name="DNI" value="<?php echo $DNI; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Información</button>
            </form>
        </div>
    </div>
</div>
<!-- Main content end -->
<?php include('../../components/footer.php'); ?>
        <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../../lib/easing/easing.min.js"></script>
        <!-- Template Javascript -->
    <script src="../js/main.js"></script>
    </body>
</html>