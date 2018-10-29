<?php if(!isset($_SESSION['loggedIN'])) exit(); ?>
<section class="index-start">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div style="text-align: center"><h1>Witaj <?php if(isset($_SESSION['loggedIN'])): ?><?=$_SESSION['loggedIN']->username; ?><?php endif; ?>!</h1></div>
        </div>
        <div class="col-sm-4"></div>
    </div>
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-3">
			<div class="start">
			<?php if (!$lastExpenses): ?>
			<h2>Nie ma jeszcze żadnych wydatków!</h2>
			<?php else: ?>
			<h2>Ostatnio dodane wydatki</h2>
			<?php
			foreach ($lastExpenses as $lastExpense) {
			    $lastExpense->getStartHTML();
			}
			?>
			<?php endif; ?>
			</div>
		</div>
		<div class="col-sm-2"></div>
		<div class="col-sm-3">
			<div class="start">
			<?php if (!$lastExpenses): ?>
			<h2>Nie ma jeszcze żadnych przychodów!</h2>
			<?php else: ?>
			<h2>Ostatnio dodane przychody</h2>
			<?php
			foreach ($lastIncomes as $lastIncome) {
			    $lastIncome->getStartHTML();
			}
			?>
			<?php endif; ?>
			</div>
		</div>
		<div class="col-sm-2"></div>
	</div>
</section>