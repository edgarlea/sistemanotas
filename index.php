<?php include 'sistema/conexion.php';
if ($_SESSION["user_id"]){
    $rol=$_SESSION["rol"];
    $id=$_SESSION["user_id"];
    $activo=$_SESSION["activo"];
}else{
    header("Location: login.php");
    exit();
}
if (isset($_SESSION['mensaje'])) {
    echo "<script>alert('" . $_SESSION['mensaje'] . "');</script>";
    unset($_SESSION['mensaje']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Notas de Autorizacion de Materiales</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="logo">
    <img src="img/logo.png" alt="logo" style="height: 100px;width:100px;">  
    <h2 style="text-align: center; padding: top 20px;">Sistema de Notas de Autorizacion de Materiales</h2>
    </div>

<h5 style="text-transform: uppercase">Tipo <?= htmlspecialchars($_SESSION["rol"]) ?></h5>
<h4 style="text-align: right;"><a href="logout.php">Cerrar sesión</a></h4>
<?php
if ($activo){
    switch ($rol) {
    case 'Administrador':
        require 'views/admin.view.php';
        break;
    case 'Visualizador':
        require 'views/visual.view.php';
        break;
    case 'Empresa':
        require 'views/empresa.view.php';
        break;
    }    
}
else{
        echo "Su cuenta no fue todavia activada";
    }  
?>

</body>
</html>