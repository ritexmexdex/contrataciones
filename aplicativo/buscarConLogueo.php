<?php
include_once "encabezado.php";
include_once "base_de_datos.php";
if (!isset($_GET["permiso"])) {
    exit();
}
if(!empty($_POST))
{
	$var3 = $_GET["permiso"];
	$PalabraClave = $_POST["PalabraClave"];
	$modalidad = $_POST["modalidad"];
	if (!isset($_POST["PalabraClave"])) {
		//$sentencia = $base_de_datos->prepare("SELECT ID,analista,abogado,infraestructura,direccion_administrativa,unidad_ejecutora,codigo,objeto,modalidad,hojadeRuta,monto,plazo,convocatoria,tipo,fecha_tarea,fecha_sicoes,fecha_apertura,estado,observaciones FROM aplicacionsim.dbo.servicio WHERE (codigo like '%$PalabraClave%' or objeto like '%$PalabraClave%' or  unidad_ejecutora like '%$PalabraClave%' or analista like '%$PalabraClave%') AND LTRIM(RTRIM(modalidad))='$modalidad';");
		$sentencia = $base_de_datos->prepare("EXEC SIMCONTRATACIONES.dbo.buscarContrato @PalabraClave='0', @Modalidad='$modalidad';");
		$sentencia->execute(array($PalabraClave,$modalidad));
	}
	else
	{	$sentencia = $base_de_datos->prepare("EXEC SIMCONTRATACIONES.dbo.buscarContrato @PalabraClave='$PalabraClave', @Modalidad='$modalidad';");
		$sentencia->execute(array($PalabraClave,$modalidad));
	}
 }
else
{
	//$sentencia = $base_de_datos->prepare("SELECT ID,analista,abogado,infraestructura,direccion_administrativa,unidad_ejecutora,codigo,objeto,modalidad,hojadeRuta,monto,plazo,convocatoria,tipo,fecha_tarea,fecha_sicoes,fecha_apertura,estado,observaciones FROM aplicacionsim.dbo.servicio WHERE estado_sistema=1;");
	$sentencia = $base_de_datos->prepare("EXEC SIMCONTRATACIONES.dbo.buscarContrato @PalabraClave='0', @Modalidad='TODAS';");
}
$mascotas = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>
<!-- Main -->
<article id="main">
<header class="special container">
<span class="icon solid fa-search"></span>
</header>
<!-- One -->
<section class="wrapper style4 special container medium">
<!-- Content -->
  <div class="content">
<ul class="list-group">
  <li class="list-group-item">
<form method="post">
  <div class="form-row align-items-center">
    <div class="col-auto">
      <input name="PalabraClave" type="text" class="form-control mb-2" id="PalabraClave" placeholder="Código, Objeto, unidad ejecutora, analista">
	  <p>
			<div class="box">
				<select name="modalidad" id="modalidad">
					<option value="TODAS">TODAS</option>
					<option value="APOYO NACIONAL A LA PRODUCCIÓN Y EMPLEO">APOYO NACIONAL A LA PRODUCCIÓN Y EMPLEO</option>
					<option value="CONTRATACION DIRECTA">CONTRATACION DIRECTA</option>
					<option value="LICITACION PUBLICA NACIONAL">LICITACION PUBLICA NACIONAL</option>
				</select>
			</div>
			</p>
	</div>
	<p></p>
    <div class="col-auto">
	  <button type="submit" class="button primary">Buscar</button>
	</div>
  </div>
</form>
  </li>

</ul>
</div>

</section>
<!--Recordemos que podemos intercambiar HTML y PHP como queramos-->

<div class="row">
<!-- Aquí pon las col-x necesarias, comienza tu contenido, etcétera -->
	<div class="col-12">
		<div class="table-responsive">
			<table class="tablaPrecios">
				<thead>
					<tr>
						<th>ID</th>
						<th>ANALISTA</th>
						<th>ABOGADO</th>
						<th>INFRAESTRUCTURA</th>
						<th>DIRECCION ADMINISTRATIVA</th>
						<th>UNIDAD EJECUTORA</th>
						<th>CODIGO</th>
						<th>OBJETO</th>
						<th>MODALIDAD</th>
						<th>HOJA DE RUTA</th>
						<th>MONTO</th>
						<th>PLAZO</th>
						<th>CONVOCATORIA</th>
						<th>TIPO</th>
						<th>FECHA ACTIVIDAD</th>
						<th>FECHA SICOES</th>
						<th>FECHA APERTURA</th>
						<th>ESTADO</th>
						<th>OBSERVACIONES</th>
						<th>EDITAR</th>
						<th>ELIMINAR</th>
					</tr>
				</thead>
				<tbody>
					<!--
					Atención aquí, sólo esto cambiará
					Pd: no ignores las llaves de inicio y cierre {}
					-->
					<?php foreach($mascotas as $mascota){ ?>
						<tr>
							<td style="display:none;"><strong>ID:</strong> <?php echo $mascota->ID ?></td>
							<td style="display:none;"><strong>ANALISTA:</strong> <?php echo $mascota->analista ?></td>
							<td style="display:none;"><strong>ABOGADO:</strong> <?php echo $mascota->abogado ?></td>
							<td style="display:none;"><strong>INFRAESTRUCTURA:</strong> <?php echo $mascota->infraestructura ?></td>
							<td style="display:none;"><strong>DIRECCIÓN ADMINISTRATIVA:</strong> <?php echo $mascota->da ?></td>
							<td ><strong>CODIGO:</strong> <?php echo $mascota->codigo ?></td>
							<td ><strong>OBJETO:</strong> <?php echo $mascota->objeto ?></td>
							<td ><strong>UNIDAD EJECUTORA:</strong> <?php echo $mascota->ue ?></td>
							<td style="display:none;"><strong>MODALIDAD:</strong> <?php echo $mascota->modalidad ?></td>
							<td style="display:none;"><strong>HOJA DE RUTA:</strong> <?php echo $mascota->hojadeRuta ?></td>
							<td style="display:none;"><strong>MONTO:</strong> <?php echo $mascota->monto ?></td>
							<td style="display:none;"><strong>PLAZO:</strong> <?php echo $mascota->plazo ?></td>
							<td style="display:none;"><strong>CONVOCATORIA:</strong> <?php echo $mascota->convocatoria ?></td>
							<td style="display:none;"><strong>TIPO:</strong> <?php echo $mascota->tipo ?></td>
							<td style="display:none;"><strong>FECHA ACCIÓN:</strong> <?php echo $mascota->fecha_tarea ?></td>
							<td style="display:none;"><strong>FECHA EN SICOES:</strong> <?php echo $mascota->fecha_sicoes ?></td>
							<td style="display:none;"><strong>FECHA APERTURA:</strong> <?php echo $mascota->fecha_apertura ?></td>
							<td><strong>ACTIVIDAD ACTUAL:</strong> <?php echo $mascota->estado ?></td>
							<td><strong>OBSERVACIÓN:</strong> <?php echo $mascota->observaciones ?></td>
							<td><a class="button primary" href="<?php echo "editar.php?ID=".$mascota->ID."&permiso=".$var3;?>">Más detalles 📝</a></td>
							
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php include_once "pie.php" ?>