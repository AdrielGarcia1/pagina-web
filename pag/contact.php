<?php include('../components/buttons.php'); ?>
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
                  <h6 class="m-0">CONTACTO</h6>
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
                            <?php                 
                              if (isset($_SESSION['username'])) {                                     
                                echo '<a href="../pag/cart.php" class="nav-item nav-link">Carrito</a>';
                                echo ' <a href="../pag/checkout.php" class="nav-item nav-link">Pagar</a>';
                              } else {                                  
                                echo '<a href="../login/login.php" class="nav-item nav-link">Carrito </a>';
                                echo '<a href="../login/login.php" class="nav-item nav-link">Pagar</a>';
                              }
                            ?>  
                            <a href="../pag/contact.php" class="nav-item nav-link active">Contacto</a>
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
<!-- Datos de Contacto Start -->
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="row justify-content-center">
                <h2 class="section-title px-5"><span class="px-2">Datos de Contacto</span></h2>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-md-5 mb-4 text-center">
                    <h5 class="mb-4 display-5 font-weight-semi-bold">Contacto 1</h5>
                    <p class="text-dark"><i class="fa fa-map-marker-alt text-primary mr-3"></i>San Martin y Neuquen</p>
                    <p><i class="fa fa-envelope text-primary mr-3"></i><a href="mailto:garciaadriel65@gmail.com" class="text-dark">garciaadriel65@gmail.com</a></p>
                    <p><i class="fa fa-phone-alt text-primary mr-3"></i><a class="text-dark" href="tel:+5492625459367">+54 9 2625459367</a></p>
                </div>
                <div class="col-md-5 mb-4 text-center">
                    <h5 class="mb-3 display-5 font-weight-semi-bold">Contacto 2</h5>
                    <p><i class="fa fa-envelope text-primary mr-1"></i><a class="text-dark" href="mailto:garciaadriel199@gmail.com">garciaadriel199@gmail.com</a></p>
                    <p><i class="fa fa-phone-alt text-primary mr-1"></i><a class="text-dark" href="tel:+5492625403666">+54 9 2625403666</a></p>
                    <p><i class="fab fa-instagram text-primary mr-1"></i><a class="text-dark" href="https://instagram.com/adriel_9234?utm_source=qr&igshid=MThlNWY1MzQwNA==">adriel_9234</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Datos de Contacto End -->

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