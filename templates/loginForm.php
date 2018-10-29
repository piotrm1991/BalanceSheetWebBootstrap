<?php 
if (!isset($portal)) exit(); 
if (isset($_SESSION['loggedIN'])) {
    header('Location: index.php?action=showStart');
}
?>
<div class="container">
	<div class="index">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div class="index-intro">
					<h2>Zaloguj się na swoje konto!</h2>
				</div>
				<form action = "index.php?action=login"
					  method = "post">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input class="form-control" type="text" name="username" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input class="form-control" type="password" name="password" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'">
						</div>
					</div>
					<?php if($message): ?>
					<div style="text-align: center;"><?=$message;?></div>
					<?php endif; ?>
					<div class="form-group">
						<button class="btn btn-default btn-sm btn-block">Zaloguj się</button>
					</div>
				</form>
				<form action="index.php?action=showMain">
					<div class="form-group">
						<button class="btn btn-primary btn-sm btn-block">Wstecz</button>
					</div>
				</form>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</div>