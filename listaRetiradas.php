<?php include('templates/header.php'); 

$hRetiradas = $conexion->prepare("
  SELECT eh.*, f.nombre_fabrica
  FROM eliminados_herramientas eh
  JOIN fabricas f ON eh.fabrica = f.id
");
$hRetiradas->execute();
$retiradas = $hRetiradas->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="table-responsive" id="contenedorHerramientas" style="visibility: hidden;">
  <table id="tablaHerramientas" class="table table-striped table-bordered nowrap" style="width:100%">
    <thead class="table-dark text-center">
      <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Código</th>
        <th>Estado</th>
        <th>Fabrica</th>
        <th>Motivo</th>
        <th>Fecha</th>
        <th>Eliminador por</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($retiradas as $eliminado): ?>
        <tr>
          <td><?= htmlspecialchars($eliminado['nombre_herramienta'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($eliminado['descripcion'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($eliminado['codigo'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($eliminado['estado'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($eliminado['nombre_fabrica'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($eliminado['motivo'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($eliminado['fecha_eliminacion'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($eliminado['eliminado_por'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include('templates/footer.php'); ?>