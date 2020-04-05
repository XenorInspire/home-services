	<?php require_once('include/check_identity.php'); ?>

	<!DOCTYPE html>
	<html lang="en" dir="ltr">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Home Services - Boutique</title>
		<link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
	</head>

	<body>

		<?php require_once("include/header.php"); ?>

		<main>

			<section class="container text-center">

				<br>
				<br>
				<br>
				<h1>Abonnements</h1>
				<br>
				<?php
				if (isset($_GET['err'])) {


					if ($_GET['err'] == 'alr') {

						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Vous possédez déjà un abonnement, si vous voulez changer d\'abonnement vous devez tout d\'abord le résilier.</div>';
						echo '<br>';
					}

					if ($_GET['err'] == 'inp') {

						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Une erreur s\'est produite durant le processus de paiement.</div>';
						echo '<br>';
					}

					if ($_GET['err'] == 'na') {

						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Cet abonnement n\'est plus disponible.</div>';
						echo '<br>';
					}
				}
				?>
				<?php

				$hm_database = new DBManager($bdd);
				$subs = $hm_database->getAllSubscriptionTypes();

				for ($i = 0; $i < count($subs); $i++) {

					sscanf($subs[$i]->getBeginTime(), "%d:%s", $time1, $trash);
					sscanf($subs[$i]->getEndTime(), "%d:%s", $time2, $trash);

				?>

					<div style="display: inline-block; margin: 10px;" class="card mb-4 box-shadow">
						<div class="card-header">
							<h4 class="my-0 font-weight-normal"><?php echo $subs[$i]->getTypeName(); ?></h4>
						</div>
						<div class="card-body">
							<h1 class="card-title pricing-card-title"><?php echo $subs[$i]->getPrice(); ?>€ TTC<small class="text-muted">/an</small></h1>
							<ul class="list-unstyled mt-3 mb-4">
								<li><?php echo $subs[$i]->getDays(); ?> jours par semaine</li>

								<?php

								if ($time1 == 24 && $time2 == 24) {

								?>

									<li>24h sur 24 !</li>

								<?php

								} else {

								?>
									<li>De <?php echo $time1; ?>h à <?php echo $time2; ?>h</li>

								<?php

								}

								?>

								<li>Avec un maximum de <?php echo $subs[$i]->getServiceTime(); ?>h par mois !</li>
							</ul>
							<button type="button" onclick="window.location.href = 'subscription.php?s=<?php echo $subs[$i]->getTypeId(); ?>';" class="btn btn-lg btn-block btn-primary">S'abonner</button>
						</div>
					</div>

				<?php

				}


				?>



			</section>

		</main>

		<?php require_once("include/footer.php"); ?>

	</body>

	</html>