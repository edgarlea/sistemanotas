<?php
include 'conexion.php';
$rol=$_SESSION["rol"];
$usuarios = null;
if (isset($_GET['buscar'])) {
    $buscar = trim($_GET['buscar']);
} else {
    $buscar = "";
}
  if ($buscar !== "") {
        $buscar = $conn->real_escape_string($buscar);
        $usuarios = $conn->query("SELECT * FROM usuarios WHERE id LIKE '%$buscar%' OR nomusu LIKE '%$buscar%' OR rol LIKE '%$buscar%' OR activo LIKE '%$buscar%'");
    } else {
        $usuarios = $conn->query("SELECT * FROM usuarios");
    } 

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados</title>
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
      <li><a href="usuarios.php">Usuarios</a></li>
    </ul>
</nav>
<br>
<div class="contenedor">
<form method="get" action="usuarios.php">
  <label for="buscar">Buscar:</label>
  <input type="text" id="buscar" name="buscar" value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>">
  <button type="submit" class="btn btn-primary">Buscar</button>
</form>
</div>
<br>
<div class="contenedor">
<h4 style="text-align: center;">Cuenta de Usuarios</h4>
<div class="table-responsive">
<table class="table">
<thead class="text-primary">
<th>Nº</th>
<th>Nombre de Usuario</th>
<th>Tipo</th>
<th>Activo</th>
<!--<th>Acciones</th>-->
</thead>
<tbody>

<?php if ($usuarios && $usuarios->num_rows > 0): ?>
<?php while ($row = $usuarios->fetch_assoc()): ?>
    <tr>
    <td><?=$row['id'] ?></td>
    <td><?= htmlspecialchars($row['nomusu']) ?></td>
    <td><?= $row['rol'] ?></td>    
        <td>
           <?php if ($row['activo']==1){
            echo "Si";
           }else{
           echo "No";
           }
           ?> 
        </td>
    <!--        <td>
        <a href="sistema/funciones.php?op=a&id=<?= $row['id'] ?>"><button class="btn btn-primary">Activar</button></a> 
      <button onclick="eliminarUsuarioModal(<?= $row['id'] ?>)" class="btn btn-danger">Eliminar</button>  
      </td> -->   
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
</body>
</html>