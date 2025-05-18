<?php include 'sistema/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="contenedor" style="width:600px; text-align:center;margin: 0 auto">
 <form method="POST">
    <h2>Registro</h2>
    <label>Nombre de Usuario:</label>
    <input type="text" name="nombre" placeholder="Nombre de Usuario" required><br>
    <label>Email:</label>
    <input type="email" name="email" placeholder="Correo electrónico" required><br>
    <label>Contraseña:</label>
    <input type="password" name="password" placeholder="Contraseña" required>
    <input type="password" name="pass2" placeholder="Repetir Contraseña" required><br>
    <label>Rol:</label>
    <select name="rol" id="roles" required onchange="mostrarCampos()">
        <option value="">Seleccionar</option>
        <option value="empresa">Empresa</option>
        <option value="administrador">Administrador</option>
        <option value="visualizador">Visualizador</option>
    </select><br> 

<!--datos empresa-->
<div id="camposEmpresa" class="opciones">
      <h4>Datos de Empresa:</h4>
      <label>Nombre:</label>
      <input type="text" name="nombreEmpresa"><br>
      <label>Responsable:</label>
      <input type="text" name="respo"><br>
      <label>Telefono:</label>
      <input type="number" name="tel">
</div>
<!--datos visualizador-->
<div id="camposVisualizador" class="opciones">
      <h4>Datos de Visualizador:</h4>
      <label>Legajo:</label>
      <input type="number" name="legajo"><br>
      <label>Nombre:</label>
      <input type="text" name="nomVisual"><br>
      <label>Apellido:</label>
      <input type="text" name="apeVisual"><br>
      <label>Jerarquia:</label>
      <select name="jerarquia">
        <option value="">Seleccionar</option>
        <option value="jefe">Jefe</option>
        <option value="supervisor">Supervisor</option>
        <option value="auxiliar">Auxiliar</option>
    </select><br>
      <label>Cargo:</label>
      <input type="text" name="cargo"><br>
</div>
<button type="submit" class="btn btn-primary">Registrarse</button>
</form>
</div>
  <script>
    function mostrarCampos() {
      document.getElementById("camposEmpresa").style.display = "none";
      document.getElementById("camposVisualizador").style.display = "none";

      const rol = document.getElementById("roles").value;

      if (rol === "empresa") {
        document.getElementById("camposEmpresa").style.display = "block";
      } else if (rol === "visualizador") {
        
    
        document.getElementById("camposVisualizador").style.display = "block";
      }
    }
  </script>

</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $conn->real_escape_string($_POST["nombre"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $_POST['password'];
    $p2 = $_POST['pass2'];
    $rol = $_POST["rol"];
    if($password==$p2){
      $hash = password_hash($password, PASSWORD_DEFAULT); 
    
    $s = $conn->prepare("INSERT INTO usuarios (nomusu, email, password, rol) VALUES (?, ?, ?, ?)");
    $s->bind_param("ssss", $nombre, $email, $hash, $rol);
    $s->execute();
    $user = $s->insert_id;
    switch  ($rol){
        case 'empresa':
        $nomEmpresa = $conn->real_escape_string($_POST["nombreEmpresa"]);
        $resp = $conn->real_escape_string($_POST["respo"]);
        $tel = $_POST["tel"];
        $s = $conn->prepare("INSERT INTO empresas (id_Usuario,nombre, telefono, responsable) VALUES (?,?, ?, ?)");
        $s->bind_param("isss", $user, $nomEmpresa, $tel, $resp);
        $s->execute();
        break;
        case 'visualizador':
        $legajo=$_POST["legajo"];
      $nomVisual = $conn->real_escape_string($_POST["nomVisual"]);
      $apeVisual = $conn->real_escape_string($_POST["apeVisual"]);
      $j = $_POST["jerarquia"];
      $c=$_POST["cargo"];
      $s = $conn->prepare("INSERT INTO visualizadores (legajo, id_Usuario,nombre, apellido, jerarquia, cargo) VALUES (?,?,?,?, ?, ?)");
      $s->bind_param("ssssss",$legajo, $user, $nomVisual,$apeVisual, $j, $c);
      $s->execute();
      break;
    }
    $_SESSION['mensaje'] = 'El usuario fue creado correctamente!.';
    header("Location: login.php");
    exit();
    }else{
      echo "Las password no coinciden";
    }
}
?>