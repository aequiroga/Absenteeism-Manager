<html>
	<?php
		session_start();
		include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");

		//Declaracion vars
		$Username = "";
		$Password = "";
		$CodigoError = 0;
		$ErrorLogin = "";
		$ExitoTxt = "";
		$_SESSION['CoordinadorID'] = 0;
		$_SESSION['TipoUsuario'] = 0;

		//REQUESTS
		$Username = $_POST['username'];
		$Password = $_POST['password'];
		$EncryptedPassword = md5("$Password");
		$CodigoError = $_GET['Error'];

		//Declaracion Query
		$SelectQuery = "SELECT * FROM administrador where Usuario='$Username' AND Contrasena='$EncryptedPassword'";
		//$sqlPrep = $db->prepare("SELECT * FROM usuarios where Usuario='?' AND Contrasena='?'");
		//$sqlPrep->bind_param("ss", $Username, $Password);

		//Busqueda de errores
		if($CodigoError == 3){
			$ErrorLogin = 'Para poder utilizar el sistema, debe iniciar sesión';
		}
		else if($CodigoError == 4){
			$ExitoTxt = 'Se cerro la sesion correctamente';
		}
		else if($CodigoError == 5){
			$ErrorLogin = 'La sesión expiro, vuelva a iniciar sesión';
		}
		else if(empty($Username)){
			$CodigoError = 1;
			$ErrorLogin = '';
		}
		else if(empty($Password)){
			$CodigoError = 2;
			$ErrorLogin = "Ingrese una contraseña";
		}

		else {
			$UserExistQ = mysqli_query($db, $SelectQuery);
			$UserExist = mysqli_fetch_assoc($UserExistQ);
			//$UserExistQ = $sqlPrep->execute();
			//$UserExist = mysqli_fetch_assoc($UserExistQ);
			if(!$UserExist){
				$ErrorLogin = "El usuario y/o la contraseña son erroneos";
			}
			else{
				$_SESSION['AdminID'] = $UserExist['IDAdmin'];
				if($_SESSION['AdminID'])
				header("Location:Mantenimiento.php");
			}
		}
		$db->close();
	?>
	<head>
		<meta charset="UTF-8">
		<title>Inicio de sesión</title>
		<link rel="stylesheet" type="text/css" href="../System/Style.css">
		<script src="../System/jQuery331.js"></script>
		<script src="../System/jQuery.js"></script>
	</head>
	<body background='../System/1sa.jpg'>

		<div class="DivBox2">
			<div class="LoginBoxAdentro">
			<p id="LoginTitle">Mantenimiento</p>
				<?php
					//Mostrar mensaje de error
					if(!empty($ExitoTxt))
						echo "<p class='Exito'>$ExitoTxt</p>";
					if(!empty($ErrorLogin))
						echo "<p class='Error'>$ErrorLogin</p>";
				?>
			<form action="<?php echo(htmlentities($_SERVER['PHP_SELF']))?>" method="POST">
				<br>
				<input type="text" name="username" placeholder="Ingrese su usuario" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''?>"></input>
				<br>
				<br>
				<input type="password" name="password" placeholder="Ingrese su contraseña"></input>
				<br>
				<br>
				<input type="submit" value="Iniciar sesión" id="ButtonLogin" name="RegisterButton"></input>
				<br>
			</form>
				<br>
			</div>
		</div>
	</body>
</html>
