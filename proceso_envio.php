<?php include('templates/header.php'); ?>

<!-- TABLA DE MOVIMIENTOS -->
<div class="table-responsive" id="contenedorMovimientos" style="visibility: hidden;">
  <table id="tablaMovimientos" class="table table-striped table-bordered nowrap" style="width:100%">
    <thead class="table-dark text-center">
      <tr>
        <th>Herramienta</th>
        <th>Estado</th>
        <th>Origen</th>
        <th>Destino</th>
        <th>Fecha de envío</th>
        <th>Proceso</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($movimientos as $mov): ?>
        <tr>
          <td><?= htmlspecialchars($mov['nombre_herramienta'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($mov['estado'] ?? '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($mov['origen_nombre'] ?? '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($mov['destino_nombre'] ?? '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($mov['fecha_envio'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($mov['proceso'] ?? '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td>
            <a href="crudM/editarM.php?id=<?= $mov['id']; ?>" type="button" class="btn btn-primary">
              <i class="bi bi-check-lg"></i>
            </a>

            <!-- Botón eliminar con modal -->
            <button type="button" class="btn btn-danger btnEliminarMovimiento btnEliminar"
              data-id="<?= $mov['id']; ?>"
              data-nombre="el proceso de envio de <?= htmlspecialchars($mov['nombre_herramienta'], ENT_QUOTES, 'UTF-8'); ?>"
              data-url="crudM/eliminarM.php">
              <i class="bi bi-trash3"></i>
            </button>


          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN -->
<?php include("modal/modalEliminacion.php"); ?>

<!-- MODAL DE CONFIRMACIÓN DE EXITO -->
<?php include("modal/modalExito.php"); ?>




<?php include('templates/footer.php'); ?>