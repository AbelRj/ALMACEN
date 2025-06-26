<?php include('templates/header.php'); ?>

  <!-- TABLA DE MOVIMIENTOS -->
  <div class="table-responsive">
    <table id="tablaMovimientos" class="table table-striped table-bordered">
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
        <?php foreach($movimientos as $mov): ?>
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
          
          
              <a href="crudM/eliminarM.php?id=<?= $mov['id']; ?>" type="button" class="btn btn-danger">
                <i class="bi bi-trash3"></i>
              </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php include('templates/footer.php'); ?>