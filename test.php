<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Navbar y Tabla</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- DataTables Bootstrap 5 CSS -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>

<!-- ✅ NAVBAR FUNCIONAL -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="https://via.placeholder.com/60x40" alt="Logo" width="60">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Sección</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- ✅ TABLA -->
<div class="container mt-5">
  <h4>Mi tabla de prueba</h4>
  <table id="tablaEjemplo" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Edad</th>
        <th>País</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>Juan</td><td>28</td><td>Perú</td></tr>
      <tr><td>Ana</td><td>34</td><td>Chile</td></tr>
      <tr><td>Carlos</td><td>25</td><td>Argentina</td></tr>
    </tbody>
  </table>
</div>

<!-- ✅ SCRIPTS EN ORDEN CORRECTO -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap5.min.js"></script>

<!-- ✅ INICIALIZACIÓN -->
<script>
  $(document).ready(function () {
    $('#tablaEjemplo').DataTable({
      pageLength: 5,
      lengthMenu: [5, 10, 25, 50],
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
      }
    });
  });
</script>

</body>
</html>
