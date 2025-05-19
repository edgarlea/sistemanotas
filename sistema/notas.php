<?php
include 'conexion.php';
$rol=$_SESSION["rol"];
$notas = null;
if (isset($_GET['buscar'])) {
    $buscar = trim($_GET['buscar']);
} else {
    $buscar = "";
}
if ($rol=="Empresa"){
 $user=$_SESSION["user_id"];
 $Empresa1 = $conn->query("SELECT id_Empresa,nombre FROM empresas WHERE id_Usuario='$user'"); 
 $e=$Empresa1->fetch_assoc();
 $ide=$e['id_Empresa']; 
  if ($buscar !== "") {
  $buscar = $conn->real_escape_string($buscar);
  $notas = $conn->query("SELECT * FROM notas WHERE id_Empresa='$ide' AND (id_Nota LIKE '%$buscar%' OR personal LIKE '%$buscar%' OR estado LIKE '%$buscar%')");
  } else {
   $notas = $conn->query("SELECT * FROM notas WHERE id_Empresa='$ide'");
  }
}else{
  if ($buscar !== "") {
        $buscar = $conn->real_escape_string($buscar);
        $notas = $conn->query("SELECT n.*, e.nombre AS nombre_empresa FROM notas n INNER JOIN empresas e ON n.id_Empresa = e.id_Empresa 
            WHERE n.id_Nota LIKE '%$buscar%' OR n.personal LIKE '%$buscar%' OR e.nombre LIKE '%$buscar%' OR n.estado LIKE '%$buscar%'");
    } else {
        $notas = $conn->query("SELECT n.*, e.nombre AS nombre_empresa 
            FROM notas n 
            INNER JOIN empresas e ON n.id_Empresa = e.id_Empresa");
    } 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas Cargadas</title>
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
      <?php if ($rol=="Administrador"): ?>
        <li><a href="usuarios.php">Usuarios</a></li>
        <?php endif;?>
    </ul>
</nav>
<br>
<div class="contenedor">
<form method="get" action="notas.php">
  <label for="buscar">Buscar:</label>
  <input type="text" id="buscar" name="buscar" value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>">
  <button type="submit" class="btn btn-primary">Buscar</button>
</form>
</div>
<br>
<div class="contenedor">
<h3 style="text-align: center;">Notas Cargadas</h3>
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
        if ($rol!="Empresa"){
        echo $row['nombre_empresa'];
        }else{
        echo $e['nombre'];
        } 
    ?></td>
    <td><?= $row['personal'] ?></td>    
    <td><?= $row['vencimiento'] ?></td>
    <td><?= $row['fecha_in'] ?></td>
    <td><?= $row['estado'] ?></td>
    <td>
        <a href="vernota.php?id=<?= $row['id_Nota'] ?>">
          <button class="btn btn-primary">Ver</button>
          </a> 
        </td>     
    </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="7">Sin Notas</td>
    </tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div> 
</body>
</html>