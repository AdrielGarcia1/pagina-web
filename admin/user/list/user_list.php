<?php
// Incluye el archivo de conexión a la base de datos
include("../../../db_connection/db_connection.php");
session_start();
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
$query = "SELECT usuarios.id, usuarios.nombre, usuarios.nombre_real, usuarios.apellido, usuarios.correo, usuarios.dni, usuarios.tipo, usuarios.fecha_registro, direcciones.ciudad_pueblo, direcciones.direccion, provincias.nombre_provincia
          FROM usuarios
          LEFT JOIN direcciones ON usuarios.id = direcciones.id_usuario
          LEFT JOIN provincias ON direcciones.id_provincia = provincias.id
          WHERE usuarios.estado = 1
          AND (usuarios.nombre LIKE '%$busqueda%'
          OR usuarios.id LIKE '%$busqueda%'
          OR usuarios.correo LIKE '%$busqueda%'
          OR usuarios.dni LIKE '%$busqueda%'
          OR usuarios.tipo LIKE '%$busqueda%'
          OR usuarios.fecha_registro LIKE '%$busqueda%'
          OR direcciones.ciudad_pueblo LIKE '%$busqueda%'
          OR direcciones.direccion LIKE '%$busqueda%'
          OR provincias.nombre_provincia LIKE '%$busqueda%')
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
LEFT JOIN direcciones ON usuarios.id = direcciones.id_usuario
LEFT JOIN provincias ON direcciones.id_provincia = provincias.id
WHERE (usuarios.nombre LIKE '%$busqueda%'
       OR usuarios.id LIKE '%$busqueda%'
       OR usuarios.correo LIKE '%$busqueda%'
       OR usuarios.dni LIKE '%$busqueda%'
       OR usuarios.tipo LIKE '%$busqueda%'
       OR usuarios.fecha_registro LIKE '%$busqueda%'
       OR direcciones.ciudad_pueblo LIKE '%$busqueda%'
       OR direcciones.direccion LIKE '%$busqueda%'
       OR provincias.nombre_provincia LIKE '%$busqueda%')
       AND usuarios.estado = 1;
";
$resultTotal = mysqli_query($connection, $queryTotal);
$rowTotal = mysqli_fetch_assoc($resultTotal);
$totalUsuarios = $rowTotal['total'];

// Calcular el número total de páginas
if ($totalUsuarios > 0) {
    $totalPaginas = ceil($totalUsuarios / $usuariosPorPagina);
} else {
    $totalPaginas = 1; // Establece al menos una página si no hay usuarios
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
            <a href="../../adminuser/user.php" class="btn border"><i class="fas fa-user text-primary"></i></a>
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
                                    <a href="../user_report.php" class="dropdown-item">Usuarios</a>
                                </div>
                            </div>                            
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Usuarios</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="user_list.php" class="dropdown-item">Lista</a>                                   
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
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 5px;
         color: black;
    }

    th {
        background-color: #f0f0f0;
    }
</style>
<!-- Tabla de clientes estilo Excel -->
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>DNI</th>
            <th>Tipo</th>
            <th>Dirección</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['nombre_real']; ?></td>
                <td><?php echo $row['apellido']; ?></td>
                <td><?php echo $row['correo']; ?></td>
                <td><?php echo $row['dni']; ?></td>
                <td><?php echo $row['tipo']; ?></td>
                <td><?php echo $row['direccion'] ?? ''; ?></td>
                <td>
                  <div class="btn-group">
                    <!-- Botón Editar -->
                    <a href="user_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
                    <!-- Botón Eliminar con confirmación -->
                    <button class="btn btn-danger" onclick="confirmarEliminacion(<?php echo $row['id']; ?>)">Eliminar</button>  
                  </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
        <!-- Paginación -->
        <div class="pagination justify-content-center">
            <ul class="pagination">
                <?php                  

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
    <script>
function confirmarEliminacion(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
        // Si el usuario acepta la confirmación, redirige a la página de eliminación
        window.location.href = "user_deleted.php?id=" + id;
    }
}
</script>
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
    <script src="../../../lib/easing/easing.min.js"></script>
    <script src="../../../js/main.js"></script>
</body>
</html>