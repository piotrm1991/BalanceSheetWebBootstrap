<?php 
if (!isset($_SESSION['loggedIN'])) {
    header('Location: index.php?action=showMain');
}
?>
<div class="modal fade" id="addExpenseCategory" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Dodaj kategorię wydatków</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=addExpenseCategory" method = "post">
					<div class="form-group">
						<input type="text" placeholder="Nowa nazwa" class="form-control" name="newCategoryName">
					</div>
			</div>
			<div class="modal-footer footer">
				<button class="btn btn-default"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Dodaj</button>
				</form>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>
<div class="modal fade" id="addIncomeCategory" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Dodaj kategorię przychodów</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=addIncomeCategory" method = "post">
					<div class="form-group">
						<input type="text" placeholder="Nowa nazwa" class="form-control" name="newCategoryName">
					</div>
			</div>
			<div class="modal-footer footer">
				<button class="btn btn-default"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Dodaj</button>
				</form>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>
<div class="modal fade" id="addPaymentMethod" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Dodaj sposób płatności</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=addPaymentCategory" method = "post">
					<div class="form-group">
						<input type="text" placeholder="Nowa nazwa" class="form-control" name="newCategoryName">
					</div>
			</div>
			<div class="modal-footer footer">
				<button class="btn btn-default"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Dodaj</button>
				</form>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>