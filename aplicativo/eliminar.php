<?php
/*
CRUD con SQL Server y PHP
@author parzibyte [parzibyte.me/blog]
@date 2019-06-03

================================
Este archivo elimina un dato por ID sin
pedir confirmación. El ID viene de la URL
================================
*/
if (!isset($_GET["ID"])) {
    exit();
}

$ID = $_GET["ID"];
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("UPDATE aplicacionsim.dbo.servicio SET estado_sistema=1 WHERE id=$ID;");
$resultado = $sentencia->execute([$ID]);
if ($resultado === true) {
    header("Location: listar.php");
} else {
    echo "Algo salió mal";
}
