<?php
include 'conexion.php';
$id = $_GET['id'];
$opcion=$_GET['op'];
switch ($opcion) {
case 'a':
$conn->query("UPDATE usuarios SET activo = '1' WHERE id = $id");
$_SESSION['mensaje'] = 'EL usuario fue aprobado correctamente!.';
break;
case 'r': 
$conn->query("DELETE FROM empresas WHERE id_Usuario = $id");  
$conn->query("DELETE FROM usuarios WHERE id = $id");
$_SESSION['mensaje'] = 'EL usuario fue eliminado correctamente!.';
break; 
}
header("Location: /sistemanotas/index.php");
exit;
?>