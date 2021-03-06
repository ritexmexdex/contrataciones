<?php
/*
CRUD con SQL Server y PHP
@author parzibyte [parzibyte.me/blog]
@date 2019-06-03

================================
Este archivo lista todos los
datos de la tabla, pero en un
ciclo usando un cursor, no
a través de un arreglo
(se supone que es más eficiente)
================================
*/
?>
<?php

include_once "base_de_datos.php";
$consulta = "SELECT ID,analista,abogado,infraestructura,direccion_administrativa,unidad_ejecutora,codigo,objeto,modalidad,hojadeRuta,monto,plazo,convocatoria,tipo,fecha_tarea,fecha_sicoes,fecha_apertura,estado,observaciones,estado_sistema FROM aplicacionsim.dbo.servicio where estado_sistema=1";
# Preparar sentencia e indicar que vamos a usar un cursor
$sentencia = $base_de_datos->prepare($consulta, [
    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
# Ejecutar sin parámetros
$sentencia->execute();
# Abajo iteramos
?>

<!--Recordemos que podemos intercambiar HTML y PHP como queramos-->
<?php include_once "encabezado.php" ?>
<div class="row">
<!-- Aquí pon las col-x necesarias, comienza tu contenido, etcétera -->
	<div class="col-12">
		<h1>Listar con cursor</h1>
		<a href="//www.lapaz.bo" target="_blank">GOBIERNO AUTÓNOMO MUNICIPAL DE LA PAZ</a>
		<br>
		<table class="table table-bordered">
			<thead class="thead-dark">
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
					Y aquí usamos el ciclo while y fecthObject, el cuerpo
					del ciclo queda intacto pero ahora estamos usando
					cursores :)
				-->
				<?php while ($mascota = $sentencia->fetchObject()){ ?>
					<tr>
					<td><?php echo $mascota->ID ?></td>
							<td><?php echo $mascota->analista ?></td>
							<td><?php echo $mascota->abogado ?></td>
							<td><?php echo $mascota->infraestructura ?></td>
							<td><?php echo $mascota->direccion_administrativa ?></td>
							<td><?php echo $mascota->unidad_ejecutora ?></td>
							<td><?php echo $mascota->codigo ?></td>
							<td><?php echo $mascota->objeto ?></td>
							<td><?php echo $mascota->modalidad ?></td>
							<td><?php echo $mascota->hojadeRuta ?></td>
							<td><?php echo $mascota->monto ?></td>
							<td><?php echo $mascota->plazo ?></td>
							<td><?php echo $mascota->convocatoria ?></td>
							<td><?php echo $mascota->tipo ?></td>
							<td><?php echo $mascota->fecha_tarea ?></td>
							<td><?php echo $mascota->fecha_sicoes ?></td>
							<td><?php echo $mascota->fecha_apertura ?></td>
							<td><?php echo $mascota->estado ?></td>
							<td><?php echo $mascota->observaciones ?></td>
						<td><a class="btn btn-warning" href="<?php echo "editar.php?ID=" . $mascota->ID?>">Editar 📝</a></td>
							<td><a class="btn btn-danger" href="<?php echo "eliminar.php?ID=" . $mascota->ID?>">Eliminar 🗑️</a></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php include_once "pie.php" ?>