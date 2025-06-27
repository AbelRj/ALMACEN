<?php 
include('templates/header.php'); 
include('bd.php');

// Gráfico 1: Herramientas por fábrica
$sentencia = $conexion->prepare("
  SELECT f.nombre_fabrica, COUNT(h.id) as total_herramientas
  FROM fabricas f
  LEFT JOIN herramientas h ON f.id = h.id_fabrica
  GROUP BY f.id
");
$sentencia->execute();
$resultados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$nombresFabricas = [];
$totales = [];

foreach ($resultados as $fila) {
  $nombresFabricas[] = $fila['nombre_fabrica'];
  $totales[] = $fila['total_herramientas'];
}

// Gráfico 2: Herramientas por estado
$consulta = $conexion->prepare("
  SELECT estado, COUNT(*) as cantidad
  FROM herramientas
  GROUP BY estado
");
$consulta->execute();
$datosEstado = $consulta->fetchAll(PDO::FETCH_ASSOC);

$labelsEstado = [];
$datosEstadoValores = [];
$coloresDisponibles = [
  'rgba(255, 99, 132, 0.6)',
  'rgba(54, 162, 235, 0.6)',
  'rgba(255, 206, 86, 0.6)',
  'rgba(75, 192, 192, 0.6)',
  'rgba(153, 102, 255, 0.6)',
  'rgba(255, 159, 64, 0.6)'
];
$coloresEstado = [];

foreach ($datosEstado as $index => $fila) {
  $labelsEstado[] = $fila['estado'];
  $datosEstadoValores[] = $fila['cantidad'];
  $coloresEstado[] = $coloresDisponibles[$index % count($coloresDisponibles)];
}
?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Gráfico: Herramientas por Fábrica -->
<div style="width: 80%; margin: auto; margin-bottom: 50px;">
  <canvas id="graficoHerramientas"></canvas>
</div>

<!-- Gráfico: Herramientas por Estado (Circular) -->
<div style="width: 50%; margin: auto;">
  <canvas id="graficoEstadoCircular"></canvas>
</div>

<script>
// Gráfico de herramientas por fábrica
new Chart(document.getElementById('graficoHerramientas').getContext('2d'), {
  type: 'bar',
  data: {
    labels: <?= json_encode($nombresFabricas) ?>,
    datasets: [{
      label: 'Cantidad de Herramientas',
      data: <?= json_encode($totales) ?>,
      backgroundColor: [
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)',
        'rgba(153, 102, 255, 0.6)',
        'rgba(255, 159, 64, 0.6)'
      ],
      borderColor: 'rgba(0,0,0,0.2)',
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { position: 'top' },
      title: {
        display: true,
        text: 'Herramientas por Fábrica'
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: { stepSize: 1 }
      }
    }
  }
});

// Gráfico circular de herramientas por estado
new Chart(document.getElementById('graficoEstadoCircular').getContext('2d'), {
  type: 'pie',
  data: {
    labels: <?= json_encode($labelsEstado) ?>,
    datasets: [{
      label: 'Estado de Herramientas',
      data: <?= json_encode($datosEstadoValores) ?>,
      backgroundColor: <?= json_encode($coloresEstado) ?>,
      borderColor: 'rgba(255, 255, 255, 1)',
      borderWidth: 2
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'bottom'
      },
      title: {
        display: true,
        text: 'Distribución de Herramientas por Estado'
      }
    }
  }
});
</script>

<?php include('templates/footer.php'); ?>
