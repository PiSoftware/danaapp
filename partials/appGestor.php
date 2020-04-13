<?php
/*
Librería para gestionar sistemas de login-logout y registros generales en tablas
de bases de datos
Escrita y desarrollada en los laboratorios CIDETER, en Guatemala, Centroamerica
GNU-LGPL // Lesser General Public License, para más información sobre uso de este software
sientete libre de ingresar al sitio oficial de GNU.
*/

//Función para conexión a la base de datos
function bd_conexion($server, $username, $password, $database){
  /*
    $server = 'Colaca el nombre de tu host aquí';
    $username = 'Coloca tu nombre de usuario para acceder a la bd (root por defecto)';
    $password = 'Coloca tu contraseña en este parametro (dejala como "" si no tienes contraseña)';
    $database = 'Ingresa el nombre de tu base de datos para conectarnos :)';
  */
  try {
    $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
  } catch (PDOException $e) {
    die('Connection Failed: ' . $e->getMessage());
  }
  return $conn;
}

//Función para conexión a la base de datos mediante sqli
function conexion2($dbHost, $dbUsername, $dbPassword, $dbName){
//Creamos una conexion y seleccionamos la db
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("No pudimos conectar a tu base de datos: " . $db->connect_error);
}
  return $db;
}

//Funcion para loguear usuarios
function login($conn, $post_user, $post_password){
  $message = "";

  /*Iniciaremos una consulta SI el contenido de los inputs NO esta vacío*/
	if (!empty($_POST[$post_user]) && !empty($_POST[$post_password])) {
      //Almacenamos en la variable records el resultado de la consulta, en la cual condicionamos para que funcione igual con correo, numero telefonico o nombre de usuario!
			$records = $conn->prepare('SELECT id, nombre, usuario, email, tel, password FROM users WHERE email = :email OR usuario = :usuario OR tel = :tel');
			$records->bindParam(':email', $_POST[$post_user]);
      $records->bindParam(':usuario', $_POST[$post_user]);
      $records->bindParam(':tel', $_POST[$post_user]);
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);

			$message = "";

      //Verificamos que las contraseñas obtenidas de la consulta anterior sean iguales a las ingresadas en el input.
			if (count($results) > 0 && password_verify($_POST[$post_password], $results['password'])) {
        //Si las contraseñas son iguales, entonces almacenamos los datos del usuario en variables de sesion
        //Utilizaremos estas variables para la informacion del perfil y direcciones.
        $_SESSION['user_id'] = $results['id'];
        $_SESSION['user_name'] = $results['usuario'];
        $_SESSION['user_email'] = $results['email'];
        $_SESSION['user_tel'] = $results['tel'];
        $_SESSION['user_nombre'] = $results['nombre'];
				header('Location: /DanaApp/profile.php');
			} else{
				$message = 'Lo sentimos, los datos ingresados no son correctos';
			}
		}

	if (isset($_SESSION['user_id'])) {

		$records = $conn->prepare('SELECT id, user, email, tel, password FROM users WHERE id = :id');
		$records->bindParam(':id', $_SESSION['user_id']);
		$records->execute();
		$results = $records->fetch(PDO::FETCH_ASSOC);

		$user = null;

    if (is_array($results)) {
      if (count($results) > 0) {
      $user = $results;
    }
    }

	}
  return $message;
}

//Funcion para salir de la sesión y borrar todos nuestros datos de la misma
function logout($ruta){
  session_start(); //Iniciamos la sesion, siempre debe hacerse si deseamos que el usuario y sus variables de sesion esten presentes en el programa!
  session_unset();//Desconfiguramos las variables de sesion que se configuran en el login!
  session_destroy();//Finalmente, destruimos la sesion, si esto se realiza solo, las variables de sesion quedan almacenadas para el próximo login.
  header($ruta);//Redirigimos al usuario al login :)
}

function signup($conn, $post_nom, $post_us, $post_tel, $post_em, $post_pass){
  $message = '';

  //Si los inputs enviados de email y contraseña NO estan vacíos entonces realiza un INSERT
	if (!empty($_POST[$post_em]) && !empty($_POST['password'])) {
      //Dictamos la sentencia sql para insertar los datos del formulario en nuestra bd
      $sql = "INSERT INTO users (nombre, usuario, tel, email, password) VALUES (:nombre, :usuario, :tel, :email, :password)";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':nombre', $_POST[$post_nom]);
      $stmt->bindParam(':usuario', $_POST[$post_us]);
      $stmt->bindParam(':tel', $_POST[$post_tel]);
      $stmt->bindParam(':email', $_POST[$post_em]);
      //Encriptamos la contraseña para evitar robos de la bd
			$password = password_hash($_POST[$post_pass], PASSWORD_BCRYPT);
			$stmt->bindParam(':password', $password);

      //Condicion para mostrar mensaje de éxito/error de la operación!
			if ($stmt->execute()) {
				header('Location: /DanaApp/index.php');
			} else{
				$message = 'Disculpa, hubo un problema creando tu usuario';
			}
	}
  return $message;
}

//Funcion que registra 4 datos en una tabla, parametros necesarios los names del formulario
function bd_registro_4($conn, $nombre, $nombre1, $nombre2, $nombre3){
  $message = '';

  //Si los inputs enviados de nombre, barrio y direccion NO estan vacíos entonces realiza un INSERT
	if (!empty($_POST[$nombre]) && !empty($_POST[$nombre1]) && !empty($_POST[$nombre2])) {
      //Dictamos la sentencia sql para insertar los datos del formulario en nuestra bd
      $sql = "INSERT INTO direcciones (user_id, nombre, barrio, direccion, extra) VALUES (:user_id, :nombre, :barrio, :direccion, :extra)";
			$stmt = $conn->prepare($sql);
      $stmt->bindParam(':user_id', $_SESSION['user_id']);
			$stmt->bindParam(':nombre', $_POST[$nombre]);
      $stmt->bindParam(':barrio', $_POST[$nombre1]);
      $stmt->bindParam(':direccion', $_POST[$nombre2]);
      $stmt->bindParam(':extra', $_POST[$nombre3]);

      //Condicion para mostrar mensaje de éxito/error de la operación!
			if ($stmt->execute()) {
				header('Location: /DanaApp/profile.php');
			} else {

				$message = 'Disculpa, hubo un problema registrando tu direccion <a href="profile.php">Volver al inicio</a>';
			}
	}
  return $message;
}

function consulta_tabla_4_col($conn, $sql) {
  try {
    $contador = 1;
    $sentencia = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $sentencia->bindParam(':user_id', $_SESSION['user_id']);
    $sentencia->execute();
    while ($fila = $sentencia->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
      echo '
					<label>Nombre: '.$fila[1].'</label>
					<label>Barrio: '.$fila[2].'</label>
					<label>Dirección: '.$fila[3].'</label>
		      <label>Observaciones: '.$fila[4].'</label>

         <form method="POST"><input class="edit" type="submit" name="edit" value="Editar"></form>
         <form method="POST"><input class="erase" type="submit" name="erase" value="Eliminar"><input type="hidden" name="ident" value=" ' . $fila[0] . '"></form>
				';

      $contador = $contador + 1;
    }

    $sentencia = null;
  }

  catch (PDOException $e) {
    echo $e->getMessage();
  }
}
 ?>
