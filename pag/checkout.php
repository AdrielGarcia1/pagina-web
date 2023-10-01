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
// Verifica si se ha enviado el formulario
if (isset($_POST['realizar_pedido'])) {
    // Obtiene el nombre de usuario desde la sesión
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Realiza una consulta para obtener el ID del usuario basado en el nombre de usuario
        $getIdSQL = "SELECT id FROM usuarios WHERE nombre = ?";
        $stmtGetId = $connection->prepare($getIdSQL);

        if ($stmtGetId === false) {
            die("Error en la preparación de la consulta para obtener el ID del usuario: " . $connection->error);
        }

        $stmtGetId->bind_param("s", $username);

        if ($stmtGetId->execute()) {
            $stmtGetId->bind_result($userId);
            $stmtGetId->fetch();
            $stmtGetId->close();

            // Inserta una fila en la tabla de ventas
            $insertVentaSQL = "INSERT INTO ventas (usuario_id, fecha_venta) VALUES (?, NOW())";
            $stmtVenta = $connection->prepare($insertVentaSQL);

            if ($stmtVenta === false) {
                die("Error en la preparación de la consulta de venta: " . $connection->error);
            }

            $stmtVenta->bind_param("i", $userId);

            if ($stmtVenta->execute()) {
                // Obtiene el ID de la venta recién creada
                $ventaId = $stmtVenta->insert_id;

                // Inserta los productos del carrito en la tabla de detalle_venta
                foreach ($cartData as $product) {
                    $productoId = $product['id'];
                    $cantidad = $product['cantidad'];
                    $precioUnitario = $product['precio'];

                    $insertDetalleSQL = "INSERT INTO detalle_venta (venta_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
                    $stmtDetalle = $connection->prepare($insertDetalleSQL);

                    if ($stmtDetalle === false) {
                        die("Error en la preparación de la consulta de detalle de venta: " . $connection->error);
                    }

                    $stmtDetalle->bind_param("iiid", $ventaId, $productoId, $cantidad, $precioUnitario);

                    if (!$stmtDetalle->execute()) {
                        echo "Error al insertar detalle de venta: " . $stmtDetalle->error;
                        $stmtDetalle->close();
                        break; 
                    }

                    $stmtDetalle->close();
                }

                // Cierre de la transacción
                $connection->commit();
            } else {
                echo "Error al insertar venta: " . $stmtVenta->error;
            }

            $stmtVenta->close();
        } else {
            echo "Error al obtener el ID del usuario: " . $stmtGetId->error;
        }
    }
}
if (isset($_SESSION['username'])) {
    // El usuario ha iniciado sesión
    $username = $_SESSION['username']; // Obtener el nombre de usuario de la sesión

    // Crea una nueva conexión a la base de datos (similar a user.php)
    $conn = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);

    // Verificar si la conexión tuvo éxito
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Realiza la consulta SQL para obtener la información del usuario
    $sql = "SELECT u.nombre, u.nombre_real, u.apellido, u.numero_telefono, u.correo, u.DNI, p.nombre_provincia,d.ciudad_pueblo, d.direccion, u.codigo_postal
        FROM usuarios u
        JOIN direcciones d ON u.id = d.id_usuario
        JOIN provincias p ON d.id_provincia = p.id
        WHERE u.nombre = ?";

    // Preparar la consulta
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Asociar el parámetro a la consulta
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);

        // Obtener los resultados de la consulta
        mysqli_stmt_bind_result($stmt, $nombre, $nombre_real, $apellido, $numero_telefono, $correo, $DNI, $nombre_provincia, $ciudad_pueblo, $direccion, $codigo_postal);

        // Obtener los datos del usuario
        mysqli_stmt_fetch($stmt);

        // Cerrar la consulta
        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($conn);
    }
}
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
</head>

<body>
   <?php include('../components/topbar.php'); ?>
    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
           <div class="col-lg-3 d-none d-lg-block">
               <a class="btn shadow-none d-flex align-items-center justify-content-center bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                  <h6 class="m-0">CHECKOUT</h6>
               </a>
           </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">

                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="../pag/index.php" class="nav-item nav-link">Inicio</a>
                            <a href="../pag/shop.php" class="nav-item nav-link">Productos</a>                            
                            <?php                 
                              if (isset($_SESSION['username'])) {                                     
                                echo '<a href="../pag/cart.php" class="nav-item nav-link">Carrito</a>';
                                echo ' <a href="../pag/checkout.php" class="nav-item nav-link">Pagar</a>';
                              } else {                                  
                                echo '<a href="../login/login.php" class="nav-item nav-link">Carrito </a>';
                                echo '<a href="../login/login.php" class="nav-item nav-link">Pagar</a>';
                              }
                            ?> 
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

    <!-- Compra Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Datos de Envio</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Nombre</label>
                            <input class="form-control" type="text" placeholder="John" value="<?php echo $nombre_real; ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Apellido</label>
                            <input class="form-control" type="text" placeholder="Perez" value="<?php echo $apellido; ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mail</label>
                            <input class="form-control" type="text" placeholder="example@email.com" value="<?php echo $correo; ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Número de telefono</label>
                            <input class="form-control" type="text" placeholder="+54 9 2625 489458" value="<?php echo $numero_telefono; ?>">                            
                        </div>  
                        <div class="col-md-6 form-group">
                            <label>DNI</label>
                            <input class="form-control" type="text" placeholder="41962761" value="<?php echo $DNI; ?>">                            
                        </div>                       
                        <div class="col-md-6 form-group">
                            <label>Provincia</label>
                            <input class="form-control" type="text" placeholder="Buenos Aires" value="<?php echo $nombre_provincia; ?>">                                                         
                        </div>
                        <div class="col-md-6 form-group">
                             <label>Ciudad/Pueblo</label>
                             <input class="form-control" type="text" placeholder="Ej:General Alvear" value="<?php echo $ciudad_pueblo; ?>">                            
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Dirección</label>
                            <input class="form-control" type="text" placeholder="Ej: San Juan 234" value="<?php echo $direccion; ?>">                            
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Código postal</label>
                            <input class="form-control" type="text" placeholder="123" value="<?php echo $codigo_postal; ?>">                            
                        </div>
                        <!--<div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="newaccount">
                                <label class="custom-control-label" for="newaccount">Crear cuenta</label>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                </div>
                    <div class="card-body">
    <h5 class="font-weight-medium mb-3">Products</h5>
    <!-- Comprobar si $cartData no es nulo y es un array antes de usar foreach -->
    <?php
    $subtotal = 0;
    if (!empty($cartData) && is_array($cartData)) {
        foreach ($cartData as $product) {
            $nombreProducto = htmlspecialchars($product['nombre']);
            $precioProducto = $product['precio'];
            $cantidadProducto = $product['cantidad'];
            $totalProducto = $product['total'];
            $subtotal += $totalProducto;

            echo '<div class="d-flex justify-content-between">';
            echo '<p>' . $nombreProducto . '</p>';
            echo '<p>$' . number_format($precioProducto, 2) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No hay productos en el carrito.</p>';
    }
    ?>
                 <hr class="mt-0">
                 <!-- Mostrar el subtotal y los costos de envío -->
                <div class="d-flex justify-content-between mb-3 pt-1">
                  <h6 class="font-weight-medium">Subtotal</h6>
                  <h6 class="font-weight-medium">$<?php echo number_format($subtotal, 2); ?></h6>
                </div>
                <div class="d-flex justify-content-between">
                  <h6 class="font-weight-medium">Shipping</h6>
                  <h6 class="font-weight-medium">$2,000.00</h6>
                </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                  <!-- Mostrar el total -->
                  <div class="d-flex justify-content-between mt-2">
                    <h5 class="font-weight-bold">Total</h5>
                    <h5 class="font-weight-bold">$<?php echo number_format($subtotal + 2000, 2); ?></h5>
                  </div>
                </div>
            </div>
          <form method="post" action="checkout.php">
              <!-- Agrega campos para la venta -->
              <input type="hidden" name="usuario_id" value="<?php echo $userId; ?>">
              <!-- Agrega campos para los detalles de venta (por cada producto en el carrito) -->
              <?php foreach ($cartData as $product): ?>
                <input type="hidden" name="producto_id[]" value="<?php echo $product['id']; ?>">
                <input type="hidden" name="cantidad[]" value="<?php echo $product['cantidad']; ?>">
                <input type="hidden" name="precio_unitario[]" value="<?php echo $product['precio']; ?>">
              <?php endforeach; ?>
              <!-- Botón de "Realizar Pedido" -->
              <div class="card-footer border-secondary bg-transparent">
                <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3" name="realizar_pedido">Realizar pedido</button>
              </div>
          </form>
          <div id="mensaje-confirmacion" style="display: none;">
             <p>¡La compra se ha realizado con éxito!</p>
          </div>
          <script>
            // Agrega esta función después de realizar la compra con éxito
            function mostrarMensajeConfirmacion() {
              var mensajeConfirmacion = document.getElementById("mensaje-confirmacion");
              mensajeConfirmacion.style.display = "block"; // Muestra el mensaje
            }
          </script>

        </div>
    </div>  
</div>  
</div>

        </div>
    </div>
    <!-- Compra End -->
    <?php include('../components/footer.php'); ?> 
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
  
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>