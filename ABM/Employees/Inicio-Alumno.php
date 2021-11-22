<!DOCTYPE html>
<html>
<?php
	include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");
	session_start();

	//Requests al servidor
	$DoAct = $_GET['DoAct'];
	$UserID = $_SESSION['UserID'];
	
	require ('Sesiones.php');
	SesionUsuario($UserID,$DoAct);
	

	//Ejecuta una query que filtra avisos segun la ID del usuario que inicio sesion
	$SelectQuery = "SELECT * FROM aviso where usuario_fk=$UserID";
	$AvisosQ = mysqli_query($db, $SelectQuery);
?>
<head>
  <link rel="stylesheet" type="text/css" href="../System/Style.css">
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  <script src="../System/jQuery.js"></script>
  <meta charset="utf-8">
  <title>Bienvenido, alumno</title>
</head>


<body>
  <!-- Header-->
  <div class="header">
    <ul class="navbar ListStyle">
      <li><img src="../system/Images/Home.png" height="15px" width="15px">Listado de notificaciones</li>
      <li><a href="AgregarNotificacion.php"><img src = "../System/Images/AddUser.png" height= "15px" width= "15px">Agregar notificación</a></li>
		  <li><a href="Inicio-Alumno.php?DoAct=5">Cerrar sesión</li></a>
	  	<li id="Titulo"><strong>Sistema de gestión de ausentismo</strong></li>
    </ul>

    <div class="breadcrumb">
      <ul>
        <li>Listado de notificaciones</li>
      </ul>
    </div>
  </div>

<div class="tabla">
    <!-- Tabla-->
	<?php
		if($DoAct == 1)
			echo "<p class='Exito'>La notificación se guardo exitosamente</p><br>";
	?>
    <table width="100%">
      <thead>
        <tr>
          <th>Fecha de aviso</th>
          <th>Asunto</th>
          <th>Fecha del evento</th>
		  <th>Más información</th>
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
					<td>".$Avisos['Asunto']."</td>
					<td>".$Avisos['FechaEvento']."</td>
					<td>
					<a href='DetallesNotificacion.php?IDAviso=".$Avisos['HashAviso']."'>Ver detalles</a>
					</td>
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
