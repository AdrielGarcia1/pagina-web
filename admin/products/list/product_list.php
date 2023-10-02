<?php
// Incluye el archivo de conexión a la base de datos
include("../../../db_connection/db_connection.php");
session_start();
// Verifica si la conexión a la base de datos se estableció correctamente
if (!$connection) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Definir la cantidad de productos por página
$productosPorPagina = 7;

// Obtener el número de página actual
if (isset($_GET['pagina'])) {
    $paginaActual = $_GET['pagina'];
} else {
    $paginaActual = 1;
}

// Calcular el offset
$offset = ($paginaActual - 1) * $productosPorPagina;

// Consulta SQL para obtener la lista de productos con detalles de categorías, talles, colores y descripciones
// Consulta SQL para obtener la lista de productos con detalles de categorías, talles, colores y descripciones
$query = "SELECT p.id, p.nombre, p.precio, p.stock, c.nombre_categoria AS categoria, t.nombre_talle AS talle, co.nombre_color AS color
          FROM productos p
          LEFT JOIN categorias c ON p.categoria_id = c.id
          LEFT JOIN talles t ON p.talle_id = t.id
          LEFT JOIN colores co ON p.color_id = co.id
          WHERE p.estado = 1  -- Agrega esta condición para excluir productos con estado 0
          LIMIT $offset, $productosPorPagina";

// Ejecutar la consulta SQL
$result = mysqli_query($connection, $query);

// Verificar si la consulta se ejecutó correctamente
if (!$result) {
    echo "Error en la consulta: " . mysqli_error($connection);
    exit();
}

// Obtener el número total de productos
$queryTotal = "SELECT COUNT(*) AS total FROM productos";
$resultTotal = mysqli_query($connection, $queryTotal);
$rowTotal = mysqli_fetch_assoc($resultTotal);
$totalProductos = $rowTotal['total'];

// Calcular el número total de páginas
$totalPaginas = ceil($totalProductos / $productosPorPagina);

// Cerrar la conexión a la base de datos
mysqli_close($connection);
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
                  <h6 class="m-0">CATEGORIAS</h6>
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
                            <a href="../../../admin/admin_index.php" class="nav-item nav-link active">Inicio</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Informes</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../products/report/product_report.php" class="dropdown-item">Productos</a>
                                    <a href="../../../admin/user/user_report.php" class="dropdown-item">Usuarios</a>
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Usuarios</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../../admin/user/list/user_list.php" class="dropdown-item">Lista</a>
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Productos</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../../../admin/products/list/product_list.php" class="dropdown-item">Lista productos</a>
                                    <a href="../../../admin/products/add_product.php" class="dropdown-item">Agregar producto</a>
                                    <a href="../../../admin/products/category/add_category.php" class="dropdown-item">Agregar categoria</a>
                                    <a href="../../../admin/products/talle/add_talle.php" class="dropdown-item">Agregar talle</a>
                                </div>
                            </div>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <a href="../../../login/cerrar_sesion.php" class="nav-item nav-link">Cerrar Sesion</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->
    <!-- Contenido principal -->
    <div class="container">
        <h1>Lista de Productos</h1>
        <!-- Tabla de productos con detalles -->
<!-- Tabla de productos con botones -->
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
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Talle</th>
            <th>Color</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Itera sobre los resultados de la consulta y muestra cada producto en una fila de la tabla
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['precio'] . "</td>";
            echo "<td>" . $row['stock'] . "</td>";
            echo "<td>" . $row['categoria'] . "</td>";
            echo "<td>" . $row['talle'] . "</td>";
            echo "<td>" . $row['color'] . "</td>";
            echo "<td>";
            
            // Botón Eliminar con confirmación
            echo '<button class="btn btn-danger btn-block" onclick="confirmarEliminacion(' . $row['id'] . ')">Eliminar</button>';
           
            // Botón Editar (enlaza a la página de edición)
            echo '<a href="product_edit.php?id=' . $row['id'] . '" class="btn btn-primary btn-block">Editar</a>';
            
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<script>
function confirmarEliminacion(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
        // Si el usuario acepta la confirmación, redirige a la página de eliminación
        window.location.href = "product_deleted.php?id=" + id;
    }
}
</script>

        <!-- Paginación -->
        <div class="pagination justify-content-center">
            <ul class="pagination">
                <?php
                // Muestra enlaces a páginas anteriores y siguientes
                if ($paginaActual > 1) {
                    echo '<li class="page-item"><a class="page-link" href="product_list.php?pagina=' . ($paginaActual - 1) . '">Anterior</a></li>';
                }
                for ($i = 1; $i <= $totalPaginas; $i++) {
                    echo '<li class="page-item ' . ($i == $paginaActual ? 'active' : '') . '"><a class="page-link" href="product_list.php?pagina=' . $i . '">' . $i . '</a></li>';
                }
                if ($paginaActual < $totalPaginas) {
                    echo '<li class="page-item"><a class="page-link" href="product_list.php?pagina=' . ($paginaActual + 1) . '">Siguiente</a></li>';
                }
                ?>
            </ul>
        </div>
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
    <script src="../../../js/main.js"></script>
</body>
</html>