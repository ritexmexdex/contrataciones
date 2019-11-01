<?php
include_once "encabezado.php";
if (!isset($_GET["ID"])) {
    exit();
}
if (!isset($_GET["permiso"])) {
    exit();
}
$var3 = $_GET["permiso"];
$ID = $_GET["ID"];
include_once "base_de_datos.php";
//$sentencia = $base_de_datos->prepare("SELECT ID,analista,abogado,infraestructura,direccion_administrativa,unidad_ejecutora,codigo,objeto,modalidad,hojadeRuta,monto,plazo,convocatoria,tipo,CONVERT(VARCHAR(10), fecha_tarea, 103) as fecha_tarea,CONVERT(VARCHAR(10), fecha_sicoes, 103) as fecha_sicoes,CONVERT(VARCHAR(10), fecha_apertura, 103) as fecha_apertura,estado,observaciones FROM aplicacionsim.dbo.servicio WHERE ID=$ID;");
$sentencia = $base_de_datos->prepare("SELECT a.id_TblEstadoContratos  AS ID 
,a.Id_Proceso_Contratacion AS Id_proceso 
,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_asicaf_TblEstadoContratos) as analista     
,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_asesorcaf_TblEstadoContratos) as abogado 
,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_maxus_TblEstadoContratos) as infraestructura 
,a.nombre_da_TblEstadoContratos as da 
,a.nombre_ue_TblEstadoContratos as ue 
,a.Pmc_Cod_Carp_SIM_TblEstadoContratos as codigo 
,LTRIM(RTRIM(a.Pmc_Desc_Objeto_TblEstadoContratos)) as objeto 
,LTRIM(RTRIM(a.Proc_Modulo_Contratacion_TblEstadoContratos)) as modalidad 
,LTRIM(RTRIM(a.HR_TblEstadoContratos)) as hr 
,a.Pmc_monto_TblEstadoContratos as monto 
,a.plazo_TblEstadoContratos as plazo 
,(select Tip_Conv_Descripcion from TblMENTipoConvocatorias  
inner join TblMENContraProcPrevio 
on TblMENTipoConvocatorias.Id_Tipo_Convocatoria=TblMENContraProcPrevio.Id_Tipo_Convocatoria 
where TblMENContraProcPrevio.Id_Proceso_Contratacion= a.Id_Proceso_Contratacion) as convocatoria 
,(select mod_cont_normativa from TblMENModalidadContratacion 
inner join TblMENContraProcPrevio 
on TblMENModalidadContratacion.Id_Modal_Contratacion = TblMENContraProcPrevio.Id_Modal_Contratacion 
where TblMENContraProcPrevio.Id_Proceso_Contratacion= a.Id_Proceso_Contratacion) as tipo 
,CONVERT(VARCHAR(10), a.fechaTarea_TblEstadoContratos, 103) as fecha_tarea 
,CONVERT(VARCHAR(10), a.sicoes_fecha_doc_TblEstadoContratos, 103) as fecha_sicoes 
,CONVERT(VARCHAR(10), a.fechaAperProp_TblEstadoContratos, 103) as fecha_apertura 
,ltrim(rtrim(estadoProceso_TblEstadoContratos)) as estado
,observaciones_TblEstadoContratos as observaciones 
FROM SIMCONTRATACIONES.dbo.TblEstadoContratos as a 
WHERE a.id_TblEstadoContratos=$ID 
AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CUSTODIA ARCHIVO UGDS' 
AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN REVISION' 
AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'DEVUELTO A LA CAF' 
AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CUSTODIA ARCHIVO UGDS' 
AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'PENDIENTE' 
AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CONSIDERACION'  
AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'APROBADO'  
AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'REMITIDO EN LISTADO Y NO SOLICITADO'  
AND Abm_TblEstadoContratos=3 AND Estado_TblEstadoContratos=1;");
$sentencia->execute([$ID]);
$mascota = $sentencia->fetchObject();
if (!$mascota) {
    #No existe
    echo "¡NO EXISTEN REGISTROS CON ESE CÓDIGO!";
    exit();
}

#Si el registro existe se ejecuta esta parte del código
?>
<div class="row">
	<div class="col-12">
		<h1>Editar</h1>
		<form action="guardarDatosEditados.php" method="POST">
			<input type="hidden" name="ID" value="<?php echo $mascota->ID; ?>">
			<div class="form-group">
				<label for="analista"><strong>ANALISTA:</strong></label>
				<input value="<?php echo $mascota->analista; ?>" required name="analista" type="text" id="analista" placeholder="Responsable analista" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="abogado"><strong>ABOGADO:</strong></label>
				<input value="<?php echo $mascota->abogado; ?>" required name="abogado" type="text" id="abogado" placeholder="Responsable Abogado" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="infraestructura"><strong>INFRAESTRUCTURA:</strong></label>
				<input value="<?php echo $mascota->infraestructura; ?>" required name="infraestructura" type="text" id="infraestructura" placeholder="Responsable infraestructura" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="direccion_administrativa"><strong>DIRECCIÓN ADMINISTRATIVA:</strong></label>
				<input value="<?php echo $mascota->da; ?>" required name="da" type="text" id="da" placeholder="Dirección administrativa" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="unidad_ejecutora"><strong>UNIDAD EJECUTORA:</strong></label>
				<input value="<?php echo $mascota->ue; ?>" required name="ue" type="text" id="ue" placeholder="Unidad ejecutora" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="codigo"><strong>CÓDIGO:</strong></label>
				<input value="<?php echo $mascota->codigo; ?>" required name="codigo" type="text" id="codigo" placeholder="codigo" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="objeto"><strong>OBJETO:</strong></label>
				<input value="<?php echo $mascota->objeto; ?>" required name="objeto" type="text" id="objeto" placeholder="Objeto" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="modalidad"><strong>MODALIDAD:</strong></label>
				<input value="<?php echo $mascota->modalidad; ?>" required name="modalidad" type="text" id="modalidad" placeholder="Modalidad" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="hojadeRuta"><strong>HOJA DE RUTA:</strong></label>
				<input value="<?php echo $mascota->hr; ?>" required name="hr" type="text" id="hr" placeholder="Hoja de ruta" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="monto"><strong>MONTO:</strong></label>
				<input value="<?php echo $mascota->monto; ?>" required name="monto" type="number" id="monto" placeholder="Monto" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="plazo"><strong>PLAZO:</strong></label>
				<input value="<?php echo $mascota->plazo; ?>" required name="plazo" type="text" id="plazo" placeholder="Plazo" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="convocatoria"><strong>CONVOCATORIA:</strong></label>
				<input value="<?php echo $mascota->convocatoria; ?>" required name="convocatoria" type="text" id="convocatoria" placeholder="Convocatoria" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="tipo"><strong>TIPO:</strong></label>
				<input value="<?php echo $mascota->tipo; ?>" required name="tipo" type="text" id="tipo" placeholder="tipo" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="fecha_tarea"><strong>FECHA DE ACTIVIDAD:</strong></label>
				<input value="<?php echo $mascota->fecha_tarea; ?>" required name="fecha_tarea" type="text" id="fecha_tarea" placeholder="Fecha de la actividad" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="fecha_sicoes"><strong>FECHA SICOES:</strong></label>
				<input value="<?php echo $mascota->fecha_sicoes; ?>" required name="fecha_sicoes" type="text" id="fecha_sicoes" placeholder="Fecha en SICOES" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="fecha_apertura"><strong>FECHA APERTURA:</strong></label>
				<input value="<?php echo $mascota->fecha_apertura; ?>" required name="fecha_apertura" type="text" id="fecha_apertura" placeholder="fecha de apertura" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="estado"><strong>ACTIVIDAD ACTUAL:</strong></label>
				<input value="<?php echo $mascota->estado; ?>" required name="estado" type="text" id="estado" placeholder="actividad actual" class="form-control" disabled>
			</div>
			<div class="form-group">
				<label for="observaciones"><strong>OBSERVACIÓN:</strong></label>
				<input value="<?php echo $mascota->observaciones; ?>" required name="observaciones" type="text" id="observaciones" placeholder="Observaciones" class="form-control" disabled>
			</div>
			<p></p>
			<!--<button type="submit" class="btn btn-success">Guardar</button>--> 
			<footer id="footer">
				<a class="button primary" href="<?php echo "./buscar.php?permiso=".$var3; ?>">Volver</a>
			</footer>
		</form>
	</div>
</div>
<?php include_once "pie.php"?>