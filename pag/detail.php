<?php
// Incluye el archivo de conexión a la base de datos
include('../db_connection/db_connection.php');
session_start();

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    // Obtén los datos del formulario
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 'ID no definido';
    // Obtener el user_id de la sesión a través del nombre de usuario
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Nombre de usuario no definido';

    // Obtén la cantidad del formulario
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; // Asegura que $quantity sea un número entero

    // Prepara la consulta para verificar si el producto ya está en el carrito
    $sql_check_product = "SELECT cantidad FROM carrito_compras WHERE usuario_id = (SELECT id FROM usuarios WHERE nombre = ?) AND producto_id = ?";
    
    // Prepara la sentencia de verificación
    $stmt_check_product = $connection->prepare($sql_check_product);

    if ($stmt_check_product === false) {
        die("Error al preparar la consulta de verificación: " . $connection->error);
    }

    // Enlaza los parámetros
    $stmt_check_product->bind_param("si", $username, $product_id);

    // Ejecuta la consulta de verificación
    if ($stmt_check_product->execute()) {
        $result_check_product = $stmt_check_product->get_result();

        if ($result_check_product->num_rows > 0) {
            // Si el producto ya está en el carrito, actualiza la cantidad
            $row_check_product = $result_check_product->fetch_assoc();
            $current_quantity = $row_check_product['cantidad'];
            $new_quantity = $current_quantity + $quantity;

            // Prepara la consulta de actualización de cantidad
            $sql_update_quantity = "UPDATE carrito_compras SET cantidad = ? WHERE usuario_id = (SELECT id FROM usuarios WHERE nombre = ?) AND producto_id = ?";
            
            // Prepara la sentencia de actualización de cantidad
            $stmt_update_quantity = $connection->prepare($sql_update_quantity);

            if ($stmt_update_quantity === false) {
                die("Error al preparar la consulta de actualización: " . $connection->error);
            }

            // Enlaza los parámetros
            $stmt_update_quantity->bind_param("isi", $new_quantity, $username, $product_id);

            // Ejecuta la consulta de actualización de cantidad
            if ($stmt_update_quantity->execute()) {
                // Éxito al actualizar la cantidad en el carrito
                echo "La cantidad del producto se actualizó en el carrito con éxito.";
            } else {
                echo "Error al actualizar la cantidad del producto en el carrito: " . $stmt_update_quantity->error;
            }

            // Cierra la sentencia de actualización de cantidad
            $stmt_update_quantity->close();
        } else {
            // Si el producto no está en el carrito, inserta un nuevo registro
            // Prepara la consulta de inserción
            $sql_insert_cart = "INSERT INTO carrito_compras (usuario_id, producto_id, cantidad) VALUES ((SELECT id FROM usuarios WHERE nombre = ?), ?, ?)";
            
            // Prepara la sentencia de inserción
            $stmt_insert_cart = $connection->prepare($sql_insert_cart);

            if ($stmt_insert_cart === false) {
                die("Error al preparar la consulta de inserción: " . $connection->error);
            }

            // Enlaza los parámetros
            $stmt_insert_cart->bind_param("sii", $username, $product_id, $quantity);

            // Ejecuta la consulta de inserción
            if ($stmt_insert_cart->execute()) {
                // Éxito al agregar el producto al carrito
                echo "El producto se agregó al carrito con éxito.";
            } else {
                echo "Error al agregar el producto al carrito: " . $stmt_insert_cart->error;
            }

            // Cierra la sentencia de inserción
            $stmt_insert_cart->close();
        }
    } else {
        echo "Error al verificar si el producto está en el carrito: " . $stmt_check_product->error;
    }

    // Cierra la sentencia de verificación
    $stmt_check_product->close();
}

// Verificar si existe la variable de sesión del nombre de usuario
if (isset($_SESSION['username'])) {
    // Botón de "Cerrar Sesión"
    $logoutButton = '<a href="../login/cerrar_sesion.php" class="nav-item nav-link">Cerrar Sesión</a>';
} else {
    // Botones de "Login" y "Register"
    $loginButton = '<a href="../login/login.php" class="nav-item nav-link">Login</a>';
    $registerButton = '<a href="../register/register.php" class="nav-item nav-link">Registrar</a>';
}

// Obtiene el ID del producto desde la URL
$id = isset($_GET['id']) ? $_GET['id'] : 'ID no definido';

// Incluye el archivo de consulta de detalles del producto
include('query/product_detail_query.php');

// Verifica si se obtuvieron los datos del producto
if (isset($product_data)) {
    $nombre = $product_data['nombre'];
    $precio = $product_data['precio'];
    $talle = $product_data['nombre_talle'];
    $color = $product_data['nombre_color'];
    $descripcionCorta = $product_data['descripcion_corta'];
    $descripcionLarga = $product_data['descripcion_larga'];

} else {
    // Manejar el caso en que no se encuentra el producto
    echo "Producto no encontrado.";
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
                            <a href="../pag/index.php" class="nav-item nav-link">Inicio</a>
                            <a href="../pag/shop.php" class="nav-item nav-link">Productos</a>                            
                            <a href="../pag/cart.php" class="nav-item nav-link">Carrito</a>
                            <a href="../pag/checkout.php" class="nav-item nav-link">Compra</a> 
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

    <!-- Productos Detail Start -->
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
                <h3 class="font-weight-semi-bold"></h3>
                <div class="d-flex mb-3"></div>
                <h3 class="font-weight-semi-bold"><?php echo $nombre; ?></h3>
                <p class="mb-4"><?php echo $descripcionCorta; ?></p>
                <div class="d-flex mb-3">
                    <div class="mr-3">
                        <p class="text-dark font-weight-medium mb-0">talla:</p>
                    </div>
                    <div>
                        <p><?php echo $talle; ?></p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <div class="mr-3">
                        <p class="text-dark font-weight-medium mb-0">color:</p>
                    </div>
                    <div>
                        <p><?php echo $color; ?></p>
                    </div>
                </div>
                <div class="input-group quantity mr-3 mb-3" style="width: 130px;">
<!-- Botones para incrementar y decrementar la cantidad -->
<div class="input-group-btn">
    <button class="btn btn-primary btn-minus" onclick="decrementQuantity()">
        <i class="fa fa-minus"></i>
    </button>
</div>
<input type="text" class="form-control bg-secondary text-center" name="quantity" id="quantity" value="<?php echo $quantity; ?>">
<div class="input-group-btn">
    <button class="btn btn-primary btn-plus" onclick="incrementQuantity()">
        <i class="fa fa-plus"></i>
    </button>
</div>

    </div>
<script>
    function incrementQuantity() {
        var quantityInput = document.getElementById("quantity");
        var currentQuantity = parseInt(quantityInput.value);
        quantityInput.value = currentQuantity + 1;
    }

    function decrementQuantity() {
        var quantityInput = document.getElementById("quantity");
        var currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity > 1) {
            quantityInput.value = currentQuantity - 1;
        }
    }
</script>
 <!-- Formulario de agregar al carrito -->
<form method="post" class="mb-3">
    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
   
    <!-- Botón para comprar -->
    <a href="checkout.php" class="btn btn-primary px-3 ">
        <i class="fa fa-shopping-cart mr-1"></i> Comprar
    </a>

    <!-- Agregar al carrito -->
    <button type="submit" class="btn btn-primary px-3" name="add_to_cart">
        <i class="fa fa-shopping-cart mr-1"></i> Agregar al carrito
    </button>
</form>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Descripción</h4>
                        <p><?php echo $descripcionLarga; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Productos Detail End -->

    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">También te puede interesar</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    <!-- Aquí puedes agregar productos relacionados -->
                    <!-- Ejemplo de producto relacionado -->
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
                    <!-- Fin del ejemplo -->
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