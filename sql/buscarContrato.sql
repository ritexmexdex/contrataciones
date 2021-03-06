﻿USE [SIMCONTRATACIONES]
GO
/****** Object:  StoredProcedure [dbo].[buscarContrato]    Script Date: 30/10/2019 8:58:44 ******/
SET ANSI_NULLS OFF
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[buscarContrato]
	@PalabraClave nvarchar(250),
	@Modalidad char(150)
AS
	IF @PalabraClave<>'0' AND LTRIM(RTRIM(@Modalidad))='TODAS'
	BEGIN 
  	  SELECT a.id_TblEstadoContratos  AS ID
	  ,a.Id_Proceso_Contratacion AS Id_proceso
	  ,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_asicaf_TblEstadoContratos) as analista    
	  ,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_asesorcaf_TblEstadoContratos) as abogado
	  ,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_maxus_TblEstadoContratos) as infraestructura
	  ,a.nombre_da_TblEstadoContratos as da
	  ,a.nombre_ue_TblEstadoContratos as ue
	  ,LTRIM(RTRIM(a.Pmc_Cod_Carp_SIM_TblEstadoContratos)) as codigo
	  ,LTRIM(RTRIM(a.Pmc_Desc_Objeto_TblEstadoContratos)) as objeto
	  ,LTRIM(RTRIM(a.Proc_Modulo_Contratacion_TblEstadoContratos)) as modalidad
	  ,LTRIM(RTRIM(a.HR_TblEstadoContratos)) as hr
	  ,a.Pmc_monto_TblEstadoContratos as monto
	  ,a.plazo_TblEstadoContratos as plazo
	  ,(select LTRIM(RTRIM(Tip_Conv_Descripcion)) from TblMENTipoConvocatorias 
	  inner join TblMENContraProcPrevio 
	  on TblMENTipoConvocatorias.Id_Tipo_Convocatoria=TblMENContraProcPrevio.Id_Tipo_Convocatoria 
	  where TblMENContraProcPrevio.Id_Proceso_Contratacion= a.Id_Proceso_Contratacion) as convocatoria
	  ,(select mod_cont_normativa from TblMENModalidadContratacion
	   inner join TblMENContraProcPrevio
	   on TblMENModalidadContratacion.Id_Modal_Contratacion = TblMENContraProcPrevio.Id_Modal_Contratacion
	   where TblMENContraProcPrevio.Id_Proceso_Contratacion= a.Id_Proceso_Contratacion) as tipo
	  ,fechaTarea_TblEstadoContratos as fecha_tarea
	  ,sicoes_fecha_doc_TblEstadoContratos as fecha_sicoes
	  ,fechaAperProp_TblEstadoContratos as fecha_apertura 
	  ,ltrim(rtrim(estadoProceso_TblEstadoContratos)) as estado
	  ,observaciones_TblEstadoContratos as observaciones
	  FROM SIMCONTRATACIONES.dbo.TblEstadoContratos as a
      WHERE LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN REVISION'
	  --AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CUSTODIA ARCHIVO UGDS'
	  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'DEVUELTO A LA CAF'
	  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CUSTODIA ARCHIVO UGDS'
	  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'PENDIENTE'
	  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CONSIDERACION'                                                                                                                                                                                        
	  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'APROBADO'                                                                                                                                                                                                
	  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'REMITIDO EN LISTADO Y NO SOLICITADO'
	  --AND Pmc_monto_TblEstadoContratos> 200000
	  AND Abm_TblEstadoContratos=3
	  AND Estado_TblEstadoContratos=1
	  AND (LTRIM(RTRIM(a.Pmc_Cod_Carp_SIM_TblEstadoContratos)) like '%'+@PalabraClave +'%' OR LTRIM(RTRIM(a.Pmc_Desc_Objeto_TblEstadoContratos)) like '%'+@PalabraClave +'%' or LTRIM(RTRIM(nombre_ue_TblEstadoContratos)) like '%'+@PalabraClave +'%')
  END
  IF @PalabraClave='0' AND LTRIM(RTRIM(@Modalidad))<>'TODAS'
  BEGIN
  		  SELECT a.id_TblEstadoContratos  AS ID
		  ,a.Id_Proceso_Contratacion AS Id_proceso
		  ,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_asicaf_TblEstadoContratos) as analista    
		  ,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_asesorcaf_TblEstadoContratos) as abogado
		  ,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_maxus_TblEstadoContratos) as infraestructura
		  ,a.nombre_da_TblEstadoContratos as da
		  ,a.nombre_ue_TblEstadoContratos as ue
		  ,LTRIM(RTRIM(a.Pmc_Cod_Carp_SIM_TblEstadoContratos)) as codigo
	      ,LTRIM(RTRIM(a.Pmc_Desc_Objeto_TblEstadoContratos)) as objeto
	      ,LTRIM(RTRIM(a.Proc_Modulo_Contratacion_TblEstadoContratos)) as modalidad
	      ,LTRIM(RTRIM(a.HR_TblEstadoContratos)) as hr
	      ,a.Pmc_monto_TblEstadoContratos as monto
	      ,a.plazo_TblEstadoContratos as plazo
	      ,(select LTRIM(RTRIM(Tip_Conv_Descripcion)) from TblMENTipoConvocatorias 
		  inner join TblMENContraProcPrevio 
		  on TblMENTipoConvocatorias.Id_Tipo_Convocatoria=TblMENContraProcPrevio.Id_Tipo_Convocatoria 
		  where TblMENContraProcPrevio.Id_Proceso_Contratacion= a.Id_Proceso_Contratacion) as convocatoria
		  ,(select mod_cont_normativa from TblMENModalidadContratacion
		   inner join TblMENContraProcPrevio
		   on TblMENModalidadContratacion.Id_Modal_Contratacion = TblMENContraProcPrevio.Id_Modal_Contratacion
		   where TblMENContraProcPrevio.Id_Proceso_Contratacion= a.Id_Proceso_Contratacion) as tipo
		  ,fechaTarea_TblEstadoContratos as fecha_tarea
		  ,sicoes_fecha_doc_TblEstadoContratos as fecha_sicoes
		  ,fechaAperProp_TblEstadoContratos as fecha_apertura 
		  ,ltrim(rtrim(estadoProceso_TblEstadoContratos)) as estado
		  ,observaciones_TblEstadoContratos as observaciones
		  FROM SIMCONTRATACIONES.dbo.TblEstadoContratos as a
		  WHERE LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN REVISION'
	      --AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CUSTODIA ARCHIVO UGDS'
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'DEVUELTO A LA CAF'
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CUSTODIA ARCHIVO UGDS'
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'PENDIENTE'
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CONSIDERACION'                                                                                                                                                                                        
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'APROBADO'                                                                                                                                                                                                
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'REMITIDO EN LISTADO Y NO SOLICITADO'
		  --AND Pmc_monto_TblEstadoContratos> 200000
		  AND Abm_TblEstadoContratos=3
		  AND Estado_TblEstadoContratos=1
		  AND LTRIM(RTRIM(Proc_Modulo_Contratacion_TblEstadoContratos)) = @Modalidad
	END
	IF @PalabraClave<>'0' AND LTRIM(RTRIM(@Modalidad))<>'TODAS'
	BEGIN
  		  SELECT a.id_TblEstadoContratos  AS ID
		  ,a.Id_Proceso_Contratacion AS Id_proceso
		  ,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_asicaf_TblEstadoContratos) as analista    
		  ,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_asesorcaf_TblEstadoContratos) as abogado
		  ,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_maxus_TblEstadoContratos) as infraestructura
		  ,a.nombre_da_TblEstadoContratos as da
		  ,a.nombre_ue_TblEstadoContratos as ue
		  ,LTRIM(RTRIM(a.Pmc_Cod_Carp_SIM_TblEstadoContratos)) as codigo
	      ,LTRIM(RTRIM(a.Pmc_Desc_Objeto_TblEstadoContratos)) as objeto
	      ,LTRIM(RTRIM(a.Proc_Modulo_Contratacion_TblEstadoContratos)) as modalidad
	      ,LTRIM(RTRIM(a.HR_TblEstadoContratos)) as hr
	      ,a.Pmc_monto_TblEstadoContratos as monto
	      ,a.plazo_TblEstadoContratos as plazo
	      ,(select LTRIM(RTRIM(Tip_Conv_Descripcion)) from TblMENTipoConvocatorias 
		  inner join TblMENContraProcPrevio 
		  on TblMENTipoConvocatorias.Id_Tipo_Convocatoria=TblMENContraProcPrevio.Id_Tipo_Convocatoria 
		  where TblMENContraProcPrevio.Id_Proceso_Contratacion= a.Id_Proceso_Contratacion) as convocatoria
		  ,(select mod_cont_normativa from TblMENModalidadContratacion
		   inner join TblMENContraProcPrevio
		   on TblMENModalidadContratacion.Id_Modal_Contratacion = TblMENContraProcPrevio.Id_Modal_Contratacion
		   where TblMENContraProcPrevio.Id_Proceso_Contratacion= a.Id_Proceso_Contratacion) as tipo
		  ,fechaTarea_TblEstadoContratos as fecha_tarea
		  ,sicoes_fecha_doc_TblEstadoContratos as fecha_sicoes
		  ,fechaAperProp_TblEstadoContratos as fecha_apertura 
		  ,ltrim(rtrim(estadoProceso_TblEstadoContratos)) as estado
		  ,observaciones_TblEstadoContratos as observaciones
		  FROM SIMCONTRATACIONES.dbo.TblEstadoContratos as a
          WHERE LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN REVISION'
	      --AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CUSTODIA ARCHIVO UGDS'
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'DEVUELTO A LA CAF'
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CUSTODIA ARCHIVO UGDS'
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'PENDIENTE'
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CONSIDERACION'                                                                                                                                                                                        
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'APROBADO'                                                                                                                                                                                                
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'REMITIDO EN LISTADO Y NO SOLICITADO'
		  --AND Pmc_monto_TblEstadoContratos> 200000
		  AND Abm_TblEstadoContratos=3
		  AND Estado_TblEstadoContratos=1
		  AND LTRIM(RTRIM(Proc_Modulo_Contratacion_TblEstadoContratos)) = @Modalidad
	      AND (LTRIM(RTRIM(a.Pmc_Cod_Carp_SIM_TblEstadoContratos)) like '%'+@PalabraClave +'%' OR LTRIM(RTRIM(a.Pmc_Desc_Objeto_TblEstadoContratos)) like '%'+@PalabraClave +'%' or LTRIM(RTRIM(nombre_ue_TblEstadoContratos)) like '%'+@PalabraClave +'%')
	END
	IF @PalabraClave='0' AND LTRIM(RTRIM(@Modalidad))='TODAS'
	BEGIN
  		   SELECT a.id_TblEstadoContratos  AS ID
		  ,a.Id_Proceso_Contratacion AS Id_proceso
		  ,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_asicaf_TblEstadoContratos) as analista    
		  ,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_asesorcaf_TblEstadoContratos) as abogado
		  ,(select (ltrim(rtrim(nombre_Emp)) + ' ' + ltrim(rtrim(apellidoP_Emp)) + ' ' + ltrim(rtrim(apellidoM_Emp))) from tblDLCEmpleado where idEmpleado=a.idempleado_maxus_TblEstadoContratos) as infraestructura
		  ,a.nombre_da_TblEstadoContratos as da
		  ,a.nombre_ue_TblEstadoContratos as ue
	      ,LTRIM(RTRIM(a.Pmc_Cod_Carp_SIM_TblEstadoContratos)) as codigo
	      ,LTRIM(RTRIM(a.Pmc_Desc_Objeto_TblEstadoContratos)) as objeto
	      ,LTRIM(RTRIM(a.Proc_Modulo_Contratacion_TblEstadoContratos)) as modalidad
	      ,LTRIM(RTRIM(a.HR_TblEstadoContratos)) as hr
	      ,a.Pmc_monto_TblEstadoContratos as monto
	      ,a.plazo_TblEstadoContratos as plazo
	      ,(select LTRIM(RTRIM(Tip_Conv_Descripcion)) from TblMENTipoConvocatorias 
		  inner join TblMENContraProcPrevio 
		  on TblMENTipoConvocatorias.Id_Tipo_Convocatoria=TblMENContraProcPrevio.Id_Tipo_Convocatoria 
		  where TblMENContraProcPrevio.Id_Proceso_Contratacion= a.Id_Proceso_Contratacion) as convocatoria
		  ,(select mod_cont_normativa from TblMENModalidadContratacion
		   inner join TblMENContraProcPrevio
		   on TblMENModalidadContratacion.Id_Modal_Contratacion = TblMENContraProcPrevio.Id_Modal_Contratacion
		   where TblMENContraProcPrevio.Id_Proceso_Contratacion= a.Id_Proceso_Contratacion) as tipo
		  ,fechaTarea_TblEstadoContratos as fecha_tarea
		  ,sicoes_fecha_doc_TblEstadoContratos as fecha_sicoes
		  ,fechaAperProp_TblEstadoContratos as fecha_apertura 
		  ,ltrim(rtrim(estadoProceso_TblEstadoContratos)) as estado
		  ,observaciones_TblEstadoContratos as observaciones
		  FROM SIMCONTRATACIONES.dbo.TblEstadoContratos as a
          WHERE LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN REVISION'
	      --AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CUSTODIA ARCHIVO UGDS'
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'DEVUELTO A LA CAF'
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CUSTODIA ARCHIVO UGDS'
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'PENDIENTE'
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'EN CONSIDERACION'                                                                                                                                                                                        
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'APROBADO'                                                                                                                                                                                                
		  AND LTRIM(RTRIM(estadoProceso_TblEstadoContratos)) <> 'REMITIDO EN LISTADO Y NO SOLICITADO'
		  --AND Pmc_monto_TblEstadoContratos> 200000
		  AND Abm_TblEstadoContratos=3
		  AND Estado_TblEstadoContratos=1
	 END
