<?php

require_once('include/check_identity.php');
if (!($status == 'associate' && $connected == 1)) {

	header('Location: connect.php?status=associate&error=forb');
	exit;
}

if (
	isset($_GET['serviceProvidedId']) && !empty($_GET['serviceProvidedId'])
	&& isset($_GET['associateId']) && !empty($_GET['associateId'])
) {
	$serviceProvidedId = $_GET['serviceProvidedId'];
	$associateId = $_GET['associateId'];
	$hm_database = new DBManager($bdd);

	$servPro = $hm_database->getServiceProvided($serviceProvidedId);

	$reservation = $hm_database->getReservationByServiceProvidedId($serviceProvidedId);

	if($reservation->getStatus() == 1){
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
	<title>Home Services - Accueil</title>
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
				<div class="display-4 text-center">Réservation de</div>
				<div class="display-4 text-center"><?= $customer->getLastname() ?> <?= $customer->getFirstname() ?></div>

				<?php
				// if (isset($_GET['delete']) == "successful") {
				//     echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">L\'abonnement a bien été supprimé</div>';
				// }

				// if (isset($_GET['create']) == "successful") {
				//     echo '<div class="alert alert-success alert-dismissible " class="close" data-dismiss="alert" role="alert">L\'abonnement a bien été créé</div>';
				// }

				// if (isset($_GET['edit']) == "successful") {
				//     echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">L\'abonnement a bien été modifié</div>';
				// }

				?>
				<hr>
				<div class="card border-secondary">
					<div class="card-header text-center">
						Informations Service
					</div>
					<div class="card-body">
						<h5 class="card-title"><?= $serv->getServiceTitle() ?></h5>
						<p class="card-text">
							<div class="form-group">
								<label>Description</label>
								<input type="text" class="form-control" value="<?= $serv->getDescription() ?>" readonly>
							</div>
							<div class="form-group">
								<label>Date</label>
								<input type="text" class="form-control" value="<?= $servPro->getDate() ?>" readonly>
							</div>
							<div class="form-group">
								<label>Heure</label>
								<input type="text" class="form-control" value="<?= $servPro->getBeginHour() ?>" readonly>
							</div>
							<div class="form-group">
								<label>Lieu</label>
								<input type="text" class="form-control" value="<?= $servPro->getAddress() ?>, <?= $servPro->getTown() ?>" readonly>
							</div>
						</p>
						<br>
						<div class="form-group">
							<div class="row">
								<div class="col-md mb-3">
									<div class="btn btn-outline-success btn-block" data-toggle="modal" data-target="#modalSave">Accepter la prestation</a></div>
								</div>
								<div class="col-md mb-3">
									<div class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#modalCancel">Refuser la prestation</div>
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
								<h4 class="modal-title">Accepation de la presation</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<!-- Modal body -->
							<div class="modal-body">
								Voulez-vous accepter cette prestation ?
							</div>
							<!-- Modal footer -->
							<div class="modal-footer">
								<a class="" href="accept_proposal.php?serviceProvidedId=<?= $serviceProvidedId ?>&associateId=<?= $associateId ?>">
									<div class="btn btn-outline-success">Accepter</div>
								</a>
								<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
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
								<h4 class="modal-title">Refus de la prestation</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<!-- Modal body -->
							<div class="modal-body">
								Etes-vous certain de refuser cette prestation ?
							</div>
							<!-- Modal footer -->
							<div class="modal-footer">
								<a class="" href="deny_proposal.php?serviceProvidedId=<?= $serviceProvidedId ?>&associateId=<?= $associateId ?>">
									<div class="btn btn-outline-danger">refuser</div>
								</a>
								<button type=" button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
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