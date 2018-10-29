<?php if(!isset($_SESSION['loggedIN'])) exit(); ?>
<section class="index-start">
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-3">
			<div class="start">
			<?php if ($expenseSum<=0): ?>
			<h2>Nie ma wydatków!</h2>
			<?php else: ?>
			<h2>Wydatki</h2>
			<?php endif; ?>
			<?php 
			foreach ($categoriesExpense as $category) {
			    $category->getBalanceHTML();
			    foreach ($expenses as $expense) {
				    if ($expense->expense_category_assigned_to_user_id==$category->id) {
				        echo $expense->getBalanceHTML();
			        }
			    }
			}
			?>
			</div>
		</div>
		<div class="col-sm-2"></div>
		<div class="col-sm-3">
			<div class="start">
			<?php if ($incomeSum<=0): ?>
			<h2>Nie ma przychodów!</h2>
			<?php else: ?>
			<h2>Przychody</h2>
			<?php endif; ?>
			<?php 
			foreach ($categoriesIncome as $category) {
			    $category->getBalanceHTML();
			    foreach ($incomes as $income) {
				    if ($income->income_category_assigned_to_user_id==$category->id) {
				        echo $income->getBalanceHTML();
			        }
			    }
			}
			?>
			</div>
		</div>
		<div class="col-sm-2"></div>
	</div>
	<?php if ($incomeSum!=0 || $expenseSum!=0): ?>
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-6">
			<div class="start balance">
				<h2>Bilans</h2>
				<div style="text-align: center;">Bilans w wybranym okresie wynosi:&nbsp;
				<?php $balance = $incomeSum-$expenseSum; echo round($balance,2); ?>
				</div>
				<?php if ($balance>=0): ?>
				<h3 class="balanceSuccess">Gratulacje, świetnie zarządzasz finansami!</h3>
				<?php else: ?>
				<h3 class="balanceWarning">Uwaga, zbyt duże wydatki!</h3>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-sm-3"></div>
	</div>
	<?php endif; ?>
	<?php if ($expenseSum>0): ?>
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<div class="start balance">
				<div id="chart">
					<div id="piechart"></div>
				</div>
			</div>
		</div>
		<div class="col-sm-4"></div>
	</div>
	<?php include 'templates/chart.php'; ?>
	<?php endif; ?>
</section>
<?php include 'templates/chooseDateForm.php'; ?>

