<?php
include 'conexion.php';
$id_empresa = $_POST['idEmpresa'];
$autorizado = $_POST['personalautorizado'];
$vencimiento = $_POST['vencimiento'];
$estado="pendiente";

$s_nota = $conn->prepare("INSERT INTO notas (id_Empresa, vencimiento, personal, estado) VALUES (?, ?, ?, ?)");
$s_nota->bind_param("isss", $id_empresa,  $vencimiento,$autorizado, $estado);
$s_nota->execute();
$id_nota = $s_nota->insert_id;

$nombres = $_POST['material_nombre'];
$tipos = $_POST['material_tipo'];
$cantidades = $_POST['material_cantidad'];
$descripciones = $_POST['material_descripcion'];

for ($i = 0; $i < count($nombres); $i++) {
  $nombre = $conn->real_escape_string($nombres[$i]);
  $tipo = $conn->real_escape_string($tipos[$i]);
  $cantidad = (int)$cantidades[$i];
  $descripcion = $conn->real_escape_string($descripciones[$i]);

  $conn->query("INSERT INTO materiales (id_Nota, nombre, tipo, cant, descripcion)
                VALUES ('$id_nota', '$nombre', '$tipo', '$cantidad', '$descripcion')");
}
$_SESSION['mensaje'] = 'La Nota fue ingresa correctamente, quedando pendiente sujeta a aprobación.';
header("Location: /index.php");
exit;
?>