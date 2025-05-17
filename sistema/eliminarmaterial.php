<?php
include 'conexion.php';
$id=$_POST["idnota"];
$idMaterial = $_POST["idmaterial"];
     $conn->query("DELETE FROM materiales WHERE id = $idMaterial");
     $_SESSION['mensaje'] = 'El material fue eliminado correctamente!.';
    header("Location: modnota.php?id=$id");
    exit();
?>