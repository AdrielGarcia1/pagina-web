<?php require_once "register_process.php";?>
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
<?php include('../components/topbar.php'); ?>
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
                            <a href="../pag/index.php" class="nav-item nav-link">Inicio</a>
                            <a href="../pag/shop.php" class="nav-item nav-link">Productos</a>                            
                            <a href="../pag/cart.php" class="nav-item nav-link">Carrito</a>
                            <a href="../pag/checkout.php" class="nav-item nav-link">Compra</a>                                    
                            <a href="../pag/contact.php" class="nav-item nav-link">Contacto</a>
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
        <input type="text" id="username" name="username" class="form-control" placeholder="Ingresa tu Nombre de Usuario" required>
        <div id="usernameMessage" class="text-danger"></div>
    </div>
    <div class="form-group">
        <label for="nombre_real">Nombre Real:</label>
        <input type="text" id="nombre_real" name="nombre_real" class="form-control" placeholder="Ingresa tu Nombre Real" required>
    </div>
    <div class="form-group">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Ingresa tu Apellido" required>
    </div>
    <div class="form-group">
        <label for="numero_telefono">Número de Teléfono:</label>
        <input type="text" id="numero_telefono" name="numero_telefono" class="form-control" placeholder="Ingresa tu Número de Teléfono" required>
    </div>
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
        <label for="codigo_postal">Código Postal:</label>
        <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" placeholder="Ingresa tu Código Postal" required>
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
   <?php include('../components/footer.php'); ?>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>    
</body>
</html>