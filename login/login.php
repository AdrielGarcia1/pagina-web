<?php include('../components/buttons.php'); ?>
<?php
// Inicia la sesión en la parte superior del archivo    

// Incluye el archivo de conexión a la base de datos
require_once "../db_connection/db_connection.php";

// Inicializa las variables
$username = "";
$password = "";
$errors = array();
$errorMessage = ""; // Variable para almacenar el mensaje de error

// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura los datos del formulario
    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);

    // Validación básica
    if (empty($username) || empty($password)) {
        array_push($errors, "El nombre de usuario y la contraseña son requeridos");
    }
    // Si no hay errores de validación, procede con la autenticación
    if (count($errors) == 0) {
        $query = "SELECT * FROM usuarios WHERE nombre='$username'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Verificar el estado del usuario antes de autenticar
            if ($user['estado'] == 0) {
                array_push($errors, "Tu cuenta está desactivada. Por favor, contacta al soporte.");
                $errorMessage = "Tu cuenta está desactivada. Por favor, contacta al soporte.";
            } else {
                if (password_verify($password, $user['contrasena'])) {
                    // Inicio de sesión exitoso, establece una variable de sesión
                    $_SESSION['username'] = $username;

                    // Verifica el tipo del usuario
                    if ($user['tipo'] == 'administrador') {
                        // Si el usuario es un administrador, redirige a admin_index.php
                        header('location: ../admin/admin_index.php');
                    } else {
                        // Si el usuario es un usuario regular, redirige a index.php
                        header('location: ../pag/index.php');
                    }
                    exit(); // Asegúrate de detener la ejecución del script después de redirigir
                } else {
                    array_push($errors, "Contraseña incorrecta");
                    $errorMessage = "Nombre de usuario o contraseña incorrectos.";
                }
            }
        } else {
            array_push($errors, "Nombre de usuario no encontrado");
            $errorMessage = "Nombre de usuario o contraseña incorrectos.";
        }
    }
}

// Cierra la conexión a la base de datos
mysqli_close($connection);
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
    <?php include('../components/topbar.php'); ?>
    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
                       <div class="col-lg-3 d-none d-lg-block">
               <a class="btn shadow-none d-flex align-items-center justify-content-center bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                  <h6 class="m-0">LOGIN</h6>
               </a>
           </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold">TIENDA</h1>
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
                                echo ' <a href="../pag/checkout.php" class="nav-item nav-link">Pagar</a>';
                              } else {                                  
                                echo '<a href="../login/login.php" class="nav-item nav-link">Carrito </a>';
                                echo '<a href="../login/login.php" class="nav-item nav-link">Pagar</a>';
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
    <!-- Login Form Start -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Iniciar Sesión</h2>
                         <?php if (!empty($errorMessage)) : ?>
                           <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                         <?php endif; ?>
                        <form method="POST" action="../login/login.php">                         
                            <div class="form-group">
                                <h5 class="text-dark" for="username">Nombre de Usuario</h5>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" placeholder="Ingresa tu nombre de usuario" required>
                            </div>
                            <div class="form-group">
                                <h5 class="text-dark" for="password">Contraseña</h5>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                            </div>
                            <p class="text-center text-dark"><a href="forgot_password.php">¿Olvidaste tu contraseña?</a></p>
                            <p  class="text-center text-dark">¿No tienes una cuenta? <a href="../register/register.php">Regístrate</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Form End -->
<?php include('../components/footer.php'); ?>
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>
</html>