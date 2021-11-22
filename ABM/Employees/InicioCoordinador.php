<?php
	include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");
	session_start();

	
	$DoAct = $_GET['DoAct'];
	$CoordinadorID = $_SESSION['CoordinadorID'];
	require ('Sesiones.php');
	SesionCoordinador($CoordinadorID,$DoAct);
	echo $CoordinadorID;
	
	//Requests al servidor
	$FiltroNovedad = $_POST['FiltroNovedad'];


	//Datos cooridandor
	$CoordinadorQ = mysqli_query($db, "SELECT * FROM Coordinador WHERE CoordinadorID = $CoordinadorID");
	$Coordinador = mysqli_fetch_assoc($CoordinadorQ);
	//Ejecuta una query que filtra avisos segun la fecha
	if($FiltroNovedad == 1 || empty($FiltroNovedad))
		$FiltroNovedad = 'WHERE FechaAviso = CURDATE()';
	else if($FiltroNovedad == 2)
		$FiltroNovedad = 'WHERE FechaEvento = CURDATE()';
	$SelectQuery1 = "SELECT * FROM aviso INNER JOIN usuarios ON aviso.usuario_fk = usuarios.DNI INNER JOIN pasantias ON aviso.pasantia_fk = pasantias.IDPasantia ".$FiltroNovedad;
	$AvisosQ = mysqli_query($db, $SelectQuery1);

?>

<html>

<head>
  <link rel="stylesheet" type="text/css" href="../System/Style.css">
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  <script src="../System/jQuery.js"></script>
  <meta charset="utf-8">
  <title>Bienvenido, coordinador</title>
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
        <li>Novedades</li>
      </ul>
    </div>
  </div>

<div class="tabla">
	<p>Elija que notificaciones desea ver
	<form id="FiltroInicioCoordinador" action="<?php echo(htmlentities($_SERVER['PHP_SELF']))?>" method="POST">
		<select name="FiltroNovedad" id="SelectInicioCoordinador">
			<option value="1" <?php if(isset($_POST['FiltroNovedad']) && $_POST['FiltroNovedad'] == 1) echo 'selected';?>>Del día</option>
			<option value="2" <?php if(isset($_POST['FiltroNovedad']) && $_POST['FiltroNovedad'] == 2) echo 'selected';?>>Para el día</option>
		<select>
			<br>
			<br>
		
	</form>
	<br>
    <!-- Tabla-->
    <table width="100%">
      <thead>
        <tr>
          <th>Fecha de aviso</th>
    		  <th>Apellido</th>
		      <th>Pasantía</th>
          <th>Asunto</th>
          <th>Fecha del evento</th>
          <th>Mas información</th>
        </tr>
      </thead>
      <tbody>
        <?php
    //Genera la tabla con los avisos
    if($AvisosQ){
      while($Avisos = mysqli_fetch_assoc($AvisosQ)){
        echo "
        <tr>
          <td>".$Avisos['FechaAviso']."</td>
          <td>".$Avisos['Apellido']."</td>
          <td>".$Avisos['NombrePasantia']."</td>
          <td>".$Avisos['Asunto']."</td>
          <td>".$Avisos['FechaEvento']."</td>
          <td>
          <a href='VerNotificacion.php?IDAviso=".$Avisos['HashAviso']."'>Ver detalles</a>
          </td>
        </tr>
        ";
      }
    }
    ?>
      </tbody>
    </table>

</body>

</html>
