<?php
	include 'modelo.php';
	session_start();
	require_once 'Classes/PHPExcel.php';

function utf8_encode_recursive ($array)
{
    $result = array();
    foreach ($array as $key => $value)
    {
        if (is_array($value))
        {
            $result[$key] = utf8_encode_recursive($value);
        }
        else if (is_string($value))
        {
            $result[$key] = utf8_encode($value);
        }
        else
        {
            $result[$key] = $value;
        }
    }
    return $result;
}
if (isset($_POST["user"]) && isset($_POST["password"])) {
	$user = new Login($_POST["user"],$_POST["password"]);
	if(!$user = $user->login()){
		echo "0";
	}
	else{
		if ($user["typeUser"])
			echo "1";
		else
			echo "2";
	}
}
	// Fragmento de codigo que obtiene datos de un archivo

	if (isset($_GET["getReportes"])) {
		$_SESSION["Reporte"] = new Reporte();
		$reportes = $_SESSION["Reporte"]->getReports();
		$reportes = utf8_encode_recursive($reportes);
		echo json_encode($reportes);
		/*$_SESSION["tiposReportes"] = array();
		$tiposReportes = fopen("tiposReportes.txt", "a+");// abrir el archivo
		while(!feof($tiposReportes)){// Mientras no sea el dfinal del archivo
			$tipoReporte = fgets($tiposReportes);// Leer la primera linea del archivo			
			if ($tipoReporte != false) {// Si la linea leida no es la final
				$tipoReporteAF = array();
				$tipoReporteA = explode("\t", $tipoReporte); // Divide la linea leida y la almacena en un array
				$tipoReporteAF["codigo"] = (int)$tipoReporteA[0];
				$tipoReporteAF["reporte"] = $tipoReporteA[1];
				array_push($_SESSION["tiposReportes"], $tipoReporteAF); // Almacena el array en el la matriz que contendra todos los arrays
			}
		}
		fclose($tiposReportes);// cierra el archivo

		echo json_encode($_SESSION["tiposReportes"]); // codifica a Json la matriz*/
	}

	// Fragmento de codigo que guarda un dato nuevo al final del archivo
	if (isset($_GET["setReportes"])) {
		$_SESSION["Reporte"]->newReport($_GET["setReportes"]);

		/*if (isset($_SESSION["tiposReportes"])) {
			$tiposReportes = fopen("tiposReportes.txt", "a+");// Abre el archivo
			$totalReportes = 1+count($_SESSION["tiposReportes"]);// Cuenta cuantas filas hay en el archivo
			$nt = $_GET["setReportes"];// Obtiene el datos enviado del cliente
			$newReporte = "$totalReportes\t$nt"; // Prepara la linea a escribir en el archivo
			fwrite($tiposReportes,$newReporte.PHP_EOL);// Escribe la linea al final del arhchivo
			fclose($tiposReportes);// Cierra el archivo
			$nR = array();
			$nR["codigo"] = $totalReportes;
			$nR["reporte"] = $nt;
			echo json_encode($nR);// Envia el nuevo datos ya almacenado en el archivo
		}
		else
			echo false;*/			

	}


	// Fgragmento de tados que lee datos de un archivo
	if (isset($_GET["getRepPer"])) {
		$_SESSION["cantidadEmpleados"] = array();
		$trabajadores = fopen("empleados.txt", "a+");
		while(!feof($trabajadores)){
			$renglon = fgets($trabajadores);			
			if ($renglon != false) {
				$renglonArray = array();
				$renglonReporteArray = explode("\t", $renglon);
				$renglonArray["renglon"] = $renglonReporteArray[0];
				$renglonArray["cantidadEmpleados"] = $renglonReporteArray[1];
				array_push($_SESSION["cantidadEmpleados"], $renglonArray);
			}
		}
		fclose($trabajadores);
		echo json_encode($_SESSION["cantidadEmpleados"]);
	}
	if (isset($_GET["getReportNational"])) {
		$reportNational = $_SESSION["Reporte"]->getReportNational($_GET["getReportNational"]);
		echo "$reportNational";
	}
	if (isset($_GET["getRegions"])) {
		$regions = $_SESSION["Reporte"]->getRegions();
		echo "$regions";
	}
	if (isset($_GET["getDepartament"])) {
		$departaments = $_SESSION["Reporte"]->getDepartament();
		echo "$departaments";
	}
	if (isset($_GET["getMunicios"])) {
		$municipios = $_SESSION["Reporte"]->getMunicios($_GET["getMunicios"]);
		echo "$municipios";		
	}
	if (isset($_POST["getReportRegion"])) {
		$reportRegion = json_decode($_POST["getReportRegion"],true);
		$reportRegion = $_SESSION["Reporte"]->getReportRegion($reportRegion["idReporte"],$reportRegion["idRegion"]);	
		echo json_encode($reportRegion);		
	}
	if (isset($_POST["getReportDepartament"])) {
		$reportDepartament = json_decode($_POST["getReportDepartament"],true);
		$reportDepartament = $_SESSION["Reporte"]->getReportDepartament($reportDepartament["idReporte"],$reportDepartament["idDepartament"]);	
		echo json_encode($reportDepartament);
	}
	if (isset($_POST["getReportMunicipio"])){
		$reportMunicipio = json_decode($_POST["getReportMunicipio"],true);
		$reportMunicipio = $_SESSION["Reporte"]->getReportMunicipio($reportMunicipio["idReporte"],$reportMunicipio["idMunicipio"]);	
		echo json_encode($reportMunicipio);
	}



	/*Cre un nuevo Reporte*/

	if (isset($_POST["saveReport"])) {
		$newReport = json_decode($_POST["saveReport"],true);
		$newReportt = $_SESSION["Reporte"]->createReport($newReport["nameReport"], $newReport["columns"]);
		$_SESSION["Report"] = new Reporte();
		$_SESSION["Report"]->columnsReport = $newReport["columns"];
		$_SESSION["Report"]->nameReport = $newReport["nameReport"];
		if($newReportt)
			echo true;
		else
			echo false;
	}
	/*if (isset($_GET["sendRequestReport"])) {
			$reports = $_SESSION["Report"]->columnsReport;
			$title = $_SESSION['Report']->nameReport;
			$columns = array("A1","B1","C1","D1","E1","F1","G1","H1","I1","J1","K1","L1","M1","N1","O1","P1","Q1","R1","S1");
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator("Miguel Menchu")
			->setLastModifiedBy("Miguel Menchu")
			->setTitle("Reporte $title")
			->setSubject("Documento Excel de Prueba")
			->setDescription("Archivo de recepcion de datos para reportes gerenciales")
			->setKeywords("Excel Office 2007 openxml php")
			->setCategory("Archivos por municipios");
			for ($i=0; $i <= count($reports); $i++) {
				if($i < count($reports)){
					$column = $columns[$i];
					$data = $reports[$i];
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("$column", "$data");
				}
				else{
					$column = $columns[$i];
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("$column", "CodigoMunicipio");					
				}
			}
			/*->setCellValue('B1', 'Valor 2')
			->setCellValue('C1', 'Total')
			->setCellValue('A2', '10')
			->setCellValue('B2', '15')
			->setCellValue('C2', '=sum(A2:B2)');

			$objPHPExcel->getActiveSheet()->setTitle('Archivo datos municipios');

			$objPHPExcel->setActiveSheetIndex(0);

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

		exit;
	}*/
	if (isset($_GET["getReport"])) {
		$_SESSION["Report"] = new Reporte();
		$reports = $_SESSION["Report"]->getReports();
		$reports = utf8_encode_recursive($reports);
		echo json_encode($reports);
	}

	if (isset($_GET["dowlandReport"])) {
		if (isset($_SESSION["Report"])) {
			$_SESSION["Report"]->getReportFormat($_GET["dowlandReport"]);
			$reports = $_SESSION["Report"]->columnsReport;
			$columns = array("A1","B1","C1","D1","E1","F1","G1","H1","I1","J1","K1","L1","M1","N1","O1","P1","Q1","R1","S1");
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator("Cattivo")
			->setLastModifiedBy("Cattivo")
			->setTitle("Documento Excel de Prueba")
			->setSubject("Documento Excel de Prueba")
			->setDescription("Demostracion sobre como crear archivos de Excel desde PHP.")
			->setKeywords("Excel Office 2007 openxml php")
			->setCategory("Pruebas de Excel");
			for ($i=1; $i < count($reports); $i++) {
				$column = $columns[$i-1];
				$data = $reports[$i];
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("$column", "$data");
			}
			/*->setCellValue('B1', 'Valor 2')
			->setCellValue('C1', 'Total')
			->setCellValue('A2', '10')
			->setCellValue('B2', '15')
			->setCellValue('C2', '=sum(A2:B2)');*/

			$objPHPExcel->getActiveSheet()->setTitle('Tecnologia Simple');

			$objPHPExcel->setActiveSheetIndex(0);

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="pruebaReal.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;					
		}
	}
	if (isset($_GET["setReportUpload"])) {
		$_SESSION["nameReporUpload"] = $_SESSION["Reporte"]->setReportUpload($_GET["setReportUpload"]);
		if ($_SESSION["nameReporUpload"])
			echo true;
		else
			echo false;
	}
?>






