<?php
	if(isset($_POST['submit'])) {
		$file = $_FILES['file'];
		
		$fileName = $_FILES['file']['name'];
		$fileTmpName = $_FILES['file']['tmp_name'];
		$fileSize = $_FILES['file']['size'];
		$fileError = $_FILES['file']['error'];
		$fileType = $_FILES['file']['type'];
		
		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));
		
		// $SelectIDQuery ="SELECT MAX(IDAviso) from aviso";
		
		
		echo $IDUltimoAviso;
		$Allowed = array('jpg', 'jpeg', 'png', 'pdf');
		
		if(in_array($fileActualExt, $Allowed)) {
			if($fileError===0){
				if($fileSize < 5000000){
					$fileNameNew = "Certificado-". $_SESSION['UserID'] ."-".$FechaEvento."." . $fileActualExt;
					$fileDestination = "../ArchivosCertif/" . $fileNameNew;
					if(file_exists($fileDestination)){
						unlink($fileDestination);
					}
					move_uploaded_file($fileTmpName, $fileDestination);
					$ExitoArchivos = 1;
					echo "exito";
					//header("Location:Inicio-Alumno.php?DoAct=1");
				}
				else {
					echo "El archivo es muy grande";
					return;
				}
			}
			else {
				echo "Error del archivo";
				return;
			}
			
		}
		else {
			echo "No se puede subir archivos de este tipo";
			return;
		}
	}
	
?>