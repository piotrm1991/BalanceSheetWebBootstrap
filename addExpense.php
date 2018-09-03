<?php
session_start();

if (!isset($_SESSION['logged_id']))
{
	header('Location: index.php');
	exit();
}
unset($_SESSION['amount']);
unset($_SESSION['date']); 
unset($_SESSION['payment']);
unset($_SESSION['category']); 
unset($_SESSION['comment']); 
	
unset($_SESSION['saveExpense']);

unset($_SESSION['e_amount']);
unset($_SESSION['e_date']);
unset($_SESSION['e_payment']);
unset($_SESSION['e_category']);
unset($_SESSION['e_comment']);

if (isset($_POST['date']))
{
	$expense_OK = true;
	
	//Amount
	if (($_POST['amount'])==NULL)
	{
		$expense_OK = false;
		$_SESSION['e_amount'] = "Musisz podać kwotę!";
	}
	
	//Date
	if ($_POST['date'] == NULL)
	{
		$expense_OK = false;
		$_SESSION['e_date'] = "Podaj poprawną datę!";
	}
	//Payment
	if (!isset($_POST['payment']))
	{
		$expense_OK = false;
		$_SESSION['e_payment'] = "Musisz wybrać sposób płatności!";
	}
	
	//Category
	if (!isset($_POST['category']))
	{
		$expense_OK = false;
		$_SESSION['e_category'] = "Musisz wybrać kategorię!";
	}
	
	//Comment
	if (isset($_POST['comment']))
	{
		$comment = $_POST['comment'];
		if (strlen($comment)>100)
		{
			$expense_OK = false;
			$_SESSION['e_comment'] = "Komentarz może zawierać nie więcej niż 100 znaków!";
		}
	}
	
	//OK
	if ($expense_OK == true)
	{
		unset($_SESSION['e_amount']);
		unset($_SESSION['e_date']);
		unset($_SESSION['e_payment']);
		unset($_SESSION['e_category']);
		unset($_SESSION['e_comment']);
		
		$_SESSION['amount'] = $_POST['amount'];
		$_SESSION['date'] = $_POST['date'];
		$_SESSION['payment'] = $_POST['payment'];
		$_SESSION['category'] = $_POST['category'];
		$_SESSION['comment'] = $_POST['comment'];
		
		$_SESSION['saveExpense'] = true;
		
		header('Location: saveExpense.php');
	}
}
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
			<?php
			
			$page = 'addExpense';
			require_once "navigation.php";

			?>
			<section class="main-container">
				<section class="addExpense">
					<h3 class="addExpenseHeader">Dodaj nowy wydatek</h3>
					<form class="form" method="POST">
						<div class="row">
							<div class="col-sm-2">
								<div class="form-group">
									<label for="amount">Kwota:</label>
									<input name="amount" type="number" placeholder="0,0" onfocus="this.placeholder=''" onblur="this.placeholder='0,0'" step="0.01" class="form-control">
								</div>
								<?php
									if (isset($_SESSION['e_amount']))
									{
										echo '<div class="error">'.$_SESSION['e_amount'].'</div>';
										unset($_SESSION['e_amount']);
									}
								?>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label for="date">Data:</label>
									<input name="date" id="datePicker" type="date" class="form-control">
								</div>
								<?php
									if (isset($_SESSION['e_date']))
									{
										echo '<div class="error">'.$_SESSION['e_date'].'</div>';
										unset($_SESSION['e_date']);
									}
								?>
							</div>
							<div class="col-sm-8">
								<div class="form-group">
									<label>Sposób płatności:</label>
									<div class="radio">
										<label class="radio-inline"><input type="radio" name="payment" value="Cash" >Gotówka</label>
										<label class="radio-inline"><input type="radio" name="payment" value="Debit Card" >Karta debetowa</label>
										<label class="radio-inline"><input type="radio" name="payment" value="Credit Card" >Karta kredytowa</label>
									</div>
								</div>
								<?php
									if (isset($_SESSION['e_payment']))
									{
										echo '<div class="error">'.$_SESSION['e_payment'].'</div>';
										unset($_SESSION['e_payment']);
									}
								?>
							</div>
						</div>
						<div class="form-group">
							<label for="radio">Kategoria:</label>
							<div class="radio">
								<div class="row">
									<div class="col-sm-4">
										<label class="radio"><input type="radio" name="category" value="Food" >Jedzenia</label>
										<label class="radio"><input type="radio" name="category" value="Apartments" >Mieszkanie</label>
										<label class="radio"><input type="radio" name="category" value="Transport" >Transport</label>
										<label class="radio"><input type="radio" name="category" value="Health" >Opieka zdrowotna</label>
										<label class="radio"><input type="radio" name="category" value="Clothes" >Ubranie</label>
									</div>
									<div class="col-sm-4">
										<label class="radio"><input type="radio" name="category" value="Hygiene" >Higiena</label>
										<label class="radio"><input type="radio" name="category" value="Kids" >Dzieci</label>
										<label class="radio"><input type="radio" name="category" value="Recreation" >Rozrywka</label>
										<label class="radio"><input type="radio" name="category" value="Trip" >Wycieczka</label>
										<label class="radio"><input type="radio" name="category" value="Training" >Szkolenie</label>
									</div>
									<div class="col-sm-4">
										<label class="radio"><input type="radio" name="category" value="Books" >Książki</label>
										<label class="radio"><input type="radio" name="category" value="Savings" >Oszczędności</label>
										<label class="radio"><input type="radio" name="category" value="For Retirement" >Emerytura</label>
										<label class="radio"><input type="radio" name="category" value="Debt Repayment" >Długi</label>
										<label class="radio"><input type="radio" name="category" value="Gift" >Prezent</label>
									</div>
								</div>
								<label class="radio"><input type="radio" name="category" value="Another" >Inne wydatki</label>
							</div>
						</div>
						<?php
							if (isset($_SESSION['e_category']))
							{
								echo '<div class="error">'.$_SESSION['e_category'].'</div>';
								unset($_SESSION['e_category']);
							}
						?>
						<div class="form-group">
							<label for="comment">Komentarz (opcjonalnie):</label>
							<textarea class="form-control" rows="1" name="comment" id="comment"></textarea>
						</div>
						<?php
							if (isset($_SESSION['e_comment']))
							{
								echo '<div class="error">'.$_SESSION['e_comment'].'</div>';
								unset($_SESSION['e_comment']);
							}
						?>
						<button class="btn btn-default btn-sm btn-block" name="addExpenseButton" id="addExpenseButton" >Dodaj</button>
					</form>
				</section>
			</section>
		</div>
	</main>
	<script>document.getElementById('datePicker').valueAsDate = new Date();</script>
</body>
</html>