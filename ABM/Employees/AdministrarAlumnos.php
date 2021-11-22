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

	if(!empty($FiltroSelectCurso)){
		$ArrayFiltros[] = "curso_fk = $FiltroSelectCurso";
	}

	if(!empty($FiltroSelectPasantia)){
		$ArrayFiltros[] = "pasantia_fk = $FiltroSelectPasantia";
	}
	
	$Where = '';
	
	//Si existen coincidencias, prepara la condicion para la query
	if(count($ArrayFiltros) > 0){
		$Where = ' WHERE '.implode(' AND ',$ArrayFiltros);
	}


	//Ejecuta una query que filtra alumnos
	$SelectQuery1 = "SELECT * FROM usuarios INNER JOIN cursos ON usuarios.curso_fk = cursos.IDCurso  INNER JOIN pasantias ON usuarios.pasantia_fk = pasantias.IDPasantia ".$Where." ORDER BY Apellido ";
	$AlumnosQ = mysqli_query($db, $SelectQuery1);
	
	//Query para obtener listado de pasantias y cursos
	$SelectQuery2 = "SELECT * FROM cursos";
	$CursoQ = mysqli_query($db, $SelectQuery2);

	$SelectQuery3 = "SELECT * FROM pasantias";
	$PasantiaQ = mysqli_query($db, $SelectQuery3);
	
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
		<li><img src = "../System/Images/Details.png" height= "15px" width= "15px">Administrar alumnos</li>
		<li><a href="AdministrarCoordinadores.php"><img src = "../System/Images/Details.png" height= "15px" width= "15px">Administrar coordinadores</a></li>
		<li><a href="Mantenimiento.php?DoAct=5">Cerrar sesión</li>
		<li style="float: right;"><strong>Sistema de gestión de ausentismo</strong></li>
    </ul>

    <div class="breadcrumb">
      <ul>
        <li><a href="Mantenimiento.php">Mantenimiento</a></li>
		<li>Administrar alumnos</li>
      </ul>
    </div>
  </div>
  
  <div class="DivBox1">
  <br>
  <br>
  </div>
  
  <div class="tabla">
  <h2><a href="Register.php">Registrar un alumno</h2></a></li>
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
			<input type="text" name="InputBusqueda" Placeholder="Busqueda por apellido" value="<?php if(!empty($FiltroInputBusqueda))echo $FiltroInputBusqueda;?>"></input>
			<br>
			<br>
			<select name="SelectCurso">
				<option value="">Ingrese un curso</option>
				<?php 
					while($Cursos = mysqli_fetch_assoc($CursoQ)){
						if($Cursos['IDCurso'] == $_POST['SelectCurso'])
						echo "<option value='".$Cursos['IDCurso']."' selected>".$Cursos['NombreCurso']."</option>";
						else
						echo "<option value='".$Cursos['IDCurso']."'>".$Cursos['NombreCurso']."</option>";
					}
				?>
				</select>	
			<br>
			<br>
			<select name="SelectPasantia">
				<option value="">Ingrese una pasantia</option>
				<?php
					while($Pasantias = mysqli_fetch_assoc($PasantiaQ)){
						if($Pasantias['IDPasantia'] == $_POST['SelectPasantia'])
						echo "<option value='".$Pasantias['IDPasantia']."'selected>".$Pasantias['NombrePasantia']."</option>";
						else
						echo "<option value='".$Pasantias['IDPasantia']."'>".$Pasantias['NombrePasantia']."</option>";
					}
			?>
			</select>
			<br>
			<br>
			<input type="submit" value="Buscar"></submit>
		</form>
		<br>
	</div>
	<table width="100%">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>DNI</th>
		  <th>Pasantía</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
    //Genera la tabla con los Alumnos
    if($AlumnosQ){
      while($Alumnos = mysqli_fetch_assoc($AlumnosQ)){
        echo "
        <tr>
		  <td>".$Alumnos['Nombre']."</td>
          <td>".$Alumnos['Apellido']."</td>
          <td>".$Alumnos['DNI']."</td>
          <td>".$Alumnos['NombrePasantia']."</td>
		  <td><a href='CambioContrasena.php?HashUsuario=".$Alumnos['Token']."&Usuario=".$Alumnos['Usuario']."&TipoUsuario=1'>Cambiar contraseña</a> // <a href='EliminarUsuario.php?HashUsuario=".$Alumnos['Token']."&Usuario=".$Alumnos['Usuario']."&TipoUsuario=1'>Eliminar usuario</a></td>
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