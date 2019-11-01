<?php
/*// Connection variables
$dbhost	= "localhost";	   // localhost or IP
$dbuser	= "root";		  // database username
$dbpass	= "";		     // database password
$dbname	= "soporte_tecnico";    // database name*/

$serverName = "GMLPSR0058"; //serverName\instanceName
$connectionInfo = array( "Database"=>"SIMCONTRATACIONES", "UID"=>"simmobile", "PWD"=>"dlc0f1c14lsimmovile");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>