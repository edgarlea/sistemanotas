<?php
$rol=$_SESSION["rol"];
if ($rol!="Administrador") {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM usuarios where activo=0");
$notas = $conn->query("SELECT * FROM notas where estado='pendiente'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bienvenido Administrador</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <h1>Panel de Administrador</h1>
    <div class="menu-toggle" onclick="toggleMenu()">☰</div>
</header>
<nav>
    <ul id="menu">
      <li><a href="/index.php">Inicio</a></li>
      <li><a href="/sistema/notas.php">Notas</a></li>
      <li><a href="/sistema/usuarios.php">Usuarios</a></li>
    </ul>
</nav>
<h2>Pendientes</h2>
<?php if ($mensaje): ?>
  <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
    <?= htmlspecialchars($mensaje) ?>
    <span class="close-btn" onclick="this.parentElement.remove()">&times;</span>
  </div>
<?php endif; ?>
<div class="contenedor">
<h4 style="text-align: center;">Activar Cuenta de Usuarios</h4>
<div class="table-responsive">
<table class="table">
<thead class="text-primary">
<th>Nº</th>
<th>Nombre de Usuario</th>
<th>Tipo</th>
<th>Activo</th>
<th>Acciones</th>
</thead>
<tbody>

<?php if ($result && $result->num_rows > 0): ?>
<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
    <td><?=$row['id'] ?></td>
    <td><?= htmlspecialchars($row['nomusu']) ?></td>
    <td><?= $row['rol'] ?></td>    
        <td>NO</td>
            <td>
        <a href="sistema/funciones.php?op=a&id=<?= $row['id'] ?>"><button class="btn btn-primary">Activar</button></a> 
      <button onclick="eliminarUsuarioModal(<?= $row['id'] ?>)" class="btn btn-danger">Eliminar</button>  
      </td>    
    </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="5">Sin pendientes</td>
    </tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
<br>
<div class="contenedor">
<h4 style="text-align: center;">Aprobar Notas Pendientes</h4>
<div class="table-responsive">
<table class="table">
<thead class="text-primary">
<th>Nota Nro</th>
<th>Empresa</th>
<th>Personal Autorizado</th>
<th>Vencimiento</th>
<th>Fecha de Ingreso</th>
<th>Estado</th>
<th>Acciones</th>
</thead>
<tbody>
<?php if ($notas && $notas->num_rows > 0): ?>
<?php while ($row = $notas->fetch_assoc()): ?>
    <tr>
    <td><?= $row['id_Nota'] ?></td>
    <td><?php
    $idemp=$row['id_Empresa'];
    $empresa = $conn->query("SELECT nombre FROM empresas WHERE id_Empresa='$idemp'");
    $emp=$empresa->fetch_assoc();
    echo $emp['nombre'];
    ?></td>
    <td><?= $row['personal'] ?></td>    
    <td><?= $row['vencimiento'] ?></td>
    <td><?= $row['fecha_in'] ?></td>
    <td><?= $row['estado'] ?></td>
    <td>
        <a href="sistema/vernota.php?id=<?= $row['id_Nota'] ?>">
          <button class="btn btn-primary">Ver</button>
          </a> 
          <button onclick="eliminarModal(<?= $row['id_Nota'] ?>)" class="btn btn-danger">Eliminar</button>
        </td>     
    </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="7">Sin pendientes</td>
    </tr>
<?php endif; ?>
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
        <h5>Esto tambien eliminara los materiales cargados en la nota</h5>
        <div style="display: flex; justify-content: space-between;">
          <button type="button" class="btn btn-danger" onclick="cerrarModal()">NO</button>
          <button type="submit" class="btn btn-primary">SI</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div id="eliminarUsuarioModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3>Eliminar Usuario</h3>
      <span class="close" onclick="cerrarModal()">&times;</span>
    </div>
    <form action="/sistema/funciones.php" method="GET">
      <div class="modal-body">
        <input type="text" name="op" value="r" hidden>
         <input type="number" name="id" id="idUsuarioEliminar" hidden>
        <h3>Esta seguro que quiere eliminar al usuario?</h3>
        <div style="display: flex; justify-content: space-between;">
          <button type="button" class="btn btn-danger" onclick="cerrarModal()">NO</button>
          <button type="submit" class="btn btn-primary">SI</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
      function eliminarModal(idNota) {
    document.getElementById('eliminarModal').style.display = 'block';
    document.getElementById('idNota').value = idNota;
  }
   function eliminarUsuarioModal(id) {
    document.getElementById('idUsuarioEliminar').value = id;
    document.getElementById('eliminarUsuarioModal').style.display = 'block';
  }
    function cerrarModal() {
    document.getElementById('eliminarModal').style.display = 'none';
    document.getElementById('eliminarUsuarioModal').style.display = 'none';
  }
window.onclick = function(event) {
const modal = document.getElementById('eliminarModal');
if (event.target === modal) {
      cerrarModal();
}
}
    function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.classList.toggle('active');
    }
</script>
</body>
</html>

