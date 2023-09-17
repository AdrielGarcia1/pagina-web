<?php
include_once("../../db_connection/db_connection.php");

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


// Consulta SQL para obtener las fechas disponibles
$sql = "SELECT DISTINCT DATE(fecha_registro) AS fecha FROM usuarios WHERE tipo = 'cliente'";
$resultadoFechas = mysqli_query($connection, $sql);

// Inicializa las fechas disponibles
$fechasDisponibles = [];

while ($filaFecha = mysqli_fetch_assoc($resultadoFechas)) {
    $fechasDisponibles[] = $filaFecha['fecha'];
}

// Convierte las fechas al formato deseado (puedes personalizar esto según tus necesidades)
$fechasFormateadas = [];
foreach ($fechasDisponibles as $fecha) {
    $fechasFormateadas[] = date("d-m-Y", strtotime($fecha));
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
<?php include('../../components/topbar.php'); ?>
     <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
               <a class="btn shadow-none d-flex align-items-center justify-content-center bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                  <h6 class="m-0">USER REPORT</h6>
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
                            <a href="../admin_index.php" class="nav-item nav-link active">Home</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Informes</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../admin/products.php" class="dropdown-item">Productos</a>
                                    <a href="../admin/user/user_report.php" class="dropdown-item">Usuarios</a>
                                </div>
                            </div>                            
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Usuarios</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="../user/user_list.php" class="dropdown-item">Lista</a>                                   
                                </div>
                            </div>
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
                            <a href="../login/cerrar_sesion.php" class="nav-item nav-link">Cerrar Sesion</a>                            
                        </div>
                    </div>
                </nav>                
            </div>
        </div>
    </div>
    <!-- Navbar End -->

     <!-- Aquí se mostrará el gráfico -->
    <div class="container mt-5">
        <canvas id="myChart"></canvas>
        </div>

    <!-- Agrega este elemento select en tu formulario -->
<form action="">
    <div class="input-group">
        <select id="timeRange" class="form-control">
            <option value="last_hour">Última hora</option>
            <option value="today">Día actual</option>
            <option value="week">Semana</option>
            <option value="month">Mes</option>
            <option value="year">Año</option>
            <option value="all">Todos</option>
        </select>
        <div class="input-group-append">
            <span class="input-group-text bg-transparent text-primary">
                <i class="fa fa-search"></i>
            </span>
        </div>
    </div>
</form>

<!-- JavaScript para manejar el cambio en el menú desplegable -->
    <script>
        var timeRangeSelect = document.getElementById('timeRange');
        timeRangeSelect.addEventListener('change', function () {
            var selectedValue = timeRangeSelect.value;
            var url;

            if (selectedValue === 'last_hour') {
                url = ' ../user/report/get_data_last_hour.php';
            } else if (selectedValue === 'today') {
                url = '../user/report/get_data_today.php';
            } else if (selectedValue === 'week') {
                url = '../user/report/get_data_week.php';
            } else if (selectedValue === 'month') {
                url = '../user/report/get_data_month.php';
            } else if (selectedValue === 'year') {
                url = '../user/report/get_data_year.php';
            } else {
                // Para la opción "Todos" o "all", usa el archivo original get_data.php
                url = '../user/report/get_data.php';
            }

            // Realiza la solicitud AJAX
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Actualiza el gráfico con los nuevos datos
                    myChart.data.labels = data.fechas;
                    myChart.data.datasets[0].data = data.cantidades;
                    myChart.update();
                })
                .catch(error => {
                    console.error('Error en la solicitud AJAX:', error);
                });
        });

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [], // Aquí deberían estar tus etiquetas de fecha
                datasets: [{
                    label: 'Cantidad de Usuarios',
                    data: [], // Aquí deberían estar tus datos de cantidad de usuarios
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
<?php include('../../components/footer.php'); ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../../lib/easing/easing.min.js"></script>
</body>
</html>