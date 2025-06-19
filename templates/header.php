<?php
session_start();
//var_dump($_SESSION);

if (isset($_SESSION["usuario"])) {
   //echo "Usuario Activo: " . $_SESSION["usuario"];
   //echo "Rol del usuario: " . $_SESSION["rol"]; // Para depuración
} else {
    header("location:login.php");
}
include("bd.php");
include("crud/leer.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mover'])) {

  $herramientaId = $_POST['id_herramienta'];
  $nuevoDestinoId = $_POST['destino_id'];
  $proceso = $_POST['proceso'];

  // Obtener el ID de fábrica actual (origen)
  $stmtOrigen = $conexion->prepare("SELECT id_fabrica FROM herramientas WHERE id = :id");
  $stmtOrigen->bindParam(':id', $herramientaId, PDO::PARAM_INT);
  $stmtOrigen->execute();
  $origenId = $stmtOrigen->fetchColumn();

  // Validar que el destino es diferente del origen
  if ($origenId != $nuevoDestinoId) {
    // 1. Registrar el movimiento
  $stmtMovimiento = $conexion->prepare("
  INSERT INTO movimientos (herramienta_id, destino, fecha_envio, proceso)
  VALUES (:herramienta_id, :destino, NOW(), :proceso)
");
$stmtMovimiento->execute([
  ':herramienta_id' => $herramientaId,
  ':destino' => $nuevoDestinoId,
  'proceso' => $proceso
]);




    echo "<script>alert('Herramienta movida correctamente'); window.location='index.php';</script>";
  } else {
    echo "<script>alert('La fábrica de destino debe ser diferente a la de origen');</script>";
  }
}






// Obtener movimientos pendientes
$sentenciaPendientes = $conexion->prepare("
  SELECT herramienta_id FROM movimientos WHERE proceso = 'pendiente'
");
$sentenciaPendientes->execute();
$pendientes = $sentenciaPendientes->fetchAll(PDO::FETCH_COLUMN);

// Esto será un array con los IDs de herramientas que tienen un movimiento pendiente

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
        <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <title>EL´ENMOLL</title>
  </head>
  <body>
<header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php?fabrica="><img src="img/logo.png" width="60px" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav me-auto">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="index.php?fabrica=">Inicio</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?fabrica=almacén">Almacén</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?fabrica=tasa">Tasa</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?fabrica=copeinca">Copeinca</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?fabrica=hayduck">Hayduck</a>
  </li>
</ul>

<ul class="navbar-nav ms-auto">

<?php /* if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "administrador"): */?>
  <li class="nav-item">
    <a class="nav-link" href="index.php?proceso=1">Proceso de envío |</a>
  </li>
<?php /* endif; */?>

  <li class="nav-item me-4">
    <a class="nav-link" href="./cerrarSesion.php" title="Cerrar sesión">
      <i class="bi bi-box-arrow-right fs-5"></i>
    </a>
  </li>
</ul>
    </div>
  </div>
</nav>
</header>
<div class="container shadow rounded bg-white p-4">
      <h2 class="mb-4 text-center">
  <?php
$paginaActual = basename($_SERVER['PHP_SELF']);
if ($mostrarMovimientos) {
  echo "Proceso de envíos";
}elseif ($paginaActual === 'formulario.php' && isset($_GET['id'])) {
    echo "Editar herramienta";
} elseif ($paginaActual === 'formulario.php') {
    echo "Agregar herramienta";
} elseif ($paginaActual === 'movimientos.php' && isset($_GET['id'])) {
    echo "Movimiento de herramienta";
} elseif ($paginaActual === 'movimientos.php' && isset($_GET['fabrica']) && $_GET['fabrica'] !== '') {
    echo "Movimientos - " . ucfirst($_GET['fabrica']);
} elseif ($paginaActual === 'movimientos.php') {
    echo "Movimientos de herramientas";
} elseif ($paginaActual === 'index.php' && isset($_GET['fabrica']) && $_GET['fabrica'] !== '') {
    echo "Listado de herramientas - " . ucfirst($_GET['fabrica']);
} else {
    echo "Listado de herramientas";
}
  ?>
      </h2>
      <?php

if ($paginaActual === 'index.php') : ?>
<?php if (!$mostrarMovimientos && isset($_SESSION["rol"]) && $_SESSION["rol"] === "administrador"): ?>
  <a href="formulario.php"><button type="button" class="btn btn-dark">Agregar Herramienta</button></a>
<?php endif; ?>

<?php endif; ?>
