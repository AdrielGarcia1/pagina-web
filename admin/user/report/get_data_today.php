<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "proyecto1";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$today = date("Y-m-d");
$sql = "SELECT HOUR(fecha_registro) AS hora, COUNT(*) AS cantidad_registrados_hoy
FROM usuarios
WHERE DATE(fecha_registro) = CURDATE()
GROUP BY HOUR(fecha_registro)";
$result = $conn->query($sql);

// Crear un array con los datos seleccionados
$data = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $data[] = array(
      'hora' => $row['hora'],
      'cantidad_registrados_hoy' => $row['cantidad_registrados_hoy']
    );
  }
}

$conn->close();

// Crear un array con las etiquetas y los datos para la gráfica
$labels = array();
$values = array();
foreach ($data as $row) {
  $labels[] = $row['hora'];
  $values[] = $row['cantidad_registrados_hoy'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Gráfica de usuarios registrados hoy según la hora</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <canvas id="myChart"></canvas>
  <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
          label: 'Usuarios registrados hoy',
          data: <?php echo json_encode($values); ?>,
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  </script>
</body>
</html>