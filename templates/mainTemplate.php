<?php if(!isset($portal)) exit(); ?>
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
	
	<link rel="stylesheet" type="text/css" href="css/theme.min.css" >

	<link rel="stylesheet" type="text/css" href="css/style.css" >
	
	<link href="https://fonts.googleapis.com/css?family=Charmonman:400,700|Mukta&amp;subset=latin-ext" rel="stylesheet">

	<?php if ($action == 'showRegistrationForm'): ?>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<?php endif; ?>
	<?php if ($action == 'showBalanceThisMonth' || $action == 'showBalanceLastMonth' || $action == 'showBalanceThisYear' || $action == 'showBalanceChoosenDate'): ?>
	<script src='https://www.gstatic.com/charts/loader.js'></script>
	<?php endif; ?>
</head>
<body>
	<?php if ($portal->loggedIN) include 'templates/navigation.php'; ?>
	<main>	
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<?php if (isset($_SESSION['warning'])): ?>
				<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><?=$_SESSION['warning'];?></strong>
				</div>
				<?php unset($_SESSION['warning']); ?>
				<?php elseif(isset($_SESSION['success'])): ?>
				<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><?=$_SESSION['success'];?></strong>
				</div>
				<?php unset($_SESSION['success']); ?>
				<?php endif; ?>
			</div>
			<div class="col-sm-4"></div>
		</div>
		<?php
		switch ($action) :
		    case 'showStart':
			    $portal->showStart();
				break;
			case 'showLoginForm':
			    include 'templates/loginForm.php';
				break;
			case 'showRegistrationForm':
			    $portal->showRegistrationForm();
				break;
			case 'showBalanceThisMonth':
			    $portal->showBalanceThisMonth();
				break;
			case 'showBalanceThisYear':
			    $portal->showBalanceThisYear();
				break;
			case 'showBalanceLastMonth':
			    $portal->showBalanceLastMonth();
				break;
			case 'showBalanceChoosenDate':
			    $portal->showBalanceChoosenDate();
				break;
			case 'showSettings':
			    $portal->showSettings();
				break;
            case 'showMain':
            default:
                include 'templates/main.php';
        endswitch;
		?>
	</main>
	<?php if ($portal->loggedIN): ?>
	<?=$portal->showIncomeForm() ?>
	<?=$portal->showExpenseForm() ?>
	<?=$portal->showIncomeEditForm() ?>
	<?=$portal->showExpenseEditForm() ?>
	<?php include 'templates/deleteIncomeForm.php';?>
	<?php include 'templates/deleteExpenseForm.php';?>
	<?php endif; ?>
</body>
</html>