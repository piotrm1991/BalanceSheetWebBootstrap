<?php if(!isset($_SESSION['loggedIN'])) exit(); ?>
<section class="index-start">
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<div class="start">
				<div style="border-bottom: 1px dashed #aa1818; padding-bottom: 10px;"><h2>Ustawienia</h2></div>
				<div style="padding-bottom: 20px;">
					<h3>Edytuj kategorie</h3>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-sm-4">
									<a data-toggle="modal" data-target="#editExpenseCategory"><button class="btn btn-default btn-block"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Wydatki</button></a>
								</div>
								<div class="col-sm-4">
									<a data-toggle="modal" data-target="#editIncomeCategory"><button class="btn btn-default btn-block"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Przychody</button></a>
								</div>
								<div class="col-sm-4">
									<a data-toggle="modal" data-target="#editPaymentMethod"><button class="btn btn-default btn-block"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Sposób płatności</button></a>
								</div>
							</div>
						</div>
						<div class="col-sm-1"></div>
					</div>
				</div>
				<div style="padding-bottom: 20px;">
					<h3>Dodawaj kategorie</h3>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-sm-4">
									<a data-toggle="modal" data-target="#addExpenseCategory"><button class="btn btn-default btn-block"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Wydatki</button></a>
								</div>
								<div class="col-sm-4">
									<a data-toggle="modal" data-target="#addIncomeCategory"><button class="btn btn-default btn-block"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Przychody</button></a>
								</div>
								<div class="col-sm-4">
									<a data-toggle="modal" data-target="#addPaymentMethod"><button class="btn btn-default btn-block"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Sposób płatności</button></a>
								</div>
							</div>
						</div>
						<div class="col-sm-1"></div>
					</div>
				</div>
				<div style="padding-bottom: 20px; border-bottom: 1px dashed #aa1818;">
					<h3>Usuwaj kategorie</h3>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-sm-4">
									<a data-toggle="modal" data-target="#deleteExpenseCategory"><button class="btn btn-default btn-block"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Wydatki</button></a>
								</div>
								<div class="col-sm-4">
									<a data-toggle="modal" data-target="#deleteIncomeCategory"><button class="btn btn-default btn-block"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Przychody</button></a>
								</div>
								<div class="col-sm-4">
									<a data-toggle="modal" data-target="#deletePaymentMethod"><button class="btn btn-default btn-block"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Sposób płatności</button></a>
								</div>
							</div>
						</div>
						<div class="col-sm-1"></div>
					</div>
				</div>
				<div style="padding-bottom: 20px;">
					<h3>Twoje konto</h3>
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-6">
							<div style="padding-bottom: 5px;">
								<a data-toggle="modal" data-target="#editUser"><button class="btn btn-default btn-block"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Edytuj dane konta</button></a>
							</div>
							<a data-toggle="modal" data-target="#deleteUserForm"><button class="btn btn-default btn-block"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Usuń konto</button></a>
						</div>
						<div class="col-sm-3"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-1"></div>
	</div>
</section>