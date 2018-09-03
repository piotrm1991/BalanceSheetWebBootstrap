<?php
if (!isset($_SESSION['logged_id']))
{
	header('Location: index.php');
	exit();
}

require_once 'database.php';

$date = new DateTime();
$dateThisYear = $date->format('Y-00-00');

$incomeThisYearQuery = $db->prepare('SELECT income_category_assigned_to_user_id, SUM(amount) AS amount FROM incomes WHERE user_id=:logged_id AND date>:date GROUP BY income_category_assigned_to_user_id ORDER BY amount DESC');
$incomeThisYearQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
$incomeThisYearQuery->bindValue(':date', $dateThisYear, PDO::PARAM_STR);
$incomeThisYearQuery->execute();
$incomeThisYear = $incomeThisYearQuery->fetchAll();

$_SESSION['income'] = $incomeThisYear;

$_SESSION['incomeSum'] = 0;
foreach ($incomeThisYear as $category)
{
	$_SESSION['incomeSum']+=$category['amount'];
}

$expenseThisYearQuery = $db->prepare('SELECT expense_category_assigned_to_user_id, SUM(amount) AS amount FROM expenses WHERE user_id=:logged_id AND date>:date GROUP BY expense_category_assigned_to_user_id ORDER BY amount DESC');
$expenseThisYearQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
$expenseThisYearQuery->bindValue(':date', $dateThisYear, PDO::PARAM_STR);
$expenseThisYearQuery->execute();
$expenseThisYear = $expenseThisYearQuery->fetchAll();

$_SESSION['expense'] = $expenseThisYear;

$_SESSION['expenseSum'] = 0;
foreach ($expenseThisYear as $category)
{
	$_SESSION['expenseSum']+=$category['amount'];
}
