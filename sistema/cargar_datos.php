<?php
include 'conexion.php';
$idMaterial = intval($_GET['id']);
$sql = "SELECT * FROM `materiales`
        WHERE id = $idMaterial";
$res = $conn->query($sql);
$mat = $res->fetch_assoc();
echo "<input type='hidden' name='material_id' value='{$mat['id']}'>";
            echo "<label>Nombre:</label>
                <input type='text' name='material_nombre' value='" . htmlspecialchars($mat['nombre']) . "'>";
            echo "<label>Tipo:</label>
                <input type='text' name='material_tipo' value='" . htmlspecialchars($mat['tipo']) . "'>";
            echo "<label>Cantidad:</label>
                <input type='number' name='material_cantidad' value='{$mat['cant']}' min='1'>";
            echo "<label>Descripción:</label>
                <textarea name='material_descripcion' rows='4' cols='35'>". htmlspecialchars($mat['descripcion']) ."</textarea>";
$conn->close();
?>