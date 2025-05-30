<?php
include 'conexion.php';
$id = $_GET['id'];
$usu=$_SESSION["nomusu"];
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
      <li><a href="notas.php">Notas</a></li>
      <?php if($rol=="Administrador"): ?>
        <li><a href="usuarios.php">Usuarios</a></li>
        <?php endif;?>
    </ul>
</nav>
<h2 style="text-align: center;">Nota de Autorizacion Nº<?= $nota['id_Nota'] ?></h2>
<div class="contenedor notas">
<table class="table">
<thead class="text-primary">
  <?php
  $ap=$nota['aprueba'];
  if ($ap!=null){
    if ($nota['estado'] ==="Rechazado"){
        echo  "<th style='color:red;'>Rechazado por:</th>";
        echo  "<th style='color:red;'>Motivo por:</th>";
    }else{
       echo  "<th>Aprobado por:</th>";
       echo  "<th>Observaciones:</th>";
    }
 
  }
  ?>
 
<th>Personal Autorizado</th>
<th>Vencimiento</th>
</thead>
<tbody>
    <tr>
 <?php
  if ($ap!=null){
   echo "<td>". $ap."</td>";
   echo "<td>". $nota['observacion']."</td>";
  }
  ?>
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
    <td><?=$row['id']?></td>
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
echo "<br>
<div class='contenedor' style='text-align: center;'>  
    <form action='apruebanota.php' method='POST'>
  <input type='number'name='idnota' value=". $nota['id_Nota'] ." hidden>
  <input type='text'name='nomusu' value=". $usu ." hidden>
<h3>Desea aprobar o rechazar la nota?:
<select name='aprob' required>
        <option value=''>Seleccionar</option>
        <option value='Aprobado'>Aprobar</option>
        <option value='Rechazado'>Rechazar</option>
    </select></h3>
<label for='observacion'>Observaciones:</label><br>
<textarea name='observacion' rows='4' cols='50'></textarea><br>
<button type='submit' class='btn btn-primary'>Aceptar</button><br>
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