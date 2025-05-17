<?php
include 'conexion.php';
$id=$_POST["idnota"];
$personal = $_POST["personalautorizado"];
$vencimiento = $_POST["vencimiento"];
     $conn->query("UPDATE notas SET vencimiento='$vencimiento', personal = '$personal' WHERE id_Nota = $id");
     $_SESSION['mensaje'] = 'La nota fue modificada correctamente!.';
    header("Location: modnota.php?id=$id");
    exit();
?>