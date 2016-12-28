function System(){
	this.statusM;
	this.tiposReportes = [];
}
System.prototype.login = function(user, password){
	$.ajax({
		url : "controlador.php",
		type : "POST",
		data : {"user" : user, "password" : password},
		success : function(data){
		console.log(data);
			data = parseInt(data);
			if (data == 0) {
				alert("Usuario no registrado");
			}
			else if(data == 1)
				window.location = "indexAdmon.html";
			else
				if (data == 2) 
				window.location = "indexInformatic.html";
		}
	})
}
System.prototype.getReport = function(){
	var _this = this;
	$.ajax({
		url : "controlador.php",
		type : "GET",
		data : {"getReport" : true},
		success : function(data){
			_this.tiposReportes = $.parseJSON(data);
			showReportDowlands();
		}
	})
}
System.prototype.dowlandReport = function(position){
	window.location = "controlador.php?dowlandReport="+position;
}
System.prototype.getReportes = function(){
	var _this = this;
	$.ajax({
		url : "controlador.php",
		type : "GET",
		data : {"getReportes" : true},
		success : function(data){
			var tiposReportes = $.parseJSON(data);
			_this.tiposReportes = [];
			for(var i in tiposReportes){
				reporte = {};
				reporte.nombre = tiposReportes[i]["Tables_in_sigOJ"];
				reporte.codigo = i;
				_this.tiposReportes.push(reporte); 
			}
			showTypeReports();
		}
	})
}
System.prototype.getReportesUpload = function(){
	var _this = this;
	$.ajax({
		url : "controlador.php",
		type : "GET",
		data : {"getReportes" : true},
		success : function(data){
			var tiposReportes = $.parseJSON(data);
			_this.tiposReportes = [];
			for(var i in tiposReportes){
				reporte = {};
				reporte.nombre = tiposReportes[i]["Tables_in_sigOJ"];
				reporte.codigo = i;
				_this.tiposReportes.push(reporte); 
			}
			showTypeReportsUpload();
		}
	})
}
System.prototype.setReportUpload = function(positionReport){
	var _this = this;
	$.ajax({
		url : "controlador.php",
		type : "GET",
		data : {"setReportUpload" : positionReport},
		success : function(data){
			if (parseInt(data) == 1)
				console.log("Reporte almacenado correctamente");
			else
				console.log("Error al almacenar el reporte");
			/*var tiposReportes = $.parseJSON(data);
			_this.tiposReportes = [];
			for(var i in tiposReportes){
				reporte = {};
				reporte.nombre = tiposReportes[i]["Tables_in_sigOJ"];
				reporte.codigo = i;
				_this.tiposReportes.push(reporte); 
			}
			showTypeReportsUpload();*/
		}
	})
}
System.prototype.setReportes = function(nuevoReporte){
	var _this = this;
	$.ajax({
		url : "controlador.php",
		type : "GET",
		data : {"setReportes" : nuevoReporte},
		success : function(data){
			if (parseInt(data) == 1)
				addColumnsReport();
			else
				alert("Error al crear el nuevo Reporte");
		}
	})	
}
System.prototype.getRepPersonal = function(){
	$.ajax({
		url: "controlador.php",
		type: "GET",
		data : {"getRepPer": true},
		success : function(data){
			var personal = $.parseJSON(data);
			showPersonal(personal);
		}
	})
}
System.prototype.getReportNational = function(reporte){
	$.ajax({
		url: "controlador.php",
		type: "GET",
		data : {"getReportNational": reporte},
		success : function(data){
			var report = $.parseJSON(data);
			showReport(report);
		}
	})
}
System.prototype.getRegions = function(){
	$.ajax({
		url: "controlador.php",
		type: "GET",
		data : {"getRegions": true},
		success : function(data){
			var regions = $.parseJSON(data);
			showRegions(regions);
		}
	})	
}
System.prototype.getDepartament = function(){
	$.ajax({
		url: "controlador.php",
		type: "GET",
		data : {"getDepartament": true},
		success : function(data){
			var departaments = $.parseJSON(data);
			showDepartaments(departaments);
		}
	})	
}
System.prototype.getDepartamentUpload = function(){
	$.ajax({
		url: "controlador.php",
		type: "GET",
		data : {"getDepartament": true},
		success : function(data){
			var departaments = $.parseJSON(data);
			showDepartamentsUpload(departaments);
		}
	})	
}
System.prototype.getMunicios = function(departamento){
	$.ajax({
		url: "controlador.php",
		type: "GET",
		data : {"getMunicios": departamento},
		success : function(data){
			var municipios = $.parseJSON(data);
			showMunicipios(municipios);
		}
	})	
}
System.prototype.getMuniciosUpload = function(departamento){
	$.ajax({
		url: "controlador.php",
		type: "GET",
		data : {"getMunicios": departamento},
		success : function(data){
			var municipios = $.parseJSON(data);
			showMunicipiosUpload(municipios);
		}
	})	
}
System.prototype.getReportRegion = function(idReporte,idRegion){
	var reportRegion = {};
	reportRegion.idReporte = idReporte;
	reportRegion.idRegion = idRegion;
	reportRegion = JSON.stringify(reportRegion);
	$.ajax({
		url: "controlador.php",
		type: "POST",
		data : {"getReportRegion": reportRegion},
		success : function(data){
			var report = $.parseJSON(data);
			showReport(report);
		}
	})
}
System.prototype.getReportDepartament = function(idReporte,idDepartamento){
	var reportDepartament = {};
	reportDepartament.idReporte = idReporte;
	reportDepartament.idDepartament = idDepartamento;
	reportDepartament = JSON.stringify(reportDepartament);
	$.ajax({
		url: "controlador.php",
		type: "POST",
		data : {"getReportDepartament": reportDepartament},
		success : function(data){
			var report = $.parseJSON(data);
			showReport(report);
		}
	})
}
System.prototype.getReportMunicipio = function(idReporte,idMunicipio){
	var reportMunicipio = {};
	reportMunicipio.idReporte = idReporte;
	reportMunicipio.idMunicipio = idMunicipio;
	reportMunicipio = JSON.stringify(reportMunicipio);
	$.ajax({
		url: "controlador.php",
		type: "POST",
		data : {"getReportMunicipio": reportMunicipio},
		success : function(data){
			var report = $.parseJSON(data);
			showReport(report);
		}
	})
}

System.prototype.saveReport = function(newReport){
	var _this = this;
	newReport = JSON.stringify(newReport);
	$.ajax({
		url: "controlador.php",
		type: "POST",
		data : {"saveReport": newReport},
		success : function(data){
			if (parseInt(data) == 1)
				alert("Reporte Creado Exitosamente");
				//window.location = "controlador.php?sendRequestReport=true";
			else
				alert("Error al crear el reporte");
		}
	})	
}