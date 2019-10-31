//Initiallising node modules
var express = require("express");
var bodyParser = require("body-parser");
var sql = require("mssql");
var app = express(); 

// Body Parser Middleware
app.use(bodyParser.json()); 

//CORS Middleware
app.use(function (req, res, next) {
    //Enabling CORS 
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, contentType,Content-Type, Accept, Authorization");
    next();
});

//Setting up server
 var server = app.listen(process.env.PORT || 8080, function () {
    var port = server.address().port;
    console.log("App now running on port", port);
 });

//Initiallising connection string
var dbConfig = {
    user: "simmobile",
    password: "dlc0f1c14lsimmovile",
    server: "GMLPSR0058",
    database:"SIMCONTRATACIONES"
};

//Function to connect to database and execute query
var  executeQuery = function(res, query){             
     sql.connect(dbConfig, function (err) {
         if (err) {   
                     console.log("Error while connecting database :- " + err);
                     res.send(err);
                  }
                  else {
                         // create Request object
                         var request = new sql.Request();
                         // query to the database
                         request.query(query, function (err, result) {
                           if (err) {
                                      console.log("Error while querying database :- " + err);
                                      res.send(err);
                                     }
                                     else {
                                       res.send(result);
                                            }
                               });
                       }
      });           
}

//GET API
app.get("/api/user", function(req , res){
                //var texto = "Arbol";
                //texto += " verde";
                var query ="SELECT a.Id_Proceso_Contratacion AS ID ";
                query +=",(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_asicaf_TblEstadoContratos) as analista ";    
                query +=",(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_asesorcaf_TblEstadoContratos) as abogado ";
                query +=",(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_maxus_TblEstadoContratos) as infraestructura ";
                query +=",a.nombre_da_TblEstadoContratos as da ";
                query +=",a.nombre_ue_TblEstadoContratos as ue ";
                query +=",a.Pmc_Cod_Carp_SIM_TblEstadoContratos as codigo ";
                query +=",LTRIM(RTRIM(a.Pmc_Desc_Objeto_TblEstadoContratos)) as objeto ";
                query +=",LTRIM(RTRIM(a.Proc_Modulo_Contratacion_TblEstadoContratos)) as modalidad ";
                query +=",LTRIM(RTRIM(a.HR_TblEstadoContratos)) as hr ";
                query +=",a.Pmc_monto_TblEstadoContratos as monto ";
                query +=",a.plazo_TblEstadoContratos as plazo ";
                query +=",(select Tip_Conv_Descripcion from TblMENTipoConvocatorias "; 
                query +="inner join TblMENContraProcPrevio "; 
                query +="on TblMENTipoConvocatorias.Id_Tipo_Convocatoria=TblMENContraProcPrevio.Id_Tipo_Convocatoria "; 
                query +="where TblMENContraProcPrevio.Id_Proceso_Contratacion= a.Id_Proceso_Contratacion) as convocatoria ";
                query +=",(select mod_cont_normativa from TblMENModalidadContratacion ";
                query +="inner join TblMENContraProcPrevio ";
                query +="on TblMENModalidadContratacion.Id_Modal_Contratacion = TblMENContraProcPrevio.Id_Modal_Contratacion ";
                query +="where TblMENContraProcPrevio.Id_Proceso_Contratacion= a.Id_Proceso_Contratacion) as tipo ";
                query +=",fechaTarea_TblEstadoContratos as fecha_tarea ";
                query +=",sicoes_fecha_doc_TblEstadoContratos as fecha_sicoes ";
                query +=",fechaAperProp_TblEstadoContratos as fecha_apertura "; 
                query +=",ltrim(rtrim(estadoProceso_TblEstadoContratos)) as estado ";
                query +="FROM SIMCONTRATACIONES.dbo.TblEstadoContratos as a ";
                query +="WHERE LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'APOYO NACIONAL A LA PRODUCCIÓN Y EMPLEO (Hasta 200mil Bolivianos)' ";
                query +="AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CUSTODIA ARCHIVO UGDS' ";
                query +="AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN REVISION' ";
                query +="AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'DEVUELTO A LA CAF' ";
                query +="AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CUSTODIA ARCHIVO UGDS' ";
                query +="AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'PENDIENTE' ";
                query +="AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CONSIDERACION' "; 
                query +="AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'APROBADO' "; 
                query +="AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'REMITIDO EN LISTADO Y NO SOLICITADO' "; 
                query +="AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'CONTRATACIÓN MENOR' "; 
                query +="AND Pmc_monto_TblEstadoContratos> 200000 AND Abm_TblEstadoContratos=3 AND Estado_TblEstadoContratos=1 ORDER BY analista DESC ";
                executeQuery (res, query);
               
});

//GET API
app.get("/api/contarcontratos", function(req , res){
  var query = "EXEC SIMCONTRATACIONES.dbo.ContarContratos";
  executeQuery (res, query);
});

//POST API
app.post("/api/buscador/:PalabraClave/:Modalidad", function(req , res){
  var query = "EXEC SIMCONTRATACIONES.dbo.buscarContrato @PalabraClave='" + req.params.PalabraClave + "', @Modalidad='" + req.params.Modalidad + "';";
  executeQuery (res, query);
});


//POST API
app.post("/api/buscarAdjudicaciones/:empresa/:nit", function(req , res){
  var query = "EXEC SIMCONTRATACIONES.dbo.BuscarAdjudicaciones @PalabraClave='" + req.params.empresa + "', @nit='" + req.params.nit + "';";
  executeQuery (res, query);
});


//POST API
app.post("/api/estadistica01/:Modalidad", function(req , res){
    var query ="SELECT nombre_da_TblEstadoContratos as name, Count(nombre_da_TblEstadoContratos) AS y, nombre_da_TblEstadoContratos as drilldown "; 
       query +="FROM SIMCONTRATACIONES.dbo.TblEstadoContratos WHERE Estado_TblEstadoContratos=1 AND Abm_TblEstadoContratos=3 ";
       query +="AND LTRIM(RTRIM(Proc_Modulo_Contratacion_TblEstadoContratos))='" + req.params.Modalidad + "'";
       query +=" GROUP BY nombre_da_TblEstadoContratos; ";
  executeQuery (res, query);
});

//POST API
 app.post("/api/user", function(req , res){
          //SSN-639%2F2019
          var query = "INSERT INTO dbo.servicio (ID, analista ,abogado ,infraestructura ,direccion_administrativa ,unidad_ejecutora ,codigo,objeto,modalidad ,hojadeRuta ,monto ,plazo ,convocatoria ,tipo ,fecha_tarea ,fecha_sicoes ,fecha_apertura ,estado ,observaciones, estado_sistema VALUES (21,'123', 1, 1, 1, '10/20190', 1, 2002, '06/05/2019')";
          executeQuery (res, query);
});

//PUT API
 app.put("/api/user/:id", function(req , res){
                var query = "UPDATE SIMCONTRATACIONES.dbo.tblSolicitudInicioProceso SET nroPreventivo= " + req.body.Name  +  " , idEmpleadoDe=  " + req.body.Email + "  WHERE idSolicitudInicioProceso= " + req.params.id;
                executeQuery (res, query);
});

// DELETE API
 app.delete("/api/user /:id", function(req , res){
                var query = "DELETE FROM SIMCONTRATACIONES.dbo.tblSolicitudInicioProceso WHERE idSolicitudInicioProceso=" + req.params.id;
                executeQuery (res, query);
});