<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reportes</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
	<hr>
	<header>
    		<!-- NAVBAR
    	    ================================================== -->
            <div class="container">
                <ul class="nav nav-tabs">
                	<div class="row">
                		<div class="col-xs-3">
                			<select name="empleados" class="form-control" required="required" id="reportesUpload" onchange="searchReportPersonal();">
                			</select>
                		</div>
                		<div class="col-xs-2" id="sub">

						</div>
                		<div class="col-xs-2" id="subSub">
                			
                		</div>
                		<div class="col-xs-2">
                			
                		</div>
                		<div class="col-xs-3">

                		</div>
                	</div>
                </ul>
            </div>

    </header>
	<section>
		<div class="container">
			<hr>
			<div class="row">
				<div class="col-xs-2" ></div>
				<div class="col-xs-8">
					<p class="lead">Seleccione el reporte:</p>
					<form name="importa" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
					<input type="file" name="excel" /><br>
					<input type='submit' name='enviar'  value="Importar"  />
					<input type="hidden" value="upload" name="action" />
					</form>
				</div>
				<div class="col-xs-2" ></div>
			</div>
		</div>
	</section>
	<footer></footer>


	<script type="text/javascript" src="js/jquery-2.1.1.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/modelo.js"></script>
	<script type="text/javascript" src="js/controlador.js"></script>
	<script>
		getReports();
	</script>

<?php
require 'fpdf.php'; 
header("Content-Type: text/html;charset=utf-8");
extract($_POST);
if ($action == "upload"){
//cargamos el archivo al servidor con el mismo nombre
//solo le agregue el sufijo bak_ 
	$archivo = $_FILES['excel']['name'];
	$tipo = $_FILES['excel']['type'];
	$destino = "bak_".$archivo;
	if (move_uploaded_file($_FILES['excel']['tmp_name'],$destino)) echo "Archivo Cargado Con Éxito";
	else echo "Error Al Cargar el Archivo";
////////////////////////////////////////////////////////
	/** Clases necesarias */
	require_once('Classes/PHPExcel.php');
	require_once('Classes/PHPExcel/Reader/Excel2007.php');
	include 'modelo.php';
		session_start();
	if (isset($_SESSION["nameReporUpload"])) {
		if (file_exists ("bak_".$archivo)){ 
			// Cargando la hoja de cálculo
			$objReader = new PHPExcel_Reader_Excel2007();
			$objPHPExcel = $objReader->load("bak_".$archivo);
			$objFecha = new PHPExcel_Shared_Date();       

			// Asignar hoja de excel activa
			$objPHPExcel->setActiveSheetIndex(0);

			//conectamos con la base de datos 
			//$cn = mysql_connect ("localhost","root","pass") or die ("ERROR EN LA CONEXION");
			//$db = mysql_select_db ("escuela",$cn) or die ("ERROR AL CONECTAR A LA BD");
				
			        // Llenamos el arreglo con los datos  del archivo xlsx
			//Para almacenar las relaciones
			$report = new Reporte();
			$columns = $report->getReportFormatUpload($_SESSION["nameReporUpload"]);
			$columnsHoja = array("","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S");

			$afterData = true;
			$i = 1;
			while ($afterData){
				for ($j = 1; $j < count($columns); $j++) { 
					$nameColumns = $columns[$j];
					$column = $columnsHoja[$j];
					$_DATOS_EXCEL[$i]["$nameColumns"] = $objPHPExcel->getActiveSheet()->getCell("$column".$i)->getCalculatedValue();
				}
				$after= $objPHPExcel->getActiveSheet()->getCell("A".($i+1))->getCalculatedValue();
				if($after == null)
					$afterData = false;
			$i++;
			}
			$cantDatos = count($_DATOS_EXCEL);
			$report->saveReport($_SESSION["nameReporUpload"],$columns,$_DATOS_EXCEL);
		}
		//si por algo no cargo el archivo bak_ 
		else{echo "Necesitas primero importar el archivo";}
	}
	else
		echo "<p class='lead'>Seleccione el tipo de reporte que subirá</p>";
//$errores=0;
//recorremos el arreglo multidimensional 
//para ir recuperando los datos obtenidos
//del excel e ir insertandolos en la BD
/*foreach($_DATOS_EXCEL as $campo => $valor){
	//$sql = "INSERT INTO alumnos VALUES (NULL,'";
	foreach ($valor as $campo2 => $valor2){
		//$campo2 == "sexo" ? $sql.= $valor2."');" : $sql.= $valor2."','";
		echo "$valor2";	
	}
	//$result = mysql_query($sql);
	if (!$result){ echo "Error al insertar registro ".$campo;$errores+=1;}
}*/	
/////////////////////////////////////////////////////////////////////////


//una vez terminado el proceso borramos el 
//archivo que esta en el servidor el bak_
unlink($destino);
}

?>

</body>
</html>
