<?php 
if (!isset($_SESSION['loggedIN'])) {
    header('Location: index.php?action=showMain');
}
?>
<div class="modal fade" id="deleteExpenseCategory" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Usuń kategorię wydatków</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=deleteExpenseCategory" method = "post">
					<div class="form-group">
						<select class="form-control" name="category">
							<option selected value="" selected disabled hidden>Wybierz kategorię</option>
							<?php foreach ($inputExpenseFields as $input): ?>
							<?=$input->getInputHTML()?>
							<?php endforeach; ?>
						</select>
					</div>
					<div style="text-align: center;">Uwaga! Ta opcja usunie wszystkie wpisy w tej kategorii!</div>
			</div>
			<div class="modal-footer footer">
				<button class="btn btn-default"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Usuń</button>
				</form>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>
<div class="modal fade" id="deleteIncomeCategory" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Usuń kategorię przychodów</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=deleteIncomeCategory" method = "post">
					<div class="form-group">
						<select class="form-control" name="category">
							<option selected value="" selected disabled hidden>Wybierz kategorię</option>
							<?php foreach ($inputIncomeFields as $input): ?>
							<?=$input->getInputHTML()?>
							<?php endforeach; ?>
						</select>
					</div>
					<div style="text-align: center;">Uwaga! Ta opcja usunie wszystkie wpisy w tej kategorii!</div>
			</div>
			<div class="modal-footer footer">
				<button class="btn btn-default"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Usuń</button>
				</form>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>
<div class="modal fade" id="deletePaymentMethod" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Usuń sposób płatności</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=deletePaymentCategory" method = "post">
					<div class="form-group">
						<select class="form-control" name="category">
							<option selected value="" selected disabled hidden>Wybierz sposób płatności</option>
							<?php foreach ($inputPaymentFields as $input): ?>
							<?=$input->getInputHTML()?>
							<?php endforeach; ?>
						</select>
					</div>
					<div style="text-align: center;">Uwaga! Ta opcja usunie wszystkie wpisy w tej kategorii!</div>
			</div>
			<div class="modal-footer footer">
				<button class="btn btn-default"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Usuń</button>
				</form>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>