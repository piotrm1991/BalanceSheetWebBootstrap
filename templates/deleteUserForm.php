<?php 
if (!isset($_SESSION['loggedIN'])) {
    header('Location: index.php?action=showMain');
}
?>
<div class="modal fade" id="deleteUserForm" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Czy napewno chcesz usunąć swoje konto?</h4>
			</div>
			<div class="modal-footer footer">
				<a href="index.php?action=deleteUser"><button class="btn btn-default"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Usuń</button></a>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>
