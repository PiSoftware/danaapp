<?php
session_start(); // Iniciamos la sesion para obtener los parametros de sesion actuales!
include 'partials/appGestor.php';

//Verificamos si fue presionado el boton de cerrar sesion y ejecutamos su función
if(array_key_exists('logout',$_POST)){
   logout('Location: /DanaApp20/index.php');
}
 ?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/styleS.css">
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

           <div class="form-body">
                  <?php
      // Mostramos los datos almacenados en las variables de sesion
                    echo '<label>Bienvenido </label> <input type="text" name="" value="'. $_SESSION['user_nombre'] . '">' ;
                    echo '<label>Usuario: </label> <input type="text" name="" value="'. $_SESSION['user_name'].'">';
                    echo '<label>Correo: </label> <input type="text" name="" value="'. $_SESSION['user_email'].'">';
                    echo '<label>Telefono: </label> <input type="text" name="" value="'. $_SESSION['user_tel'].'">';
                  ?>
           </div>
           <div class="form-footer">
             <p>¿Ya te aburriste? prueba a <form method="post"><input type="submit" name="logout" value="Cerrar Sesion"></</p>

              <div>
                <p>¿Deseas registrar tu direccion de entrega? prueba a <a href="direccionN.php">registrar direccion</a></p>
                 <p>¿Deseas revisar tus <a href="direccionesG.php">direcciones guardadas</a>?</p>
               <p>¿Deseas <a href="shop.php">ordenar</a>?</p>
              </div>

           </div>
       </div>
     </form>
</section>
  </body>
</html>
