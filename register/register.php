<?php
require_once "register_process.php";
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php include('../components/topbar.php'); ?>
<!-- Navbar Start -->
<div class="container-fluid mb-5">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn shadow-none d-flex align-items-center justify-content-center bg-primary text-white w-100"
               data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">REGISTRO</h6>
            </a>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold">TIENDA</h1>
                </a>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="../pag/index.php" class="nav-item nav-link">Inicio</a>
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
                        <a href="../login/login.php" class="nav-item nav-link">Iniciar Sesión</a>
                        <a href="../register/register.php" class="nav-item nav-link">Registrar</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->

<script>
 $(document).ready(function () {
        // Función para verificar la disponibilidad del nombre de usuario
        $("#username").on("input", function () {
            var username = $(this).val();

            if (username !== "") {
                $.ajax({
                    url: "verificar_usuario.php",
                    type: "POST",
                    data: { username: username },
                    dataType: "json",
                    success: function (response) {
                        if (response.existe) {
                            // El nombre de usuario ya existe, muestra sugerencias
                            $("#usernameMessage").html("El nombre de usuario ya está en uso. Prueba con otro:<br>");

                            // Muestra las sugerencias (si las hay)
                            if (response.sugerencias && response.sugerencias.length > 0) {
                                $("#usernameMessage").append();
                                var ul = $("<ul>");
                                $.each(response.sugerencias, function (index, sugerencia) {
                                    ul.append($("<li>").text(sugerencia));
                                });
                                $("#usernameMessage").append(ul);
                            }
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

     $(document).ready(function () {
        // Función para verificar la disponibilidad del DNI
        $("#dni").on("input", function () {
            var dni = $(this).val();

            if (dni !== "") {
                $.ajax({
                    url: "verificar_dni.php",
                    type: "POST",
                    data: { dni: dni },
                    dataType: "json",
                    success: function (response) {
                        if (response.existe) {
                            // El DNI ya está registrado, muestra un mensaje de error
                            $("#dniMessage").html("El DNI ya está registrado. Por favor, ingresa otro.");
                        } else {
                            // El DNI está disponible, borra el mensaje de error
                            $("#dniMessage").html("");
                        }
                    },
                });
            } else {
                // El campo está vacío, no se realiza ninguna verificación
                $("#dniMessage").html("");
            }
        });
    });
    function validarRegistro() {
        var numero_telefono = document.getElementById("numero_telefono").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var confirm_password = document.getElementById("confirm_password").value;
        var dni = document.getElementById("dni").value;

        // Validación de número de teléfono
        if (numero_telefono.length < 9 || isNaN(numero_telefono)) {
            alert("El número de teléfono debe tener al menos 9 dígitos y contener solo números.");
            return false;
        }

        // Validación de correo electrónico
        var emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;
        if (!emailRegex.test(email)) {
            alert("El correo electrónico no es válido.");
            return false;
        }

        // Validación de contraseña
        if (password.length < 6) {
            alert("La contraseña debe tener al menos 6 caracteres.");
            return false;
        }

        // Validación de confirmación de contraseña
        if (password !== confirm_password) {
            alert("Las contraseñas no coinciden.");
            return false;
        }

        // Validación de DNI
        if (dni.length !== 8 || isNaN(dni)) {
            alert("El DNI debe contener exactamente 8 dígitos y contener solo números.");
            return false;
        }

        return true;
    }
</script>
<!-- Register Form Start -->
<div class="container mt-5">
    <div class="row justify-content-center text-dark">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Registro de Usuario</h2>
                    <form action="../register/register.php" method="POST" onsubmit="return validarRegistro();">
                        <div class="form-group">
                            <h5 for="username">Nombre de Usuario:</h5>
                            <input type="text" id="username" name="username" class="form-control"
                                   placeholder="Ingresa tu Nombre de Usuario" required>
                            <div id="usernameMessage" class="text-danger"></div>
                            <div class="text-danger"><?php echo $errorUsername; ?></div>
                        </div>
                        <div class="form-group">
                            <h5 for="nombre_real">Nombre Real:</h5>
                            <input type="text" id="nombre_real" name="nombre_real" class="form-control"
                                   placeholder="Ingresa tu Nombre Real" required>
                        </div>
                        <div class="form-group">
                            <h5 for="apellido">Apellido:</h5>
                            <input type="text" id="apellido" name="apellido" class="form-control"
                                   placeholder="Ingresa tu Apellido" required>
                        </div>
                        <div class="form-group">
                            <h5 for="numero_telefono">Número de Teléfono:</h5>
                            <input type="text" id="numero_telefono" name="numero_telefono" class="form-control"
                                   placeholder="Ingresa tu Número de Teléfono" required>
                        </div>
                        <div class="form-group">
                            <h5 for="email">Correo Electrónico:</h5>
                            <input type="email" id="email" name="email" class="form-control"
                                   placeholder="Ingresa tu Correo Electrónico" required>
                            <div id="emailMessage" class="text-danger"></div>
                            <div class="text-danger"><?php echo $errorEmail; ?></div>
                        </div>
                        <div class="form-group">
                            <h5 for="password">Contraseña:</h5>
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="Ingresa tu Contraseña" required>
                        </div>
                        <div class="form-group">
                            <h5 for="confirm_password">Confirmar Contraseña:</h5>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                                   placeholder="Ingresa nuevamente tu Contraseña" required>
                        </div>
                        <div class="form-group">
                            <h5 for="dni">DNI:</h5>
                            <input type="text" id="dni" name="dni" class="form-control"
                                   placeholder="Ingresa tu DNI" required>
                            <div id="dniMessage" class="text-danger"></div>
                            <div class="text-danger"><?php echo $errorDNI; ?></div>
                        </div>
                        <div class="form-group">
                            <h5 for="codigo_postal">Código Postal:</h5>
                            <input type="text" id="codigo_postal" name="codigo_postal" class="form-control"
                                   placeholder="Ingresa tu Código Postal" required>
                        </div>
                        <div class="form-group">
                            <h5 for="province">Provincia:</h5>
                            <select id="province" name="province" class="form-control" required>
                                <?php while ($row = mysqli_fetch_assoc($provinces_result)) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre_provincia']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <h5 for="city">Ciudad/Pueblo:</h5>
                            <input type="text" id="city" name="city" class="form-control"
                                   placeholder="Ingresa tu Ciudad o Pueblo" required>
                        </div>
                        <div class="form-group">
                            <h5 for="address">Dirección:</h5>
                            <textarea id="address" name="address" class="form-control"
                                      placeholder="Ingresa tu Dirección" required></textarea>
                        </div>
                        <div id="registrationErrorMessage" class="text-danger"></div>
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
    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>
</html>