<?php
/*
CRUD con SQL Server y PHP
@author parzibyte [parzibyte.me/blog]
@date 2019-06-03

================================
Este archivo guarda los datos del formulario
en donde se editan
================================
*/
?>

<?php

#Salir si alguno de los datos no está presente
if (
    !isset($_POST["ID"]) ||
    !isset($_POST["analista"]) ||
    !isset($_POST["abogado"]) ||
    !isset($_POST["infraestructura"]) ||
    !isset($_POST["direccion_administrativa"]) ||
    !isset($_POST["unidad_ejecutora"]) ||
    !isset($_POST["codigo"]) ||
    !isset($_POST["objeto"]) ||
    !isset($_POST["modalidad"]) ||
    !isset($_POST["hojadeRuta"]) ||
    !isset($_POST["monto"]) ||
    !isset($_POST["plazo"]) ||
    !isset($_POST["convocatoria"]) ||
    !isset($_POST["tipo"]) ||
    !isset($_POST["fecha_tarea"]) ||
    !isset($_POST["fecha_sicoes"]) ||
    !isset($_POST["fecha_apertura"]) ||
    !isset($_POST["estado"]) ||
    !isset($_POST["observaciones"])
) {
    exit();
}

#Si todo va bien, se ejecuta esta parte del código...

include_once "base_de_datos.php";
$ID = $_POST["ID"];
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

$sentencia = $base_de_datos->prepare("UPDATE aplicacionsim.dbo.servicio SET analista='$analista',abogado='$abogado',infraestructura='$infraestructura',direccion_administrativa='$direccion_administrativa',unidad_ejecutora='$unidad_ejecutora',codigo='$codigo',objeto='$objeto',hojadeRuta='$hojadeRuta',monto=$monto,plazo=$plazo,convocatoria='$convocatoria',tipo='$tipo',fecha_tarea='$fecha_tarea',fecha_sicoes='$fecha_sicoes',fecha_apertura='$fecha_apertura',estado='$estado',observaciones='$observaciones' WHERE ID=$ID ;");
$resultado = $sentencia->execute([$ID,$analista,$abogado,$infraestructura,$direccion_administrativa,$unidad_ejecutora,$codigo,$objeto,$hojadeRuta,$monto,$plazo,$convocatoria,$tipo,$fecha_tarea,$fecha_sicoes,$fecha_apertura,$estado,$observaciones]); # Pasar en el mismo orden de los ?
if ($resultado === true) {
    header("Location: listar.php");
} else {
    echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID del usuario";
}