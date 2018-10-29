<?php 
if (!isset($_SESSION['loggedIN'])) {
    header('Location: index.php?action=showMain');
}
?>
<div class="modal fade" id="editIncome" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content addEntry">
			<div class="modal-header header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title headerAddEntry">Edytuj wpis</h4>
			</div>
			<div class="modal-body">
				<form action = "index.php?action=editIncome" method = "POST">
					<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								<label for="amount"><strong>Kwota:</strong>&nbsp;<span class="amount"></span></label>
								<?=$inputFields['amount']->getInputHTML()?>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label for="date"><strong>Data:</strong>&nbsp;<span class="date"></span></label>
								<?=$inputFields['date']->getInputHTML()?>
							</div>
						</div>
						<div class="col-sm-7">
							<div class="form-group">
								<label for="category"><strong>Kategoria:</strong>&nbsp;<span class="categoryTranslated"></span></label>
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
					<label for="comment"><strong>Komentarz:</strong>&nbsp;<span class="comment"></span></label>
					<?=$inputFields['comment']->getInputHTML()?>
					</div>
			</div>
			<input type="hidden" name="id" class="id">
			<input type="hidden" name="income_category_assigned_to_user_id_old" class="income_category_assigned_to_user_id_old">
			<input type="hidden" name="amount_old" class="amountVal">
			<input type="hidden" name="date_old" class="dateVal">
			<input type="hidden" name="comment_old" class="commentVal">
			<div class="modal-footer footer">
				<button class="btn btn-default"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Zapisz</button>
				</form>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Zamkni</button>
			</div>	
		</div>
	</div>
</div>
<script>
$('#editIncome').on('show.bs.modal', function (event) {
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
  modal.find('.income_category_assigned_to_user_id_old').val(categoryId)
  modal.find('.amountVal').val(amount)
  modal.find('.dateVal').val(date)
  modal.find('.commentVal').val(comment)
})
</script>