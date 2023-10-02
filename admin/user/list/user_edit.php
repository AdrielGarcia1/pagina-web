<?php
session_start();

// Incluye el archivo de conexión a la base de datos
require_once('../../../db_connection/db_connection.php');

// Inicializa variables para almacenar los datos del usuario
$nombre = $nombre_real = $apellido = $correo = $numero_telefono = $DNI = "";

// Verificar si se ha enviado el ID del usuario a editar
if (isset($_GET["id"])) {
    // Obtener el ID del usuario a editar desde la URL
    $id = $_GET["id"];

    // Consultar la base de datos para obtener los datos del usuario a editar
    $sql = "SELECT nombre, nombre_real, apellido, correo, numero_telefono, DNI, estado FROM usuarios WHERE id = ?";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        // Asociar el parámetro a la consulta
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);

        // Obtener los resultados de la consulta
        mysqli_stmt_bind_result($stmt, $nombre, $nombre_real, $apellido, $correo, $numero_telefono, $DNI, $estado);

        // Obtener los datos del usuario
        mysqli_stmt_fetch($stmt);

        // Cerrar la consulta
        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($connection);
    }
}
// Cerrar la conexión a la base de datos
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
    <link href="../../../img/d.jpg" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../../../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../../../css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-3 px-xl-5">
        </div>
        <div class="row align-items-center py-2 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold">TIENDA</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
            <a href="../../adminuser/user.php" class="btn border"><i class="fas fa-user text-primary"></i></a>
            </div>
        </div>
    </div>
<!-- Topbar End -->
 <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">USUARIOS</h6>                    
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
                            <a href="../../../admin/admin_index.php" class="nav-item nav-link active">Inicio</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Informes</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../products/report/product_report.php" class="dropdown-item">Productos</a>
                                    <a href="../../../admin/user/user_report.php" class="dropdown-item">Usuarios</a>
                                </div>
                            </div>                            
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Usuarios</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../../admin/user/list/user_list.php" class="dropdown-item">Lista</a>                                   
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Productos</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../../admin/products/list/product_list.php" class="dropdown-item">Lista productos</a>
                                    <a href="../../../admin/products/add_product.php" class="dropdown-item">Agregar producto</a>
                                    <a href="../../../admin/products/category/add_category.php" class="dropdown-item">Agregar categoria</a>
                                    <a href="../../../admin/products/talle/add_talle.php" class="dropdown-item">Agregar talle</a> 
                                </div>
                            </div>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <a href="../../../login/login.php" class="nav-item nav-link">Cerrar Sesion</a>                            
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
            
             <h2>Editar Usuario</h2>
            <!-- Formulario para mostrar y editar datos del usuario -->
            
    <form action="user_update.php" method="POST">
        <input type="hidden" name="usuario_id" value="<?php echo $id; ?>">
        <div class="form-group">
            <h5 for="nombre">Nombre de Usuario:</h5>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
        </div>
        <div class="form-group">
            <h5 for="nombre_real">Nombre Real:</h5>
            <input type="text" class="form-control" id="nombre_real" name="nombre_real" value="<?php echo $nombre_real; ?>" required>
        </div>
        <div class="form-group">
            <h5 for="apellido">Apellido:</h5>
            <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>
        </div>
        <div class="form-group">
            <h5 for="correo">Correo Electrónico:</h5>
            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $correo; ?>" required>
        </div>
        <div class="form-group">
            <h5 for="numero_telefono">Número de Teléfono:</h5>
            <input type="text" class="form-control" id="numero_telefono" name="numero_telefono" value="<?php echo $numero_telefono; ?>" required>
        </div>
        <div class="form-group">
            <h5 for="DNI">DNI:</h5>
            <input type="text" class="form-control" id="DNI" name="DNI" value="<?php echo $DNI; ?>" required>
        </div>        
        <button type="submit" class="btn btn-primary">Actualizar Información</button>
    </form>
        </div>
    </div>
</div>
<!-- Main content end -->
<div class="container-fluid bg-secondary text-dark mt-2 pt-2">
        <div class="row px-xl-2 pt-2">
            <div class="col-lg-4 col-md-8 mb-5 pr-3 pr-xl-5">
                
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        
                        <div class="d-flex flex-column justify-content-start">
                           
                        </div>
                    </div>
                    <div class="col-md-4 mb-7">
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../../../lib/easing/easing.min.js"></script>
    </body>
</html>