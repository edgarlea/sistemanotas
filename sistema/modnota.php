<?php
include 'conexion.php';
$id = $_GET['id'];
$nota = $conn->query("SELECT * FROM notas WHERE id_Nota = '$id'");
$nota=$nota->fetch_assoc();
$materiales=$conn->query("SELECT * FROM materiales WHERE id_Nota = '$id'");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Nota</title>
    <link rel="stylesheet" href="css/style.css">
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

<h2>Materiales</h2>
<div class="contenedor">
<table class="table">
<thead class="text-primary">
<th>Nro</th>
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

<form method="POST">
<label>Personal Autorizado:</label>
<input type="text" name="personalautorizado" id="personalautorizado" required><br><br>
<label>Fecha de Vencimiento:</label>
<input type="date" name="vencimiento" id="vencimiento" required><br><br>
<button type="submit" class="btn btn-primary">Guardar Nota</button>
</form>
<script>
        document.getElementById('personalautorizado').value = '<?= $nota['personal']?>';
        document.getElementById('vencimiento').value = '<?= $nota['vencimiento']?>';
</script>
</body>
</html>

<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

}
?>