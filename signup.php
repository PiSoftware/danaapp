<?php
	include 'partials/appGestor.php';
	require 'partials/compatibilidad.php';

	$message = "";

	$conexion = bd_conexion('localhost','root','','danaapp');
	if (!empty($_POST['nombre']) && !empty($_POST['user']) && !empty($_POST['tel']) && !empty($_POST['email']) && !empty($_POST['password'])) {
		$message = signup($conexion, 'nombre', 'user', 'tel', 'email', 'password');
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Dana app</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/styleS.css">
	<link rel=”shortcut icon” type=”image/png” href=”img/icono.png” />
</head>
<body>

<section class="login-page">
             <div class="form-head">
              <img src="img/icono_2.png">
              </div>

<form action="signup.php" method="POST">
       <div class="box">

           <div class="form-body">
                <label>Nombre completo:</label>
                <input type="text" name="nombre" placeholder="Ingrese su nombre">
                <label>Nombre de usuario:</label>
                <input type="text" name="user" placeholder="Ingrese su usuario">
                <label>Número de Tel:</label>
          		<input type="text" name="tel" placeholder="Ingrese su telefono">
                <label>Correo:</label>
          		<input type="text" name="email" placeholder="Ingrese su email">
          		<label>Contraseña:</label>
          		<input type="password" name="password" placeholder="Ingrese su Contraseña">

           </div><br>
           <div class="form-footer">
    			<input type="submit" name="" value="Crear Cuenta">
           </div>
       </div>
</form>
</section>
          <?php if ($message != "") {
            //Mostramos un mensaje de error o éxito del registro de usuario a la bd
            echo $message;
          }?>
</body>
</html>
