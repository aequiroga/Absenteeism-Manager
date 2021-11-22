<?php
	include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");
	require("Sesiones.php");
	require("ExisteID.php");
	$DoAct = $_GET['DoAct'];
	$UserID = $_SESSION['UserID'];
	
	SesionUsuario($UserID,$DoAct);
	
	//REQUEST de variables
	$IDAviso = $_GET['IDAviso'];
	$IDAvisoPOST = $_POST['IDAvisoPOST'];
	
	ExisteIDAlumno($IDAviso);
	
	//Query SQL
	$DeleteQuery1 = "DELETE FROM aviso WHERE HashAviso = '$IDAvisoPOST'";

	//Ver si existe el usuario
	echo $DeleteQuery1;
	if($IDAvisoPOST){
	if(mysqli_query($db, $DeleteQuery1)){
		header("Location:Inicio-Alumno.php");
	}
	else {
		$ErrorRegistro = "Error:" . mysqli_error($db);
	}}
?>


<html>

  <head>
    <link rel="stylesheet" type="text/css" href="../System/Style.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script src="../System/Delete.js"></script>
    <meta charset="utf-8">
    <title>Eliminar empleado</title>
  </head>


  <body>
<!--Input de header-->
  <div class="header">
    <ul class="navbar ListStyle">
		<li><a href="Mantenimiento.php"><img src = "../System/Images/Details.png" height= "15px" width= "15px">Mantenimiento</a></li>
		<a href="AdministrarAlumnos.php"><img src = "../System/Images/Details.png" height= "15px" width= "15px">Administrar Alumnos</a></li>
		<li><a href="AdministrarCoordinadores.php"><img src = "../System/Images/Details.png" height= "15px" width= "15px">Administrar coordinadores</a></li>
		<li><a href="Mantenimiento.php?DoAct=5">Cerrar sesión</li></a>
		<li style="float: right;"><strong>Sistema de gestión de ausentismo</strong></li>
    </ul>

    <div class="breadcrumb">
      <ul>
        <li><a href="Inicio-Alumno.php">Listado de notificaciones</a></li>
        <li><a href="DetallesNotificacion.php?IDAviso=<?php echo $IDAviso;?>">Detalles de notificación</a></li>
		<li>Eliminar notificacion</li>
      </ul>
    </div>
  </div>

<!-- Confirmacion de delete-->
    <div class="DivBox2">
      <div class="Delete">
	  <?php
      echo "<h2 class='RojoCritico'>¿Esta seguro de que desea eliminar la notificación del sistema?</h2>"
	  ?>
      <img src="../System/Images/Warning.png" height: "200" width="200">
      <br>
      <a href="javascript:history.go(-1);"><button style="height:50px;width:150px">No,volver</button></a>
      <br>
      <br>
	  <form action="<?php echo(htmlentities($_SERVER['PHP_SELF']))?>" method="POST">
	  
	  <input type="hidden" name="IDAvisoPOST" value="<?php echo $IDAviso;?>"></input>
	  
      <input type="submit" class="RojoCritico" id="BotonDelete" value="Si, eliminar"></button>
	  </form>
    </div>
    </div>
  </body>

</html>