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
<?php
// Incluye el archivo de conexión a la base de datos
include("../../db_connection/db_connection.php");

// Verifica si la conexión a la base de datos se estableció correctamente
if (!$connection) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Definir la cantidad de usuarios por página
$usuariosPorPagina = 7;

// Obtener el número de página actual
if (isset($_GET['pagina'])) {
    $paginaActual = $_GET['pagina'];
} else {
    $paginaActual = 1;
}

// Inicializar la variable de búsqueda
$busqueda = "";

// Verificar si se ha enviado el formulario de búsqueda
if (isset($_GET['busqueda'])) {
    // Limpiar y escapar el valor de búsqueda para evitar inyección de SQL
    $busqueda = mysqli_real_escape_string($connection, $_GET['busqueda']);
}

// Calcular el offset
$offset = ($paginaActual - 1) * $usuariosPorPagina;

// Consultar los usuarios desde la base de datos con la condición de búsqueda y paginación
$query = "SELECT usuarios.id, usuarios.nombre, usuarios.correo, usuarios.dni, usuarios.tipo, usuarios.fecha_registro 
          FROM usuarios 
          WHERE usuarios.nombre LIKE '%$busqueda%' 
          OR usuarios.id LIKE '%$busqueda%'
          OR usuarios.correo LIKE '%$busqueda%'
          OR usuarios.dni LIKE '%$busqueda%'
          OR usuarios.tipo LIKE '%$busqueda%'
          OR usuarios.fecha_registro LIKE '%$busqueda%'
          LIMIT $offset, $usuariosPorPagina";

// Ejecutar la consulta SQL
$result = mysqli_query($connection, $query);

// Verificar si la consulta se ejecutó correctamente
if (!$result) {
    echo "Error en la consulta: " . mysqli_error($connection);
    exit();
}

// Obtener el número total de usuarios (sin la condición de búsqueda)
$queryTotal = "SELECT COUNT(*) AS total FROM usuarios 
               WHERE usuarios.nombre LIKE '%$busqueda%' 
               OR usuarios.id LIKE '%$busqueda%'
               OR usuarios.correo LIKE '%$busqueda%'
               OR usuarios.dni LIKE '%$busqueda%'
               OR usuarios.tipo LIKE '%$busqueda%'
               OR usuarios.fecha_registro LIKE '%$busqueda%'";
$resultTotal = mysqli_query($connection, $queryTotal);
$rowTotal = mysqli_fetch_assoc($resultTotal);
$totalUsuarios = $rowTotal['total'];

// Calcular el número total de páginas
$totalPaginas = ceil($totalUsuarios / $usuariosPorPagina);

// Cerrar la conexión a la base de datos
mysqli_close($connection);
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
 <?php include('../../components/topbar.php'); ?>
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
                            <a href="../../admin/admin_index.php" class="nav-item nav-link active">Home</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Informes</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../admin/products.php" class="dropdown-item">Productos</a>
                                    <a href="../../admin/user/user_report.php" class="dropdown-item">Usuarios</a>
                                </div>
                            </div>                            
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Usuarios</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../admin/user/user_list.php" class="dropdown-item">Lista</a>                                   
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Productos</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../admin/products/add_product.php" class="dropdown-item">Agregar producto</a>
                                     <a href="../../admin/products/category/add_category.php" class="dropdown-item">Agregar categoria</a>
                                     <a href="../../admin/products/talle/add_talle.php" class="dropdown-item">Agregar talle</a> 
                                </div>
                            </div>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <a href="../login/login.php" class="nav-item nav-link">Cerrar Sesion</a>                            
                        </div>
                    </div>
                </nav>                
            </div>
        </div>
    </div>
    <!-- Navbar End -->
    <!-- Contenido principal -->
     <div class="container">
        <h1>Lista de Clientes</h1>

    <!-- Formulario de búsqueda -->
    <form action="user_list.php" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar por Nombre, Correo Electrónico, Tipo o Fecha de Registro" name="busqueda">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </div>
    </form>
        <!-- Tabla de clientes estilo Excel -->
        <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo Electrónico</th>
            <th>DNI</th>
            <th>Tipo</th>
            <th>Fecha de Registro</th>
        </tr>
    </thead>
     <tbody>
        <?php

         // Definir la cantidad de clientes por página
         $clientesPorPagina = 7;
         // Obtener el número de página actual
         if (isset($_GET['pagina'])) {
            $paginaActual = $_GET['pagina'];
         } else {
             $paginaActual = 1;
         }
         // Calcular el offset
         $offset = ($paginaActual - 1) * $clientesPorPagina; 
         // Itera sobre los resultados de la consulta y muestra cada cliente en una fila de la tabla
         while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['correo'] . "</td>";
            echo "<td>" . $row['dni'] . "</td>"; // Agregamos la columna DNI
            echo "<td>" . $row['tipo'] . "</td>";
            echo "<td>" . $row['fecha_registro'] . "</td>";
            echo "</tr>";
         }
        ?>
     </tbody>
  </table>

        <!-- Paginación -->
        <div class="pagination justify-content-center">
            <ul class="pagination">
                <?php
                   // Calcula el número total de páginas
                   $totalPaginas = ceil($totalUsuarios / $clientesPorPagina);

                   // Muestra enlaces a páginas anteriores y siguientes
                   if ($paginaActual > 1) {
                       echo '<li class="page-item"><a class="page-link" href="user_list.php?pagina=' . ($paginaActual - 1) . '">Anterior</a></li>';
                   }
                   for ($i = 1; $i <= $totalPaginas; $i++) {
                     echo '<li class="page-item ' . ($i == $paginaActual ? 'active' : '') . '"><a class="page-link" href="user_list.php?pagina=' . $i . '">' . $i . '</a></li>';
                   }

                   if ($paginaActual < $totalPaginas) {
                     echo '<li class="page-item"><a class="page-link" href="user_list.php?pagina=' . ($paginaActual + 1) . '">Siguiente</a></li>';
                   }

                ?>
            </ul>
        </div>
    </div>
    <?php include('../../components/footer.php'); ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../../lib/easing/easing.min.js"></script>
    <script src="../../lib/owlcarousel/owl.carousel.min.js"></script>
</body>
</html>