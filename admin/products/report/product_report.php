<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Informe de Ventas de Productos</title>
    <!-- Incluye jQuery (asegúrate de que jQuery esté disponible) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluye la biblioteca Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body>
    <div style="width: 80%; margin: 0 auto;">
        <canvas id="graficoVentas"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            // Realiza una solicitud AJAX a total_sales.php para obtener los datos
            $.ajax({
                url: 'unit_prices.php', // Ruta a total_sales.php
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
</body>
</html>