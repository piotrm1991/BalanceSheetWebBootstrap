<?php

$saveQuery = $db->prepare('INSERT INTO users VALUES (NULL, :user, :pass, :email)');
$saveQuery->bindValue(':user', $user, PDO::PARAM_STR);
$saveQuery->bindValue(':pass', $pass_hash, PDO::PARAM_STR);
$saveQuery->bindValue(':email', $email1, PDO::PARAM_STR);
$saveQuery->execute();

$tableIncomesQuery = $db->prepare('INSERT INTO incomes_category_assigned_to_users (user_id, name) SELECT (SELECT id FROM users ORDER BY id DESC LIMIT 1), name FROM incomes_category_default');
$tableIncomesQuery->execute();

$tablePaymentQuery = $db->prepare('INSERT INTO payment_methods_assigned_to_users (user_id, name) SELECT (SELECT id FROM users ORDER BY id DESC LIMIT 1), name FROM payment_methods_default');
$tablePaymentQuery->execute();

$tableExpensesQuery = $db->prepare('INSERT INTO expenses_category_assigned_to_users (user_id, name) SELECT (SELECT id FROM users ORDER BY id DESC LIMIT 1), name FROM expenses_category_default');
$tableExpensesQuery->execute();

$_SESSION['registrationCompleted'] = true;

header('Location: hello.php');