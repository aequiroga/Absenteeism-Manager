<?php
		include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");

		
		//REQUESTS
		$Email = $_POST['email'];
		//Declaracion Query
		$SelectQuery = "SELECT * FROM usuarios where Mail = '$Email'";
		$UpdateQuery = "UPDATE usuarios SET CambioMail = 1";
		
		$UserExistQ = mysqli_query($db, $SelectQuery);
		$UserExist = mysqli_fetch_assoc($UserExistQ);
		$HashUsuario = $UserExist['Token'];
		$Usuario = $UserExist['Usuario'];
		
		if(!$UserExist){
			$ErrorLogin = 'No existe un usuario con el mail introducido';
		}
		else {
			mysqli_query($db, $UpdateQuery);
			$Link = "http://localhost/Employees/CambioContrasena.php?HashUsuario=".$HashUsuario."&Usuario=".$Usuario"&TipoUsuario=1";
			$to      = "Mail2@localhost";
			$subject = 'Cambio de contraseña';
			$message = 'Se ha enviado una solicitud de cambio de contraseña, si no fue usted, ignore este mensaje. '.$Link;
			$headers = 'From: Pasantias@localhost' . "\r\n" .
			'Reply-To: Pasantias@localhost' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
		echo "dasdas";
		//header("Location:Login.php");
		}
		
		
		$db->close();
	?>
<html>
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
			<p id="LoginTitle">Recuperar contraseña</p>
				<p>Se le enviara a su mail un link para cambiar la contraseña
				<?php
					//Mostrar mensaje de error
					if(!empty($ExitoTxt))
						echo "<p class='Exito'>$ExitoTxt</p>";
					if(!empty($ErrorLogin))
						echo "<p class='Error'>$ErrorLogin</p>";
				?>
			<form action="<?php echo(htmlentities($_SERVER['PHP_SELF']))?>" method="POST">
				<br>
				<input type="mail" name="email" placeholder="Ingrese su mail" required></input>
				<br>
				<br>
				<input type="submit" value="Enviar mail" class="ButtonLogin" name="RegisterButton"></input>
				<br>
			</form>
				<br>
				<a href="Login.php"><h5>Volver<h5></a>
			</div>
		</div>
	</body>
</html>
