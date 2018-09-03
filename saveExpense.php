<?php
session_start();

if (!isset($_SESSION['logged_id']))
{
	header('Location: index.php');
	exit();
}

if (!isset($_SESSION['saveExpense']))
{
	header('Location: mainMenu.php');
	exit();
}

require_once 'categories.php';

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
	<script src="javascript.js"></script>
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
			<?php
			
			$page = 'addExpense';
			require_once "navigation.php";

			?>
			<section class="main-container">
				<section class="addExpense">
					<h3 class="addExpenseHeader">Dodaj nowy wydatek</h3>
					<div class="row">
						<div class="col-sm-4">
							<label>Kwota:</label>
							<?php echo ' '.$_SESSION['amount'].' zł'; ?>
						</div>
						<div class="col-sm-4">
							<label>Data:</label>
							<?php echo ' '.$_SESSION['date']; ?>
						</div>
						<div class="col-sm-4">
							<label>Sposób płatności:</label>
							<?php
							foreach ($paymentMethods as $name=>$name_meaning)
							{
								if ($name == $_SESSION['payment'])
								{
									echo $name_meaning;
									break;
								}
							}
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label for="radio">Kategoria:</label>
							<?php
							foreach ($expenseCategory as $name=>$name_meaning)
							{
								if ($name == $_SESSION['category'])
								{
									echo $name_meaning;
									break;
								}
							}
							?>
						</div>
						<div class="col-sm-6">
							<label for="comment">Komentarz:</label>
							<?php echo ' '.$_SESSION['comment']; ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<form action="cancel.php">
								<button class="btn btn-default btn-sm btn-block" name="addExpenseButton" id="saveExpenseButton" >Anuluj</button>
							</form>
						</div>
						<div class="col-sm-6">
							<form action="save.php">
								<button class="btn btn-default btn-sm btn-block" name="addExpenseButton" id="saveExpenseButton" >Zapisz</button>
							</form>
						</div>
					</div>
				</section>
			</section>
		</div>
	</main>
	<script>document.getElementById('datePicker').valueAsDate = new Date();</script>
</body>
</html>