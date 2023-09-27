<?php
session_start();// Incluye el archivo de consulta de detalles del producto
include('detail/product_detail_query.php');
$id = isset($_GET['id']) ? $_GET['id'] : 'ID no definido';

// Verifica si se obtuvieron los datos del producto
if (isset($product_data)) {
    // Ahora puedes acceder a los datos del producto como $product_data['precio'], $product_data['nombre_talle'], etc.
    $precio = $product_data['precio'];
    $talle = $product_data['nombre_talle'];
    $color = $product_data['nombre_color'];
    $descripcionCorta = $product_data['descripcion_corta'];
    $descripcionLarga = $product_data['descripcion_larga'];
    $nombre = $product_data['nombre'];
    $cantidadActual = 1;
    // Luego, puedes mostrar estos datos en tu página de detalles
    // ...
} else {
    // Manejar el caso en que no se encuentra el producto
    echo "Producto no encontrado.";
}
// Inicia sesión (si aún no se ha iniciado)


// Verificar si existe la variable de sesión del nombre de usuario
if (isset($_SESSION['username'])) {
    // Botón de "Cerrar Sesión"
    $logoutButton = '<a href="../login/cerrar_sesion.php" class="nav-item nav-link">Cerrar Sesión</a>';
} else {
    // Botones de "Login" y "Register"
    $loginButton = '<a href="../login/login.php" class="nav-item nav-link">Login</a>';
    $registerButton = '<a href="../register/register.php" class="nav-item nav-link">Registrar</a>';
}
?>
<?php

include('../db_connection/db_connection.php');
// Verifica si la variable de sesión 'username' está definida
if (isset($_SESSION['username'])) {
    // El usuario ha iniciado sesión, obtén el nombre de usuario
    $username = $_SESSION['username'];

    // Realiza una consulta a la base de datos para obtener el usuario_id basado en el nombre de usuario
     // Incluye el archivo de conexión a la base de datos

    // Consulta SQL para obtener el usuario_id
   $sql = "SELECT id FROM usuarios WHERE nombre = ?";
    // Prepara la sentencia SQL
    $stmt = $connection->prepare($sql);
    if ($stmt) { // Verifica si la preparación fue exitosa
        // Asocia el valor del nombre de usuario al parámetro de la sentencia SQL
        $stmt->bind_param("s", $username);

        // Ejecuta la consulta
        $stmt->execute();

        // Obtiene el resultado de la consulta
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Si se encontró un resultado, obtén el usuario_id
            $row = $result->fetch_assoc();
            $usuarioId = $row['id'];

            // Muestra el usuario_id obtenido
            echo "El usuario_id es: " . $usuarioId;
        } else {
            // Maneja el caso en que no se encontró el usuario
            echo "No se encontró el usuario en la base de datos.";
        }

        // Cierra la sentencia preparada y libera los resultados
        $stmt->close();
        $result->close();
    } else {
        // Maneja el caso en que hubo un error en la preparación de la consulta
        echo "Error en la preparación de la consulta SQL.";
    }
} else {
    // La variable de sesión 'username' no está definida, maneja este caso apropiadamente
    echo "La sesión del usuario no está iniciada.";
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
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
           <div class="col-lg-3 d-none d-lg-block">
               <a class="btn shadow-none d-flex align-items-center justify-content-center bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                  <h6 class="m-0">SHOP DETAIL</h6>
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
                            <a href="../pag/index.php" class="nav-item nav-link">Home</a>
                            <a href="../pag/shop.php" class="nav-item nav-link">Shop</a>
                            <a href="../pag/detail.php" class="nav-item nav-link active">Shop Detail</a>
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

    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <?php
                           $imagenURL = $product_data['url_imagen'];
                        ?>
                        <img class="w-100 h-100" src="<?php echo $imagenURL; ?>" alt="Image">
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

       <div class="col-lg-7 pb-5">
               <h3 class="font-weight-semi-bold"><?php echo $nombre; ?></h3>
             <div class="d-flex mb-3">
                </div>
                <h3 class="font-weight-semi-bold mb-4">$<?php echo $precio; ?></h3>
                <p style="color: #4D4948;" class="font-weight-medium mb-3 mr-3"><?php echo $descripcionCorta; ?></p>
                <div class="d-flex mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Talle :</p>
                    <form>
                     <p style="color: #4D4948;" class="font-weight-medium mb-0 mr-3"><?php echo $talle; ?></p>
                    </form>
                </div>
                <div class="d-flex mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Color :</p>
                    <form>
                        <p style="color: #4D4948;" class="font-weight-medium mb-0 mr-3"><?php echo $color; ?></p>
                    </form>
                </div>
            <div class="d-flex align-items-center mb-4 pt-2">
               <form id="addToCartForm" action="cart/actualizar_cantidad.php" method="POST">
                  <input type="hidden" id="usuarioId" name="usuario_id" value="<?php echo $usuarioId; ?>">
                  <input type="hidden" id="productoId" name="producto_id" value="<?php echo $id; ?>">
                  <input type="hidden" id="cantidadActual" name="cantidad_actual" value="<?php echo $cantidadActual; ?>">
                  <button id="addToCartButton" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Agregar al Carrito</button>
               </form>
            </div>
        </div>
      </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a style="color:#000000;" class="nav-item nav-link active font-weight-medium mr-3" data-toggle="tab" href="#tab-pane-1">Descripción</a>                                       
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Descripción del producto</h4>
                        <p style="color: #4D4948;" class="font-weight-medium mb-3 mr-3"><?php echo $descripcionLarga; ?></p>
                        
                    </div>                                     
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->
    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">También te puede interesar</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="../img/product-1.jpg" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                            <div class="d-flex justify-content-center">
                                <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="../img/product-2.jpg" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                            <div class="d-flex justify-content-center">
                                <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="../img/product-3.jpg" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                            <div class="d-flex justify-content-center">
                                <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="../img/product-4.jpg" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                            <div class="d-flex justify-content-center">
                                <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="../img/product-5.jpg" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                            <div class="d-flex justify-content-center">
                                <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
<?php include('../components/footer.php'); ?>
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>