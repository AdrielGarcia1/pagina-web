<?php
// Inicia sesión (si aún no se ha iniciado)
session_start();

// Verificar si existe la variable de sesión del nombre de usuario
if (isset($_SESSION['username'])) {
    // El usuario ha iniciado sesión
    $username = $_SESSION['username']; // Obtener el nombre de usuario de la sesión

    // Verificar si existe la variable de sesión del ID del usuario
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Obtener el ID del usuario de la sesión
    $message = "¡Bienvenido, $username!";
    if ($userId !== null) {
        $message .= " Tu ID de usuario es: $userId";
    }
} else {
    // El usuario no ha iniciado sesión
    $username = null; 
    $message = "Por favor, inicia sesión para acceder a todas las funciones.";
}
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
 <?php include('../../../components/topbar.php'); ?>
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
                        <h1 class="m-0 display-5 font-weight-semi-bold">DISORDER</h1>
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
                                    <a href="../../../admin/products.php" class="dropdown-item">Productos</a>
                                    <a href="../../../admin/user/user_report.php" class="dropdown-item">Usuarios</a>
                                </div>
                            </div>                            
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Usuarios</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../../admin/user/user_list.php" class="dropdown-item">Lista</a>                                   
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Productos</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../../admin/products/add_product.php" class="dropdown-item">Agregar producto</a>
                                     <a href="../../../admin/products/category/add_category.php" class="dropdown-item">Agregar categoria</a>
                                     <a href="../../../admin/products/talle/add_talle.php" class="dropdown-item">Agregar talle</a> 
                                </div>
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
    <!-- Contenido principal -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center-custom">Agregar nuevo talle</h2>
                        <!-- Formulario para agregar talles -->
                        <form action="process_add_talle.php" method="post">
                            <label for="talle_name">Talle:</label>
                            <input type="text" id="talle_name" name="talle_name" required>
                            <br>
                            <button type="submit" name="submit" class="btn btn-primary btn-block btn-primary-custom">Cargar Talle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <?php include('../../../components/footer.php'); ?>
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../../../lib/easing/easing.min.js"></script>
    <script src="../../../lib/owlcarousel/owl.carousel.min.js"></script>
</body>
</html>