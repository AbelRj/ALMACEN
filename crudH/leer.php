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


/*Obtener movimientos pendientes, esto lo estoy usando para el boton de envio*/
$sentenciaPendientes = $conexion->prepare("
  SELECT herramienta_id FROM movimientos WHERE proceso = 'pendiente'
");
$sentenciaPendientes->execute();
$pendientes = $sentenciaPendientes->fetchAll(PDO::FETCH_COLUMN);





?>