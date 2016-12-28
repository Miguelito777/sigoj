<?php

/**
* Clase Comexion
*/
class Connection 
{
	public $connection;
	function __construct()
	{
		$this->connection = new mysqli("localhost", "root", "Jesus8", "sigOJ");
	}
}

/**
* Clase login
*/
class Login extends Connection
{
	public $user;
	public $password;

	function __construct($user, $password)
	{
		$this->user = $user;
		$this->password = $password;	
	}

	public function login(){
		$query = "SELECT * from users where user = '$this->user' and password = '$this->password'";
		parent:: __construct();
		if(!$user = $this->connection->query($query)){
			$this->connection->close();
			return false;
		}
		else{
			if ($user == null) {
				echo "No encontrado";
				$this->connection->close();
				return false;
			}
			else{
				$user = $user->fetch_assoc();
				return $user;
			}
		}
		

	}
}

/**
* Reporte
*/
class Reporte extends Connection
{
	public $nameReport;
	public $reportesA = array();
	public $columnsReport = array();	
	function __construct()
	{
		# code...
	}

	public function getReports(){
		$query = "show tables";
		parent:: __construct();
		$reportes = $this->connection->query($query);
		$this->connection->close();
		while($reporte = $reportes->fetch_assoc()){
			if ($reporte["Tables_in_sigOJ"] != "users" && $reporte["Tables_in_sigOJ"] != "Departamentos" && $reporte["Tables_in_sigOJ"] != "Municipios" && $reporte["Tables_in_sigOJ"] != "Regiones")
				array_push($this->reportesA, $reporte);
		}
		return $this->reportesA;
	}

	public function getReportNational($reporte){
		$typeReport = $this->reportesA[$reporte]['Tables_in_sigOJ'];
		$query = "SELECT * from $typeReport";
		parent:: __construct();
		$reportNational = $this->connection->query($query);
		$this->connection->close();
		$reportsNational = array();
		while($report = $reportNational->fetch_assoc()){
			array_push($reportsNational, $report);
		}
		return json_encode($reportsNational);
	}
	public function setReportUpload($reporte){
		$typeReport = $this->reportesA[$reporte]['Tables_in_sigOJ'];
		return $typeReport;
	}
	public function getRegions(){
		$query = "SELECT * from Regiones";
		parent:: __construct();
		$regions = $this->connection->query($query);
		$this->connection->close();
		$regionsA = array();
		while($region = $regions->fetch_assoc()){
			array_push($regionsA, $region);
		}
		return json_encode($regionsA);
	}
	public function getDepartament(){
		$query = "SELECT * from Departamentos";
		parent:: __construct();
		$this->connection->query("SET NAMES 'utf8'");
		$departaments = $this->connection->query($query);
		$this->connection->close();
		$departamentsA = array();
		while ($departament = $departaments->fetch_assoc()) {
			array_push($departamentsA, $departament);
		}
		return json_encode($departamentsA);
	}
	public function getMunicios($idDepartamento){
		$query = "SELECT * from Municipios where DepartamentosIdDepartamento = $idDepartamento";
		parent:: __construct();
		$this->connection->query("SET NAMES 'utf8'");
		$municipios = $this->connection->query($query);
		$this->connection->close();
		$municipiosA = array();
		while ($municipio = $municipios->fetch_assoc()) {
			array_push($municipiosA, $municipio);
		}
		return json_encode($municipiosA);
	}
	public function getReportRegion($reporte,$idRegion){
		$typeReport = $this->reportesA[$reporte]['Tables_in_sigOJ'];
		$query = "explain $typeReport";
		parent:: __construct();
		$columns = $this->connection->query($query);
		$this->connection->close();
		$columnsN = array();
		while ($column = $columns->fetch_assoc()) {
			array_push($columnsN, $column["Field"]);
		}
		$valueAll = '';
		for ($i = 0; $i < count($columnsN); $i++) { 
			if ($i < (count($columnsN)-2))
				$valueAll = $valueAll.$columnsN[$i].',';
			else if($i < (count($columnsN)-1))
				$valueAll = $valueAll.$columnsN[$i];
				else
				$municipioReport = 	$columnsN[$i];	
		}
		$query = "SELECT $valueAll from $typeReport inner join Municipios M on $typeReport.$municipioReport = M.idMunicipio inner join Departamentos D on M.DepartamentosIdDepartamento = D.idDepartamento inner join Regiones R on D.RegionesIdRegion = R.idRegion and R.idRegion = $idRegion";
		parent:: __construct();
		$reportsRegion = $this->connection->query($query);
		$this->connection->close();
		$reportsRegionA = array();
		while ($reportRegion = $reportsRegion->fetch_assoc()) {
			array_push($reportsRegionA, $reportRegion);
		}
		return $reportsRegionA;
	}
	public function getReportDepartament($reporte, $idDepartament){
		$typeReport = $this->reportesA[$reporte]['Tables_in_sigOJ'];
		$query = "explain $typeReport";
		parent:: __construct();
		$columns = $this->connection->query($query);
		$this->connection->close();
		$columnsN = array();
		while ($column = $columns->fetch_assoc()) {
			array_push($columnsN, $column["Field"]);
		}
		$valueAll = '';
		for ($i = 0; $i < count($columnsN); $i++) { 
			if ($i < (count($columnsN)-2))
				$valueAll = $valueAll.$columnsN[$i].',';
			else if($i < (count($columnsN)-1))
				$valueAll = $valueAll.$columnsN[$i];
				else
				$municipioReport = 	$columnsN[$i];	
		}
		$query = "SELECT $valueAll from $typeReport inner join Municipios M on $typeReport.$municipioReport = M.idMunicipio inner join Departamentos D on M.DepartamentosIdDepartamento = D.idDepartamento and D.idDepartamento = $idDepartament inner join Regiones R on D.RegionesIdRegion = R.idRegion";
		parent:: __construct();
		$reportsRegion = $this->connection->query($query);
		$this->connection->close();
		$reportsRegionA = array();
		while ($reportRegion = $reportsRegion->fetch_assoc()) {
			array_push($reportsRegionA, $reportRegion);
		}
		return $reportsRegionA;		
	}
	public function getReportMunicipio($reporte, $idMunicipio){
		$typeReport = $this->reportesA[$reporte]['Tables_in_sigOJ'];
		$query = "explain $typeReport";
		parent:: __construct();
		$columns = $this->connection->query($query);
		$this->connection->close();
		$columnsN = array();
		while ($column = $columns->fetch_assoc()) {
			array_push($columnsN, $column["Field"]);
		}
		$valueAll = '';
		for ($i = 0; $i < count($columnsN); $i++) { 
			if ($i < (count($columnsN)-2))
				$valueAll = $valueAll.$columnsN[$i].',';
			else if($i < (count($columnsN)-1))
				$valueAll = $valueAll.$columnsN[$i];
				else
				$municipioReport = 	$columnsN[$i];	
		}
		$query = "SELECT $valueAll from $typeReport inner join Municipios M on $typeReport.$municipioReport = M.idMunicipio and M.idMunicipio = $idMunicipio inner join Departamentos D on M.DepartamentosIdDepartamento = D.idDepartamento inner join Regiones R on D.RegionesIdRegion = R.idRegion";
		parent:: __construct();
		$reportsMunicipio = $this->connection->query($query);
		$this->connection->close();
		$reportsMunicipioA = array();
		while ($reportMunicipio = $reportsMunicipio->fetch_assoc()) {
			array_push($reportsMunicipioA, $reportMunicipio);
		}
		return $reportsMunicipioA;		
	}

	public function createReport($tableName, $columnsNames){
		$query = "CREATE table $tableName (id".$tableName." int not null auto_increment primary key, ";
		for ($i = 0; $i < count($columnsNames)+1; $i++) {
			if ($i < (count($columnsNames)))
			 	$query = $query.$columnsNames[$i]." varchar(88), ";
			else
				$query = $query." MunicipiosIdMunicipio int not null)";
		}
		parent:: __construct();
		$newReport = $this->connection->query($query);
		$query = "ALTER table $tableName add foreign key(MunicipiosIdMunicipio) references Municipios(idMunicipio)";
		$this->connection->query($query);
		$this->connection->close();
		if ($newReport) {
			$this->reportesA = array();
			$reports = $this->getReports();
			return $reports;
		}
		else
			echo "Error al crear el reporte";
	}
	public function getReportFormat($reporte){
		$typeReport = $this->reportesA[$reporte]['Tables_in_sigOJ'];
		$query = "explain $typeReport";
		parent:: __construct();
		$columns = $this->connection->query($query);
		$this->connection->close();
		$columnsN = array();
		while ($column = $columns->fetch_assoc()) {
			array_push($columnsN, $column["Field"]);
		}
		$this->columnsReport = $columnsN;
	}
	public function getReportFormatUpload($reporte){
		$query = "explain $reporte";
		parent:: __construct();
		$columns = $this->connection->query($query);
		$this->connection->close();
		$columnsN = array();
		while ($column = $columns->fetch_assoc()) {
			array_push($columnsN, $column["Field"]);
		}
		return $columnsN;
	}
	public function saveReport($nameReport, $columnsReport, $dataReport){
		$valueAll = '';
		for ($i = 1; $i < count($columnsReport); $i++) { 
			if ($i < (count($columnsReport)-1))
				$valueAll = $valueAll.$columnsReport[$i].',';
			else 
				$valueAll = $valueAll.$columnsReport[$i];								
		}
		echo "columns $valueAll";
		for ($i = 2; $i <= count($dataReport); $i++) {
			$values = "";
			for ($j = 0; $j < count($dataReport[$i]); $j++) {
				$col = $columnsReport[$j+1];
				if ($j < (count($dataReport[$i])-2)){
					$val = (string)$dataReport[$i]["$col"];
					$values = $values."'".$val."',";
				}
				else if ($j < (count($dataReport[$i])-1)){
					$val = (string)$dataReport[$i]["$col"];
					$values = $values."'".$val."'";
					}
					else{
						$val = (int)$dataReport[$i]["$col"];
						$values = $values.','.$val;
					} 							
			}
			$query = "INSERT INTO $nameReport($valueAll) values($values)";
			echo "data $values";
			parent:: __construct();
			if($this->connection->query($query))
				echo "exito";
			else{
				echo mysql_error();
				echo "error";
			}
			$this->connection->close();
		}
	}
}

?>