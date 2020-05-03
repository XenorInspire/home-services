<?php

require_once('include/check_identity.php');
if (!($status == 'associate' && $connected == 1)) {

	header('Location: connect.php?status=associate&error=forb');
	exit;
}

if (
	isset($_GET['serviceProvidedId']) && !empty($_GET['serviceProvidedId'])
) {
	$serviceProvidedId = $_GET['serviceProvidedId'];
	$associateId = $id;
	$hm_database = new DBManager($bdd);

	$servPro = $hm_database->getServiceProvided($serviceProvidedId);

	$reservation = $hm_database->getReservationByServiceProvidedId($serviceProvidedId);

	if ($reservation->getStatus() == 1) {
		header('Location: index.php');
		exit;
	}

	$serviceId = $servPro->getServiceId();
	$serv = $hm_database->getService($serviceId);

	$customerId = $reservation->getCustomerId();
	$customer = $hm_database->getUserById($customerId);
} else {
	header('Location: index.php');
	exit;
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home Services - <?= $associate_proposal_accept['homepage'] ?></title>
	<link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

	<?php require_once("include/header.php"); ?>

	<main>
		<br>
		<div class="container-fluid">
			<div class="jumbotron">
				<div class="display-4 text-center"> <?= $associate_proposal_accept['bookOf'] ?></div>
				<div class="display-4 text-center"><?= $customer->getLastname() ?> <?= $customer->getFirstname() ?></div>
				<hr>
				<div class="card border-secondary">
					<div class="card-header text-center">
						<?= $associate_proposal_accept['serviceInformations'] ?>
					</div>
					<div class="card-body">
						<h5 class="card-title"><?= $serv->getServiceTitle() ?></h5>
						<p class="card-text">
							<div class="form-group">
								<label> <?= $associate_proposal_accept['description'] ?></label>
								<input type="text" class="form-control" value="<?= $serv->getDescription() ?>" readonly>
							</div>
							<div class="form-group">
								<label> <?= $associate_proposal_accept['date'] ?></label>
								<input type="text" class="form-control" value="<?= $servPro->getDate() ?>" readonly>
							</div>
							<?php
							$parts = explode(".", $servPro->getBeginHour());
							?>
							<div class="form-group">
								<label> <?= $associate_proposal_accept['hour'] ?></label>
								<input type="text" class="form-control" value="<?= $parts[0] ?>" readonly>
							</div>
							<div class="form-group">
								<label> <?= $associate_proposal_accept['place'] ?></label>
								<input type="text" class="form-control" value="<?= $servPro->getAddress() ?>, <?= $servPro->getTown() ?>" readonly>
							</div>
						</p>
						<br>
						<div class="form-group">
							<div class="row">
								<div class="col-md mb-3">
									<div class="btn btn-outline-success btn-block" data-toggle="modal" data-target="#modalSave"> <?= $associate_proposal_accept['serviceAccept'] ?></a></div>
								</div>
								<div class="col-md mb-3">
									<div class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#modalCancel"> <?= $associate_proposal_accept['serviceDecline'] ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal for saving -->
				<div class="modal fade" id="modalSave">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<!-- Modal Header -->
							<div class="modal-header">
								<h4 class="modal-title"> <?= $associate_proposal_accept['serviceAcceptance'] ?></h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<!-- Modal body -->
							<div class="modal-body">
								<?= $associate_proposal_accept['serviceAcceptanceQuestion'] ?>
							</div>
							<!-- Modal footer -->
							<div class="modal-footer">
								<a class="" href="accept_proposal.php?serviceProvidedId=<?= $serviceProvidedId ?>&associateId=<?= $associateId ?>">
									<div class="btn btn-outline-success"> <?= $associate_proposal_accept['accept'] ?></div>
								</a>
								<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"> <?= $associate_proposal_accept['cancel'] ?></button>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal for cancelling -->
				<div class=" modal fade" id="modalCancel">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<!-- Modal Header -->
							<div class="modal-header">
								<h4 class="modal-title"> <?= $associate_proposal_accept['serviceRefusal'] ?></h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<!-- Modal body -->
							<div class="modal-body">
								<?= $associate_proposal_accept['serviceRefusalQuestion'] ?>
							</div>
							<!-- Modal footer -->
							<div class="modal-footer">
								<a class="" href="deny_proposal.php?serviceProvidedId=<?= $serviceProvidedId ?>&associateId=<?= $associateId ?>">
									<div class="btn btn-outline-danger"> <?= $associate_proposal_accept['decline'] ?></div>
								</a>
								<button type=" button" class="btn btn-outline-secondary" data-dismiss="modal"> <?= $associate_proposal_accept['cancel'] ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</main>

	<?php require_once("include/footer.php"); ?>

</body>

</html>