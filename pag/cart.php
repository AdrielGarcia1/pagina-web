<?php
// Incluye el archivo de conexión a la base de datos
include('../db_connection/db_connection.php');
session_start();

// Inicializa un arreglo para almacenar los datos del carrito
$cartData = array();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    // Si el usuario no ha iniciado sesión, muestra un mensaje de error
    echo "Debes iniciar sesión para ver tu carrito de compras.";
} else {
    // El usuario ha iniciado sesión, obtenemos su ID de usuario
    $username = $_SESSION['username'];

    // Consulta SQL para obtener los productos en el carrito de compras del usuario
   $sql = "SELECT productos.id, productos.nombre, productos.precio, carrito_compras.cantidad
        FROM productos
        INNER JOIN carrito_compras ON productos.id = carrito_compras.producto_id
        WHERE carrito_compras.usuario_id = (SELECT id FROM usuarios WHERE nombre = ?)";

// Prepara la sentencia SQL
$stmt = $connection->prepare($sql);

if ($stmt === false) {
    die("Error al preparar la consulta: " . $connection->error);
}

// Enlaza el parámetro
$stmt->bind_param("s", $username);

// Ejecuta la consulta
if ($stmt->execute()) {
    $result = $stmt->get_result();

    // Verifica si hay productos en el carrito
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productId = $row['id']; // Define $productId con el ID del producto
            $nombreProducto = $row['nombre'];
            $precioProducto = $row['precio'];
            $cantidadProducto = $row['cantidad'];
            $totalProducto = $precioProducto * $cantidadProducto;

            // Agrega los datos del producto al arreglo $cartData
            $cartData[] = array(
                'id' => $productId, // Incluye el ID del producto
                'nombre' => $nombreProducto,
                'precio' => $precioProducto,
                'cantidad' => $cantidadProducto,
                'total' => $totalProducto
            );
        }
    }
}
// Cierra la sentencia
$stmt->close();
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>
    <?php include('../components/topbar.php'); ?>
    <?php
// En detail.php, verifica y muestra el mensaje

if (isset($_SESSION['cart_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['cart_message'] . '</div>';
    unset($_SESSION['cart_message']); // Limpia la variable de sesión después de mostrar el mensaje
}
?>
    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
           <div class="col-lg-3 d-none d-lg-block">
               <a class="btn shadow-none d-flex align-items-center justify-content-center bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                  <h6 class="m-0">SHOPPING CART</h6>
               </a>
           </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span></h1>
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
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
      <table class="table table-bordered text-center mb-0">
    <thead class="bg-secondary text-dark">
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody class="align-middle">
      <?php
        // Recorre los datos del carrito y muestra los productos
        foreach ($cartData as $item) {
            ?>
            <tr data-id="<?php echo $item['id']; ?>">
                <td class="align-middle"><?php echo $item['nombre']; ?></td>
                <td class="align-middle">$<?php echo $item['precio']; ?></td>
                <td class="align-middle">
                    <div class="input-group quantity mx-auto" style="width: 100px;">
                        <input type="text" class="form-control form-control-sm text-center cantidad" value="<?php echo $item['cantidad']; ?>">
                    </div>
                </td>
                <td class="align-middle">$<?php echo $item['total']; ?></td>
                <td class="align-middle">
                <button class="btn btn-sm btn-primary delete-product" data-id="<?php echo $item['id']; ?>"><i class="fa fa-times"></i></button>

                  <script>
$(document).ready(function() {
    // Agrega un evento de clic a los botones "X" con la clase "delete-product"
    $('.delete-product').click(function() {
        // Obtiene el ID del producto desde el atributo data-id
        var productoId = $(this).data('id');
        
        // Almacena una referencia al botón "X" actual
        var botonEliminar = $(this);

        // Realiza una solicitud AJAX para eliminar el producto
        $.ajax({
            type: 'POST',
            url: 'cart/eliminar_producto.php', // Ruta al script de eliminación
            data: { productoId: productoId },
            success: function(response) {
                // Comprueba si la eliminación fue exitosa
                if (response != 'success') {
                    // Elimina la fila de la tabla del carrito
                    botonEliminar.closest('tr').remove();
                    alert('Producto eliminado con éxito.');
                } else {
                    alert('Error al eliminar el producto: ' + response); // Muestra el mensaje de error del servidor
                }
            },
            error: function() {
                alert('Error al eliminar el producto.');
            }
        });
    });
});
</script>
              </td>
            </tr>
            <?php
        }
      ?>
    </tbody>
</table>

    </td>    
</tr>

            </div>
        </div>
    </div>
    <!-- Cart End -->
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