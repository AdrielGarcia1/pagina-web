<?php
include("update_product.php");
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
            <a href="../../../user/user.php" class="btn border"><i class="fas fa-user text-primary"></i></a>
            </div>
        </div>
    </div>
<!-- Topbar End -->
<!-- Navbar Start -->
<div class="container-fluid mb-5">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
               <a class="btn shadow-none d-flex align-items-center justify-content-center bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                  <h6 class="m-0">CATEGORIAS</h6>
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
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="../../../admin/admin_index.php" class="nav-item nav-link active">Inicio</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Informes</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../admin/products/add_product.php" class="dropdown-item">Productos</a>
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
                        <div class="navbar-nav ml-auto py-0">
                            <a href="../../../login/login.php" class="nav-item nav-link">Cerrar Sesion</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->
    <!-- Centra el formulario -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h1 class="text-center">Editar Producto</h1>
                <form action="update_product.php?id=<?php echo $producto_id; ?>" method="post">
                    <label for="nombre">Nombre del Producto:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
                    <br>

                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>
                    <br>

                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" name="stock" value="<?php echo $producto['stock']; ?>" required>
                    <br>

                    <!-- Menú desplegable para Categoría -->
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria">
                        <?php
                        foreach ($categorias as $categoria) {
                            $selected = ($categoria['id'] == $producto['categoria_id']) ? 'selected' : '';
                            echo '<option value="' . $categoria['id'] . '" ' . $selected . '>' . $categoria['nombre_categoria'] . '</option>';
                        }
                        ?>
                    </select>
                    <br>

                    <!-- Menú desplegable para Talle -->
                    <label for="talle">Talle:</label>
                    <select id="talle" name="talle">
                        <?php
                        foreach ($talles as $talle) {
                            $selected = ($talle['id'] == $producto['talle_id']) ? 'selected' : '';
                            echo '<option value="' . $talle['id'] . '" ' . $selected . '>' . $talle['nombre_talle'] . '</option>';
                        }
                        ?>
                    </select>
                    <br>

                    <!-- Menú desplegable para Color -->
                    <label for="color">Color:</label>
                    <select id="color" name="color">
                        <?php
                        foreach ($colores as $color) {
                            $selected = ($color['id'] == $producto['color_id']) ? 'selected' : '';
                            echo '<option value="' . $color['id'] . '" ' . $selected . '>' . $color['nombre_color'] . '</option>';
                        }
                        ?>
                    </select>
                    <br>

                    <!-- Agrega más campos para los detalles del producto si es necesario -->

                    <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>