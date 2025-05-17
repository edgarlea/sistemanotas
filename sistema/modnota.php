<?php
include 'conexion.php';
$id = $_GET['id'];
$nota = $conn->query("SELECT * FROM notas WHERE id_Nota = '$id'");
$nota=$nota->fetch_assoc();
$materiales=$conn->query("SELECT * FROM materiales WHERE id_Nota = '$id'");
if (isset($_SESSION['mensaje'])) {
    echo "<script>alert('" . $_SESSION['mensaje'] . "');</script>";
    unset($_SESSION['mensaje']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Nota</title>
    <link rel="stylesheet" href="/sistemanotas/css/style.css">
</head>
<body>
<h2>Nota Actual</h2>
<div class="contenedor notas">
<table class="table">
<thead class="text-primary">
<th>Nro</th>
<th>Personal Autorizado</th>
<th>Vencimiento</th>
</thead>
<tbody>
    <tr>
    <td><?= $nota['id_Nota'] ?></td>
    <td><?= $nota['personal'] ?></td>
    <td><?= $nota['vencimiento'] ?></td>    
    </tr>
</tbody>
</table>
</div>
<form action="actualizarnota.php" method="POST">
  <input type="number" name="idnota" value="<?= $nota['id_Nota']?>" hidden>
<label>Personal Autorizado:</label>
<input type="text" name="personalautorizado" id="personalautorizado" required><br><br>
<label>Fecha de Vencimiento:</label>
<input type="date" name="vencimiento" id="vencimiento" required><br><br>
<button type="submit" class="btn btn-primary">Actualizar Nota</button>
</form>
<h2>Materiales</h2> <button onclick="abrirModal()" class="btn btn-primary">+ Agregar Material</button>
<div class="contenedor">
<table class="table">
<thead class="text-primary">
<th>Codigo</th>
<th>Nombre</th>
<th>Tipo</th>
<th>Cantidad</th>
<th>Descripcion</th>
<th>Acciones</th>
</thead>
<tbody>
<?php while ($row = $materiales->fetch_assoc()): ?>
    <tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['nombre']) ?></td>
    <td><?= $row['tipo'] ?></td> 
    <td><?= $row['cant'] ?></td>
    <td><?= $row['descripcion'] ?></td>    
        <td>
        <button onclick="abrirModificarModal(<?= $row['id'] ?>)" class="btn btn-primary">Modificar</button> 
        <a href="sistema/elimaterial.php?id=<?= $row['id'] ?>">
           <button class="btn btn-danger">Eliminar</button> 
        </a>
        </td>    
    </tr>
    <?php endwhile; ?>
</tbody>
</table>
</div>
<div id="nuevoModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3>Nuevo Material</h3>
      <span class="close" onclick="cerrarModal()">&times;</span>
    </div>
    <form action="nuevomaterial.php" method="POST">
      <div class="modal-body">
        <input type="number" name="idnota" value="<?php echo $id?>" hidden>
        <label>Nombre:</label>
      <input type="text" name="material_nombre" required><br>
      <label>Tipo:</label>
      <input type="text" name="material_tipo" required><br>
      <label>Cantidad:</label>
      <input type="number" name="material_cantidad" required><br>
      <label>Descripción:</label>
      <textarea name="material_descripcion" rows="4" cols="35"></textarea>
        <div style="display: flex; justify-content: space-between;">
          <button type="button" class="btn btn-cancel" onclick="cerrarModal()">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div id="modificarModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3>Modificar Material</h3>
      <span class="close" onclick="cerrarModal()">&times;</span>
    </div>
    <form action="modmaterial.php" method="POST">
      <input type="number" name="idnota" value="<?php echo $id?>" hidden>
      <div class="modal-body">
        <div id="contenidoModal">Cargando...</div>
        <div style="display: flex; justify-content: space-between;">
          <button type="button" class="btn btn-danger" onclick="cerrarModal()">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
        document.getElementById('personalautorizado').value = '<?= $nota['personal']?>';
        document.getElementById('vencimiento').value = '<?= $nota['vencimiento']?>';
  function abrirModal() {
    document.getElementById('nuevoModal').style.display = 'block';
  }
 function abrirModificarModal(idMaterial) {
    document.getElementById('modificarModal').style.display = 'block';
    const xhr = new XMLHttpRequest();
        xhr.open("GET", "cargar_datos.php?id=" + idMaterial, true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
        document.getElementById('contenidoModal').innerHTML = xhr.responseText;
      }
    };
    xhr.send();
  }
  function cerrarModal() {
    document.getElementById('modificarModal').style.display = 'none';
    document.getElementById('nuevoModal').style.display = 'none';
  }
window.onclick = function(event) {
const modal = document.getElementById('nuevoModal');
if (event.target === modal) {
      cerrarModal();
}
}
</script>
</body>
</html>