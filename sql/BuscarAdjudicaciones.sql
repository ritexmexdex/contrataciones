USE [SIMCONTRATACIONES]
GO
/****** Object:  StoredProcedure [dbo].[BuscarAdjudicaciones]    Script Date: 30/10/2019 8:59:39 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		RITA FLORES
-- Create date: 15/10/2019
-- Description:	PROCEDIMIENTO PARA BUSCAR ADJUDICADO EN LAS 3 MODALIDADES ANPE, DIRECTAS, MENORES
-- =============================================
CREATE PROCEDURE [dbo].[BuscarAdjudicaciones] 
	    -- Add the parameters for the stored procedure here
           @PalabraClave VARCHAR(200),
		   @nit decimal(12,0)
AS
BEGIN
		-- SET NOCOUNT ON added to prevent extra result sets from
		-- interfering with SELECT statements.
	SET NOCOUNT ON;
		--SET @PalabraClave='IMPORTADORA DE PRODUCTOS FARMACEUTICOS "ZENITH DIV. L. G."'
		--SET @nit='0'
	IF (@nit<>0)
	BEGIN
          --PARA BUSCAR EN CONTRATACIONES DIRECTAS 
		  SELECT 
		  a1.Id_Proceso_Contratacion AS id
		 ,ltrim(rtrim(a1.Directa_Nombre)) as razon_social
		 ,a1.Directa_NIT AS nit
		 ,a1.Directa_Monto as monto
		 ,CONVERT(VARCHAR(10), a1.Directa_Fecha4, 103) AS fecha_nota
		 ,ltrim(rtrim(b.Pmc_Desc_Objeto)) AS objeto
		 ,ltrim(rtrim(b.Pmc_Cod_Carp_SIM)) AS codigo
		 FROM TblMENDatosDirecta AS a1, TblMENContraProcPrevio AS a, TBLMENPMCMUE AS b
		 WHERE a.Id_PMCM=b.Id_PMCM AND a.tblUnidadEjecutoracod_ue=b.tblUnidadEjecutoracod_ue AND a.Pmc_Nro=b.Pmc_Nro 
		 AND  a1.Id_Proceso_Contratacion=a.Id_Proceso_Contratacion
		 AND a1.Directa_NIT=@nit
		 AND a1.DIRECTA_FECHA4 >'01/01/2019'

	END
	IF (@PalabraClave<>'')
	BEGIN
	      --PARA BUSCAR EN CONTRATACIONES MENORES
		  SELECT 
			   a.Id_Proceso_Contratacion as id 
			  ,ltrim(rtrim(a.PROC_ADJUDICADO_MENOR)) as razon_social
			  ,0 as nit 
			  ,a.PROC_MONTO_MENOR AS monto 
			  ,CONVERT(VARCHAR(10), a.TTblMENContratacion02i_fechaNotaAdj_2018, 103) AS fecha_nota
			  ,ltrim(rtrim(b.Pmc_Desc_Objeto)) AS objeto
			  ,ltrim(rtrim(b.Pmc_Cod_Carp_SIM)) AS codigo
		  FROM TblMENContraProcPrevio AS a, TBLMENPMCMUE AS b
		  WHERE a.Id_PMCM=b.Id_PMCM	AND a.tblUnidadEjecutoracod_ue=b.tblUnidadEjecutoracod_ue AND a.Pmc_Nro=b.Pmc_Nro 
		  AND TTblMENContratacion02i_fechaNotaAdj_2018>'01/01/2019'
		  AND RTRIM(LTRIM(PROC_ADJUDICADO_MENOR)) LIKE '%'+@PalabraClave+'%'
		  UNION
          --PARA BUSCAR EN CONTRATACIONES DIRECTAS 
		  SELECT 
		  a1.Id_Proceso_Contratacion AS id
		 ,ltrim(rtrim(a1.Directa_Nombre)) as razon_social
		 ,a1.Directa_NIT AS nit
		 ,a1.Directa_Monto as monto
		 ,CONVERT(VARCHAR(10), a1.Directa_Fecha4, 103) AS fecha_nota
		 ,ltrim(rtrim(b.Pmc_Desc_Objeto)) AS objeto
		 ,ltrim(rtrim(b.Pmc_Cod_Carp_SIM)) AS codigo
		 FROM TblMENDatosDirecta AS a1, TblMENContraProcPrevio AS a, TBLMENPMCMUE AS b
		 WHERE a.Id_PMCM=b.Id_PMCM AND a.tblUnidadEjecutoracod_ue=b.tblUnidadEjecutoracod_ue AND a.Pmc_Nro=b.Pmc_Nro 
		 AND  a1.Id_Proceso_Contratacion=a.Id_Proceso_Contratacion
		 AND LTRIM(RTRIM(a1.Directa_Nombre)) like '%'+@PalabraClave+'%'
		 AND a1.DIRECTA_FECHA4 >'01/01/2019'
		 UNION
		 --PARA BUSCAR EN CONTRATACIONES DE ANPE 
		 SELECT
		 a1.Id_Proceso_Contratacion AS id
		 ,ltrim(rtrim(a1.Nota_Adj_Nombre)) AS razon_social
		 ,a1.Id_Proponente AS nit
		 ,b.Pmc_Monto AS monto
		 ,CONVERT(VARCHAR(10), a1.Nota_Adj_Fecha, 103) AS fecha_nota
		 ,ltrim(rtrim(b.Pmc_Desc_Objeto)) AS objeto
		 ,ltrim(rtrim(b.Pmc_Cod_Carp_SIM)) AS codigo 
		 FROM TblMENNotaAdjudicacion as a1, TblMENContraProcPrevio AS a, TBLMENPMCMUE AS b
		 WHERE a.Id_PMCM=b.Id_PMCM AND a.tblUnidadEjecutoracod_ue=b.tblUnidadEjecutoracod_ue AND a.Pmc_Nro=b.Pmc_Nro 
		 AND a1.Id_Proceso_Contratacion=a.Id_Proceso_Contratacion 
		 AND LTRIM(RTRIM(a1.Nota_Adj_Nombre)) like '%'+@PalabraClave+'%'
		 AND a1.Nota_Adj_Fecha >'01/01/2019'
	END
END
