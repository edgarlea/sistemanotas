<?php
$rol=$_SESSION["rol"];
if ($rol!="administrador") {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM usuarios where activo=0");
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
      <li><a href="index.php">Inicio</a></li>
      <li><a href="#">Notas</a></li>
      <li><a href="#">Usuarios</a></li>
    </ul>
</nav>
<h2>Pendientes</h2>
<div class="contenedor usuarios">
<h4 style="text-align: center;">Aprobar Usuarios</h4>
<table class="table">
<thead class="text-primary">
<th>ID</th>
<th>Nombre de Usuario</th>
<th>Rol</th>
<th>Activo</th>
</thead>
<tbody>
<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['nomusu']) ?></td>
    <td><?= $row['rol'] ?></td>    
        <td>NO
        <a href="sistema/funciones.php?op=a&id=<?= $row['id'] ?>">Aprobar</a> 
        <a href="sistema/funciones.php?op=r&id=<?= $row['id'] ?>">Rechazar</a>
        </td>    
    </tr>
    <?php endwhile; ?>
</tbody>
</table>
</div>
<div class="contenedor">
<?php
 require '/sistemanotas/sistema/modnota.php';
?>
</div>
<script>
    function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.classList.toggle('active');
    }
</script>
</body>
</html>

