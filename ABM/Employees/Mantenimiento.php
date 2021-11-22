<?php
	session_start();
	
	require ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");
	$AdminID = $_SESSION['AdminID'];
	$DoAct = $_GET['DoAct'];
	
	require('Sesiones.php');
	SesionAdmin($AdminID,$DoAct);
	
	require('Exportacion.php');
	$Action = $_POST['Action'];
	
	echo $Action;
	if(isset($Action) && $Action == 1 ) {
		ExportarSQL();
	}
	if(isset($Action) && $Action == 2) {
		ExportarExcel();
	}
?>


<html>
<head>
  <link rel="stylesheet" type="text/css" href="../System/Style.css">
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  <script src="../System/jQuery.js"></script>
  <meta charset="utf-8">
  <title>Mantenmiento</title>
</head>


<body>
  <!-- Header-->
  <div class="header">
    <ul class="navbar ListStyle">
		<li><img src = "../System/Images/Details.png" height= "15px" width= "15px">Mantenimiento</li>
		<li><a href="AdministrarAlumnos.php"><img src="../System/Images/Details.png" height= "15px" width= "15px">Administrar alumnos</a></li>
		<li><a href="AdministrarCoordinadores.php"><img src="../System/Images/Details.png" height= "15px" width= "15px">Administrar coordinadores</a></li>
		<li><a href="Mantenimiento.php?DoAct=5">Cerrar sesión</li></a>
		<li style="float: right;"><strong>Sistema de gestión de ausentismo</strong></li>
    </ul>

    <div class="breadcrumb">
      <ul>
        <li>Mantenimiento</li>
      </ul>
    </div>
  </div>
  <div class="DivBox1">
  <ul>
  <br>
  <form method="POST" action="">
  <li><h2>Crear copia de seguridad de la base de datos  <input type="radio" name="Action" value="1"></input></h2></li>
  <br>
  <br>
  <br>
  <li><h2>Exportar novedades a planilla de Excel <input type="radio" name="Action" value="2"></input></h2></li>
  <br>
  <br>
  <input type="submit" value="Guardar"></input>
  </form>
  </div>

</body>

</html>