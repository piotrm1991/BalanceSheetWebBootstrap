<?php if(!$this) exit();
if (isset($_SESSION['loggedIN'])) {
    header('Location: index.php?action=showStart');
}
?>
<div class="container">
	<div class="index">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div id="registrationFormDiv">
					<div class="index-intro">
						<h2>Stwórz nowe konto!</h2>
					</div>
					<form action = "index.php?action=registerUser" method = "post">
						<?php foreach ($formData as $input): ?>
						<div class="form-group">
						<?=$input->getInputHTML()?>
						</div>	
						<?php endforeach; ?>
						<div class="form-group">
							<div class="g-recaptcha" data-sitekey="6LeaGXYUAAAAAFyR82flcWL2S1wAG4WEfh8vsTjJ"></div>
						</div>
						<?php if (isset($_SESSION['registration_error'])): ?>
						<div class="message" style="text-align: center;"><?=$_SESSION['registration_error'];?></div>
						<?php unset($_SESSION['registration_error']); ?>
						<?php endif; ?>
						<div class="form-group">
							<button class="btn btn-default btn-sm btn-block">Utwórz konto</button>
						</div>
					</form>
					<form action="index.php?action=showMain">
						<div class="form-group">
							<button class="btn btn-primary btn-sm btn-block">Wstecz</button>
						</div>
					</form>
				</div>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</div>