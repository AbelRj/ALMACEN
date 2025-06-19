<?php include('templates/header.php'); ?>
<?php if ($mostrarMovimientos): ?>
   <!-- TABLA DE MOVIMIENTOS -->
  <div class="table-responsive">
    <table id="tablaMovimientos" class="table table-striped table-bordered">
      <thead class="table-dark text-center">
        <tr>
          <th>Herramienta</th>
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
          <td><?= htmlspecialchars($mov['origen_nombre'] ?? '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($mov['destino_nombre'] ?? '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($mov['fecha_envio'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($mov['proceso'] ?? '---', ENT_QUOTES, 'UTF-8'); ?></td>
          <td>
            
                        <a href="crud/editarM.php?id=<?= $mov['id']; ?>"
              type="button"
              class="btn btn-primary"
              ><i class="bi bi-check-lg"></i>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
<div class="table-responsive">
  <table id="tablaHerramientas" class="table table-striped table-bordered">
    <thead class="table-dark text-center">
      <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Código</th>
        <th>Estado</th>
        <th>Fabrica</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($herramientas as $herramienta): ?>
      <tr>
        <td>
          <?= htmlspecialchars($herramienta['nombre_herramienta'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?= htmlspecialchars($herramienta['descripcion'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?= htmlspecialchars($herramienta['codigo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?= htmlspecialchars($herramienta['estado'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?= htmlspecialchars($herramienta['nombre_fabrica'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>

          <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "administrador"): ?>

            <a href="formulario.php?id=<?= $herramienta['id']; ?>"
              type="button" class="btn btn-dark">
              <i class="bi bi-pencil"></i>
            </a>

          <?php endif; ?>


<?php if ((isset($_SESSION["rol"]) && $_SESSION["rol"] === "administrador") || (isset($_SESSION["rol"], $_SESSION["fabrica_id"]) &&
    $_SESSION["rol"] === "supervisor" && $_SESSION["fabrica_id"] == $herramienta["id_fabrica"])): ?>
    
    <?php if (in_array($herramienta['id'], $pendientes)): ?>
    <!-- Icono de X si hay movimiento pendiente -->
      <button type="button" class="btn btn-secondary" disabled>
        <i class="bi bi-x-lg"></i>
      </button>
    <?php else: ?>
    <!-- Botón de movimiento si no hay pendiente -->
      <a href="movimientos.php?id=<?= $herramienta['id']; ?>" type="button" class="btn btn-light">
        <i class="bi bi-rocket-takeoff"></i>
      </a>
    <?php endif; ?>

<?php endif; ?>


          <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "administrador"): ?>

            <a href="crud/eliminar.php?id=<?= $herramienta['id']; ?>"
              type="button"
              class="btn btn-danger"
              ><i class="bi bi-trash3"></i>
            </a>

          <?php endif; ?>
          

        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php endif; ?>
<?php include('templates/footer.php'); ?>
