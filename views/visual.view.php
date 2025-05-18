<?php

$vigente = $conn->query("SELECT * FROM notas WHERE estado = 'Aprobado' AND vencimiento >= CURDATE();");
//$vencido = $conn->query("SELECT * FROM notas WHERE estado = 'Aprobado' AND vencimiento < CURDATE();");
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
    </ul>
</nav>
<br>
<div class="contenedor">
<h4 style="text-align: center;">Notas Vigentes</h4>
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
<?php while ($row = $vigente->fetch_assoc()): ?>
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
        </td>     
    </tr>
    <?php endwhile; ?>
</tbody>
</table>
</div>
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