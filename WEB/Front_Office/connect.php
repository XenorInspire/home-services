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
	<title>Home Services - <?php if ($connect_status == 1) echo $connect['customerConnection'];
							else echo $connect['associateConnection']; ?></title>
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
			<h1 style="text-align: center;">Connexion - <?php if ($connect_status == 1) echo $connect['customerSpace'];
														else echo $connect['associateSpace']; ?></h1>

			<?php

			if (isset($_GET['error'])) {

				if ($_GET['error'] == 'passwd_nv') {

					echo '<br>';
					echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $connect['incorrectPasswd'] . '</div>';
				}

				if ($_GET['error'] == 'mail_nv') {

					echo '<br>';
					echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $connect['incorrectMail'] . '</div>';
				}

				if ($_GET['error'] == 'mail_nexit') {

					echo '<br>';
					echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $connect['invalidMail'] . '</div>';
				}

				if ($_GET['error'] == 'acc_dis') {

					echo '<br>';
					echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $connect['disabledAccount'] . '</div>';
				}

				if ($_GET['error'] == 'forb') {

					echo '<br>';
					echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $connect['goConnect'] . '</div>';
				}

				if ($_GET['error'] == 'qrcode_inv') {

					echo '<br>';
					echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $connect['invalidQRcode'] . '</div>';
				}
			}

			if (isset($_GET['info'])) {

				if ($_GET['info'] == 'first_connect') {

					echo '<br>';
					echo '<div class="alert alert-info alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $connect['pwdAndMail'] . '</div>';
				}

				if ($_GET['info'] == 'dis') {

					echo '<br>';
					echo '<div class="alert alert-info alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $connect['desactivatedAcc'] . '</div>';
				}
			}

			?>

			<br>
			<form action="<?php if ($connect_status == 1) echo "valid_customer_connect.php";
							else echo "valid_associate_connect.php"; ?>" method="POST">
				<div class="form-group">
					<label><?= $connect['mail'] ?></label>
					<input onchange="check_mail_connection(<?php echo $connect_status; ?>)" type="email" name="mail" class="form-control" placeholder="<?= $connect['enterMail'] ?>" autocomplete="email" maxlength="255" required>
					<small style="color:red;display:none;" id="emailHelp" class="form-text text-muted"><?= $connect['invalidMail'] ?></small>
				</div>
				<div class="form-group">
					<label><?= $connect['password'] ?></label>
					<input type="password" id="password_length" name="passwd" class="form-control" placeholder="<?= $connect['enterPwd'] ?>" required>
					<small id="emailHelp" class="form-text text-muted"><?= $connect['forgottenPwd'] ?> <i><u><a href="passwd_forgotten.php?status=<?php if ($connect_status == 1) echo "customer";
																																					else echo "associate"; ?>"><?= $connect['clickThere'] ?></a></u></i></small>
				</div>
				<div class="row justify-content-center">
					<div class="col-auto mb-3">
						<button style="margin:auto;display:block;" id="regis_button" type="submit" class="btn btn-primary"><?= $connect['connect'] ?></button>
					</div>

					<?php
					if ($connect_status == 0) {
						echo '<div class="col-auto mb-3">';
						echo '<a class="btn btn-dark" href="qrcode_connect.php">' . $connect['QRcodeConnect'] . '</a>';
						echo '</div>';
					}
					?>
				</div>
				<div class="row justify-content-center">
					<div class="col-auto mb-3">
						<div class="text-center btn btn-outline-secondary" onclick="history.back()"><?= $connect['cancel'] ?></div>
					</div>
				</div>
			</form>
		</section>

	</main>

	<?php require_once("include/footer.php"); ?>
	<script src="js/ajax_mail.js"></script>

</body>

</html>