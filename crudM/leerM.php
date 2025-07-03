<?php
/*ESTO SIRVE PARA QUE CUANDO HAGAN CLICK EN PROCESO DE ENVIOS, APARESCA LOS ENVIOS DE PROCESO PENDIENTE*/

$rol = $_SESSION['rol'] ?? null;
$fabricaSesion = $_SESSION['fabrica_id'] ?? null;

if ($rol === 'supervisor' && $fabricaSesion) {
  // Supervisores solo ven los envíos pendientes dirigidos a su fábrica
  $sentenciaMov = $conexion->prepare("
    SELECT m.*, 
          h.nombre_herramienta,
          h.estado, 
          f_origen.nombre_fabrica AS origen_nombre, 
          f_destino.nombre_fabrica AS destino_nombre
    FROM movimientos m
    LEFT JOIN herramientas h ON m.herramienta_id = h.id
    LEFT JOIN fabricas f_origen ON m.origen = f_origen.id
    LEFT JOIN fabricas f_destino ON m.destino = f_destino.id
    WHERE m.proceso = 'pendiente' AND m.destino = :fabrica_id
  ");
  $sentenciaMov->execute([':fabrica_id' => $fabricaSesion]);
} else {
  // Administradores ven todos los envíos pendientes
  $sentenciaMov = $conexion->prepare("
    SELECT m.*, 
          h.nombre_herramienta,
          h.estado, 
          f_origen.nombre_fabrica AS origen_nombre, 
          f_destino.nombre_fabrica AS destino_nombre
    FROM movimientos m
    LEFT JOIN herramientas h ON m.herramienta_id = h.id
    LEFT JOIN fabricas f_origen ON m.origen = f_origen.id
    LEFT JOIN fabricas f_destino ON m.destino = f_destino.id
    WHERE m.proceso = 'pendiente'
  ");
  $sentenciaMov->execute();
}

$movimientos = $sentenciaMov->fetchAll(PDO::FETCH_ASSOC);


?>