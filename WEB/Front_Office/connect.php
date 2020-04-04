<?php

require_once('include/check_identity.php');
if ($connected == 1) {

	header('Location: index.php');
	exit;
}

if (!isset($_GET['status']) || empty(trim($_GET['status']))) {

	header('Location: connect.php?status=customer');
	exit;
}

if ($_GET['status'] == "customer") {

	$connect_status = 1;
} elseif ($_GET['status'] == "associate") {

	$connect_status = 0;
} else {

	header('Location: connect.php?status=customer');
	exit;
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home Services - Connexion <?php if ($connect_status == 1) echo "Client";
										else echo "Prestataire"; ?></title>
	<link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

	<?php require_once("include/header.php"); ?>

	<main>

		<section class="container">
			<br>
			<br>
			<br>
			<h1 style="text-align: center;">Connexion - Espace <?php if ($connect_status == 1) echo "client";
																else echo "prestataire"; ?></h1>

			<?php

			if (isset($_GET['error'])) {

				if ($_GET['error'] == 'passwd_nv') {

					echo '<br>';
					echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Mot de passe incorrect.</div>';
				}

				if ($_GET['error'] == 'mail_nv') {

					echo '<br>';
					echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Erreur, veuillez saisir une adresse e-mail valide</div>';
				}

				if ($_GET['error'] == 'mail_nexit') {

					echo '<br>';
					echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Cette adresse e-mail n\'existe pas</div>';
				}

				if ($_GET['error'] == 'acc_dis') {

					echo '<br>';
					echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Ce compte n\'est pas encore activé</div>';
				}

				if ($_GET['error'] == 'forb') {

					echo '<br>';
					echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Veuillez vous connecter avant de poursuivre</div>';
				}
			}

			?>

			<br>
			<form action="<?php if ($connect_status == 1) echo "valid_customer_connect.php";
							else echo "valid_associate_connect.php"; ?>" method="POST">
				<div class="form-group">
					<label>Adresse mail</label>
					<input onchange="check_mail_connection(<?php echo $connect_status; ?>)" type="email" name="mail" class="form-control" placeholder="Entez votre email" autocomplete="email" maxlength="255" required>
					<small style="color:red;display:none;" id="emailHelp" class="form-text text-muted">Cette adresse mail n'existe pas !</small>
				</div>
				<div class="form-group">
					<label>Mot de passe</label>
					<input type="password" id="password_length" name="passwd" class="form-control" placeholder="Entrez votre mot de passe" required>
					<small id="emailHelp" class="form-text text-muted">Vous avez oublié votre mot de passe ? <i><u><a href="passwd_forgotten.php?status=<?php if ($connect_status == 1) echo "customer";
																																						else echo "associate"; ?>">Cliquez ici</a></u></i></small>
				</div>
				<button style="margin:auto;display:block;" id="regis_button" type="submit" class="btn btn-primary">Se connecter</button>
			</form>
		</section>

	</main>

	<?php require_once("include/footer.php"); ?>
	<script src="js/ajax_mail.js"></script>

</body>

</html>