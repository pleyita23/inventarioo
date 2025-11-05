<?php
require 'config.php';
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $cedula=$_POST['cedula']??'';
  $password=$_POST['password']??'';
  if($cedula==='1111' && $password==='1234'){
    $_SESSION['logged']=true;
    header('Location: dashboard.php');exit;
  } else $err='Credenciales incorrectas.';
}
?>
<!doctype html><html><head><meta charset="utf-8"><link rel="stylesheet" href="styles.css"><title>Login</title></head>
<body><div class="container"><div class="card" style="max-width:400px;margin:auto">
<h2>Ingreso</h2><?php if($err):?><div style="color:red"><?=$err?></div><?php endif;?>
<form method="post">
<input class="input" name="cedula" placeholder="Cédula" required><br><br>
<input class="input" name="password" type="password" placeholder="Contraseña" required><br><br>
<button class="button btn-primary">Entrar</button>
</form>
</div></div></body></html>
