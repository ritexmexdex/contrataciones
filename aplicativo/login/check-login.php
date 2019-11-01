<?php
session_start();
?>

<!doctype html>
<html lang="en">
	<head>
		<title>Iniciar sesión</title>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	</head>
	<body>
		<div class="container">
		
			<?php
			// Connection info. file
			include 'conn.php';	
			
			// Connection variables
			$conn = sqlsrv_connect($dbhost, $dbuser, $dbpass, $dbname);

			// Check connection
			if (!$conn) {
				die("Connection failed: " . sqlsrv_connect_error());
			}
			
			// data sent from form login.html 
			$UsrCod = $_POST['UsrCod']; 
			$UsrPwd = $_POST['UsrPwd'];
			
			// Query sent to database
			$result = sqlsrv_query($conn, "SELECT login, clave FROM tblUsuarioSIM WHERE login = '$UsrCod' and rol_evaluacion=1");
			
			// Variable $row hold the result of the query
			$row = sqlsrv_fetch_assoc($result);
			
			// Variable $hash hold the password hash on database
			$hash = $row['clave'];
			
			/* 
			password_Verify() function verify if the password entered by the user
			match the password hash on the database. If everything is OK the session
			is created for one minute. Change 1 on $_SESSION[start] to 5 for a 5 minutes session.
			*/
			if ($_POST['UsrPwd'] = $hash) {	
				
				$_SESSION['loggedin'] = true;
				$_SESSION['login'] = $row['login'];
				$_SESSION['start'] = time();
				$_SESSION['expire'] = $_SESSION['start'] + (1 * 60) ;						
				
				echo "<div class='alert alert-success mt-4' role='alert'><strong>Bienvenid@! </strong> $row[nom_usuario]			
				<p><a href='edit-profile.php'>Modificar Perfil</a></p>	
				<p><a href='logout.php'>Cerrar sesión</a></p></div>";	
			
			} else {
				echo $hash;
				echo $_POST['UsrPwd'];
				echo "<div class='alert alert-danger mt-4' role='alert'>Usuario o cantraseña incorrecta!
				<p><a href='login.html'><strong>Por favor intente de nuevo!</strong></a></p></div>";			
			}	
			?>
		</div>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

	</body>
</html>