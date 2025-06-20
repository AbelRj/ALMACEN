<?php

/*ESTO SIRVE PARA CUANDO HAGA CLICK EN CUALQUIER FABRICA DEL MENU, APARESCA SOLO LAS HERRAMIENTAS DE DICHA FABRICA*/
      $fabrica = isset($_GET['fabrica']) ? $_GET['fabrica'] : null;
      if ($fabrica) {
        $sentencia = $conexion->prepare("
          SELECT h.*, f.nombre_fabrica 
          FROM herramientas h 
          JOIN fabricas f ON h.id_fabrica = f.id 
          WHERE f.nombre_fabrica = :fabrica
        ");
        $sentencia->bindParam(':fabrica', $fabrica);
      } else {
        // Si no hay filtro, se muestran todas
        $sentencia = $conexion->prepare("
          SELECT h.*, f.nombre_fabrica 
          FROM herramientas h 
          JOIN fabricas f ON h.id_fabrica = f.id
        ");
      }
      $sentencia->execute(); 
      $herramientas = $sentencia->fetchAll(PDO::FETCH_ASSOC);


/*VER TODAS LASFABRICAS*/
      $sentencia2 = $conexion->prepare("
          SELECT id, nombre_fabrica 
          FROM fabricas
      ");
      $sentencia2->execute(); 
      $fabricas = $sentencia2->fetchAll(PDO::FETCH_ASSOC);




/*TRAER DATOS MEDIANTE EL ID DE LA HERRAMIENTA*/
      $esEdicion = false;
      $herramientaActual = null;

      if (isset($_GET['id'])) {
          $esEdicion = true;
          $idEditar = $_GET['id'];

          $consulta = $conexion->prepare("
              SELECT h.*, f.nombre_fabrica 
              FROM herramientas h 
              JOIN fabricas f ON h.id_fabrica = f.id 
              WHERE h.id = :id
          ");
          $consulta->bindParam(':id', $idEditar);
          $consulta->execute();
          $herramientaActual = $consulta->fetch(PDO::FETCH_ASSOC);
      }




/*ESTO SIRVE PARA QUE CUANDO HAGAN CLICK EN PROCESO DE ENVIOS, APARESCA LOS ENVIOS DE PROCESO PENDIENTE*/
      $mostrarMovimientos = isset($_GET['proceso']) && $_GET['proceso'] == 1;
      if ($mostrarMovimientos) {
      $sentenciaMov = $conexion->prepare("
        SELECT m.*, 
              h.nombre_herramienta,
              h.estado, 
              f_origen.nombre_fabrica AS origen_nombre, 
              f_destino.nombre_fabrica AS destino_nombre
        FROM movimientos m
        LEFT JOIN herramientas h ON m.herramienta_id = h.id
        LEFT JOIN fabricas f_origen ON h.id_fabrica = f_origen.id
        LEFT JOIN fabricas f_destino ON m.destino = f_destino.id
        WHERE m.proceso = 'pendiente'
      ");
      $sentenciaMov->execute();
      $movimientos = $sentenciaMov->fetchAll(PDO::FETCH_ASSOC);
  

}


?>