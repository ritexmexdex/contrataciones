<?php
/*
CRUD con SQL Server y PHP
@author parzibyte [parzibyte.me/blog]
@date 2019-06-03

================================
Este archivo muestra un formulario que
se envía a insertar.php, el cual guardará
los datos
================================
*/
?>
<?php include_once "encabezado.php" ?>
<div class="row">
	<div class="col-12">
		<h1>Agregar</h1>
		<form action="insertar.php" method="POST">
			<div class="form-group">
				<label for="ID">ID</label>
				<input required name="ID" type="text" id="ID" placeholder="ID" class="form-control">
			</div>
			<div class="form-group">
				<label for="analista">ANALISTA</label>
				<input required name="analista" type="text" id="analista" placeholder="Responsable analista" class="form-control">
			</div>
			<div class="form-group">
				<label for="abogado">ABOGADO</label>
				<input required name="abogado" type="number" id="abogado" placeholder="Responsable Abogado" class="form-control">
			</div>
			<div class="form-group">
				<label for="infraestructura">INFRAESTRUCTURA</label>
				<input required name="infraestructura" type="text" id="infraestructura" placeholder="Responsable infraestructura" class="form-control">
			</div>
			<div class="form-group">
				<label for="direccion_administrativa">DIRECCIÓN ADMINISTRATIVA</label>
				<input required name="direccion_administrativa" type="number" id="direccion_administrativa" placeholder="Dirección administrativa" class="form-control">
			</div>
			<div class="form-group">
				<label for="unidad_ejecutora">UNIDAD EJECUTORA</label>
				<input required name="unidad_ejecutora" type="text" id="unidad_ejecutora" placeholder="Unidad ejecutora" class="form-control">
			</div>
			<div class="form-group">
				<label for="codigo">CÓDIGO</label>
				<input required name="codigo" type="number" id="codigo" placeholder="codigo" class="form-control">
			</div>
			<div class="form-group">
				<label for="objeto">OBJETO</label>
				<input required name="objeto" type="text" id="objeto" placeholder="Objeto" class="form-control">
			</div>
			<div class="form-group">
				<label for="modalidad">MODALIDAD</label>
				<input required name="modalidad" type="number" id="modalidad" placeholder="Modalidad" class="form-control">
			</div>
			<div class="form-group">
				<label for="hojadeRuta">HOJA DE RUTA</label>
				<input required name="hojadeRuta" type="text" id="hojadeRuta" placeholder="Hoja de ruta" class="form-control">
			</div>
			<div class="form-group">
				<label for="monto">MONTO</label>
				<input required name="monto" type="number" id="monto" placeholder="Monto" class="form-control">
			</div>
			<div class="form-group">
				<label for="plazo">PLAZO</label>
				<input required name="plazo" type="text" id="plazo" placeholder="Plazo" class="form-control">
			</div>
			<div class="form-group">
				<label for="convocatoria">CONVOCATORIA</label>
				<input required name="convocatoria" type="number" id="convocatoria" placeholder="Convocatoria" class="form-control">
			</div>
			<div class="form-group">
				<label for="tipo">TIPO</label>
				<input required name="tipo" type="text" id="tipo" placeholder="tipo" class="form-control">
			</div>
			<div class="form-group">
				<label for="fecha_tarea">FECHA DE ACTIVIDAD</label>
				<input required name="fecha_tarea" type="number" id="fecha_tarea" placeholder="Fecha de la actividad" class="form-control">
			</div>
			<div class="form-group">
				<label for="fecha_sicoes">FECHA SICOES</label>
				<input required name="fecha_sicoes" type="text" id="fecha_sicoes" placeholder="Fecha en SICOES" class="form-control">
			</div>
			<div class="form-group">
				<label for="fecha_apertura">FECHA APERTURA</label>
				<input required name="fecha_apertura" type="number" id="fecha_apertura" placeholder="fecha de apertura" class="form-control">
			</div>
			<div class="form-group">
				<label for="estado">ESTADO</label>
				<input required name="estado" type="text" id="estado" placeholder="actividad actual" class="form-control">
			</div>
			<div class="form-group">
				<label for="observaciones">OBSERVACIÓN</label>
				<input required name="observaciones" type="number" id="observaciones" placeholder="Observaciones" class="form-control">
			</div>
			<button type="submit" class="btn btn-success">Guardar</button>
			<a href="./listar.php" class="btn btn-warning">Ver todas</a>
		</form>
	</div>
</div>
<?php include_once "pie.php" ?>