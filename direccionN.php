<?php session_start(); ?>
<?php
include 'partials/appGestor.php';
require 'partials/compatibilidad.php'; ?>
<?php

  $conexion = bd_conexion('localhost','root','','danaapp');
	$message = bd_registro_4($conexion,'nombre','barrio','direccion','extra');

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Dana app</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel=”shortcut icon” type=”image/png” href=”img/icono.png” />
</head>
<body>

  <section class="login-page">
            <div class="form-head">
              <img src="img/icono_2.png">
            </div>

     <form class="" action="direccionN.php" method="post">
       <div class="box">

           <div class="form-body">
                <input type="text" name="nombre" placeholder="Ingrese Nombre de Direccion">
                <input type="text" name="barrio" placeholder="Ingrese barrio">
                <input type="text" name="direccion" placeholder="Ingrese su direccion">
                <input type="text" name="extra" placeholder="Ingrese indicaciones extra">
           </div>

           <div class="form-footer">
               <input type="submit" name="" value="Registrar direccion">
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
