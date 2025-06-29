<?php
/*SABER SI HAY INICIO DE SESION EXISTENTE*/
      session_start();
      //var_dump($_SESSION);
      if (isset($_SESSION["usuario"])) {
        //echo "Usuario Activo: " . $_SESSION["usuario"];
        //echo "Rol del usuario: " . $_SESSION["rol"]; // Para depuración
      } else {
          header("location:login.php");
      }


include("bd.php");
include("crudH/leer.php");
include('crudM/leerM.php'); 
include('crudU/leerU.php'); 
include('crudF/leerF.php'); 

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
    <style>
      @media (max-width: 576px) {
  div.dataTables_filter {
    margin: 0 !important;
    padding: 0 !important;
    text-align: left !important;
  }

  div.dataTables_filter input {
    margin-top: 8px !important;
    width: 100% !important;
  }

  div.dataTables_length {
    text-align: left !important;
  }
}

    </style>
  </head>
  <body>
<header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img src="img/logo.png" width="60px" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav me-auto">
  <li class="nav-item">
    <a class="nav-link " aria-current="page" href="index.php">Inicio</a>
  </li>
    <li class="nav-item">
    <a class="nav-link " aria-current="page" href="listaHerramientas.php">Herramientas</a>
  </li>
<!-- Menú desplegable de fábricas -->
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="dropdownFabricas" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    Empresas
  </a>
  <ul class="dropdown-menu" aria-labelledby="dropdownFabricas">
    <?php foreach ($fabricas as $fabricaItem): ?>
      <?php if (strtolower($fabricaItem['nombre_fabrica']) !== 'persona externa'): ?>
        <li>
          <a class="dropdown-item" href="listaHerramientas.php?fabrica=<?= urlencode(strtolower($fabricaItem['nombre_fabrica'])) ?>">
            <?= htmlspecialchars($fabricaItem['nombre_fabrica'], ENT_QUOTES, 'UTF-8') ?>
          </a>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>

    <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "administrador"): ?>
      <li><hr class="dropdown-divider"></li>
      <li>
        <a class="dropdown-item" href="listaFabricas.php">Lista de Empresas</a>
      </li>
    <?php endif; ?>
  </ul>
</li>
</ul>

<ul class="navbar-nav ms-auto">

<?php  if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "administrador"): ?>
  <li class="nav-item">
    <a class="nav-link" href="proceso_envio.php">Proceso de envío |</a>
  </li>
<?php  endif; ?>

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
<?php
$paginaActual = basename($_SERVER['PHP_SELF']);
$titulo = 'Listado de herramientas';

if ($paginaActual === 'index.php') {
    $titulo = 'Estadísticas';
} elseif ($paginaActual === 'proceso_envio.php') {
    $titulo = 'Proceso de envío de herramientas';
} elseif ($paginaActual === 'formularioHerramienta.php') {
    $titulo = isset($_GET['id']) ? 'Editar herramienta' : 'Agregar herramienta';
} elseif ($paginaActual === 'formularioUsuario.php') {
    $titulo = isset($_GET['id']) ? 'Editar usuario' : 'Agregar usuario';
} elseif ($paginaActual === 'formularioFabrica.php') {
    $titulo = isset($_GET['id']) ? 'Editar fábrica' : 'Agregar fábrica';
} elseif ($paginaActual === 'listaFabricas.php') {
    $titulo = 'Listado de fábricas';
} elseif ($paginaActual === 'movimientos.php') {
    if (isset($_GET['id'])) {
        $titulo = 'Movimiento de herramienta';
    } elseif (isset($_GET['fabrica']) && $_GET['fabrica'] !== '') {
        $titulo = 'Movimientos - ' . ucfirst($_GET['fabrica']);
    } else {
        $titulo = 'Movimientos de herramientas';
    }
} elseif ($paginaActual === 'listaUsuarios.php') {
    $titulo = 'Listado de usuarios';
} elseif ($paginaActual === 'listaHerramientas.php' && isset($_GET['fabrica']) && $_GET['fabrica'] !== '') {
    $titulo = 'Listado de herramientas - ' . ucfirst($_GET['fabrica']);
}

?>

<h2 class="mb-4 text-center"><?= $titulo ?></h2>



<?php
if (
    $paginaActual === 'listaUsuarios.php' &&
    isset($_SESSION["rol"]) &&
    $_SESSION["rol"] === "administrador"
) {
    echo '<a href="formularioUsuario.php"><button type="button" class="btn btn-dark">Agregar Usuario</button></a>';
} elseif (
   $paginaActual === 'listaHerramientas.php' &&
    (!isset($_GET['fabrica']) || $_GET['fabrica'] === '') &&
    isset($_SESSION["rol"]) &&
    $_SESSION["rol"] === "administrador"
) {
    echo '<a href="formularioHerramienta.php"><button type="button" class="btn btn-dark">Agregar Herramienta</button></a>';
} elseif (
    $paginaActual === 'listaFabricas.php' &&
    isset($_SESSION["rol"]) &&
    $_SESSION["rol"] === "administrador"
) {
    echo '<a href="formularioFabrica.php"><button type="button" class="btn btn-dark">Agregar Fábrica</button></a>';
}
?>


