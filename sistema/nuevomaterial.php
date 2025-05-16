<?php
include 'conexion.php';
$id_nota=$_POST['idnota'];
$nombre = $_POST['material_nombre'];
$tipo = $_POST['material_tipo'];
$cantidad = $_POST['material_cantidad'];
$descripcion = $_POST['material_descripcion'];
$conn->query("INSERT INTO materiales (id_Nota, nombre, tipo, cant, descripcion)
                VALUES ('$id_nota', '$nombre', '$tipo', '$cantidad', '$descripcion')");
$_SESSION['mensaje'] = 'Material agregado correctamente.';
header("Location: modnota.php?id=$id_nota");
?>