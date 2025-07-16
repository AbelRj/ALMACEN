<?php
/*VER TODAS LASFABRICAS*/
$sentencia2 = $conexion->prepare("
          SELECT *
          FROM fabricas
      ");
$sentencia2->execute();
$fabricas = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
                usort($fabricas, function ($a, $b) {
                  return strtolower($a['nombre_fabrica']) === 'persona externa' ? 1 :
                        (strtolower($b['nombre_fabrica']) === 'persona externa' ? -1 : 0);
                });
/* TRAER DATOS MEDIANTE EL ID DE LA FÁBRICA */
$esEdicion = false;
$fabricaActual = null;

if (isset($_GET['id'])) {
    $esEdicion = true;
    $idEditar = $_GET['id'];

    $consulta = $conexion->prepare("
        SELECT * FROM fabricas WHERE id = :id
    ");
    $consulta->bindParam(':id', $idEditar, PDO::PARAM_INT);
    $consulta->execute();
    $fabricaActual = $consulta->fetch(PDO::FETCH_ASSOC);
}
