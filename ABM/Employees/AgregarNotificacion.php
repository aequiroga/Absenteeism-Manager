<?php
	include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");
	SESSION_START();

	$DoAct = $_GET['DoAct'];
	$UserID = $_SESSION['UserID'];
	
	require("Sesiones.php");
	SesionUsuario($UserID,$DoAct);

	//Declaracion de vars y REQUESTS
	$FechaEvento = $_POST['FechaEvento'];
	$EventoTxt = $_POST['EventoTxt'];
	$CheckBox = $_POST['CheckBoxFile'];


	if(empty($EventoTxt))
	{
		$ErrorInput = 1;
	}
	else {
		//Declaracion query
		echo $CheckBox;
		require('upload.php');
		if($CheckBox != 1 || $ExitoArchivos == 1){
			$HashAviso = md5(Rand());
			$InsertQuery = "INSERT INTO aviso (HashAviso, usuario_fk, pasantia_fk, Asunto, FechaEvento, FechaAviso, RutaArchivoCert) VALUES ('".$HashAviso."',".$_SESSION['UserID'].", ".$_SESSION['PasantiaID'].", '".$EventoTxt."', CAST('".$FechaEvento."' AS DATE), CURDATE(), '$fileDestination')";
			echo $InsertQuery;
			if(mysqli_query($db, $InsertQuery)){
				//Si se ejecuta correctamente la query, redirecciona a la pagina de Inicio
				//$IDUltimoAviso = mysqli_query($db, $SelectIDQuery);
				header("Location:Inicio-Alumno.php?DoAct=1");
			}
		}
		else
			echo "Error:" . $InsertQuery . "<br>" . mysqli_error($db);
		//header("location: Login.php");*/
	}

?>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../System/Style.css">
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  <script src="../System/jQuery.js"></script>
  <meta charset="utf-8">
  <title>Agregar notificación</title>
</head>


<body>
  <!-- Header-->
  <div class="header">
    <ul class="navbar ListStyle">
      <li><a href="Inicio-Alumno.php"><img src = "../System/Images/Home.png" height= "15px" width= "15px">Listado de notificaciones</a></li>
      <li><img src="../system/Images/AddUser.png" height="15px" width="15px">Agregar notificación</li>
	  <li><a href="Inicio-Alumno.php?DoAct=5">Cerrar sesión</li></a>
	  <li style="float: right;"><strong>Sistema de gestión de ausentismo</strong></li>
    </ul>

    <div class="breadcrumb">
      <ul>
		<li><a href="Inicio-Alumno.php">Listado de notificaciones</a></li>
        <li>Agregar notificación</li>
      </ul>
    </div>
  </div>

  <div class="DivBox1">
	<form action="<?php echo(htmlentities($_SERVER['PHP_SELF']))?>" method="POST" enctype="multipart/form-data">
		<div class="InputUser">
			<p>Seleccione la fecha
			<br>
			<br>
			<input type="date" name="FechaEvento"></input>
			<br>
			<br>
			<p>Explique el evento y la razón(300 caracteres máximo)
			<br>
			<br>
			<input type="text" name="EventoTxt"></input>
			<br>
			<br>
			<p>Adjunte un archivo certificatorio(Formato de imagen o pdf)  <input type="checkbox" id="CheckBox1" name="CheckBoxFile" value="1">
			<br>
			<div id="FileUpload" style="display: none;">
			<br>
			<input type="file" name="file"></input>
			<br>
			</div>
			<br>
			<input type="submit" name="submit">
		</div>
	</form>
  </div>

</body>

</html>
