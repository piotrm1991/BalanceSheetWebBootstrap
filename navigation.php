<?php
$dateToday = new DateTime();
$monthToday = $dateToday->format("m");

if ($monthToday=="01") $month = "Styczeń";
else if ($monthToday=="02") $month = "Luty";
else if ($monthToday=="03") $month = "Marzec";
else if ($monthToday=="04") $month = "Kwiecień";
else if ($monthToday=="05") $month = "Maj";
else if ($monthToday=="06") $month = "Czerwiec";
else if ($monthToday=="07") $month = "Lipiec";
else if ($monthToday=="08") $month = "Śierpień";
else if ($monthToday=="09") $month = "Wrzesień";
else if ($monthToday=="10") $month = "Październik";
else if ($monthToday=="11") $month = "Listopad";
else if ($monthToday=="12") $month = "Grudzień";

$day = $dateToday->format("d");
$year = $dateToday->format("Y");
?>
<article class="mainMenu-navigation">
	<nav class="navbar navbar-default" id="nav">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="mainMenu.php">Bilans wydatków</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li <?php echo ($page == 'mainMenu') ? "class='active'" : ""; ?>><a href="mainMenu.php">Start</a>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;Dodaj</a>
						<ul class="dropdown-menu">
							<li <?php echo ($page == 'addIncome') ? "class='active'" : ""; ?>><a href="addIncome.php">Przychód</a></li>
							<li <?php echo ($page == 'addExpense') ? "class='active'" : ""; ?>><a href="addExpense.php">Wydatek</a></li>
						</ul>
					</li>
					<li <?php echo ($page == 'balanceSheet') ? "class='active'" : ""; ?>><a href="balanceSheet.php">Przeglądaj bilans</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#" id="dateToday"><?php echo $day.' '.$month.' '.$year; ?></a></li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon glyphicon-user"></span>&nbsp;<?php echo $_SESSION['logged_login'] ?></a>
						<ul class="dropdown-menu">
							<li><a href="#">Ustawienia</a></li>
							<li><a href="logout.php">Wyloguj się</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</article>