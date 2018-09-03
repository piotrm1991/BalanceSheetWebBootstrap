<?php
if (!isset($_SESSION['logged_id']))
{
	header('Location: index.php');
	exit();
}

require_once 'database.php';

$date = new DateTime();
$dateThisMonth = $date->format('Y-m-00');

$incomeThisMonthQuery = $db->prepare('SELECT income_category_assigned_to_user_id, SUM(amount) AS amount FROM incomes WHERE user_id=:logged_id AND date>:date GROUP BY income_category_assigned_to_user_id ORDER BY amount DESC');
$incomeThisMonthQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
$incomeThisMonthQuery->bindValue(':date', $dateThisMonth, PDO::PARAM_STR);
$incomeThisMonthQuery->execute();
$incomeThisMonth = $incomeThisMonthQuery->fetchAll();

$_SESSION['income'] = $incomeThisMonth;

$_SESSION['incomeSum'] = 0;
foreach ($incomeThisMonth as $category)
{
	$_SESSION['incomeSum']+=$category['amount'];
}

$expenseThisMonthQuery = $db->prepare('SELECT expense_category_assigned_to_user_id, SUM(amount) AS amount FROM expenses WHERE user_id=:logged_id AND date>:date GROUP BY expense_category_assigned_to_user_id ORDER BY amount DESC');
$expenseThisMonthQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
$expenseThisMonthQuery->bindValue(':date', $dateThisMonth, PDO::PARAM_STR);
$expenseThisMonthQuery->execute();
$expenseThisMonth = $expenseThisMonthQuery->fetchAll();

$_SESSION['expense'] = $expenseThisMonth;

$_SESSION['expenseSum'] = 0;
foreach ($expenseThisMonth as $category)
{
	$_SESSION['expenseSum']+=$category['amount'];
}
