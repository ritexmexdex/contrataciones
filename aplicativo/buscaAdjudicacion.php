<?php
include_once "encabezado.php";
?>
<!-- Main -->
<article id="main">
<header class="special container">
<span class="icon solid fa-search"></span>
<h2>Revise si su empresa está considerada en una adjudicación.</h2>
<p>Busque introduciendo NIT o la razón social o el representante legal</p>
</header>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<!-- One -->
<section class="wrapper style4 special container medium">
<!-- Content -->
  <div class="content">
   <ul class="list-group">
  <li class="list-group-item">
  <div class="form-row align-items-center">
    <div class="col-auto">
      <input name="empresa" id="empresa" type="text" class="form-control mb-2" id="PalabraClave" placeholder="Nombre del representante legal, razón social, nombre de la empresa">
	  <input name="nit" id="nit" type="text" class="form-control mb-2" id="PalabraClave" placeholder="Número de NIT">
	</div>
	<p></p>
    <div class="col-auto">
	  <button type="button" class="special" name="buscar" id="buscar">Buscar</button>
	</div>
  </div>
  </li>
</ul>
</div>
</section>
<div class="row">
	<div class="col-12">
		<div class="table-responsive">
		<table class="tablaPrecios" name="Tablita" id="Tablita"></table>
		</div>
	</div>
</div>
<?php include_once "pie.php" ?>
<script type="text/javascript">
$("#buscar").on("click", function(){
		ClearDoc ();
		var empresa = $("#empresa").val();
		var nit = $("#nit").val();
		if (nit == "") {
			var nit = 0;
		} 
    $.ajax({
        url:"http://localhost:8080/api/buscarAdjudicaciones/"+empresa+"/"+nit+"",
        method: "POST"
    }).then(function(data) {
        for (var i = 0; i < data.length; i++) {
			$("#Tablita").append('<tr>' + 
									'<td align="center"><b>CÓDIGO: </b>' + data[i].id + '</td>'+
									'<td align="center"><b>RAZÓN SOCIAL: </b>' + data[i].razon_social + '</td>'+
									'<td align="center"><b>IDENTIFICACIÓN DE PROPONENTE: </b>' + data[i].nit + '</td>'+
									'<td align="center"><b>MONTO: </b>' + data[i].monto + '</td>'+
									'<td align="center"><b>FECHA: </b>' + data[i].fecha_nota + '</td>'+
									'<td align="center"><b>OBJETO: </b>' + data[i].objeto + '</td>'+
									'<td align="center"><b>CÓDOGO DE CARPETA: </b>' + data[i].codigo + '</td>'+'</tr>');
    }
});
});

function ClearDoc () {
	document.getElementById("Tablita").innerHTML="";
        }
</script>