<?php 
if (!isset($_SESSION['loggedIN'])) {
    header('Location: index.php?action=showMain');
}
?>
<div class="modal fade" id="chooseDate" role="dialog">
	<div class="modal-dialog modal-me">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Wybierz daty</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=chooseDate" method = "POST">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="dateA">Od:</label>
								<input type="date" name="dateA" class="form-control">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="dateB">Do:</label>
								<input type="date" name="dateB" class="form-control">
							</div>
						</div>
					</div>
			</div>
			<div class="modal-footer footer">
				<button class="btn btn-default"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Prześlij</button>
				</form>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>

