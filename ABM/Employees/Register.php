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
		
		//$SelectedClass = $_GET['QS'];
		//echo $SelectedClass . "<br>";
		
		//Declaracionv vars
		$Username = "";
		$Password = "";
		$Email = "";
		$Token = "";
		$ErrorRegistro = "";
		$ExitoRegistro = "";
		
		//REQUEST de vars
		$Username = $_POST['username'];
		$Password1 = $_POST['password1'];
		$Password2 = $_POST['password2'];
		$Email = $_POST['email'];
		$Name = $_POST['name'];
		$Surname = $_POST['surname'];
		$DNI = $_POST['DNI'];
		$CursoPasantia = $_POST['CursoPasantia'];
		
		
		
		//QuerySQL y Conversion de CursoPasantia a array
		$DropdownQ = mysqli_query($db, "SELECT * FROM pasantias INNER JOIN cursos ON pasantias.cursoPasantia_fk = cursos.IDCurso");
		
		$CursoPasantia_explode = explode('|',$CursoPasantia);
		$Curso =  $CursoPasantia_explode[0];
		$Pasantia = $CursoPasantia_explode[1];
		
		//Verificacion de campos
		if(empty($Password1))
			$ErrorRegistro = 'Ingrese una contraseña';
		else if($Password1 != $Password2)
			$ErrorRegistro = 'Las contraseñas no coinciden';
		else if($Username == $Password2)
			$ErrorRegistro = 'El usuario y la contraseña no pueden ser identicos';
		else if(empty($Name) OR empty($Surname))
			$ErrorRegistro = 'Complete todos los campos';
		else{
			
			$SelectQuery = "SELECT * FROM usuarios where Usuario='$Username' OR DNI=$DNI OR Mail='$Email'";
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
				else if($UserExists['Mail'] == $Email) {
					$ErrorRegistro = "El Email ya esta registrado en el sistema";
				}
			}
			else{
				//Encripta contrasena
				$HashedPassword = md5($Password2);
				//Genera token para recuperar contrasena
				$Token = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890!$/*";
				$Token = str_shuffle($Token);
				substr($Token,0,10);
				
				//Genera Query
				$InsertQuery = "INSERT INTO usuarios (DNI, Usuario, Contrasena, Token, CambioMail, Mail, Nombre, Apellido, curso_fk, pasantia_fk) VALUES ($DNI, '$Username', '$HashedPassword', '$Token', 0, '$Email', '$Name', '$Surname', $Curso, $Pasantia)";
				
				if(mysqli_query($db, $InsertQuery)){
					$ExitoRegistro = 'El usuario se registro exitosamente';
					//header("Location:Login.php");
					}
				else
				//Si falla la query, muestra el error
				echo "Error:" . $InsertQuery . "<br>" . mysqli_error($db);
				
				}

		}
		/*$Password = md5($Password);
		$InsertQuery = "INSERT INTO usuarios (Usuario, Contrasena) VALUES ('$Username', '$Password')";
		if(mysqli_query($db, $InsertQuery)){
			echo "USUARIO CREADO";
			//header("Location:Login.php");
		}
		else
		echo "Error:" . $InsertQuery . "<br>" . mysqli_error($db);*/
		$db->close();
	?>
	
	<head>
		<meta charset="UTF-8">
		<title>Registrar un usuario</title>
		<link rel="stylesheet" type="text/css" href="../System/Style.css">
		<script src="../System/jQuery331.js"></script>
		<script src="../System/jQuery.js"></script>
	</head>
	
	<body background='../System/1sa.jpg'>
		<div class="DivBox3">
			<div class="LoginBoxAdentro">
				<p id="LoginTitle">Registrar usuario</p>
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
					<input type="password" name="password1" placeholder="Ingrese una contraseña"></input>
					<br>
					<br>
					<input type="password" name="password2" placeholder="Confirme la contraseña"></input>
					<br>
					<br>
					<input type="text" name="email" placeholder="Ingrese un mail" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''?>"></input>
					<br>
					<br>
					<input type="text" name="name" placeholder="Ingrese el nombre" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''?>"></input>
					<br>
					<br>
					<input type="text" name="surname" placeholder="Ingrese el apellido" value="<?php echo isset($_POST['surname']) ? $_POST['surname'] : ''?>"></input>
					<br>
					<br>
					<input type="number" name="DNI" placeholder="Ingrese el DNI" min=0 value="<?php echo isset($_POST['DNI']) ? $_POST['DNI'] : ''?>"></input>
					<br>
					<br>
					<select name="CursoPasantia" id="SelectClass">
					<option value='' selected>Seleccione un curso y pasantía</option>
					<?php
						//Muestra los cursos existentes como opciones del dropdown
						while($Dropdown = mysqli_fetch_assoc($DropdownQ)){
						echo "<option value=".$Dropdown['IDCurso']."|".$Dropdown['IDPasantia'].">".$Dropdown['NombreCurso']." // ".$Dropdown['NombrePasantia']."</option>";
						}
					?>
					</select>
					<br>
					<br>
					<input type="hidden" name="DoAction"></input>
					<input type="submit" value="Registrarse" class="ButtonLogin"></input>
				</form>
				<br>
				<a href='AdministrarAlumnos.php'><button class="ButtonLoginBack">Volver a la pagina anterior</button></a>
				<br>
				<br>
			</div>
		</div>
	</body>
</html>