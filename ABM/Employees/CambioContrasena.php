	<?php
		include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");
		
		session_start();
		
		$AdminID = $_SESSION['AdminID'];
		//Declaracion variables
		$Username = '';
		$Password1 = "";
		$Password2 = "";
		$ErrorLogin = "";
		$ExitoRegistro = "";
		$EncryptedPassword = "";
		$TipoUsuario = "";
		
		//REQUEST de variables
		$Username = $_GET['Usuario'];
		$HashUsuario = $_GET['HashUsuario'];
		$IDUsuario = $_GET['IDUsuario'];
		$TipoUsuario = $_GET['TipoUsuario'];
		
		$UsernamePOST = $_POST['UsuarioPOST'];
		$HashUsuarioPOST = $_POST['HashUsuarioPOST'];
		$IDUsuarioPOST = $_POST['IDUsuarioPOST'];
		$TipoUsuarioPOST = $_POST['TipoUsuarioPOST'];
		
		$Password1 = $_POST['Password1'];
		$Password2 = $_POST['Password2'];		
		
		//Querys
		if($TipoUsuarioPOST==1)
			$SelectQuery = "SELECT * FROM usuarios WHERE Usuario = '$UsernamePOST' AND Token = '$HashUsuarioPOST'";
		else if($TipoUsuarioPOST==2)
			$SelectQuery = "SELECT * FROM coordinador WHERE Usuario = '$UsernamePOST' AND DNI = '$IDUsuarioPOST'";
		
		
		echo $SelectQuery;
			
		//Condiciones
		if(empty($Password1)){
			$ErrorLogin = "Ingrese una contraseña";
		}
		if(empty($Password2)){
			$ErrorLogin = "Reingrese la contraseña";
		}
		if($Password1 != $Password2){
			$ErrorLogin = "Las contraseñas deben coincidir";
		}
		else {
			$EncryptedPassword = md5("$Password2");
			$UserExistQ = mysqli_query($db, $SelectQuery);
			$UserExist = mysqli_fetch_assoc($UserExistQ);
			if($TipoUsuarioPOST == 1 && !$UserExist['CambioMail'])
				$ErrorLogin = "No se envio ninguna solicitud de cambio de mail";
			else {
			$UpdateQuery = "UPDATE usuarios SET CambioMail = 0";
			if($TipoUsuarioPOST==1)
				$UpdateQuery = "UPDATE usuarios SET Contrasena='$EncryptedPassword' WHERE Usuario='$UsernamePOST'";
			else if($TipoUsuarioPOST==2)
				$UpdateQuery = "UPDATE coordinador SET Contrasena='$EncryptedPassword' WHERE Usuario='$UsernamePOST'";
			//Ver si existe el usuario
			if(!$UserExist){	
				
			} 
			else if(mysqli_query($db, $UpdateQuery)){
				if($AdminID){
					header("Location:Mantenimiento.php");
				}
				else
					header("Location:Login.php");
			}
			else {
				$ErrorRegistro = "Error:" . $InsertQuery . "<br>" . mysqli_error($db);
			}
			
		}}
	?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Cambio de contraseña</title>
		<link rel="stylesheet" type="text/css" href="../System/Style.css">
		<script href="../System/jQuery.js"></script>
		<script href="../System/jQueryFile"></script>
	</head>
	<body background='../System/1sa.jpg'>
		<div class="DivBox2">
			<div class="LoginBoxAdentro">
				<p id="LoginTitle">Cambiar una contraseña</p>
				<form action="<?php echo(htmlentities($_SERVER['PHP_SELF']))?>" method="POST">
					<?php
						if(!empty($ErrorLogin))
							echo "<p class='Error'>$ErrorLogin</p>";
						else if(!empty($ExitoRegistro))
							echo "<p class='Exito'>$ExitoRegistro</p>";
					?>
					<br>
					<input type="password" name="Password1" placeholder="Ingrese la nueva contraseña"></input>
					<br>
					<br>
					<input type="password" name="Password2" placeholder="Reingrese la nueva contraseña"></input>
					<br>
					<br>
					
					<input type="hidden" name="UsuarioPOST" value="<?php if(isset($Username)) echo $Username; else echo $UsuarioPOST ?>"></input>
					<input type="hidden" name="HashUsuarioPOST" value="<?php if(isset($HashUsuario)) echo $HashUsuario; else echo $HashUsuarioPOST ?>"></input>
					<input type="hidden" name="TipoUsuarioPOST" value="<?php if(isset($TipoUsuario)) echo $TipoUsuario; else echo $TipoUsuarioPOST ?>"></input>
					<input type="hidden" name="IDUsuarioPOST" value="<?php if(isset($IDUsuario)) echo $IDUsuario; else echo $IDUsuarioPOST ?>"></input>
					
					<input type="submit" value="Cambiar contraseña" id="ButtonLogin" name="RegisterButton"></input>
					<br>
				</form>
				<br>
			</div>
		</div>
	</body>
</html>