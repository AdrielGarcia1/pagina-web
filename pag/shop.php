<?php
include('../components/buttons.php');

// Obtener los productos
$products = include('shop/product_query.php');

// Obtener todas las categorías (sin filtro)
$categorias = include('shop/categories.php');

// Inicializar la variable de filtro de categoría
$categoria_filtro = '';

// Verificar si se seleccionó una categoría para filtrar
if (isset($_GET['categoria_filtro']) && !empty($_GET['categoria_filtro'])) {
    $categoria_filtro = $_GET['categoria_filtro'];
}

// Filtrar productos si se seleccionó una categoría
if (!empty($categoria_filtro)) {
    $products = array_filter($products, function ($product) use ($categoria_filtro) {
        return $product['nombre_categoria'] === $categoria_filtro;
    });
}
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

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>
    <?php include('../components/topbar.php'); ?>

    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-center bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">SHOP</h6>
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
                            <a href="../pag/index.php" class="nav-item nav-link">Inicio</a>
                            <a href="../pag/shop.php" class="nav-item nav-link active">Productos</a>
                            <?php                 
                            if (isset($_SESSION['username'])) {                                     
                                echo '<a href="../pag/cart.php" class="nav-item nav-link">Carrito</a>';                                
                            } else {                                  
                                echo '<a href="../login/login.php" class="nav-item nav-link">Carrito</a>';                                
                            }
                            ?>                          
                            <a href="../pag/contact.php" class="nav-item nav-link">Contacto</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">                            
                            <?php
                            if (isset($logoutButton)) {
                                echo $logoutButton;
                            } else {
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

    <!-- Productos Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Productos Sidebar Start -->
            <script>
    // Función para cargar y mostrar las categorías
    function cargarCategorias() {
        // Realizar una solicitud AJAX para obtener las categorías desde categories.php
        $.ajax({
            url: 'shop/categories.php', // La URL de categories.php
            dataType: 'json', // El tipo de datos esperados
            success: function (categorias) {
                // No es necesario usar JSON.parse cuando se devuelve un array PHP
                var categoriasHTML = '<ul>';
                for (var i = 0; i < categorias.length; i++) {
                    var categoria = categorias[i];
                    categoriasHTML += '<li><a href="#" data-id="' + categoria.id + '">' + categoria.nombre_categoria + '</a></li>';
                }
                categoriasHTML += '</ul>';

                // Muestra las categorías en el div
                $('#categorias-list').html(categoriasHTML);
            },
            error: function () {
                console.log('Error al cargar las categorías');
            }
        });
    }

    // Llama a la función para cargar las categorías cuando se carga la página
    $(document).ready(function () {
        cargarCategorias();
    });
</script>
            <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Categoría</h5>
                    <form method="get" action="shop.php">
                        <select name="categoria_filtro" class="form-control">
                            <option value="">Todas las Categorías</option>
                            <?php foreach ($categorias as $categoria): ?>
                              <option value="<?php echo $categoria['nombre_categoria']; ?>"><?php echo $categoria['nombre_categoria']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
                    </form>
                </div>
            </div>
            <!-- Productos Sidebar End -->

            <!-- Productos Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    <?php
                    // Iterar a través de los productos y mostrar la imagen, el nombre y el precio
                    foreach ($products as $product) {
                        // Asegurarse de que la URL de la imagen esté definida antes de mostrarla
                        $imagenURL = isset($product['url_imagen']) ? $product['url_imagen'] : 'ruta_por_defecto.jpg';

                        // Acceder a las otras propiedades del producto
                        $nombre = isset($product['nombre']) ? $product['nombre'] : 'Nombre no disponible';
                        $precio = isset($product['precio']) ? $product['precio'] : 'Precio no disponible';
                        ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100" src="<?php echo $imagenURL; ?>" style="width: 150px; height: 350px;">
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3"><?php echo $nombre; ?></h6>
                                    <div class="d-flex justify-content-center">
                                        <h6>$<?php echo $precio; ?></h6>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between bg-light border">
                                    <a href="detail.php?id=<?php echo $product['id']; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-0"></i>Ver detalle</a>
                                    <?php
                                    if (isset($_SESSION['username'])) {
                                        //boton para enviar datos a cart/actualizar_cantidad.php
                                        $addtocart = '<a href="shop/data_shop.php?id=' . $product['id'] . '" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary"></i>Sumar al carrito</a>';
                                    } else {    
                                        $loginButton = '<a href="../login/login.php" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary"></i>Sumar al carrito</a>';
                                    }
                                    ?>  
                                    <?php
                                    if (isset($addtocart)) {
                                        echo $addtocart;
                                    } else {                                 
                                        echo $loginButton;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <!-- Productos Product End -->
        </div>
    </div>
    <!-- Productos End -->

    <?php include('../components/footer.php'); ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>
</html>