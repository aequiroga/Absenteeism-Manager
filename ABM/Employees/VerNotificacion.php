<?php
	//Conexion BD
	require("Sesiones.php");
	require("ExisteID.php");
	include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
	//Inicia sesion y obtiene las vars de esta
	SESSION_START();
	$CoordinadorID = $_SESSION['CoordinadorID'];
	$DoAct = $_GET['DoAct'];
	
	
	SesionCoordinador($CoordinadorID,$DoAct);
	
	
	
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
	    <li><img src = "../System/Images/Home.png" height= "15px" width= "15px">Novedades</li>
		<li><a href="ListadoAlumnos.php"><img src = "../System/Images/Details.png" height= "15px" width= "15px">Listado de alumnos</a></li>
		<li><a href="Historial.php"><img src = "../System/Images/Details.png" height= "15px" width= "15px">Historial</a></li>
		<li><a href="InicioCoordinador.php?DoAct=5">Cerrar sesión</li></a>
		<li style="float: right;"><strong>Sistema de gestión de ausentismo</strong></li>
    </ul>

    <div class="breadcrumb">
      <ul>
		<li><a href="InicioCoordinador.php">Novedades</a></li>
        <li><a href="Historial.php">Historial</a></li>
		<li>Detalles de la notificación</li>
      </ul>
    </div>
  </div>
  
  <div class="DivBox1">
	<div class="Detalles">
		<?php
			echo $RutaArchivo;
			echo "
				<h2><span class='Underline'>Datos personales</span></h2>
				<ul class='ListStyle'>
				<li><span class='Underline'>Fecha del evento:</span> $DetallesAviso[FechaEvento]</li>
				<li><span class='Underline'>Motivo:</span> $DetallesAviso[Asunto]</li>
				<li><span class='Underline'>Fecha de aviso:</span> $DetallesAviso[FechaAviso]</li>
			";
			if($RutaArchivo != " "){
				echo "%%%".$RutaArchivo;
				echo "<a href='$RutaArchivo'><li><span class='Underline'>Ver certificado</span></li></a>";
			}
			else
				echo "<li>No se adjunto ningun certificado</li>";
			echo"
				</ul>
				<br>	
			";
		?>
	</div>
  </div>
</body>

</html>