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
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel=”shortcut icon” type=”image/png” href=”img/icono.png” />
</head>

<body>

  <h1>Direcciones Guardadas</h1>

<table>
<tr>
  <td><strong>id</strong></td>
  <td><strong>Nombre</strong></td>
  <td><strong>Barrio</strong></td>
  <td><strong>Direccion</strong></td>
  <td><strong>Extra</strong></td>
</tr>

<?php
consulta_tabla_4_col($conn, 'SELECT id, nombre, barrio, direccion, extra FROM direcciones WHERE user_id = :user_id');
?>
</table>

<p>Estas listo? <a href="profile.php">volver al perfil</a></p>
</body>

</html>
