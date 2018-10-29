<?php 
if (!isset($_SESSION['loggedIN'])) {
    header('Location: index.php?action=showMain');
}
?>
<div class="modal fade" id="editExpenseCategory" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Edytuj kategorię wydatków</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=editExpenseCategory" method = "post">
					<div class="form-group">
						<input type="text" placeholder="Nowa nazwa" class="form-control" name="newCategoryName">
					</div>
					<div class="form-group">
						<select class="form-control" name="category">
							<option selected value="" selected disabled hidden>Wybierz kategorię</option>
							<?php foreach ($inputExpenseFields as $input): ?>
							<?=$input->getInputHTML()?>
							<?php endforeach; ?>
						</select>
					</div>
			</div>
			<div class="modal-footer footer">
				<button class="btn btn-default"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Zmień</button>
				</form>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>
<div class="modal fade" id="editIncomeCategory" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Edytuj kategorię przychodów</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=editIncomeCategory" method = "post">
					<div class="form-group">
						<input type="text" placeholder="Nowa nazwa" class="form-control" name="newCategoryName">
					</div>
					<div class="form-group">
						<select class="form-control" name="category">
							<option selected value="" selected disabled hidden>Wybierz kategorię</option>
							<?php foreach ($inputIncomeFields as $input): ?>
							<?=$input->getInputHTML()?>
							<?php endforeach; ?>
						</select>
					</div>
			</div>
			<div class="modal-footer footer">
				<button class="btn btn-default"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Zmień</button>
				</form>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>
<div class="modal fade" id="editPaymentMethod" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Edytuj sposób płatności</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=editPaymentCategory" method = "post">
					<div class="form-group">
						<input type="text" placeholder="Nowa nazwa" class="form-control" name="newCategoryName">
					</div>
					<div class="form-group">
						<select class="form-control" name="category">
							<option selected value="" selected disabled hidden>Wybierz sposób płatności</option>
							<?php foreach ($inputPaymentFields as $input): ?>
							<?=$input->getInputHTML()?>
							<?php endforeach; ?>
						</select>
					</div>
			</div>
			<div class="modal-footer footer">
				<button class="btn btn-default"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Zmień</button>
				</form>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>