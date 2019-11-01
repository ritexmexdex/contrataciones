<?php
/*$opciones = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n"
  )
);
$contexto = stream_context_create($opciones);
$fichero = file_get_contents('http://localhost:8080/api/user', false, $contexto);
$rest = substr($fichero, 1, -1);
echo $rest;*/
$url = "http://localhost:8080/api/user";
 
$client = curl_init($url);
curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
$response = curl_exec($client);

$result = json_decode($response);
$rest = substr($result, 1, -1);
$ajson = json_encode($rest);
$desjson = json_decode($rest);
?>