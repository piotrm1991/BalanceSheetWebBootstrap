<?php

if (!$portal->loggedIN)
{
	header ('Location: index.php?action=showMain');
	exit();
}

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
<header>
	<article class="navigation">
		<nav class="navbar navbar-default" id="nav">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand brand" href="index.php?action=showStart">Bilans wydatków</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li <?php if ($action == 'showStart'): ?>class="active"<?php $_SESSION['actionReturn'] = 'Location:index.php?action=showStart'; endif; ?>><a href="index.php?action=showStart"><i class="glyphicon glyphicon-home"></i>&nbsp;&nbsp;Start</a>
						</li>
						<li><a data-toggle="modal" data-target="#addExpense" style="cursor: pointer;"><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;&nbsp;Dodaj wydatek</a>
						</li>
						<li><a data-toggle="modal" data-target="#addIncome" style="cursor: pointer;"><i class="glyphicon glyphicon-usd"></i>&nbsp;&nbsp;Dodaj przychód</a>
						</li>
						<li <?php if ($action == 'showBalanceThisMonth' || $action == 'showBalanceLastMonth' || $action == 'showBalanceThisYear'): ?>class="active"<?php endif; ?>><a href="index.php?action=showBalanceThisMonth"><i class="glyphicon glyphicon-signal"></i>&nbsp;&nbsp;Przeglądaj bilans</a>
						</li>
						<?php if ($action == 'showBalanceThisMonth'): ?>
						<?php $_SESSION['actionReturn'] = 'Location:index.php?action=showBalanceThisMonth';?>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;&nbsp;Bierzący miesiąc&nbsp;&nbsp;<i class="glyphicon glyphicon-calendar"></i></a>
							<ul class="dropdown-menu">
								<li><a href="index.php?action=showBalanceLastMonth">Ostatni Miesiąc</a></li>
								<li><a href="index.php?action=showBalanceThisYear">Bierzący rok</a></li>
								<li><a data-toggle="modal" data-target="#chooseDate" style="cursor: pointer;">Wybierz daty</a></li>
							</ul>
						</li>
						<?php elseif ($action == 'showBalanceLastMonth'): ?>
						<?php $_SESSION['actionReturn'] = 'Location:index.php?action=showBalanceLastMonth';?>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;&nbsp;Ostatni Miesiąc&nbsp;&nbsp;<i class="glyphicon glyphicon-calendar"></i></a>
							<ul class="dropdown-menu">
								<li><a href="index.php?action=showBalanceThisMonth">Bierzący miesiąc</a></li>
								<li><a href="index.php?action=showBalanceThisYear">Bierzący rok</a></li>
								<li><a data-toggle="modal" data-target="#chooseDate" style="cursor: pointer;">Wybierz daty</a></li>
							</ul>
						</li>
						<?php elseif ($action == 'showBalanceThisYear'): ?>
						<?php $_SESSION['actionReturn'] = 'Location:index.php?action=showBalanceThisYear';?>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;&nbsp;Bierzący rok&nbsp;&nbsp;<i class="glyphicon glyphicon-calendar"></i></a>
							<ul class="dropdown-menu">
								<li><a href="index.php?action=showBalanceThisMonth">Bierzący miesiąc</a></li>
								<li><a href="index.php?action=showBalanceLastMonth">Ostatni Miesiąc</a></li>
								<li><a data-toggle="modal" data-target="#chooseDate" style="cursor: pointer;">Wybierz daty</a></li>
							</ul>
						</li>
						<?php elseif ($action == 'showBalanceChoosenDate'): ?>
						<?php $_SESSION['actionReturn'] = 'Location:index.php?action=showBalanceThisMonth';?>
						<li class="dropdown">
							<?php if (isset($_SESSION['dateA']) && isset($_SESSION['dateB'])): ?>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;&nbsp;Od: <?=$_SESSION['dateA']?> Do: <?=$_SESSION['dateB']?>&nbsp;&nbsp;<i class="glyphicon glyphicon-calendar"></i></a>
							<?php else: ?>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;&nbsp;Wybierz daty&nbsp;&nbsp;<i class="glyphicon glyphicon-calendar"></i></a>
							<?php endif; ?>
							<ul class="dropdown-menu">
								<li><a href="index.php?action=showBalanceThisMonth">Bierzący miesiąc</a></li>
								<li><a href="index.php?action=showBalanceThisYear">Bierzący rok</a></li>
								<li><a href="index.php?action=showBalanceLastMonth">Ostatni Miesiąc</a></li>
								<li><a data-toggle="modal" data-target="#chooseDate" style="cursor: pointer;">Wybierz daty</a></li>
							</ul>
						</li>
						<?php endif; ?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#" id="dateToday"><?php echo $day.' '.$month.' '.$year; ?></a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $portal->loggedIN->username; ?></a>
							<ul class="dropdown-menu">
								<li <?php if($action == 'showSettings'): ?>class="active"<?php $_SESSION['actionReturn'] = 'Location:index.php?action=showSettings'; endif; ?>><a href="index.php?action=showSettings"><i class="glyphicon glyphicon-cog"></i>&nbsp;&nbsp;Ustawienia</a></li>
								<li><a href="index.php?action=logout"><i class="glyphicon glyphicon-off"></i>&nbsp;&nbsp;Wyloguj się</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</article>
</header>