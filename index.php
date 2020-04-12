<?php session_start(); ?>
<?php
include 'partials/appGestor.php'; // Incluimos librería de código php
//require 'partials/bd.php'; //Requerimos la conexion a base de datos.
require 'partials/compatibilidad.php'
?>
<?php
	$conexion = bd_conexion('localhost','root','','danaapp');
	$message = login($conexion, 'user', 'password');

?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel=”shortcut icon” type=”image/png” href=”img/icono.png” />
    <title>Dana App</title>
  </head>
  <body>
<section class="login-page">
             <div class="form-head">
              <img src="img/icono_2.png">
              </div>

     <form class="" action="index.php" method="post">
       <div class="box">

           <div class="form-body"><br><br><br><br>
                <label>Usuario:</label>
                <input type="text" name="user" value="" placeholder="Usuario">
                <label>Contraseña:</label>
                <input type="password" name="password" value="" placeholder="Contraseña">
           </div>
           <div class="form-footer">
                <label>¿Olvidaste tu contraseña?</label><br>
               <input type="submit" name="submit" value="Ingresar"><br><br><p>¿No tienes una cuenta? <a href="signup.php">Registrate</a></p>
           </div>
       </div>
			 <?php if ($message != "") {
         //Mostramos un mensaje de error en caso que los datos de inicio de sesión no sean correctos
         echo $message;
       }?>
     </form>
</section>
  </body>
</html>
