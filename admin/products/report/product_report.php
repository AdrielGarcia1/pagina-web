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
    <!-- Incluye jQuery (asegúrate de que jQuery esté disponible) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluye la biblioteca Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../../../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../../../css/style.css" rel="stylesheet">
    <title>Informe de Ventas de Productos</title>

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
                            <a href="../../../admin/admin_index.php" class="nav-item nav-link active">Inicio</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Informes</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="product_report.php" class="dropdown-item">Productos</a>
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
                                     <a href="../list/product_list.php" class="dropdown-item">Lista productos</a>
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
                </nav>           
            </div>
        </div>
    </div>
    <div style="width: 80%; margin: 0 auto;">
        <canvas id="graficoVentas"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            // Realiza una solicitud AJAX a total_sales.php para obtener los datos
            $.ajax({
                url: 'total_sales.php', // Ruta a total_sales.php
                method: 'GET',
                dataType: 'json', // Esperamos datos en formato JSON
                success: function (data) {
                    // Datos obtenidos de total_sales.php
                    var productos = data.productos;
                    var ventas = data.ventas;

                    // Configuración del gráfico
                    var ctx = document.getElementById('graficoVentas').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: productos, // Nombres de productos en el eje X
                            datasets: [{
                                label: 'Ventas por Producto',
                                data: ventas, // Datos de ventas en el eje Y
                                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Color de las barras
                                borderColor: 'rgba(75, 192, 192, 1)', // Borde de las barras
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Cantidad de Ventas'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Productos'
                                    }
                                }
                            }
                        }
                    });
                },
                error: function () {
                    console.error('Error al cargar los datos de ventas.');
                }
            });
        });
    </script>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../../lib/easing/easing.min.js"></script>
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
</body>
</html>