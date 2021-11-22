
<?php
	SESSION_START();
	
	$DoAct = $_GET['DoAct'];
	$UserID = $_SESSION['UserID'];
	
	//Chequea si el usuario cerro su sesion
	if($DoAct == 5){
		session_unset();
		session_destroy();
		header("location: Login.php?Error=4");
		
	}
	//Chequea si la sesion existe
	if(!$UserID) {
		session_unset();
		session_destroy();
		header("location: Login.php?Error=3");
	}
	//Chequea si la sesion acabo
	$now = time();
	if (isset($_SESSION['Duration']) && $now > $_SESSION['Duration']) {
		// Acaba la sesion y devuelve al usuario al login
		session_unset();
		session_destroy();
		header("location: Login.php?Error=5");
	}
	//Si no acabo, renueva la duración de esta
	else $_SESSION['Duration'] = $now + 360;
	
	include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
	
	//Declaracion de vars y REQUESTS
	$FechaEvento = $_POST['FechaEvento'];
	$EventoTxt = $_POST['EventoTxt'];
	$IDAviso = $_GET['IDAviso'];
	$IDAvisoPOST = $_POST['IDAvisoPOST'];
	$CheckBox = $_POST['CheckBoxFile'];
	
	$SelectQuery = "SELECT * FROM aviso WHERE HashAviso = '".$IDAviso."'";
	$DetallesNotificacionQ = mysqli_query($db, $SelectQuery);
	$DetallesNotificacion = mysqli_fetch_assoc($DetallesNotificacionQ);
	
	echo "<br>".$SelectQuery;
		echo "<br>".$IDAviso;
	if(empty($EventoTxt))
	{
		$ErrorInput = 1;
	}
	else {
		//Declaracion query
		require('upload.php');
		if($CheckBox != 1 || $ExitoArchivos == 1){
			//UPDATE aviso SET Asunto = 'Probando' WHERE HashAviso = 'e37e72799cdab4e611dc2bdcaa9a6c' AND usuario_fk =123654789
			if(empty($fileDestination))
				$fileDestination = " ";
			$UpdateQuery = "UPDATE aviso SET Asunto = '".$EventoTxt."', FechaEvento = CAST('".$FechaEvento."' AS DATE), RutaArchivoCert = '$fileDestination' WHERE HashAviso ='" . $IDAvisoPOST . "' AND usuario_fk=". $UserID;
		echo "<br>".$UpdateQuery;
			if(mysqli_query($db, $UpdateQuery)){
				//Si se ejecuta correctamente la query, redirecciona a la pagina de Inicio
				//$IDUltimoAviso = mysqli_query($db, $SelectIDQuery);
				header("Location:Inicio-Alumno.php?DoAct=1");
			}
		}
		else
			echo "Error:" . $UpdateQuery . "<br>" . mysqli_error($db);
		//header("location: Login.php");*/
	}
	
?>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../System/Style.css">
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  <script src="../System/jQuery.js"></script>
  <meta charset="utf-8">
  <title>Modificar notificación</title>
</head>


<body>
  <!-- Header-->
  <div class="header">
    <ul class="navbar ListStyle">
      <li><a href="Inicio-Alumno.php"><img src = "../System/Images/Home.png" height= "15px" width= "15px">Listado de notificaciones</a></li>
      <li><a href="AgregarNotificacion.php"><img src = "../System/Images/AddUser.png" height= "15px" width= "15px">Agregar notificación</a></li>
	  <li><a href="Inicio-Alumno.php?DoAct=5">Cerrar sesión</li>
	  <li style="float: right;"><strong>Sistema de gestión de ausentismo</strong></li>
    </ul>

    <div class="breadcrumb">
      <ul>
		<li><a href="Inicio-Alumno.php">Listado de notificaciones</a></li>
		<li><a href="DetallesNotificacion.php?IDAviso=<?php echo $IDAviso;?>">Detalles de notificacion</a></li>
        <li>Modificar notificación</li>
      </ul>
    </div>
  </div>
  
  <div class="DivBox1">
	<form action="<?php echo(htmlentities($_SERVER['PHP_SELF']))?>" method="POST" enctype="multipart/form-data" id="FormModNotificacionPOST">
		<div class="InputUser">
			<p>Seleccione la fecha
			<br>
			<br>
			<input type="date" name="FechaEvento" value="<?php echo $DetallesNotificacion['FechaEvento']?>"></input>
			<br>
			<br>
			<p>Explique el evento y la razón(300 caracteres máximo)
			<br>
			<br>
			<input type="text" name="EventoTxt" value="<?php echo $DetallesNotificacion['Asunto']?>"></input>
			<br>
			<br>
			<p>Adjunte un archivo certificatorio(Formato de imagen o pdf)  <input type="checkbox" id="CheckBox1" name="CheckBoxFile" value="1">
			<br>
			<div id="FileUpload" style="display: none;">
			<br>
			<input type="file" name="file"></input>
			<br>
			</div>
			
			<input type="hidden" name="IDAvisoPOST" value="<?php echo $IDAviso; ?>"></input>
			
			<br>
			<input type="submit" name="submit" id="ModNotificacionSubmit">
		</div>
	</form>
  </div>

</body>
</html>