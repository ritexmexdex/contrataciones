USE [SIMCONTRATACIONES]
GO
/****** Object:  StoredProcedure [dbo].[ContarContratos]    Script Date: 30/10/2019 8:56:45 ******/
SET ANSI_NULLS OFF
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[ContarContratos]
AS
  SET NOCOUNT ON;
  	DECLARE @TOTALFINAL INT

	SELECT @TOTALFINAL = count(*)
	FROM SIMCONTRATACIONES.dbo.TblEstadoContratos
	WHERE 
	Estado_TblEstadoContratos=1 
	AND Abm_TblEstadoContratos=3

	SELECT ltrim(rtrim(Proc_Modulo_Contratacion_TblEstadoContratos)) AS name,
	Count(Proc_Modulo_Contratacion_TblEstadoContratos) AS y,
	((Count(Proc_Modulo_Contratacion_TblEstadoContratos) * 100)/@TOTALFINAL) AS z
	FROM SIMCONTRATACIONES.dbo.TblEstadoContratos
	WHERE 
	Estado_TblEstadoContratos=1 
	AND Abm_TblEstadoContratos=3 
	GROUP BY Proc_Modulo_Contratacion_TblEstadoContratos