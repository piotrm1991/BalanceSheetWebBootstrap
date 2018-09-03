<?php

if (!isset($_SESSION['logged_id']))
{
	header('Location: index.php');
	exit();
}

require_once 'database.php';
require_once 'categories.php';

$idIncomesQuery = $db->prepare('SELECT * FROM incomes_category_assigned_to_users WHERE user_id=:logged_id');
$idIncomesQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_STR);
$idIncomesQuery->execute();
$idIncomes = $idIncomesQuery->fetchAll();

$idExpenseQuery = $db->prepare('SELECT * FROM expenses_category_assigned_to_users WHERE user_id=:logged_id');
$idExpenseQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_STR);
$idExpenseQuery->execute();
$idExpense = $idExpenseQuery->fetchAll();

$idPaymentQuery = $db->prepare('SELECT * FROM payment_methods_assigned_to_users WHERE user_id=:logged_id');
$idPaymentQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_STR);
$idPaymentQuery->execute();
$idPayment = $idPaymentQuery->fetchAll();