<?php include('update_address.php'); ?>
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
               
            </div>
            <div class="col-lg-3 col-6 text-right">
            <a href="../user.php" class="btn border"><i class="fas fa-user text-primary"></i></a>
            </div>
        </div>
    </div>
<!-- Topbar End -->
    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
               <a class="btn shadow-none d-flex align-items-center justify-content-center bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                  <h6 class="m-0">INICIO</h6>
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
                            <a href="../../admin_index.php" class="nav-item nav-link active">Inicio</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Informes</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../products/report/product_report.php" class="dropdown-item">Productos</a>
                                    <a href="../../user/user_report.php" class="dropdown-item">Usuarios</a>
                                </div>
                            </div>                            
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Usuarios</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../user/list/user_list.php" class="dropdown-item">Lista</a>                                   
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Productos</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                     <a href="../../products/list/product_list.php" class="dropdown-item">Lista productos</a>
                                     <a href="../../products/add_product.php" class="dropdown-item">Agregar producto</a>
                                     <a href="../../products/category/add_category.php" class="dropdown-item">Agregar categoria</a>
                                     <a href="../../products/talle/add_talle.php" class="dropdown-item">Agregar talle</a> 
                                </div>
                            </div>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <a href="../../../login/cerrar_sesion.php" class="nav-item nav-link">Cerrar Sesion</a>                            
                        </div>
                    </div>
                </nav>           
            </div>
        </div>
    </div>
    <!-- Navbar End -->
    <!-- Content Start -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Editar Perfil</h2>
<!--Main content -->
<form action="../user/edit_profile.php" method="POST">
    <div class="form-group">
        <label for="province">Provincia:</label>
        <select id="province" name="province" class="form-control" required>
            <?php while ($row = mysqli_fetch_assoc($provinces_result)) { ?>
                <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $currentProvinceId) echo 'selected="selected"'; ?>><?php echo $row['nombre_provincia']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="city">Ciudad/Pueblo:</label>
        <input type="text" id="city" name="city" class="form-control" placeholder="Ingresa tu Ciudad o Pueblo" value="<?php echo $currentCity; ?>" required>
    </div>
    <div class="form-group">
        <label for="address">Dirección:</label>
        <textarea id="address" name="address" class="form-control" placeholder="Ingresa tu Dirección" required><?php echo $currentAddress; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
</form>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content End -->
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
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../../lib/easing/easing.min.js"></script>
</body>

</html>