<?php
if (!isset($_SESSION['logged_id']))
{
	header('Location: index.php');
	exit();
}

require_once 'database.php';

$date = new DateTime();
$dateLastMonthB = $date->format('Y-m-00');
$date->modify('-1 month');
$dateLastMonthA = $date->format('Y-m-00');

$incomeLastMonthQuery = $db->prepare('SELECT income_category_assigned_to_user_id, SUM(amount) AS amount FROM incomes WHERE user_id=:logged_id AND date BETWEEN :dateA AND :dateB GROUP BY income_category_assigned_to_user_id ORDER BY amount DESC');
$incomeLastMonthQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
$incomeLastMonthQuery->bindValue(':dateA', $dateLastMonthA, PDO::PARAM_STR);
$incomeLastMonthQuery->bindValue(':dateB', $dateLastMonthB, PDO::PARAM_STR);
$incomeLastMonthQuery->execute();
$incomeLastMonth = $incomeLastMonthQuery->fetchAll();

$_SESSION['income'] = $incomeLastMonth;

$_SESSION['incomeSum'] = 0;
foreach ($incomeLastMonth as $category)
{
	$_SESSION['incomeSum']+=$category['amount'];
}

$expenseLastMonthQuery = $db->prepare('SELECT expense_category_assigned_to_user_id, SUM(amount) AS amount FROM expenses WHERE user_id=:logged_id AND date BETWEEN :dateA AND :dateB GROUP BY expense_category_assigned_to_user_id ORDER BY amount DESC');
$expenseLastMonthQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
$expenseLastMonthQuery->bindValue(':dateA', $dateLastMonthA, PDO::PARAM_STR);
$expenseLastMonthQuery->bindValue(':dateB', $dateLastMonthB, PDO::PARAM_STR);
$expenseLastMonthQuery->execute();
$expenseLastMonth = $expenseLastMonthQuery->fetchAll();

$_SESSION['expense'] = $expenseLastMonth;

$_SESSION['expenseSum'] = 0;
foreach ($expenseLastMonth as $category)
{
	$_SESSION['expenseSum']+=$category['amount'];
}

