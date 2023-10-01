    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-2 pt-2">
        <div class="row px-xl-2 pt-2">
            <div class="col-lg-4 col-md-8 mb-5 pr-3 pr-xl-5">
                
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="../pag/index.php"><i class="fa fa-angle-right mr-2"></i>Inicio</a>
                            <a class="text-dark mb-2" href="../pag/shop.php"><i class="fa fa-angle-right mr-2"></i>Productos</a> 
                            <?php                 
                              if (isset($_SESSION['username'])) {                                     
                                echo '<a class="text-dark mb-2" href="../pag/cart.php"><i class="fa fa-angle-right mr-2"></i>Carrito</a>';
                                echo '<a class="text-dark mb-2" href="../pag/checkout.php"><i class="fa fa-angle-right mr-2"></i>Pagar</a>';
                              } else {                                  
                                echo '<a class="text-dark mb-2" href="../login/login.php"><i class="fa fa-angle-right mr-2"></i>Carrito</a>';
                                echo '<a class="text-dark mb-2" href="../login/login.php"><i class="fa fa-angle-right mr-2"></i>Pagar</a>';
                              }
                            ?>                             
                            <a class="text-dark" href="../pag/contact.php"><i class="fa fa-angle-right mr-2"></i>Contacto</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-7">
                        <a href="" class="text-decoration-none">
                          <h1 class="mb-4 display-5 font-weight-semi-bold">TIENDA</h1>
                        </a>                
                        <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>San Martin y Neuquen</p>
                        <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>garciaadriel65@gmail.com</p>
                        <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+54 9 2625459367</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->
