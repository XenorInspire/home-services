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
		<title>Home Services - <?= $waiting_register['waiting'] ?></title>
		<link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
	</head>

	<body>

		<?php require_once("include/header.php"); ?>

		<main>
			<br>
			<br>
			<br>
			<br>
			<br>
			<section class="container text-center">
				<h1><i><?= $waiting_register['confMail'] ?></i></h1>
				<br>
				<li><?= $waiting_register['noConfMail'] ?></li>
				<br>
				<button type="button" onclick="window.location.href = 'mail_again.php';" class="btn btn-dark"><?= $waiting_register['sendAgain'] ?></button>
			</section>
		</main>

		<?php require_once("include/footer.php"); ?>

	</body>

	</html>
