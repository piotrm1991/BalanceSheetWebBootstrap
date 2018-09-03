<?php

	session_start();
	
	if (isset($_SESSION['logged_id'])) 
	{
	header('Location: mainMenu.php');
	exit();
	}
	
	if (isset($_POST['email1']))
	{
		$registration_OK = true;
		
		
		//Login
		$user = $_POST['user'];
		
		if ((strlen($user)<3) || (strlen($user)>20))
		{
			$registration_OK = false;
			$_SESSION['e_user'] = "Login musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($user) == false)
		{
			$registration_OK = false;
			$_SESSION['e_user'] = "Login może się składać tylko z liter i cyfr (bez polskich znaków)!";
		}
		
		//Password
		$pass1 = $_POST['password1'];
		$pass2 = $_POST['password2'];
		
		if ($pass1!=$pass2)
		{
			$registration_OK = false;
			$_SESSION['e_pass'] = "Podane hasła nie są identyczne!";
		}
		
		if ((strlen($pass1)<8) || (strlen($pass1)>20))
		{
			$registration_OK = false;
			$_SESSION['e_pass'] = "Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		$pass_hash = password_hash($pass1, PASSWORD_DEFAULT);
		
		//Email
		$email1 = $_POST['email1'];
		$email2 = $_POST['email2'];
		
		$emailSafe = filter_var($email1, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailSafe, FILTER_VALIDATE_EMAIL)==false) || ($emailSafe!=$email1))
		{
			$registration_OK = false;
			$_SESSION['e_email'] = "Podaj poprawny adres email!";
		}
		
		if ($email1!=$email2)
		{
			$registration_OK = false;
			$_SESSION['e_email'] = "Podane adresy email nie są identyczne!";
		}
		
		//Commit
		$_SESSION['fr_user'] = $user;
		$_SESSION['fr_pass1'] = $pass1;
		$_SESSION['fr_pass2'] = $pass2;
		$_SESSION['fr_email1'] = $email1;
		$_SESSION['fr_email2'] = $email2;
		
		require_once 'database.php';
		
		//Email exist?
		$emailQuery = $db->prepare('SELECT id FROM users WHERE email = :email');
		$emailQuery->bindValue(':email', $emailSafe, PDO::PARAM_STR);
		$emailQuery->execute();
		
		if (($emailQuery->rowCount())>0)
		{
			$registration_OK = false;
			$_SESSION['e_email'] = "Istnieje już konto przypisane do tego konta email!";
		}
		
		//Login exist?
		$loginQuery = $db->prepare('SELECT id FROM users WHERE username = :user');
		$loginQuery->bindValue(':user', $user, PDO::PARAM_STR);
		$loginQuery->execute();
		
		if (($loginQuery->rowCount())>0)
		{
			$registration_OK = false;
			$_SESSION['e_login'] = "Istnieje już konto o takim loginie!";
		}
		
		//OK
		if ($registration_OK == true)
		{
			require_once 'newAccount.php';
		}
	}
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
			<section class="main-container">
				<div class="row">
					<div class="col-sm-4"></div>
					<div class="col-sm-4">
						<article class="registration-form">
							<form method="POST">
								<div class="form-group">
									<input class="form-control" type="text" name="user" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'" value="<?php
									if (isset($_SESSION['fr_user']))
									{
										echo $_SESSION['fr_user'];
										unset($_SESSION['fr_user']);
									}
									?>">
								</div>
								<?php
									if (isset($_SESSION['e_user']))
									{
										echo '<div class="error">'.$_SESSION['e_user'].'</div>';
										unset($_SESSION['e_user']);
									}
								?>
								<div class="form-group">
									<input class="form-control" type="password" name="password1" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'" value="<?php
									if (isset($_SESSION['fr_pass1']))
									{
										echo $_SESSION['fr_pass1'];
										unset($_SESSION['fr_pass1']);
									}
									?>">
								</div>
								<?php
									if (isset($_SESSION['e_pass']))
									{
										echo '<div class="error">'.$_SESSION['e_pass'].'</div>';
										unset($_SESSION['e_pass']);
									}
								?>
								<div class="form-group">
									<input class="form-control" type="password" name="password2" placeholder="powtórz hasło" onfocus="this.placeholder=''" onblur="this.placeholder='powtórz hasło'" value="<?php
									if (isset($_SESSION['fr_pass2']))
									{
										echo $_SESSION['fr_pass2'];
										unset($_SESSION['fr_pass2']);
									}
									?>">
								</div>
								<div class="form-group">
									<input class="form-control" type="email" name="email1" placeholder="email" onfocus="this.placeholder=''" onblur="this.placeholder='email'" value="<?php
									if (isset($_SESSION['fr_email1']))
									{
										echo $_SESSION['fr_email1'];
										unset($_SESSION['fr_email1']);
									}
									?>">
								</div>
								<?php
									if (isset($_SESSION['e_email']))
									{
										echo '<div class="error">'.$_SESSION['e_email'].'</div>';
										unset($_SESSION['e_email']);
									}
								?>
								<div class="form-group">
									<input class="form-control" type="email" name="email2" placeholder="powtórz email" onfocus="this.placeholder=''" onblur="this.placeholder='powtórz email'" value="<?php
									if (isset($_SESSION['fr_email2']))
									{
										echo $_SESSION['fr_email2'];
										unset($_SESSION['fr_email2']);
									}
									?>">
								</div>
								<button class="btn btn-default btn-sm btn-block"  name="register">Utwórz konto</button> 
							</form>
							<form action="index.php">
								<button class="btn btn-default btn-sm btn-block" name="cancel" >Anuluj</button>
							</form>
						</article>
					</div>
					<div class="col-sm-4"></div>
				</div>
			</section>
		</div>
	</main>
</body>
</html>