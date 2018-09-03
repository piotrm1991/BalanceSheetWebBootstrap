<?php
session_start();

if (isset($_SESSION['saveExpense']))
{
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
