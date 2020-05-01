	<?php require_once('include/check_identity.php'); ?>

	<!DOCTYPE html>
	<html lang="en" dir="ltr">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Home Services - <?= $shop['shop'] ?></title>
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
				<h1><?= $shop['subscriptions'] ?></h1>
				<br>
				<?php
				if (isset($_GET['err'])) {

					if ($_GET['err'] == 'alr') {

						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $shop['alreadyHave'] . '</div>';
						echo '<br>';
					}

					if ($_GET['err'] == 'inp') {

						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $shop['paymentError'] . '</div>';
						echo '<br>';
					}

					if ($_GET['err'] == 'na') {

						echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $shop['unavailableSub'] . '</div>';
						echo '<br>';
					}
				}

				if (isset($_GET['info'])) {

					if ($_GET['info'] == 'success') {

						echo '<div class="alert alert-success alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $shop['registeredBook'] . '</div>';
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
							<h1 class="card-title pricing-card-title"><?php echo $subs[$i]->getPrice(); ?><?= $shop['allTax'] ?><small class="text-muted"><?= $shop['perYear'] ?></small></h1>
							<ul class="list-unstyled mt-3 mb-4">
								<li><?php echo $subs[$i]->getDays(); ?><?= $shop['daysAWeek'] ?></li>

								<?php

								if ($time1 == 24 && $time2 == 24) {

								?>

									<li><?= $shop['allDay'] ?></li>

								<?php

								} else {

								?>
									<li><?= $shop['from'] ?><?php echo $time1; ?><?= $shop['to'] ?><?php echo $time2; ?><?= $shop['clock'] ?></li>

								<?php

								}

								?>

								<li><?= $shop['withMax'] ?><?php echo $subs[$i]->getServiceTime(); ?><?= $shop['hoursAMonth'] ?></li>
							</ul>
							<button type="button" onclick="window.location.href = 'subscription.php?s=<?php echo $subs[$i]->getTypeId(); ?>';" class="btn btn-lg btn-block btn-primary"><?= $shop['subscribeMe'] ?></button>
						</div>
					</div>

				<?php

				}

				?>

			</section>

			<section class="container text-center">
				<br>
				<h1><?= $shop['recurrentServices'] ?></h1>
				<br>
				<table class="table">
					<thead class="thead-dark">
						<tr>
							<th scope="col"><?= $shop['category'] ?></th>
							<th scope="col"><?= $shop['service'] ?></th>
							<th scope="col"><?= $shop['price'] ?></th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>

						<?php

						$services = $hm_database->getRecurringServices();

						for ($i = 0; $i < count($services); $i++) { ?>

							<tr>
								<td><?= $hm_database->getServiceType($services[$i]->getServiceTypeId())->getTypeName() ?></td>
								<td><?= $services[$i]->getServiceTitle() ?></td>
								<td><?= $services[$i]->getServicePrice() ?><?= $shop['euroPerHour'] ?></td>
								<td><button type="button" class="btn btn-primary mb-2" onclick="window.location.href = 'book_service.php?i=<?= $services[$i]->getServiceId() ?>';"><?= $shop['book'] ?></button></td>
							</tr>

						<?php
						}

						?>

					</tbody>
				</table>
				<br>
				<button type="button" onclick="window.location.href = 'all_services.php';" class="btn btn-lg btn-primary"><?= $shop['allServices'] ?></button>
				<br>
				<br>
				<br>
			</section>

		</main>

		<?php require_once("include/footer.php"); ?>

	</body>

	</html>
