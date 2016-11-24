var usuario = new System();
usuario.getReportes();
var newReport = {};

document.getElementById("report").innerHTML = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Seleccione un reporte!</strong></div>";
var departamentSelected;

function newReporte(){
	var nuevoReporte = document.getElementById('nuevoReporte').value;
	newReport.nameReport = nuevoReporte;
	addColumnsReport();
}
function showTypeReports(){
	document.getElementsByTagName("select")[0].options.length = 0;
	for (var i = 0; i < usuario.tiposReportes.length; i++) {
		$("#reportes").append("<option value="+usuario.tiposReportes[i].codigo+">"+usuario.tiposReportes[i].nombre+"</option>");
	};
	$("#reportes").append("<option value='' selected>Menu</option>");
}
function addColumnsReport(){
	newReport.columns = [];
	document.getElementById("titleReport").innerHTML = "Nuevo Reporte <strong>"+newReport.nameReport+"</strong>";
	$('#columnsReport').modal();

	/*
	usuario.setReportes(nuevoReporte);
	document.getElementsByTagName("select")[0].options.length = 0;
	for (var i = 0; i < usuario.tiposReportes.length; i++) {
		$("#reportes").append("<option value="+usuario.tiposReportes[i].codigo+">"+usuario.tiposReportes[i].nombre+"</option>");
	};
	$("#reportes").append("<option value='0' selected>Menu</option>");*/
}
function addColumn(){
	var newNameColumn = document.getElementById("nameNewcolumn").value;
	newReport.columns.push(newNameColumn);
	$("#titlesColumns").append("<th>"+newNameColumn+"</th>");
}
function saveReport(){
	usuario.saveReport(newReport);
}
$("#reportes").change(searchReportPersonalUno);
function searchReportPersonalUno(){
	var alcance = document.getElementsByTagName("select")[1].value;
	var reporte = document.getElementsByTagName("select")[0].value;
	if (alcance == "0") {
		usuario.getReportNational(reporte);
	}
	else{
		usuario.getRepPersonal();
	}
}

function showReport(report){
	document.getElementById("report").innerHTML = "";
	document.getElementById("report").innerHTML = "<table class='table table-hover' id='tableReport'><thead><tr id='titleClumn'></tr></thead><tbody></tbody></table>";
	var keys = Object.keys(report[0]);
	for(var i in keys){
		$("#titleClumn").append("<th>"+keys[i]+"</th>");
	}
	for(var i in report){
		$("#tableReport").append("<tr id="+i+"></tr>");
		for(var j in report[i]){
			$("#"+i+"").append("<td>"+report[i][j]+"</td>");
		}
	}
}

function showPersonal(personal){
	document.getElementById("personal").innerHTML = "";
	$("#personal").append("<table class='table table-hover' id='tablePersonal'><thead><tr><th>Renglon</th><th>No. Empleados</th></tr></thead></table>");
	for(var i in personal){
		$("#tablePersonal").append("<tr><td>"+personal[i]["renglon"]+"</td><td>"+personal[i]["cantidadEmpleados"]+"</td></tr>");
	}
}

$("#alcance").change(changeAlcance);
function changeAlcance(){
	var alcance = document.getElementById("alcance");
	alcance = alcance.options[alcance.selectedIndex].value;
	if (alcance == "0"){
		var reporte = document.getElementById("reportes");
		reporte = reporte.options[reporte.selectedIndex].value;
		document.getElementById("sub").innerHTML = "";
		if (reporte == "")
			document.getElementById("report").innerHTML = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Seleccione un reporte!</strong></div>";
		else{
			var reporte = document.getElementById("reportes").value;
			reporte = reporte.options[reporte.selectedIndex].value;
			usuario.getReportNational(reporte);
		}
	}
	else if(alcance == "1"){
		document.getElementById("sub").innerHTML = "<select name='empleados' class='form-control' required='required' id='submenuR' onchange='changeRegion()'>";
		usuario.getRegions();
	}
	else if(alcance == "2"){
		document.getElementById("sub").innerHTML = "<select name='empleados' class='form-control' required='required' id='submenuD' onchange='changeDepartamento()'>";
		usuario.getDepartament();
	}
	else if(alcance == "3")
		alert("Municial");
}

function showRegions(regions){
	for(var i in regions){
		$("#submenuR").append("<option value="+regions[i]["idRegion"]+">"+regions[i]["nombreRegion"]+"</option>");
	}
	$("#submenuR").append("<option value='' selected>Seleccione Region</option>");
}

function changeRegion(){
	var regionSelected = document.getElementById("submenuR");
	regionSelected = regionSelected.options[regionSelected.selectedIndex].value;
	var reporte = document.getElementsByTagName("select")[0].value;
	usuario.getReportRegion(reporte,regionSelected);
}

function showDepartaments(departaments){
	for(var i in departaments){
		$("#submenuD").append("<option value="+departaments[i]["idDepartamento"]+">"+departaments[i]["nombreDepartamento"]+"</option>");
	}
		$("#submenuD").append("<option value=''selected>Seleccione departamento</option>");
}
function changeDepartamento(){
	var submenuD = document.getElementById("submenuD");
	submenuD = submenuD.options[submenuD.selectedIndex].value;
	departamentSelected = submenuD;
	if (submenuD != ''){
		usuario.getMunicios(submenuD);		
	}
	else
		document.getElementById("report").innerHTML = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Seleccione un departamento!</strong></div>";			
}

function showMunicipios(municipios){
	document.getElementById("subSub").innerHTML = "<select name='empleados' class='form-control' required='required' id='submenuM' onchange='changeMunicipio()'>";	
	for(var i in municipios){
		$("#submenuM").append("<option value="+municipios[i]["idMunicipio"]+">"+municipios[i]["nombreMunicipio"]+"</option>");
	}
		$("#submenuM").append("<option value=''selected>Seleccione municipio</option>");	
	var reporte = document.getElementsByTagName("select")[0].value;
	usuario.getReportDepartament(reporte,departamentSelected);
}

function changeMunicipio(){
	var municipio = document.getElementById("submenuM");
	municipio = municipio.options[municipio.selectedIndex].value;
	if (municipio != '') {
		var reporte = document.getElementsByTagName("select")[0].value;
		usuario.getReportMunicipio(reporte,municipio);		
	}
	else
		document.getElementById("report").innerHTML = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Seleccione un municipio!</strong></div>";			
}


function getReport(){
	usuario.getReport();
}
function showReportDowlands(){
	document.getElementById("reportDowlands").innerHTML="";
	document.getElementById("reportDowlands").innerHTML="<table class='table table-hover' id='dowlandReport'><thead><tr><th><h2>Reporte</h2></th><th><h2>Descargar formato</h2></th></tr></thead></table>";
	for(var i in usuario.tiposReportes){
		$("#dowlandReport").append("<tr><td><p class='lead'>"+usuario.tiposReportes[i]["Tables_in_sigOJ"]+"</p></td><td><button type='button' class='btn btn-link' id="+i+" onclick= 'dowlandReport(this.id)'>dowland</button></td></tr>")
	}
}

function dowlandReport(position){
	usuario.dowlandReport(position);
}






/**
* Upload reports
*/
function getReports(){
	usuario.getReportesUpload();	
}

function showTypeReportsUpload(){
	document.getElementsByTagName("select")[0].options.length = 0;
	for (var i = 0; i < usuario.tiposReportes.length; i++) {
		$("#reportesUpload").append("<option value="+usuario.tiposReportes[i].codigo+">"+usuario.tiposReportes[i].nombre+"</option>");
	};
	$("#reportesUpload").append("<option value='' selected>Menu</option>");
}

function searchReportPersonal(){
	var submenuD = document.getElementById("reportesUpload");
	submenuD = submenuD.options[submenuD.selectedIndex].value;
	
	if(submenuD == '')
		alert("Seleccione un reporte");
	else
		usuario.setReportUpload(submenuD);
}