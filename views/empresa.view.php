<?php
$id=$_SESSION["user_id"];
$result = $conn->query("SELECT * FROM empresas WHERE id_Usuario = '$id'");
$empresa = $result->fetch_assoc();
$id_empresa=$empresa['id_Empresa'];
$notaspendientes = $conn->query("SELECT * FROM notas WHERE id_Empresa = '$id_empresa' AND estado='pendiente'");
$notasaprobadas = $conn->query("SELECT * FROM notas WHERE id_Empresa = '$id_empresa' AND estado='aprobado'");
$notasrechazadas = $conn->query("SELECT * FROM notas WHERE id_Empresa = '$id_empresa' AND estado='rechazado'");

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bienvenido Usuario Empresa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <h1>Panel de Empresa</h1>
    <div class="menu-toggle" onclick="toggleMenu()">☰</div>
</header>
<nav>
    <ul id="menu">
      <li><a href="index.php">Inicio</a></li>
      <li><a href="#" onclick="crearnota();">Crear Nota</a></li>
      <li><a href="#">Notas</a></li>
    </ul>
</nav>
<div class="contenedor opciones" id="contenedornota">
<h2>Crear Nota de Autorización</h2>

<form action="sistema/crearnota.php" method="POST">
  <label>Empresa: <?php echo $empresa['nombre']?></label>
  <input type="number" name="idEmpresa" value="<?php echo $id_empresa?>" hidden>
  <br><br>

  <label>Personal Autorizado:</label>
  <input type="text" name="personalautorizado" required><br><br>

  <label>Fecha de Vencimiento:</label>
  <input type="date" name="vencimiento" required><br><br>

  <h3>Agregar Materiales</h3>
  <div id="materiales-container">
    <div class="material">
      <br>
      <label>Nombre:</label>
      <input type="text" name="material_nombre[]" required><br>
      <label>Tipo:</label>
      <input type="text" name="material_tipo[]" required><br>
      <label>Cantidad:</label>
      <input type="number" name="material_cantidad[]" required><br>
      <label>Descripción:</label><br>
      <textarea name="material_descripcion[]" rows="4" cols="30"></textarea><br><br>
    </div>
  </div>

  <button type="button" class="btn btn-primary" onclick="agregarMaterial()">+ Añadir otro material</button><br><br>

  <button type="submit" class="btn btn-primary">Guardar Nota</button>
</form>
</div>

<h2 style="text-align: center;">Notas Pendientes de Aprobacion</h2>
<div class="contenedor notas">
<div class="table-responsive">
<table class="table">
<thead class="text-primary">
<th>Nro</th>
<th>Personal Autorizado</th>
<th>Vencimiento</th>
<th>Estado</th>
<th>Acciones</th>
</thead>
<tbody>
<?php while ($row = $notaspendientes->fetch_assoc()): ?>
    <tr>
    <td><?= $row['id_Nota'] ?></td>
    <td><?= htmlspecialchars($row['personal']) ?></td>
    <td><?= $row['vencimiento'] ?></td> 
    <td><?= $row['estado'] ?></td>    
        <td>
        <a href="sistema/vernota.php?id=<?= $row['id_Nota'] ?>">
          <button class="btn btn-primary">Ver</button>
          </a> 
          <a href="sistema/modnota.php?id=<?= $row['id_Nota'] ?>">
          <button class="btn btn-warning">Modificar</button>
          </a> 
          <button onclick="eliminarModal(<?= $row['id_Nota'] ?>)" class="btn btn-danger">Eliminar</button>
        
        </td>    
    </tr>
    <?php endwhile; ?>
</tbody>
</table>
</div>
</div>

<h2 style="text-align: center;">Notas Aprobadas</h2>
<div class="contenedor notas">
<div class="table-responsive">
<table class="table">
<thead class="text-primary">
<th>Nro</th>
<th>Personal Autorizado</th>
<th>Vencimiento</th>
<th>Estado</th>
<th>Acciones</th>
</thead>
<tbody>
<?php while ($row = $notasaprobadas->fetch_assoc()): ?>
    <tr>
    <td><?= $row['id_Nota'] ?></td>
    <td><?= htmlspecialchars($row['personal']) ?></td>
    <td><?= $row['vencimiento'] ?></td> 
    <td><?= $row['estado'] ?></td>    
        <td>
          <a href="sistema/vernota.php?id=<?= $row['id_Nota'] ?>">
          <button class="btn btn-primary">Ver</button></a>
          <button onclick="eliminarModal(<?= $row['id_Nota'] ?>)" class="btn btn-danger">Eliminar</button>
        </td>    
    </tr>
    <?php endwhile; ?>
</tbody>
</table>
</div>
</div>

<h2 style="text-align: center;">Notas Rechazadas</h2>
<div class="contenedor notas">
<div class="table-responsive">
<table class="table">
<thead class="text-primary">
<th>Nro</th>
<th>Personal Autorizado</th>
<th>Vencimiento</th>
<th>Estado</th>
<th>Acciones</th>
</thead>
<tbody>
<?php while ($row = $notasrechazadas->fetch_assoc()): ?>
    <tr>
    <td><?= $row['id_Nota'] ?></td>
    <td><?= htmlspecialchars($row['personal']) ?></td>
    <td><?= $row['vencimiento'] ?></td> 
    <td><?= $row['estado'] ?></td>    
        <td>
        <a href="sistema/modnota.php?id=<?= $row['id_Nota'] ?>">
          <button class="btn btn-primary">Ver</button>
          </a> 
          <button onclick="eliminarModal(<?= $row['id_Nota'] ?>)" class="btn btn-danger">Eliminar</button>
        
        </td>    
    </tr>
    <?php endwhile; ?>
</tbody>
</table>
</div>
</div>

<div id="eliminarModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3>Eliminar Nota</h3>
      <span class="close" onclick="cerrarModal()">&times;</span>
    </div>
    <form action="sistema/eliminarnota.php" method="POST">
      <div class="modal-body">
        <input type="number" name="idnota" id="idNota" hidden>
        <h3>Esta seguro que quiere eliminar la nota?</h3>
        <div style="display: flex; justify-content: space-between;">
          <button type="button" class="btn btn-danger" onclick="cerrarModal()">NO</button>
          <button type="submit" class="btn btn-primary">SI</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
    function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.classList.toggle('active');
    }
function eliminarModal(idNota) {
    document.getElementById('eliminarModal').style.display = 'block';
    document.getElementById('idNota').value = idNota;
  }
 function cerrarModal() {
    document.getElementById('eliminarModal').style.display = 'none';
  }
window.onclick = function(event) {
const modal = document.getElementById('eliminarModal');
if (event.target === modal) {
      cerrarModal();
}
}
function crearnota() {
 document.getElementById("contenedornota").style.display = "block";
}
function agregarMaterial() {
  const container = document.getElementById('materiales-container');
  const nuevo = document.createElement('div');
  nuevo.classList.add('material');
  nuevo.innerHTML = `
  <br>  
  <label>Nombre:</label>
    <input type="text" name="material_nombre[]" required><br>
    <label>Tipo:</label>
    <input type="text" name="material_tipo[]" required><br>
    <label>Cantidad:</label>
    <input type="number" name="material_cantidad[]" required><br>
    <label>Descripción:</label><br>
    <textarea name="material_descripcion[]" rows="4" cols="30"></textarea><br><br>
  `;
  container.appendChild(nuevo);
}
</script>
</body>
</html>