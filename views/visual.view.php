<?php

$result = $conn->query("SELECT * FROM notas WHERE estado = 'aprobada' AND vencimiento >= CURDATE();");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bienvenido Visualizador</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <h1>Panel de Visualizador</h1>
    <div class="menu-toggle" onclick="toggleMenu()">☰</div>
</header>
<nav>
    <ul id="menu">
      <li><a href="index.php">Inicio</a></li>
      <li><a href="ver_solicitudes.php">S</a></li>
      <li><a href="crear_solicitud.php">Crear Solicitud</a></li>
      <li><a href="usuarios.php">Usuarios</a></li>
      <li><a href="reportes.php">Notas</a></li>
    </ul>
</nav>
<h2>Notas Vigentes</h2>
<div class="contenedor usuarios">
<table class="table">
<thead class="text-primary">
<th>Nro</th>
<th></th>
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
        <a href="aprobar.php?id=<?= $row['id'] ?>">Aprobar</a> 
        <a href="rechazar.php?id=<?= $row['id'] ?>">Rechazar</a>
        </td>    
    </tr>
    <?php endwhile; ?>
</tbody>
</table>
</div>
<div class="contenedor">

</div>
<script>
    function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.classList.toggle('active');
    }
</script>
</body>
</html>