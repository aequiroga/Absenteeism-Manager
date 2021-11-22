<?php
	include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");
	require("Sesiones.php");
	session_start();
	

	//Requests al servidor
	$DoAct = $_GET['DoAct'];
	$CoordinadorID = $_SESSION['CoordinadorID'];
	$FiltroInputBusqueda = $_POST['InputBusqueda'];
	$FiltroInputFecha = $_POST['InputFecha'];
	$ArrayFiltros = array();

	SesionCoordinador($CoordinadorID,$DoAct);

	//Revisa que los campos esten vacios
	if(!empty($FiltroInputBusqueda)){
		$ArrayFiltros[] = "Apellido LIKE '%$FiltroInputBusqueda%'";
	}
	
	if(!empty($FiltroInputFecha)){
		$ArrayFiltros[] = "FechaEvento = CAST('$FiltroInputFecha' AS DATE)";
	}
	
	$Where = '';
	
	//Si existen coincidencias, prepara la condicion para la query
	if(count($ArrayFiltros) > 0){
		$Where = ' WHERE '.implode(' AND ',$ArrayFiltros);
	}
	
	//Se declara y ejecuta la query
	$SelectQuery1 = "SELECT * FROM aviso INNER JOIN usuarios ON aviso.usuario_fk = usuarios.DNI INNER JOIN pasantias ON aviso.pasantia_fk = pasantias.IDPasantia ".$Where." ORDER BY FechaEvento DESC ";
	echo $SelectQuery1;
	$AvisosQ = mysqli_query($db, $SelectQuery1);

?>

<html>

<head>
  <link rel="stylesheet" type="text/css" href="../System/Style.css">
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  <script src="../System/jQuery.js"></script>
  <meta charset="utf-8">
  <title>Historial de notificaciones</title>
</head>


<body>
  <!-- Header-->
  <div class="header">
    <ul class="navbar ListStyle">
			<li><a href="InicioCoordinador.php"><img src = "../System/Images/Home.png" height= "15px" width= "15px">Novedades</a></li>
			<li><a href="ListadoAlumnos.php"><img src = "../System/Images/Details.png" height= "15px" width= "15px">Listado de alumnos</a></li>
			<li><img src = "../System/Images/Details.png" height= "15px" width= "15px">Historial</li>
			<li><a href="InicioCoordinador.php?DoAct=5">Cerrar sesión</li></a>
			<li style="float: right;"><strong>Sistema de gestión de ausentismo</strong></li>
    </ul>

    <div class="breadcrumb">
      <ul>
		<li><a href="InicioCoordinador.php">Novedades</a></li>
		<li>Historial</li>
      </ul>
    </div>
  </div>

    <div class="tabla">
	<button id="MostrarFiltros">Filtrar</button>
	<?php if(!empty($Where)){
		echo " 
			<form action='".htmlentities($_SERVER['PHP_SELF'])."' method='POST'>
			<input type='submit' value='Borrar filtros'></input>
			</form>
			";
		}?>
	<div class="Filtros">
		<br>
		<form "<?php echo(htmlentities($_SERVER['PHP_SELF']))?>" method="POST">
			<p>Por apellido
			<input type="text" name="InputBusqueda" Placeholder="Busqueda por apellido" value="<?php echo $FiltroInputBusqueda?>"></input>
			<br>
			<br>
			<p>Por fecha del evento
			<input type="date" name="InputFecha" value="<?php echo $FiltroInputFecha?>"></input>
			<br>
			<br>
			<input type="submit" value="Buscar"></submit>
		</form>
		<br>
	</div>
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

</body>

</html>
