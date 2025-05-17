<?php
include 'conexion.php';
$id = $_POST['idnota'];
     $conn->query("DELETE FROM materiales WHERE id_Nota = $id");
     $conn->query("DELETE FROM notas WHERE id_Nota = $id");
     $_SESSION['mensaje'] = 'La nota fue eliminada correctamente!.';
    header("Location: /sistemanotas/index.php");
    exit();
?>