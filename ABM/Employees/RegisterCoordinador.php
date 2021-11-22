	<html>
	<?php
		session_start();
		include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");
		//Intentar conexion BD
		if ($db->connect_error) {
			die("Connection failed: " . $db->connect_error);
		}
		
		$DoAct = $_GET['DoAct'];
		$AdminID = $_SESSION['AdminID'];
		require("Sesiones.php");
		SesionAdmin($AdminID,$DoAct);
		
		//Declaracionv vars
		$Username = "";
		$Password = "";
		$ErrorRegistro = "";
		$ExitoRegistro = "";
		
		//REQUEST de vars
		$Username = $_POST['username'];
		$Password1 = $_POST['password1'];
		$Password2 = $_POST['password2'];
		$Name = $_POST['name'];
		$Surname = $_POST['surname'];
		$DNI = $_POST['DNI'];
		
		//Verificacion de campos
		if(empty($Password1))
			$ErrorRegistro = 'Ingrese una contraseña';
		else if($Password1 != $Password2)
			$ErrorRegistro = 'Las contraseñas no coinciden';
		else if($Username == $Password2)
			$ErrorRegistro = 'El usuario y la contraseña no pueden ser identicos';
		else{
			
			$SelectQuery = "SELECT * FROM coordinador where Usuario='$Username' OR DNI=$DNI";
			$UserExistsQ = mysqli_query($db, $SelectQuery);
			$UserExists = mysqli_fetch_assoc($UserExistsQ);
			
			if($UserExists){
				//Ver si el nombre de usuario ya esta en uso
				if($UserExists['Usuario'] == $Username) {
					$ErrorRegistro = 'El nombre de usuario ya esta en uso';
				}
				//Ver si el nombre de usuario ya esta en uso
				else if($UserExists['DNI'] == $DNI) {
					$ErrorRegistro = "El DNI ya esta registrado en el sistema";
				}
			}
			else{
				$HashedPassword = md5($Password2);
				$InsertQuery = "INSERT INTO coordinador (DNI, Usuario, Contrasena) VALUES ($DNI, '$Username', '$HashedPassword')";
				
				if(mysqli_query($db, $InsertQuery)){
					$ExitoRegistro = 'El usuario se registro exitosamente';
					header("Location:AdministrarCoordinadores.php");
					}
				else
				//Si falla la query, muestra el error
				echo "Error:" . $InsertQuery . "<br>" . mysqli_error($db);
				
				}

		}
		$db->close();
	?>
	
	<head>
		<meta charset="UTF-8">
		<title>Registrar un coordinador</title>
		<link rel="stylesheet" type="text/css" href="../System/Style.css">
		<script src="../System/jQuery331.js"></script>
		<script src="Register.js"></script>
		<script src="../System/jQuery.js"></script>
	</head>
	
	<body background='../System/1sa.jpg'>
		<div class="DivBox3">
			<div class="LoginBoxAdentro">
				<p id="LoginTitle">Registrar un coordinador</p>
				<form action="<?php echo(htmlentities($_SERVER['PHP_SELF']))?>" method="POST">
					<?php
						if(!empty($ErrorRegistro))
							echo "<p class='Error'>$ErrorRegistro</p>";
						if(!empty($ExitoRegistro))
							echo "<p class='Exito'>$ExitoRegistro</p>";
					?>
					<br>
					<input type="text" name="username" placeholder="Ingrese un usuario" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''?>"></input>
					<br>
					<br>
					<input type="number" name="DNI" placeholder="Ingrese el DNI" min=0 value="<?php echo isset($_POST['DNI']) ? $_POST['DNI'] : ''?>"></input>
					<br>
					<br>
					<input type="password" name="password1" placeholder="Ingrese una contraseña"></input>
					<br>
					<br>
					<input type="password" name="password2" placeholder="Confirme la contraseña"></input>
					<br>
					<br>
					<input type="hidden" name="DoAction"></input>
					<input type="submit" value="Registrarse" class="ButtonLogin"></input>
					<br>
				</form>
				<br>
				<a href='AdministrarAlumnos.php'><button class="ButtonLoginBack">Volver a la pagina anterior</button></a>
				<br>
			</div>
		</div>
	</body>
</html>