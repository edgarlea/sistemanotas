<?php include 'sistema/conexion.php'; 
$mensaje=$_SESSION['mensaje'] ?? null;
unset($_SESSION['mensaje']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login de Usuario</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php if ($mensaje): ?>
  <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
    <?= htmlspecialchars($mensaje) ?>
  </div>
<?php endif; ?>
<div class="contenedor" style="height: 200px; width:300px; text-align:center;margin: 0 auto">
<form method="POST">
    <h2>Iniciar sesión</h2>
    <input type="text" name="nomusu" placeholder="Nombre de Usuario" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button type="submit" class="btn btn-primary">Entrar</button>
</form>
</div>

<h4 style="text-align: center;"><a href="registro.php">Registrar</a></h4>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nomusu = $conn->real_escape_string($_POST["nomusu"]);
    $password = $_POST["password"];

    $result = $conn->query("SELECT * FROM usuarios WHERE nomusu = '$nomusu'");

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["rol"] = $user["rol"];
            $_SESSION["nomusu"] = $user["nomusu"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["activo"] = $user["activo"];
            header("Location: index.php");
            exit();
        }
    }

    echo "<p>El usuario o contraseña no coinciden</p>";
}
?>