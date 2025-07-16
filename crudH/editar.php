<?php
include("../bd.php");

$nombre = strtoupper($_POST['nombreH']);
$descripcion = strtolower($_POST['descripcionH']);
$codigo = strtoupper($_POST['codigoH']);
$estado = $_POST['estadoH'];
$fabrica = $_POST['fabricaH'];

// Buscar ID de la fábrica
$buscarFabrica = $conexion->prepare("SELECT id FROM fabricas WHERE nombre_fabrica = :nombre");
$buscarFabrica->bindParam(':nombre', $fabrica);
$buscarFabrica->execute();
$fabricaRow = $buscarFabrica->fetch(PDO::FETCH_ASSOC);
$idFabrica = $fabricaRow['id'] ?? null;

// Comprobamos que venga el botón 'editar' y el parámetro 'id' por GET
if (isset($_POST['editar']) && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sentencia = $conexion->prepare("UPDATE herramientas SET nombre_herramienta = :nombre, descripcion = :descripcion, codigo = :codigo, estado = :estado, id_fabrica = :id_fabrica WHERE id = :id");
    $sentencia->bindParam(':nombre', $nombre);
    $sentencia->bindParam(':descripcion', $descripcion);
    $sentencia->bindParam(':codigo', $codigo);
    $sentencia->bindParam(':estado', $estado);
    $sentencia->bindParam(':id_fabrica', $idFabrica);
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();

    // Redirigir luego de editar
    header("Location: ../listaHerramientas.php?editado=ok&tipo=herramienta");


    exit();
}
