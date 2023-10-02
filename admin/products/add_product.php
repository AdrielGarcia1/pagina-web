<?php
// Inicia sesión (si aún no se ha iniciado)
session_start();
// Include the database connection
include_once('../../db_connection/db_connection.php');

// Obtener categorías desde la base de datos
$queryCategorias = "SELECT id, nombre_categoria FROM categorias";
$resultCategorias = mysqli_query($connection, $queryCategorias);

// Obtener talles desde la base de datos
$queryTalles = "SELECT id, nombre_talle FROM talles";
$resultTalles = mysqli_query($connection, $queryTalles);

// Obtener colores desde la base de datos
$queryColores = "SELECT id, nombre_color FROM colores";
$resultColores = mysqli_query($connection, $queryColores);

// Mensajes de éxito y error
$mensajeExito = $mensajeError = '';
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
            <a href="../adminuser/user.php" class="btn border"><i class="fas fa-user text-primary"></i></a>
            </div>
        </div>
    </div>
<!-- Topbar End -->
<!-- Navbar Start -->
<div class="container-fluid mb-5">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse"
                href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
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
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="../../admin/admin_index.php" class="nav-item nav-link active">Inicio</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Informes</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="report/product_report.php" class="dropdown-item">Productos</a>
                                    <a href="../../admin/user/user_report.php" class="dropdown-item">Usuarios</a>
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Usuarios</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../admin/user/list/user_list.php" class="dropdown-item">Lista</a>
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Productos</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../admin/products/list/product_list.php" class="dropdown-item">Lista productos</a>
                                    <a href="../../admin/products/add_product.php" class="dropdown-item">Agregar producto</a>
                                    <a href="../../admin/products/category/add_category.php" class="dropdown-item">Agregar categoria</a>
                                    <a href="../../admin/products/talle/add_talle.php" class="dropdown-item">Agregar talle</a>
                                </div>
                            </div>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <a href="../../login/cerrar_sesion.php" class="nav-item nav-link">Cerrar Sesion</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->
<div class="container mt-3">
    <?php if (!empty($mensajeExito)) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $mensajeExito; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($mensajeError)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $mensajeError; ?>
        </div>
    <?php endif; ?>
</div>  
<div class="row justify-content-center">
     <h1 class="text-center">Alta de Producto</h1>
    </div>
<!-- Formulario para dar de alta un producto -->
<div class="row justify-content-center">

    <form action="product_registration_process.php" method="POST" enctype="multipart/form-data" class="text-center">
        <div class="form-group">
            <h5 class="text-dark" for="nombre"><b>Nombre del Producto:</b></h5>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <h5 class="text-dark" for="precio"><b>Precio:</b></h5>
            <input type="number" class="form-control" id="precio" name="precio" required>
        </div>
        <div class="form-group">
            <h5 class="text-dark" for="stock"><b>Stock:</b></h5>
            <input type="number" class="form-control" id="stock" name="stock" required>
        </div>
        <div class="form-group">
            <h5 class="text-dark" for="categoria"><b>Categoría:</b></h5>
            <select class="form-control" id="categoria" name="categoria" required>
                <?php while ($rowCategoria = mysqli_fetch_assoc($resultCategorias)) : ?>
                    <option value="<?php echo $rowCategoria['id']; ?>"><?php echo $rowCategoria['nombre_categoria']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <h5 class="text-dark" for="talle"><b>Talle:</b></h5>
            <select class="form-control" id="talle" name="talle">
                <?php while ($rowTalle = mysqli_fetch_assoc($resultTalles)) : ?>
                    <option value="<?php echo $rowTalle['id']; ?>"><?php echo $rowTalle['nombre_talle']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <h5 class="text-dark" for="color"><b>Color:</b></h5>
            <select class="form-control" id="color" name="color">
                <?php while ($rowColor = mysqli_fetch_assoc($resultColores)) : ?>
                    <option value="<?php echo $rowColor['id']; ?>"><?php echo $rowColor['nombre_color']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <h5 class="text-dark" for="descripcion_corta"><b>Descripción Corta:</b></h5>
            <textarea class="form-control" id="descripcion_corta" name="descripcion_corta" rows="4"></textarea>
        </div>
        <div class="form-group">
            <h5 class="text-dark"for="descripcion_larga"><b>Descripción Larga:</b></h5>
            <textarea class="form-control" id="descripcion_larga" name="descripcion_larga" rows="4"></textarea>
        </div>
        <div class="form-group">
    <h5 class="text-dark" for="imagenes"><b>Imágenes del Producto:</b></h5>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="imagenes" name="imagen" accept=".jpg, .jpeg, .png, .gif" required>
        <h5 class="text-dark" class="custom-file-h5" for="imagenes">Elegir Archivo</h5>
    </div>
    <span id="nombreImagenes"></span>
</div>

<script>
    // Obtener el elemento de entrada de imagen
    const imagenesInput = document.getElementById("imagenes");

    // Obtener el elemento donde se mostrará el nombre de la imagen
    const nombreImagenes = document.getElementById("nombreImagenes");

    // Agregar un evento de cambio al elemento de entrada de imagen
    imagenesInput.addEventListener("change", function() {
        const archivos = imagenesInput.files;
        if (archivos.length > 0) {
            // Mostrar los nombres de los archivos seleccionados
            const nombres = Array.from(archivos).map(file => file.name);
            nombreImagenes.textContent = nombres.join(", ");
        } else {
            // Restablecer el valor del campo de entrada si no hay imágenes seleccionadas
            nombreImagenes.textContent = "Elegir Archivo";
        }
    });
</script>

        <button type="submit" class="btn btn-primary">Agregar Producto</button>
    </form>
</div>
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
<script src="../../lib/easing/easing.min.js"></script>
<script src="../../lib/owlcarousel/owl.carousel.min.js"></script>
<script src="../../js/main.js"></script>
</body>
</html>