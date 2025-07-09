<!-- PROCESO DE RESTABLECER  -->
<?php include("proceso_restablecer.php"); ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EL´ENMOLL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/restablecer.css">
</head>

<body class="bg-light">

  <div class="container-fluid reset-wrapper d-flex justify-content-center align-items-center">
    <div class="card p-4 shadow reset-card mx-2">
      <img src="img/logo.png" alt="" class="p-5">

      <form method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" class="form-control" id="email" name="email">
        </div>
        <button type="submit" class="btn btn-light w-100">Restablecer contraseña</button>
      </form>
    </div>
  </div>

  <!-- MODAL DE CONFIRMACIÓN DE EXITO Y DE ERROR -->
<?php include("modal/modalRestablecer.php"); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>