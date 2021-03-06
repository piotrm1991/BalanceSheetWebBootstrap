<?php 
if (!isset($_SESSION['loggedIN'])) {
    header('Location: index.php?action=showMain');
}
?>
<div class="modal fade" id="addIncome" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Dodaj nowy przychód</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=addIncome" method = "POST">
					<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
							<?=$inputFields['amount']->getInputHTML()?>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<?=$inputFields['date']->getInputHTML()?>
							</div>
						</div>
						<div class="col-sm-7">
							<div class="form-group">
								<select class="form-control" name="category">
									<option selected value="" selected disabled hidden>Wybierz kategorię</option>
									<?php foreach ($inputFieldsSelection as $input): ?>
									<?php if ($input->name=='category'): ?>
									<?=$input->getInputHTML()?>
									<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-group">
						<?=$inputFields['comment']->getInputHTML()?>
						</div>
					</div>
			</div>
			<div class="modal-footer footer">
				<button class="btn btn-default"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Dodaj</button>
				</form>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>
<script>document.getElementById('datePickerIncome').valueAsDate = new Date();</script>
