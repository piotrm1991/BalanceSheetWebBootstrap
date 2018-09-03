<?php
session_start();

require_once 'database.php';

if (!isset($_SESSION['logged_id']))
{
	if (isset($_POST['login']))
	{
		$login = filter_input(INPUT_POST, 'login');
		$password = filter_input(INPUT_POST, 'password');
		
		$userQuery = $db->prepare('SELECT id, password FROM users WHERE username = :login');
		$userQuery->bindValue(':login', $login, PDO::PARAM_STR);
		$userQuery->execute();
		
		$user = $userQuery->fetch();
		
		if ($user && password_verify($password, $user['password']))
		{
			$_SESSION['logged_id'] = $user['id'];
			$_SESSION['logged_login'] = $login;
			unset($_SESSION['bad_attempt']);
		}
		else
		{
			$_SESSION['bad_attempt'] = true;
			header('Location: index.php');
			exit();
		}
	}
	else
	{
		header('Location: index.php');
		exit();
	}
}

$lastExpensesQuery = $db->prepare('SELECT * FROM expenses WHERE user_id=:logged_id ORDER BY id DESC LIMIT 3');
$lastExpensesQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_STR);
$lastExpensesQuery->execute();
$lastExpenses = $lastExpensesQuery->fetchAll();

$lastIncomesQuery = $db->prepare('SELECT * FROM incomes WHERE user_id=:logged_id ORDER BY id DESC LIMIT 3');
$lastIncomesQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_STR);
$lastIncomesQuery->execute();
$lastIncomes = $lastIncomesQuery->fetchAll();

require_once 'idCategoryToNameCategory.php';

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
			$page = 'mainMenu';
			require_once "navigation.php";

			?>
			<section class="main-container">
				<section class="lastExpensesIncome">
					<div class="row">
						<div class="col-sm-6">
							<h3 class="lastEntryHeader">Ostatnie wydatki</h3>
							<?php
							foreach ($lastExpenses as $lastExpense)
							{
								echo '
								<section class="expense">
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>Data</th>
													<th>Kwota</th>
													<th>Sposób płatności</th>
													<th>Kategoria</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>'.$lastExpense['date'].'</td>
													<td>'.$lastExpense['amount'].'</td>
													<td>';
													foreach ($idPayment as $id)
													{
														if ($id['id']==$lastExpense['payment_method_assigned_to_user_id'])
														{
															foreach ($paymentMethods as $name=>$name_meaning)
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
													<td>';
													foreach ($idExpense as $id)
													{
														if ($id['id']==$lastExpense['expense_category_assigned_to_user_id'])
														{
															foreach ($expenseCategory as $name=>$name_meaning)
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
												</tr>
												</tbody>
											</table>
										<span style="font-weight: 700;">Komentarz: </span>'.$lastExpense['comment'].'
									</div>
								</section>';
							}
							?>	
						</div>
						<div class="col-sm-6">
							<h3 class="lastEntryHeader">Ostatnie przychody</h3>
							<?php
							foreach ($lastIncomes as $lastIncome)
							{
								echo '
								<section class="income">
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>Data</th>
													<th>Kwota</th>
													<th>Kategoria</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>'.$lastIncome['date'].'</td>
													<td>'.$lastIncome['amount'].'</td>
													<td>';
													foreach ($idIncomes as $id)
													{
														if ($id['id']==$lastIncome['income_category_assigned_to_user_id'])
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
												</tr>
											</tbody>
										</table>
									<span style="font-weight: 700;">Komentarz: </span>'.$lastIncome['comment'].'
									</div>
								</section>'
								;
							}
							?>
						</div>
					</div>
				</section>
			</section>
		</div>
	</main>
</body>
</html>