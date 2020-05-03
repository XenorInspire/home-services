	<?php

	require_once('include/check_identity.php');
	if ($connected == 1) {

		header('Location: index.php');
		exit;
	}

	?>

	<!DOCTYPE html>
	<html lang="en" dir="ltr">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Home Services - <?= $registration['signIn'] ?></title>
		<link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
	</head style="background-color: whitesmoke;">

	<body>

		<?php require_once("include/header.php"); ?>

		<main>

			<section class="container">
				<br>
				<br>
				<br>
				<h1 style="text-align: center;"><?= $registration['signIn'] ?></h1>

				<?php

				if (isset($_GET['error'])) {


					if ($_GET['error'] == 'captcha_inv') {

						echo '<br>';
						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $registration['captchaError'] . '</div>';
					}

					if ($_GET['error'] == 'inputs_inv') {

						echo '<br>';
						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $registration['emptyError'] . '</div>';
					}

					if ($_GET['error'] == 'password_inv') {

						echo '<br>';
						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $registration['passwdError'] . '</div>';
					}

					if ($_GET['error'] == 'password_length') {

						echo '<br>';
						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $registration['lengthError'] . '</div>';
					}

					if ($_GET['error'] == 'email_inv') {

						echo '<br>';
						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $registration['mailError'] . '</div>';
					}

					if ($_GET['error'] == 'mail_taken') {

						echo '<br>';
						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $registration['mailAlreadyUsed'] . '</div>';
					}

					if ($_GET['error'] == 'lname_length') {

						echo '<br>';
						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $registration['nameError'] . '</div>';
					}

					if ($_GET['error'] == 'fname_length') {

						echo '<br>';
						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $registration['firstNameError'] . '</div>';
					}

					if ($_GET['error'] == 'city_length') {

						echo '<br>';
						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $registration['cityError'] . '</div>';
					}

					if ($_GET['error'] == 'ps_length') {

						echo '<br>';
						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $registration['pseudoError'] . '</div>';
					}

					if ($_GET['error'] == 'mail_length') {

						echo '<br>';
						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $registration['mailError'] . '</div>';
					}
				}

				?>

				<br>
				<form action="valid_registration.php" method="POST">
					<div class="form-group">
						<label><?= $registration['name'] ?></label>
						<input type="text" name="lastname" class="form-control" placeholder="Entrez votre nom" maxlength="255" required>
					</div>
					<div class="form-group">
						<label><?= $registration['firstName'] ?></label>
						<input type="text" name="firstname" class="form-control" placeholder="Entrez votre prénom" maxlength="255" required>
					</div>
					<div class="form-group">
						<label><?= $registration['mail'] ?></label>
						<input onchange="check_mail_registration()" type="email" name="mail" class="form-control" placeholder="Entrez votre adresse mail" autocomplete="email" maxlength="255" required>
						<small id="emailHelp" class="form-text text-muted"><?= $registration['mailNotShared'] ?></small>
					</div>
					<div class="form-group">
						<label><?= $registration['phone'] ?></label>
						<input type="tel" name="phone_number" class="form-control" placeholder="Entrez votre numéro de téléphone" required>
					</div>
					<div class="form-group">
						<label><?= $registration['address'] ?></label>
						<input type="text" name="address" class="form-control" placeholder="Entrez votre adresse" maxlength="255" required>
					</div>
					<div class="form-group">
						<label><?= $registration['city'] ?></label>
						<input type="text" name="city" class="form-control" placeholder="Entrez votre ville" maxlength="255" required>
					</div>
					<div class="form-group">
						<label><?= $registration['passwd'] ?></label>
						<input type="password" id="password_length" name="passwd" onkeyup="checkPassword()" class="form-control" placeholder="Entrez votre mot de passe" required>
						<small id="password_size" class="form-text"><?= $registration['charMin'] ?></small>
					</div>
					<div class="form-group">
						<label><?= $registration['confirm'] ?></label>
						<input type="password" id="same" onkeyup="samePassword()" name="passwd_confirmed" class="form-control" placeholder="Confirmez votre mot de passe" required>
						<small id="password_same" class="form-text"><?= $registration['passwdError'] ?> !</small>
					</div>
					<div class="form-group">
						<label><?= $registration['captcha'] ?></label>
						<input type="text" name="captcha" class="form-control" required>
						<img src="captcha/captcha.php" alt="captcha">
					</div>
					<button id="regis_button" type="submit" class="btn btn-primary"><?= $registration['signMeIn'] ?></button>
				</form>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
			</section>

		</main>

		<?php require_once("include/footer.php"); ?>
		<script src="js/password.js"></script>
		<script src="js/ajax_mail.js"></script>

	</body>

	</html>
