<?php
session_start();

if (!isset($_SESSION['logged_id']))
{
	header('Location: index.php');
	exit();
}

require_once 'idCategoryToNameCategory.php';

unset($_SESSION['thisMonth']);
unset($_SESSION['lastMonth']);
unset($_SESSION['thisYear']);
unset($_SESSION['another']);
unset($_SESSION['hide']);

$incomeSum = 0;
$expenseSum =0;
$incomeThisMonth = Null;
$expenseThisMonth = Null;

if (!isset($_POST['choice']))
{
	require_once 'thisMonth.php';
	$_SESSION['thisMonth'] = true;
}
else
{
	if ($_POST['choice'] == "thisMonth")
	{
		unset($_SESSION['lastMonth']);
		unset($_SESSION['thisYear']);
		unset($_SESSION['another']);
		unset($_SESSION['hide']);
		
		require_once 'thisMonth.php';
		$_SESSION['thisMonth'] = true;
	}
	if ($_POST['choice'] == "lastMonth")
	{
		unset($_SESSION['thisMonth']);
		unset($_SESSION['thisYear']);
		unset($_SESSION['another']);
		unset($_SESSION['hide']);
		
		require_once 'lastMonth.php';
		$_SESSION['lastMonth'] = true;
	}
	if ($_POST['choice'] == "thisYear")
	{
		unset($_SESSION['thisMonth']);
		unset($_SESSION['lastMonth']);
		unset($_SESSION['another']);
		unset($_SESSION['hide']);
		
		require_once 'thisYear.php';
		$_SESSION['thisYear'] = true;
	}
	if ($_POST['choice'] == "another")
	{
		unset($_SESSION['thisMonth']);
		unset($_SESSION['lastMonth']);
		unset($_SESSION['thisYear']);
		
		$_SESSION['another'] = true;
		$_SESSION['hide'] = true;
	}
}

if (isset($_POST['dateA']) && isset($_POST['dateA']))
{
	unset($_SESSION['e_dates']);
	
	$dates_OK = true;
	
	if ($_POST['dateA']==NULL || $_POST['dateB']==NULL)
	{
		$dates_OK = false;
		$_SESSION['e_dates'] = "Podaj poprawne daty!";
	}
	
	if ($_POST['dateA']>$_POST['dateB'])
	{
		$dates_OK = false;
		$_SESSION['e_dates'] = "Podaj daty w odpowiedniej kolejności!";
	}
	
	if ($_POST['dateA'] == $_POST['dateB'] && $_POST['dateA']!=NULL)
	{
		$dates_OK = false;
		$_SESSION['e_dates'] = "Daty nie mogą być takie samie!";
	}
	
	if ($dates_OK == true)
	{
		$_SESSION['dateA'] = $_POST['dateA'];
		$_SESSION['dateB'] = $_POST['dateB'];
		
		unset($_SESSION['hide']);

		require_once 'anotherDate.php';
	}
}

if (isset($_SESSION['incomeSum']))
{
	$incomeSum = $_SESSION['incomeSum'];
	unset($_SESSION['incomeSum']);
}

if (isset($_SESSION['expenseSum']))
{
	$expenseSum = $_SESSION['expenseSum'];
	unset($_SESSION['expenseSum']);
}

if (isset($_SESSION['income']))
{
	$income = $_SESSION['income'];
	unset($_SESSION['income']);
}

if (isset($_SESSION['expense']))
{
	$expense = $_SESSION['expense'];
	unset($_SESSION['expense']);
}

$pieData = array
(
	array('Category', 'Amount')
);

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
	
	<script src="https://www.gstatic.com/charts/loader.js"></script>
		
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
			
			$page = 'balanceSheet';
			require_once "navigation.php";

			?>
			<section class="main-container">
				<section class="balanceSheet">
					<h3 class="balanceSheetHeader">Twój bilans wydatków</h3>
					<?php
					if (!isset($_SESSION['hide']))
					{
						if ($expenseSum>$incomeSum)
						{
							echo '<div class="alert alert-danger">
									<strong>Uwaga! </strong>Wpadasz w długi!
								</div>';
						}
						else
						{
							echo '<div class="alert alert-success">
									<strong>Brawo! </strong>Nie masz długów!
								</div>';
						}
					}
					?>
					<form method="post" >
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<select class="form-control" name="choice" onchange="this.form.submit()">
										<option value="thisMonth" <?php 
										if (isset($_SESSION['thisMonth'])) 
										{
											echo 'selected';
										}
										?>>Bierzący miesiąc</option>
										<option value="lastMonth" <?php 
										if (isset($_SESSION['lastMonth'])) 
										{
											echo 'selected';
										}
										?>>Poprzedni miesiąc</option>
										<option value="thisYear" <?php 
										if (isset($_SESSION['thisYear'])) 
										{
											echo 'selected';
										}
										?>>Bierzący rok</option>
										<option value="another" <?php 
										if (isset($_SESSION['another'])) 
										{
											echo 'selected';
										}
										?>>Niestandardowy</option>
									</select>
								</div>
							</div>
							<div class="col-sm-9"></div>
						</div>
							<?php
							if (isset($_SESSION['another']))
							{
								echo '<form method="post">
								<div class="row">
									<div class="col-sm-2"></div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="dateA">Od: </label>
											<input name="dateA" type="date" class="form-control">
										</div>
									</div>
									<div class="col-sm-2">';
									if (isset($_SESSION['e_dates']))
									{
										echo '<div class="error">'.$_SESSION['e_dates'].'</div>';
										unset($_SESSION['e_dates']);
									}
									echo '</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="dateB">Do: </label>
											<input name="dateB" type="date" class="form-control">
										</div>
									</div>
									<div class="col-sm-2"></div>
								</div>
								<div class="row">
									<div class="col-sm-12">
									<button class="btn btn-default btn-sm btn-block" name="showBalance" id="showBalance" >Wyświetl</button>
									</div>
								</div>
									</form>';
							}
							else
							{
								echo '';
							}
							?>
					</form>
					<?php
					if (!isset($_SESSION['hide']))
					{
						echo '<h5 class="incomeHeader">Przychody</h5>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Kategoria</th>
										<th>Kwota</th>
									</tr>
								</thead>
								<tbody>';
									foreach ($income as $category)
									{
										echo 
										'<tr>
											<td>';
											foreach ($idIncomes as $id)
											{
												if ($id['id'] == $category['income_category_assigned_to_user_id'])
												{
													foreach ($incomeCategory as $name=>$name_meaning)
													{
														if ($name==$id['name'])
															{
																echo $name_meaning;
																break;
															}
													}
													break;
												}
											}
											echo '</td>
											<td>'.$category['amount'].'</td>
										</tr>';
									}
									echo '<tr>
										<th class="sum">Suma</th>
										<td class="sum">'.$incomeSum.' zł</td>
									</tr>
								</tbody>
							</table>
						</div>
						<h5 class="expensesHeader">Wydatki</h5>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Kategoria</th>
										<th>Kwota</th>
									</tr>
								</thead>
								<tbody>';
									foreach ($expense as $category)
									{
										echo 
										'<tr>
											<td>';
											foreach ($idExpense as $id)
											{
												if ($id['id'] == $category['expense_category_assigned_to_user_id'])
												{
													foreach ($expenseCategory as $name=>$name_meaning)
													{
														if ($name==$id['name'])
															{
																echo $name_meaning;
																$newPieData = array
																(
																	array($name_meaning, floatval($category['amount'])),
																);
																$pieData = array_merge($pieData, $newPieData);
																break;
															}
													}
													break;
												}
											}
											echo '</td>
											<td>'.$category['amount'].'</td>
										</tr>';
									}
									echo '<tr>
										<th class="sum">Suma</th>
										<td class="sum">'.$expenseSum.' zł</td>
									</tr>
								</tbody>
							</table>
						</div>
					<div id="chart">
						<div id="piechart"></div>
					</div>';
					}
					?>	
				</section>
			</section>
		</div>
	</main>
	<?php 
	if (!isset($_SESSION['hide']))
	{
	require_once 'chart.php';
	}
	?>
</body>
</html>