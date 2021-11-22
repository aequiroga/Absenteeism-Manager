<?php
	include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");
	
	//REQUEST de variables
	$Usuario = $_GET['Usuario'];
	$HashUsuario = $_GET['HashUsuario'];
	$TipoUsuario = $_GET['TipoUsuario'];
	
	$UsernamePOST = $_POST['Usuario'];
	$HashUsuarioPOST = $_POST['Token'];
	$TipoUsuarioPOST = $_POST['TipoUsuario'];
	$IDUsuario = "";
	
	//Condiciones
	if($TipoUsuarioPOST == 1)
		$SelectQuery = "SELECT * FROM usuarios WHERE Usuario = '$UsernamePOST' AND Token = '$HashUsuarioPOST'";
	else if($TipoUsuarioPOST == 2)
		$SelectQuery = "SELECT * FROM coordinador WHERE Usuario = '$UsernamePOST'";
	
	
	//Query SQL
	if(!empty($UsernamePOST)){
	$UserExistQ = mysqli_query($db, $SelectQuery);
	$UserExist = mysqli_fetch_assoc($UserExistQ);
	$IDUsuario = $UserExist['DNI'];	
	
	//Queries SQL
	$DeleteQuery1 = "DELETE FROM usuarios WHERE Usuario = '$UsernamePOST' AND Token = '$HashUsuarioPOST'";
	$DeleteQuery2 = "DELETE FROM aviso WHERE usuario_fk = '$IDUsuario'";
	$DeleteQuery3 = "DELETE FROM coordinador WHERE DNI = '$IDUsuario'";

	//Ver si existe el usuario
	if($UserExistQ){
	if(!$UserExist){
		$ErrorLogin = 'El usuario no existe';	
		} 
	else if($TipoUsuarioPOST == 1){ 
		if(mysqli_query($db, $DeleteQuery2) && mysqli_query($db, $DeleteQuery1)){
		header("Location:AdministrarAlumnos.php");
	}}
	else if($TipoUsuarioPOST == 2){ 
		if(mysqli_query($db, $DeleteQuery3)){
		header("Location:AdministrarCoordinadores.php");
	}}
	else {
		$ErrorRegistro = "Error:" . mysqli_error($db);
	}}}
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
        <li><a href="Mantenimiento.php">Mantenimiento</a></li>
		<li>Eliminar usuario</li>
      </ul>
    </div>
  </div>

<!-- Confirmacion de delete-->
    <div class="DivBox2">
      <div class="Delete">
	  <?php
      echo "<h2 class='RojoCritico'>¿Esta seguro de que desea eliminar al usuario $Usuario del sistema?</h2>"
	  ?>
      <img src="../System/Images/Warning.png" height: "200" width="200">
      <br>
      <a href="javascript:history.go(-1);"><button style="height:50px;width:150px">No,volver</button></a>
      <br>
      <br>
	  <form action="<?php echo(htmlentities($_SERVER['PHP_SELF']))?>" method="POST">
	  
	  <input type="hidden" name="Usuario" value="<?php echo $Usuario?>"></input>
	  <input type="hidden" name="Token" value="<?php echo $HashUsuario?>"></input>
	  <input type="hidden" name="TipoUsuario" value="<?php echo $TipoUsuario?>"></input>
	  
      <input type="submit" class="RojoCritico" id="BotonDelete" value="Si, eliminar"></button>
	  </form>
    </div>
    </div>
  </body>

</html>