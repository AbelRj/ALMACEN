<?php
include('templates/header.php');
include('bd.php');


?>
<div class="table-responsive" id="contenedorUsuarios" style="visibility: hidden;">
  <table id="tablaUsuarios" class="table table-striped table-bordered nowrap" style="width:100%">
    <thead class="table-dark text-center">
      <tr>
        <th>Nombre</th>
        <th>Fecha de nacimiento</th>
        <th>Usuario</th>
        <th>Rol</th>
        <th>Email</th>
        <th>Fábrica</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $usuario): ?>
        <tr>
          <td><?= htmlspecialchars($usuario['nombre_apellido'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td>
            <?= $usuario['fecha_nacimiento'] && $usuario['fecha_nacimiento'] !== '0000-00-00'
              ? date('d-m-Y', strtotime($usuario['fecha_nacimiento']))
              : '---'; ?>
          </td>
          <td><?= htmlspecialchars($usuario['nombre_usuario'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($usuario['rol'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($usuario['email'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($usuario['nombre_fabrica'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>

          <td>
            <a href="formularioUsuario.php?id=<?= $usuario['id']; ?>" class="btn btn-dark">
              <i class="bi bi-pencil"></i>
            </a>
            <!-- Botón eliminar con modal -->
            <button type="button" class="btn btn-danger btnEliminar"
              data-id="<?= $usuario['id']; ?>"
              data-nombre="<?= htmlspecialchars($usuario['nombre_usuario'], ENT_QUOTES, 'UTF-8'); ?>"
              data-url="crudU/eliminarU.php">
              <i class="bi bi-trash3"></i>
            </button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>


<!-- Modal de Confirmación para Usuario -->
<?php include("modal/modalEliminacion.php"); ?>

<!-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN -->
<?php include("modal/modalExito.php"); ?>

<?php include('templates/footer.php'); ?>