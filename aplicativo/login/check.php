<?php
session_start();
include_once "../encabezado.php";
if (!isset($_POST["UsrCod"])) {
    exit();
}

$UsrCod = $_POST["UsrCod"];
$UsrPwd = $_POST["UsrPwd"];
include_once "../base_de_datos.php";
//$sentencia = $base_de_datos->prepare("SELECT email, permiso FROM aplicacionsim.dbo.usuarios WHERE usuario = '$UsrCod' AND LTRIM(RTRIM(pasword)) = '$UsrPwd' AND estado=1;");
$sentencia = $base_de_datos->prepare("SELECT login, clave FROM tblUsuarioSIM WHERE login = '$UsrCod'  AND LTRIM(RTRIM(clave)) = '$UsrPwd' and rol_evaluacion=1;");
$sentencia->execute([$UsrCod, $UsrPwd]);
$mascota = $sentencia->fetchObject();
if (!$mascota) {
    #No existe
    echo "¡NO EXISTEN REGISTROS CON ESE CÓDIGO!";
    exit();
}
else{
    if($mascota->permiso = 1)
    {
    header("Status: 301 Moved Permanently");
    header("Location: ../buscar.php?permiso=".$mascota->permiso);
    exit;
    }
    if($mascota->permiso = 2)
    {
    header("Status: 301 Moved Permanently");
    header("Location: ../buscar2.php?permiso=".$mascota->permiso);
    exit;
    }
    if($mascota->permiso = 3)
    {
    header("Status: 301 Moved Permanently");
    header("Location: ../buscar3.php?permiso=".$mascota->permiso);
    exit;
    }
}
#Si el registro existe se ejecuta esta parte del código
?>

<?php include_once "../pie.php"?>