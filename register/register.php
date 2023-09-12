<?php
// Incluye el archivo de conexión a la base de datos
require_once "../db_connection/db_connection.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Captura los datos del formulario
    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $confirm_password = mysqli_real_escape_string($connection, $_POST["confirm_password"]);

    // Obtén el valor seleccionado del menú desplegable de provincias
    $province_id = $_POST["province"]; 

    $city = mysqli_real_escape_string($connection, $_POST["city"]);
    $address = mysqli_real_escape_string($connection, $_POST["address"]);
    
    // Captura el DNI del formulario
    $dni = mysqli_real_escape_string($connection, $_POST["dni"]);

    // Verifica si las contraseñas coinciden
    if ($password != $confirm_password) {
        echo "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    } else {
        // Verifica si el nombre de usuario ya existe en la base de datos
        $check_username_query = "SELECT COUNT(*) AS count FROM usuarios WHERE nombre = '$username'";
        $result = mysqli_query($connection, $check_username_query);
        $row = mysqli_fetch_assoc($result);

        if ($row['count'] > 0) {
            echo "El nombre de usuario ya está en uso. Por favor, elige otro.";
        } else {
            // Hash de la contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepara la consulta SQL para insertar el usuario en la base de datos
            $insert_user_query = "INSERT INTO usuarios (nombre, correo, contrasena, dni, tipo, fecha_registro) 
                  VALUES ('$username', '$email', '$hashed_password', '$dni', 'cliente', NOW())";

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Disorder</title>
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
<script>
    $(document).ready(function () {
        // Función para verificar la disponibilidad del nombre de usuario
        $("#username").on("input", function () {
            var username = $(this).val();

            if (username !== "") {
                $.ajax({
                    url: "../register/verificar_usuario.php",
                    type: "POST",
                    data: { username: username },
                    dataType: "json",
                    success: function (response) {
                        if (response.existe) {
                            // El nombre de usuario ya existe, muestra sugerencias
                            $("#usernameMessage").html("El nombre de usuario ya está en uso. Prueba con otro:");
                            // Aquí puedes mostrar una lista de nombres de usuario sugeridos
                        } else {
                            // El nombre de usuario está disponible
                            $("#usernameMessage").html("");
                        }
                    },
                });
            } else {
                // El campo está vacío, no se realiza ninguna verificación
                $("#usernameMessage").html("");
            }
        });
    });
</script>
<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="">Preguntas Frecuentes</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">ayuda</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Soporte</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-dark pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold">DISORDER</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscar productos">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="../user/user.php" class="btn border">
                    <i class="fas fa-user text-primary"></i>
                </a>
                <a href="../pag/cart.php" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">0</span>
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
                  <h6 class="m-0">REGISTER</h6>
               </a>
           </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold">DISORDER</h1>
                    </a>                    
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="../pag/index.php" class="nav-item nav-link">Home</a>
                            <a href="../pag/shop.php" class="nav-item nav-link">Shop</a>
                            <a href="../pag/detail.php" class="nav-item nav-link">Shop Detail</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../pag/cart.php" class="dropdown-item">Shopping Cart</a>
                                    <a href="../pag/checkout.php" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                            <a href="../pag/contact.php" class="nav-item nav-link">Contact</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <a href="../login/login.php" class="nav-item nav-link">Login</a>
                            <a href="../register/register.php" class="nav-item nav-link">Register</a>
                        </div>
                    </div>
                </nav>                
            </div>
        </div>
    </div>
    <!-- Navbar End -->
    <!-- Register Form Start -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Registro de Usuario</h2>
                        <form action="../register/register.php" method="POST">
                            <div class="form-group">
                               <label for="username">Nombre de Usuario:</label>
                               <input type="text" id="username" name="username" class="form-control " placeholder="Ingresa tu Nombre de Usuario" required>
                            <div id="usernameMessage" class="text-danger"></div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico:</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Ingresa tu Correo Electrónico" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Ingresa tu Contraseña" required>
                            </div>                         
                            <div class="form-group">
                                <label for="confirm_password">Confirmar Contraseña:</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Ingresa nuevamente tu Contraseña" required>
                            </div>
                            <div class="form-group">
                                <label for="dni">DNI:</label>
                                <input type="text" id="dni" name="dni" class="form-control" placeholder="Ingresa tu DNI" required>
                            </div>
                            <div class="form-group">
                                <label for="province">Provincia:</label>
                                <select id="province" name="province" class="form-control" required>
                                   <?php while ($row = mysqli_fetch_assoc($provinces_result)) { ?>
                                      <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre_provincia']; ?></option>
                                      <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="city">Ciudad/Pueblo:</label>
                                <input type="text" id="city" name="city" class="form-control" placeholder="Ingresa tu Ciudad o Pueblo" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Dirección:</label>
                                <textarea id="address" name="address" class="form-control" placeholder="Ingresa tu Dirección" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form End -->
    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold">DISORDER</h1>
                </a>                
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="../pag/index.php"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="../pag/shop.php"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark mb-2" href="../pag/detail.php"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-dark mb-2" href="../pag/cart.php"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark mb-2" href="../pag/checkout.php"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark" href="../pag/contact.php"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control border-0 py-4" placeholder="Your Name" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control border-0 py-4" placeholder="Your Email"
                                    required="required" />
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="#">Your Site Name</a>. All Rights Reserved. Designed
                    by
                    <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>    
</body>
</html>