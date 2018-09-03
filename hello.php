<?php
session_start();

if (isset($_SESSION['logged_id'])) {
	header('Location: mainMenu.php');
	exit();
}

if (!isset($_SESSION['registrationCompleted']))
{
	header('Location: index.php');
	exit();
}
else
{
	unset($_SESSION['registrationCompleted']);
}

unset($_SESSION['e_user']);
unset($_SESSION['e_pass1']);
unset($_SESSION['e_pass2']);
unset($_SESSION['e_email1']);
unset($_SESSION['e_email2']);

unset($_SESSION['fr_user']);
unset($_SESSION['fr_pass1']);
unset($_SESSION['fr_pass2']);
unset($_SESSION['fr_email1']);
unset($_SESSION['fr_email2']);

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>Bilans Wydatków</title>
	<meta name="description" content="Bilans wydatków. Oszczędzaj poprzez kontrolę swoich wydatków." />
	<meta name="keywords" content="bilans, wydatki, oszczędzanie, pieniądze" />
	<meta http-equiv="X-UA-Copmatible" content="IE=edge,chrome=1"/>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" type="text/css" href="style.css" >
	
	<link href="https://fonts.googleapis.com/css?family=Knewave|Work+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
</head>
<body>	
	<header>
		<article class="index-intro">
			<div class="container">
				<div class="jumbotron">
					<div class="row">
						<div class="col-sm-8">
							<h1>Bilans</h1>
							<p>Oszczędzaj kontrolując swoje wydatki</p>
						</div>
						<div class="col-sm-4"></div>
					</div>
				</div>
			</div>
		</article>
	</header>
	<main>	
		<div class="container">
			<section class="main-container">
				<div class="row">
					<div class="col-sm-4"></div>
					<div class="col-sm-4">
						<article class="index-form">
							<h1>Nowe konto zostało utworzone!</h1>
							<form method="POST" action="index.php">
								<button class="btn btn-default btn-sm btn-block" name="logIn" id="logIn" >Zaloguj się na nowe konto</button>
							</form>
							
						</article>
					</div>
					<div class="col-sm-4"></div>
				</div>
			</section>
		</div>
	</main>
</body>
</html>