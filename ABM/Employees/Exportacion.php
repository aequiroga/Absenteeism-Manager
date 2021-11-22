<?php
	include ($_SERVER["DOCUMENT_ROOT"] . "/System/BD.php");	
	
	Function ExportarExcel() {
		global $DB;
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=Tabla.xls");
		$SelectQuery = "SELECT IDAviso,Apellido,DNI,FechaEvento,FechaAviso FROM aviso INNER JOIN usuarios on aviso.usuario_fk = usuarios.DNI INNER JOIN pasantias ON aviso.pasantia_fk = pasantias.IDPasantia";
		$TablaQ = mysqli_query($DB,$SelectQuery);
		$Tabla = array();
		while($Fila = mysqli_fetch_assoc($TablaQ)){
			$Tabla[$i] = $Fila;
			$i++;
		}
		$Columna = true;			
		foreach($Tabla as $d){
			if($Columna){
				echo implode("\t", array_keys($d));
				echo "\n";
				$Columna = false;
			}
			echo implode("\t", array_values($d));
			echo "\n";
		}
		exit();
	}
	
	Function ExportarSQL($tables = false){
		global $DB;
		$queryTables = mysqli_query($DB,'SHOW TABLES'); 
        while($row = mysqli_fetch_row($queryTables)) 
        { 
            $target_tables[] = $row[0]; 
        }   
        if($tables !== false) 
        { 
            $target_tables = array_intersect( $target_tables, $tables); 
        }
        foreach($target_tables as $table)
        {
            $result         =   mysqli_query($DB,'SELECT * FROM '.$table);  
            $fields_amount  =   mysqli_field_count($result);  
            $rows_num= mysqli_affected_rows($DB);     
            $res            =   mysqli_query($DB,'SHOW CREATE TABLE '.$table); 
            $TableMLine     =   mysqli_fetch_row($res);
            $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = mysqli_fetch_row($result))  
                { //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    {
                            $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)  
                    { 
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                        if (isset($row[$j]))
                        {
                            $content .= '"'.$row[$j].'"' ; 
                        }
                        else 
                        {   
                            $content .= '""';
                        }     
                        if ($j<($fields_amount-1))
                        {
                                $content.= ',';
                        }      
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                    {   
                        $content .= ";";
                    } 
                    else 
                    {
                        $content .= ",";
                    } 
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        $backup_name = "Backup(".date('d-m-Y').").sql";
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
        echo $content; exit;
    }
?>