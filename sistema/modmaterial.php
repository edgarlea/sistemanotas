<?php
include 'conexion.php';
$idNota=$_POST['idnota'];
$id=$_POST['material_id'];
$nombre = $_POST['material_nombre'];
$tipo = $_POST['material_tipo'];
$cantidad = $_POST['material_cantidad'];
$descripcion = $_POST['material_descripcion'];
$conn->query("UPDATE materiales SET nombre='$nombre', tipo = '$tipo', cant='$cantidad', descripcion='$descripcion' WHERE id = $id");
     $_SESSION['mensaje'] = 'El material fue modificado correctamente!.';
    header("Location: modnota.php?id=$idNota");
    exit();
?>