<?php
session_start();

require_once 'database.php';

if (isset($_SESSION['saveExpense']))
{
	$idCategoryQuery = $db->prepare('SELECT id FROM expenses_category_assigned_to_users WHERE user_id=:logged_id AND name=:name');
	$idCategoryQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
	$idCategoryQuery->bindValue(':name', $_SESSION['category'], PDO::PARAM_STR);
	$idCategoryQuery->execute();
	
	$idCategory = $idCategoryQuery->fetch();

	$idPaymentQuery = $db->prepare('SELECT id FROM payment_methods_assigned_to_users WHERE user_id=:logged_id AND name=:name');
	$idPaymentQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
	$idPaymentQuery->bindValue(':name', $_SESSION['payment'], PDO::PARAM_STR);
	$idPaymentQuery->execute();
	
	$idPayment = $idPaymentQuery->fetch();
		
	$saveExpenseQuery = $db->prepare('INSERT INTO expenses VALUES (NULL, :logged_id, :id_category, :id_payment, :amount, :date, :comment)');
	$saveExpenseQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
	$saveExpenseQuery->bindValue(':id_category', $idCategory['id'], PDO::PARAM_INT);
	$saveExpenseQuery->bindValue(':id_payment', $idPayment['id'], PDO::PARAM_INT);
	$saveExpenseQuery->bindValue(':amount', strval($_SESSION['amount']), PDO::PARAM_STR);
	$saveExpenseQuery->bindValue(':date', $_SESSION['date'], PDO::PARAM_STR);
	$saveExpenseQuery->bindValue(':comment', $_SESSION['comment'], PDO::PARAM_STR);
	$saveExpenseQuery->execute();
	
	unset($_SESSION['amount']);
	unset($_SESSION['date']); 
	unset($_SESSION['payment']);
	unset($_SESSION['category']); 
	unset($_SESSION['comment']); 
		
	unset($_SESSION['saveExpense']); 
	
	header('Location: addExpense.php');
	exit();
}
if (isset($_SESSION['saveIncome']))
{
	$idCategoryQuery = $db->prepare('SELECT id FROM incomes_category_assigned_to_users WHERE user_id=:logged_id AND name=:name');
	$idCategoryQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
	$idCategoryQuery->bindValue(':name', $_SESSION['category'], PDO::PARAM_STR);
	$idCategoryQuery->execute();
	
	$idCategory = $idCategoryQuery->fetch();
		
	$saveIncomeQuery = $db->prepare('INSERT INTO incomes VALUES (NULL, :logged_id, :id_category, :amount, :date, :comment)');
	$saveIncomeQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
	$saveIncomeQuery->bindValue(':id_category', $idCategory['id'], PDO::PARAM_INT);
	$saveIncomeQuery->bindValue(':amount', strval($_SESSION['amount']), PDO::PARAM_STR);
	$saveIncomeQuery->bindValue(':date', $_SESSION['date'], PDO::PARAM_STR);
	$saveIncomeQuery->bindValue(':comment', $_SESSION['comment'], PDO::PARAM_STR);
	$saveIncomeQuery->execute();
	
	unset($_SESSION['amount']);
	unset($_SESSION['date']); 
	unset($_SESSION['category']); 
	unset($_SESSION['comment']); 
		
	unset($_SESSION['saveIncome']); 
	
	header('Location: addIncome.php');
	exit();
}
else
{
	header('Location: mainMenu.php');
	exit();
}
