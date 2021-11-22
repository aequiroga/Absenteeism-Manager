<!DOCTYPE html>
<?php
	include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");
	session_start();

	//Requests al servidor
	$FiltroNovedadQ = $_POST['FiltroNovedad'];
	$FiltroInputBusqueda = $_POST['InputBusqueda'];
	$FiltroSelectCurso = $_POST['SelectCurso'];
	$FiltroSelectPasantia = $_POST['SelectPasantia'];

	$DoAct = $_GET['DoAct'];
	$AdminID = $_SESSION['AdminID'];
	require("Sesiones.php");
	SesionAdmin($AdminID,$DoAct);
	//Revisa que los campos de filtro esten vacios
	if(!empty($FiltroInputBusqueda)){
		$ArrayFiltros[] = "Nombre LIKE '%$FiltroInputBusqueda%' OR Apellido LIKE '%$FiltroInputBusqueda%'";
	}
	
	$Where = '';
	
	//Si existen coincidencias, prepara la condicion para la query
	if(count($ArrayFiltros) > 0){
		$Where = ' WHERE '.implode(' AND ',$ArrayFiltros);
	}


	//Ejecuta una query que filtra alumnos
	$SelectQuery1 = "SELECT * FROM coordinador ".$Where." ORDER BY Usuario ";
	$CoordinadoresQ = mysqli_query($db, $SelectQuery1);	
?>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../System/Style.css">
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  <script src="../System/jQuery.js"></script>
  <meta charset="utf-8">
  <title>Administración de alumnos</title>
</head>


<body>
  <!-- Header-->
  <div class="header">
    <ul class="navbar ListStyle">
		<li><a href="Mantenimiento.php"><img src = "../System/Images/Details.png" height= "15px" width= "15px">Mantenimiento</a></li>
		<li><a href="AdministrarAlumnos.php"><img src = "../System/Images/Details.png" height= "15px" width= "15px">Administrar alumnos</a></li>
		<li><img src = "../System/Images/Details.png" height= "15px" width= "15px">Administrar coordinadores</li>
		<li><a href="Mantenimiento.php?DoAct=5">Cerrar sesión</li></a>
		<li style="float: right;"><strong>Sistema de gestión de ausentismo</strong></li>
    </ul>

    <div class="breadcrumb">
      <ul>
        <li><a href="Mantenimiento.php">Mantenimiento</a></li>
		<li>Administrar coordinadores</li>
      </ul>
    </div>
  </div>
  
  <div class="DivBox1">
  <br>
  <br>
  </div>
  
  <div class="tabla">
  <h2><a href="RegisterCoordinador.php">Registrar un coordinador</h2></a></li>
  <br>
  <br>
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
			<p>Por nombre o apellido
			<input type="text" name="InputBusqueda" Placeholder="Busqueda por usuario" value="<?php if(isset($FiltroInputBusqueda))echo $FiltroInputBusqueda;?>"></input>
			<br>
			<br>
			<input type="submit" value="Buscar"></submit>
		</form>
		<br>
	</div>
	<table width="100%">
      <thead>
        <tr>
          <th>Usuario</th>
          <th>DNI</th>
		  <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
    //Genera la tabla con los Alumnos
    if($CoordinadoresQ){
      while($Coordinadores = mysqli_fetch_assoc($CoordinadoresQ)){
        echo "
        <tr>
          <td>".$Coordinadores['Usuario']."</td>
          <td>".$Coordinadores['DNI']."</td>
		  <td><a href='CambioContrasena.php?IDUsuario=".$Coordinadores['DNI']."&Usuario=".$Coordinadores['Usuario']."&TipoUsuario=2'>Cambiar contraseña</a> // <a href='EliminarUsuario.php?IDUsuario=".$Coordinadores['DNI']."&Usuario=".$Coordinadores['Usuario']."&TipoUsuario=2'>Eliminar usuario</a></td>
        </tr>
        ";
      }
    }
    ?>
      </tbody>
    </table>

  </div>

</body>

</html>