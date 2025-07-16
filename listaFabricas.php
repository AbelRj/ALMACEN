<?php
include('templates/header.php');
include('bd.php');
?>
<div class="table-responsive" id="contenedorFabricas" style="visibility: hidden;">
  <table id="tablaFabricas" class="table table-striped table-bordered nowrap" style="width:100%">
    <thead class="table-dark text-center">
      <tr>
        <th>Nombre</th>
        <th>Lugar</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($fabricas as $fabrica): ?>
        <?php if (strtolower(trim($fabrica['nombre_fabrica'])) === 'persona externa') continue; ?>
        <tr>
          <td><?= htmlspecialchars($fabrica['nombre_fabrica'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($fabrica['lugar'] ?: '---', ENT_QUOTES, 'UTF-8'); ?></td>

          <td>
            <a href="formularioFabrica.php?id=<?= $fabrica['id']; ?>" class="btn btn-dark">
              <i class="bi bi-pencil"></i>
            </a>
            <!-- Botón Eliminar con Modal -->
            <button type="button" class="btn btn-danger btnEliminar"
              data-id="<?= $fabrica['id']; ?>"
              data-nombre="<?= htmlspecialchars($fabrica['nombre_fabrica'], ENT_QUOTES, 'UTF-8'); ?>"
              data-url="crudF/eliminarF.php">
              <i class="bi bi-trash3"></i>
            </button>


          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>

  </table>
</div>

<!-- Modal de Confirmación para Fabricas -->
<?php include("modal/modalEliminacion.php"); ?>

<!-- MODAL DE CONFIRMACIÓN DE EXITO -->
<?php include("modal/modalExito.php"); ?>
<?php include("modal/modalEliminacionExitosa.php"); ?>

<!-- MODAL DE CONFIRMACIÓN DE ELIMINACION -->
<?php include("modal/modalErrorEliminarFabrica.php"); ?>

<?php include('templates/footer.php'); ?>