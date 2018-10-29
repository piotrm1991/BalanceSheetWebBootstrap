<?php 
if (!isset($_SESSION['loggedIN'])) {
    header('Location: index.php?action=showMain');
}
?>
<div class="modal fade" id="deleteIncome" role="dialog">
	<div class="modal-dialog modal-me">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Czy napewno chcesz usunąć?</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=deleteIncome" method = "post">
					<div class="row">
						<div class="col-sm-4">
							<strong>Data:</strong>&nbsp;<span class="date"></span>
						</div>
						<div class="col-sm-3">
							<strong>Kwota:</strong>&nbsp;<span class="amount"></span>
						</div>
						<div class="col-sm-5">
							<strong>Kategoria:</strong>&nbsp;<span class="categoryTranslated"></span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<strong>Komentarz:</strong>&nbsp;<span class="comment"></span>
						</div>
					</div>
			</div>
			<input type="hidden" name="id" class="id">
			<input type="hidden" name="income_category_assigned_to_user_id" class="income_category_assigned_to_user_id">
			<input type="hidden" name="amount" class="amountVal">
			<input type="hidden" name="date" class="dateVal">
			<input type="hidden" name="comment" class="commentVal">
			<div class="modal-footer footer">
				<button class="btn btn-default"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Usuń</button>
				</form>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>
<script>
$('#deleteIncome').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var date = button.data('date') 
  var amount = button.data('amount')
  var category = button.data('category')
  var comment = button.data('comment')
  var id = button.data('id')
  var categoryId = button.data('category-id')
  
  var modal = $(this)
  modal.find('.amount').text(amount)
  modal.find('.date').text(date)
  modal.find('.categoryTranslated').text(category)
  modal.find('.comment').text(comment)
  
  modal.find('.id').val(id)
  modal.find('.income_category_assigned_to_user_id').val(categoryId)
  modal.find('.amountVal').val(amount)
  modal.find('.dateVal').val(date)
  modal.find('.commentVal').val(comment)
})
</script>
