<?php 
if (!isset($_SESSION['loggedIN'])) {
    header('Location: index.php?action=showMain');
}
?>
<div class="modal fade" id="editUser" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Edytuj kategorię wydatków</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=changeUsername" method = "post">
					<div class="form-group">
						<input type="text" placeholder="Nowa nazwa użytkownika" class="form-control" name="newUsername">
					</div>
					<button class="btn btn-default"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Zapisz</button>
				</form>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=changePassword" method = "post">
					<div class="form-group">
						<input type="password" placeholder="Nowe hasło" class="form-control" name="newPassword">
					</div>
					<div class="form-group">
						<input type="password" placeholder="Stare hasło" class="form-control" name="oldPassword">
					</div>
					<button class="btn btn-default"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Zapisz</button>
				</form>
			</div>
			<div class="modal-footer footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>
