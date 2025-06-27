<?php
include("../bd.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener nombre de la fábrica asociada a la herramienta
    $consulta = $conexion->prepare("
        SELECT f.nombre_fabrica 
        FROM herramientas h 
        JOIN fabricas f ON h.id_fabrica = f.id 
        WHERE h.id = :id
    ");
    $consulta->bindParam(':id', $id);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    // Eliminar la herramienta
    $sentencia = $conexion->prepare("DELETE FROM herramientas WHERE id = :id");
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();

    // Redirigir a index.php con el nombre de la fábrica
    $nombreFabrica = $resultado['nombre_fabrica'] ?? '';
    $url = "../listaHerramientas.php";
    if (!empty($nombreFabrica)) {
        $url .= "?fabrica=" . urlencode($nombreFabrica);
    }

    header("Location: $url");
    exit();
} else {
    echo "ID no proporcionado.";
}
?>

