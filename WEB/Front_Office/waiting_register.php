	<?php require_once('include/check_identity.php'); ?>

	<!DOCTYPE html>
	<html lang="en" dir="ltr">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Home Services - En attente</title>
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
				<h1><i>Un mail de confirmation vous a été envoyé.</i></h1>
				<br>
				<li>Vous n'avez pas reçu de confirmation ?</li>
				<br>
				<button type="button" onclick="window.location.href = 'mail_again.php';" class="btn btn-dark">Renvoyer</button>
			</section>
		</main>

		<?php require_once("include/footer.php"); ?>

	</body>

	</html>