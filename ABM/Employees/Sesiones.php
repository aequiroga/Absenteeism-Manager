<?php

	$TiempoSesion = 600;
	
	Function SesionUsuario($UserID,$DoAct){
		
		global $TiempoSesion;
		
		//Chequea si el usuario cerro su sesion
		if($DoAct == 5){
		session_unset();
		session_destroy();
		header("location: Login.php?Error=4");

		}
		//Chequea si la sesion existe
		if(!$UserID) {
			session_unset();
			session_destroy();
			header("location: Login.php?Error=3");
		}
		//Chequea si la sesion acabo
		$now = time();
		if (isset($_SESSION['Duration']) && $now > $_SESSION['Duration']) {
			// Acaba la sesion y devuelve al usuario al login
			session_unset();
			session_destroy();
			header("location: Login.php?Error=5");
		}
		//Si no acabo, renueva la duración de esta
		else $_SESSION['Duration'] = $now + $TiempoSesion;
	}
	
	Function SesionCoordinador($CoordinadorID,$DoAct){
		
		global $TiempoSesion;
		//Chequea si el usuario cerro su sesion
		if($DoAct == 5){
			session_unset();
			session_destroy();
			header("location: LoginCoordinador.php?Error=4");

		}
		//Chequea si la sesion existe
		if(!$CoordinadorID) {
			session_unset();
			session_destroy();
			header("location: LoginCoordinador.php?Error=3");
		}
		//Chequea si la sesion acabo
		$now = time();
		if (isset($_SESSION['Duration']) && $now > $_SESSION['Duration']) {
			// Acaba la sesion y devuelve al usuario al login
			session_unset();
			session_destroy();
			header("location: LoginCoordinador.php?Error=5");
		}
		//Si no acabo, renueva la duración de esta
		else $_SESSION['Duration'] = $now + $TiempoSesion;
	}
	
	Function SesionAdmin($AdminID,$DoAct){
		//Chequea si el usuario cerro su sesion
		if($DoAct == 5){
			session_unset();
			session_destroy();
			header("location: LoginAdmin.php?Error=4");

		}
		//Chequea si la sesion existe
		if(!$AdminID) {
			session_unset();
			session_destroy();
			header("location: LoginAdmin.php?Error=3");
		}
		//Chequea si la sesion acabo
		$now = time();
		if (isset($_SESSION['Duration']) && $now > $_SESSION['Duration']) {
			// Acaba la sesion y devuelve al usuario al login
			session_unset();
			session_destroy();
			header("location: LoginAdmin.php?Error=5");
		}
		//Si no acabo, renueva la duración de esta
		else $_SESSION['Duration'] = $now + 360;
	}
?>