<?php
include 'conexion.php';
$id = $_POST['idnota'];
$usuario=$_POST['nomusu'];
$accion=$_POST['aprob'];
$observacion=$_POST['observacion'];
     $conn->query("UPDATE notas SET estado= '$accion', aprueba='$usuario', observacion='$observacion' WHERE id_Nota = $id");
     $_SESSION['mensaje'] = "La nota fue ". $accion." correctamente!.";
    header("Location: /index.php");
    exit();
?>