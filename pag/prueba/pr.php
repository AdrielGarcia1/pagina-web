<?php include('cargar.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Modificar Cantidad</title>
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
    <link href="../../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../../css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>
<body>
    <h1>Modificar Cantidad</h1>
    <div class="input-group">
        <div class="input-group-btn">
            <button id="disminuir" class="btn btn-sm btn-primary">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <input type="text" class="form-control form-control-sm bg-secondary text-center" value="<?php echo $cantidadActual; ?>" id="cantidad">
        <div class="input-group-btn">
            <button id="aumentar" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    
    <script>
        // Variable para almacenar la cantidad actual
        let cantidadActual = <?php echo $cantidadActual; ?>;

        // Función para mostrar la cantidad actual en el elemento HTML
        function mostrarCantidad() {
            document.getElementById('cantidad').value = cantidadActual;
        }

        // Evento para el botón de aumento (+)
        document.getElementById('aumentar').addEventListener('click', function() {
            cantidadActual++;
            mostrarCantidad();
            guardarCambiosEnBaseDeDatos(cantidadActual);
        });

        // Evento para el botón de disminución (-)
        document.getElementById('disminuir').addEventListener('click', function() {
            if (cantidadActual > 0) {
                cantidadActual--;
                mostrarCantidad();
                guardarCambiosEnBaseDeDatos(cantidadActual);
            }
        });

        // Función para guardar cambios en la base de datos
        function guardarCambiosEnBaseDeDatos(nuevaCantidad) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'actual_cantidad.php', true); // Reemplaza con la URL correcta
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                }
            };
            xhr.send('nuevaCantidad=' + nuevaCantidad);
        }
    </script>
      <?php include('../../components/footer.php'); ?>
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


