<?php
if (!isset($_SESSION['logged_id']))
{
	header('Location: index.php');
	exit();
}

require_once 'database.php';

$dateA = $_SESSION['dateA'];
$dateB = $_SESSION['dateB'];

unset($_SESSION['dateA']);
unset($_SESSION['dateB']);

$incomeChoosenDateQuery = $db->prepare('SELECT income_category_assigned_to_user_id, SUM(amount) AS amount FROM incomes WHERE user_id=:logged_id AND date BETWEEN :dateA AND :dateB GROUP BY income_category_assigned_to_user_id ORDER BY amount DESC');
$incomeChoosenDateQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
$incomeChoosenDateQuery->bindValue(':dateA', $dateA, PDO::PARAM_STR);
$incomeChoosenDateQuery->bindValue(':dateB', $dateB, PDO::PARAM_STR);
$incomeChoosenDateQuery->execute();
$incomeChoosenDate = $incomeChoosenDateQuery->fetchAll();

$_SESSION['income'] = $incomeChoosenDate;

$_SESSION['incomeSum'] = 0;
foreach ($incomeChoosenDate as $category)
{
	$_SESSION['incomeSum']+=$category['amount'];
}

$expenseChoosenDateQuery = $db->prepare('SELECT expense_category_assigned_to_user_id, SUM(amount) AS amount FROM expenses WHERE user_id=:logged_id AND date BETWEEN :dateA AND :dateB GROUP BY expense_category_assigned_to_user_id ORDER BY amount DESC');
$expenseChoosenDateQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
$expenseChoosenDateQuery->bindValue(':dateA', $dateA, PDO::PARAM_STR);
$expenseChoosenDateQuery->bindValue(':dateB', $dateB, PDO::PARAM_STR);
$expenseChoosenDateQuery->execute();
$expenseChoosenDate = $expenseChoosenDateQuery->fetchAll();

$_SESSION['expense'] = $expenseChoosenDate;

$_SESSION['expenseSum'] = 0;
foreach ($expenseChoosenDate as $category)
{
	$_SESSION['expenseSum']+=$category['amount'];
}
