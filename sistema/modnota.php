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
    <link rel="stylesheet" href="/css/style.css">
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
<form method="POST">
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
        <a href="sistema/modmaterial.php?id=<?= $row['id'] ?>">Modificar</a> 
        <a href="sistema/elimaterial.php?id=<?= $row['id'] ?>">Eliminar</a>
        </td>    
    </tr>
    <?php endwhile; ?>
</tbody>
</table>
</div>


<div id="myModal" class="modal">
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
      <textarea name="material_descripcion"></textarea>
        <div style="display: flex; justify-content: space-between;">
          <button type="button" class="btn btn-cancel" onclick="cerrarModal()">Cancelar</button>
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
    document.getElementById('myModal').style.display = 'block';
  }

  function cerrarModal() {
    document.getElementById('myModal').style.display = 'none';
  }
window.onclick = function(event) {
const modal = document.getElementById('myModal');
if (event.target === modal) {
      cerrarModal();
}
}
</script>
</body>
</html>

<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (($nota['personal']!== $personal) or ($nota['vencimiento']!== $vencimiento)){
     $personal = $_POST["personalautorizado"];
     $vencimiento = $_POST["vencimiento"];
     $conn->query("UPDATE notas SET vencimiento='$vencimiento', personal = '$personal' WHERE id_Nota = $id");
     $_SESSION['mensaje'] = 'La nota fue modificada correctamente!.';
    header("Location: modnota.php?id=$id");
    exit();
    }
    
}
?>