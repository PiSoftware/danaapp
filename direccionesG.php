<?php session_start();
  include 'partials/appGestor.php';
  
  $conn = bd_conexion('localhost','root','','danaapp');

  //Verificamos si fue presionado el boton de eliminar y ejecutamos su función
  if(array_key_exists('erase',$_POST)){
    $records = $conn->prepare('DELETE FROM direcciones WHERE id = :id');
		$records->bindParam(':id', $_POST['ident']);
		$records->execute();
  }
?>

<html>
<head>
	<title>Dana app</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/styleD.css">
  <link rel=”shortcut icon” type=”image/png” href=”img/icono.png” />
</head>

<body>

<section class="login-page">
             <div class="form-head">
              <img src="img/icono_2.png">   
              </div>
    
     <form class="" action="index.php" method="post">


           <div class="form-body">

                  <?php
                  consulta_tabla_4_col($conn, 'SELECT id, nombre, barrio, direccion, extra FROM direcciones WHERE user_id = :user_id');
                  ?>

           </div>

           <div class="form-footer">
              <div>
                <p>¿Estas Listo?
                  <a href="profile.php">Volver al Perfil</a></p>
              </div>
           </div>


     </form>

</section>

</body>

</html>