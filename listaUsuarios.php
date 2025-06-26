<?php
include('templates/header.php');
include('bd.php');


?>
<div class="table-responsive">
  <table id="tablaUsuarios" class="table table-striped table-bordered">
    <thead class="table-dark text-center">
      <tr>
        <th>Nombre</th>
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
        <td><?= htmlspecialchars($usuario['nombre_usuario'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($usuario['rol'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($usuario['email'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($usuario['nombre_fabrica'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>

        <td>
          <a href="formularioUsuario.php?id=<?= $usuario['id']; ?>" class="btn btn-dark">
            <i class="bi bi-pencil"></i>
          </a>
          <a href="crudU/eliminarU.php?id=<?= $usuario['id']; ?>" class="btn btn-danger">
            <i class="bi bi-trash3"></i>
          </a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include('templates/footer.php'); ?>
