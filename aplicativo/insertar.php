<?php
/*
CRUD con SQL Server y PHP
@author parzibyte [parzibyte.me/blog]
@date 2019-06-03

================================
Este archivo inserta los datos 
enviados a través de formulario.php
================================
*/
?>
<?php
#Salir si alguno de los datos no está presente
if (!isset($_POST["ID"]) || !isset($_POST["unidad_ejecutora"])) {
    exit();
}

#Si todo va bien, se ejecuta esta parte del código...

include_once "base_de_datos.php";
$analista = $_POST["analista"];
$abogado = $_POST["abogado"];
$infraestructura = $_POST["infraestructura"];
$direccion_administrativa = $_POST["direccion_administrativa"];
$unidad_ejecutora = $_POST["unidad_ejecutora"];
$codigo = $_POST["codigo"];
$objeto = $_POST["objeto"];
$hojadeRuta = $_POST["hojadeRuta"];
$monto = $_POST["monto"];
$plazo = $_POST["plazo"];
$convocatoria = $_POST["convocatoria"];
$tipo = $_POST["tipo"];
$fecha_tarea = $_POST["fecha_tarea"];
$fecha_sicoes = $_POST["fecha_sicoes"];
$fecha_apertura = $_POST["fecha_apertura"];
$estado = $_POST["estado"];
$observaciones = $_POST["observaciones"];
/*
Al incluir el archivo "base_de_datos.php", todas sus variables están
a nuestra disposición. Por lo que podemos acceder a ellas tal como si hubiéramos
copiado y pegado el código
 */
$sentencia = $base_de_datos->prepare("INSERT INTO aplicacionsim.dbo.servicio(SELECT ID,analista,abogado,infraestructura,direccion_administrativa,unidad_ejecutora,codigo,objeto,modalidad,hojadeRuta,monto,plazo,convocatoria,tipo,fecha_tarea,fecha_sicoes,fecha_apertura,estado,observaciones, estado_sistema) VALUES ( $ID,'$analista','$abogado','$infraestructura','$direccion_administrativa','$unidad_ejecutora','$codigo','$objeto','$modalidad','$hojadeRuta',$monto,'$plazo','$convocatoria','$tipo',NOW(),'$fecha_sicoes','$fecha_apertura','$estado','$observaciones',1);");
$resultado = $sentencia->execute([$ID,$analista,$abogado,$infraestructura,$direccion_administrativa,$unidad_ejecutora,$codigo,$objeto,$hojadeRuta,$monto,$plazo,$convocatoria,$tipo,$fecha_tarea,$fecha_sicoes,$fecha_apertura,$estado,$observaciones]); # Pasar en el mismo orden de los ?

#execute regresa un booleano. True en caso de que todo vaya bien, falso en caso contrario.
#Con eso podemos evaluar

if ($resultado === true) {
    # Redireccionar a la lista
	header("Location: listar.php");
} else {
    echo "Algo salió mal. Por favor verifica que la tabla exista";
}
