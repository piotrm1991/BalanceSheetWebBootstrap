<?php 
if (!isset($portal)) exit(); 
if (isset($_SESSION['loggedIN'])) {
    header ('Location: index.php?action=showStart');
}
?>
<div class="container">
	<div class="index">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<div class="index-intro">
					<h1>Bilans Wydatków</h1>
					<p>Oszczędzaj kontrolując swoje wydatki</p>
				</div>
			</div>
			<div class="col-sm-2"></div>
		</div>
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-4">
				<button class="btn btn-default btn-sm btn-block" onclick="location.href = 'index.php?action=showRegistrationForm'">Nowe konto</button>
			</div>
			<div class="col-sm-4">
				<button class="btn btn-default btn-sm btn-block" onclick="location.href = 'index.php?action=showLoginForm'" name="logIn">Zaloguj się</button>
			</div>
			<div class="col-sm-2"></div>
		</div>
		<?php if ($message): ?>
		<div style="margin-top: 20px;">
			<div class="row">
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
					<div class="alert alert-info alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong><?=$message;?></strong>
					</div>
				</div>
				</div>
				<div class="col-sm-4"></div>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>
