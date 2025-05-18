<?php
include 'conexion.php';
$id = $_GET['id'];
$nota = $conn->query("SELECT * FROM notas WHERE id_Nota = '$id'");
$nota=$nota->fetch_assoc();
$materiales=$conn->query("SELECT * FROM materiales WHERE id_Nota = '$id'");
$rol=$_SESSION["rol"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Nota</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <header>
    <h1>Panel de <?=$rol?></h1>
    <div class="menu-toggle" onclick="toggleMenu()">☰</div>
</header>
<nav>
    <ul id="menu">
      <li><a href="/index.php">Inicio</a></li>
      <li><a href="#">Notas</a></li>
      <li><a href="#">Usuarios</a></li>
    </ul>
</nav>
<h2 style="text-align: center;">Nota de Autorizacion Nº<?= $nota['id_Nota'] ?></h2>
<div class="contenedor notas">
<table class="table">
<thead class="text-primary">
<th>Personal Autorizado</th>
<th>Vencimiento</th>
</thead>
<tbody>
    <tr>
    <td><?= $nota['personal'] ?></td>
    <td><?= $nota['vencimiento'] ?></td>    
    </tr>
</tbody>
</table>
</div>

<h2 style="text-align: center;">Materiales Cargados</h2>
<div class="contenedor">
<table class="table">
<thead class="text-primary">
<th>Codigo</th>
<th>Nombre</th>
<th>Tipo</th>
<th>Cantidad</th>
<th>Descripcion</th>
</thead>
<tbody>
<?php while ($row = $materiales->fetch_assoc()): ?>
    <tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['nombre']) ?></td>
    <td><?= $row['tipo'] ?></td> 
    <td><?= $row['cant'] ?></td>
    <td><?= $row['descripcion'] ?></td>    
       <!--  <td>
       <button onclick="abrirModificarModal(<?= $row['id'] ?>)" class="btn btn-primary">Modificar</button>
        <button onclick="eliminarModal(<?= $row['id'] ?>)" class="btn btn-danger">Eliminar</button> 
  </td>  -->    
    </tr>
    <?php endwhile; ?>
</tbody>
</table>
</div>

<?php
if($rol=="Administrador"){
echo "<h4>Acciones</h4>
<div class='contenedor'>  
    <form action='apruebanota.php' method='POST'>
  <input type='number'name='idnota' value=". $nota['id_Nota'] ." hidden>
<h3 style='text-align: center;'>Desea aprobar o rechazar la nota?:
<select name='aprob' required>
        <option value=''>Seleccionar</option>
        <option value='Aprobado'>Aprobar</option>
        <option value='Rechazado'>Rechazar</option>
    </select>
<button type='submit' class='btn btn-primary'>Aceptar</button></h3><br><br>
</form>
</div>";
}
?>


<script>
   function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.classList.toggle('active');
    }
  
</script>
</body>
</html>