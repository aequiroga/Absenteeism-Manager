
<?php
	//Inicia sesion y obtiene las vars de esta
	SESSION_START();
	require("Sesiones.php");
	require("ExisteID.php");
	$DoAct = $_GET['DoAct'];
	$UserID = $_SESSION['UserID'];
	
	SesionUsuario($UserID,$DoAct);
	
	//Conexion BD
	include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
	
	//Declaracion de vars y REQUESTS
	$IDAviso=$_GET['IDAviso'];
	
	ExisteIDAlumno($IDAviso);
	
	$SelectQuery = "SELECT * FROM aviso WHERE HashAviso='$IDAviso'";
	$DetallesAvisoQ = mysqli_query($db,$SelectQuery);
	if($DetallesAvisoQ){
		$DetallesAviso = mysqli_fetch_assoc($DetallesAvisoQ);
	}
	else $ErrorDetalles="Error de Query";
	
	$RutaArchivo = $DetallesAviso['RutaArchivoCert'];
?>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../System/Style.css">
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  <meta charset="utf-8">
  <title>Agregar notificación</title>
</head>


<body>
  <!-- Header-->
  <div class="header">
    <ul class="navbar ListStyle">
      <li><a href="Inicio-Alumno.php"><img src = "../System/Images/Home.png" height= "15px" width= "15px">Listado de notificaciones</a></li>
      <li><a href="AgregarNotificacion.php"><img src = "../System/Images/AddUser.png" height= "15px" width= "15px">Agregar notificación</a></li>
	  <li><a href="Mantenimiento.php?DoAct=5">Cerrar sesión</li></a>
	  <li style="float: right;"><strong>Sistema de gestión de ausentismo</strong></li>
    </ul>

    <div class="breadcrumb">
      <ul>
		<li><a href="Inicio-Alumno.php">Listado de notificaciones</a></li>
        <li>Detalles de notificación</li>
      </ul>
    </div>
  </div>
  
  <div class="DivBox1">
	<div class="Detalles">
		<?php
			echo "
			<h2><span class='Underline'>Datos personales</span></h2>
			<ul class='ListStyle'>
			  <li><span class='Underline'>Fecha del evento:</span> $DetallesAviso[FechaEvento]</li>
			  <li><span class='Underline'>Motivo:</span> $DetallesAviso[Asunto]</li>
			  <li><span class='Underline'>Fecha de aviso:</span> $DetallesAviso[FechaAviso]</li>";
			if($RutaArchivo != ""){
				echo "<a href='$RutaArchivo'><li><span class='Underline'>Ver certificado</span></li></a>";
			}
			else
				echo "<li>No se adjunto ningun certificado</li>";
			echo "</ul>
			<br>
			<a href='ModificarNotificacion.php?IDAviso=" . $IDAviso . "'<h3><span class='Underline'>Modificar notificación</span></h3>
			<br>
			<br>
			<br>
			<a href='EliminarNotificacion.php?IDAviso=" . $IDAviso . "'<h3><span class='Underline'>Eliminar notificación</span></h3>
			";
		?>
	</div>
  </div>
</body>

</html>