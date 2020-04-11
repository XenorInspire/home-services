	<?php require_once('include/check_identity.php'); ?>

	<!DOCTYPE html>
	<html lang="en" dir="ltr">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Home Services - Liste des Services</title>
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
				<h3>Sélectionnez une catégorie :</h3>
				<br>
				<select class="form-control" id="sel" onchange="getList()">
					<?php

					$serviceTypes = $hm_database->getServiceTypeList();
					for ($i = 0; $i < count($serviceTypes); $i++)
						echo "<option>" . $serviceTypes[$i]->getTypeName() . "</option>";
					?>
				</select>
				<br>
				<input class="form-control" id="myInput" type="text" placeholder="Recherche..">
				<br>
				<br>
			</section>

			<section class="container text-center">

				<table class="table">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Catégorie</th>
							<th scope="col">Service</th>
							<th scope="col">Prix</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody id="myTable">
						<?php

						$services = $hm_database->getServiceListByType($serviceTypes[0]->getServiceTypeId());

						for ($i = 0; $i < count($services); $i++) { ?>

							<tr>
								<td><?= $hm_database->getServiceType($services[$i]->getServiceTypeId())->getTypeName() ?></td>
								<td><?= $services[$i]->getServiceTitle() ?></td>
								<td><?= $services[$i]->getServicePrice() ?>€/h</td>
								<td><button type="button" class="btn btn-primary mb-2" onclick="window.location.href = 'book_service.php?i=<?= $services[$i]->getServiceId() ?>';">Réserver</button></td>
							</tr>

						<?php
						}

						?>

					</tbody>
				</table>

			</section>

		</main>

		<?php require_once("include/footer.php"); ?>
		<script src="js/services.js"></script>
		<script>
			$(document).ready(function() {
				$("#myInput").on("keyup", function() {
					var value = $(this).val().toLowerCase();
					$("#myTable tr").filter(function() {
						$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
					});
				});
			});
		</script>
	</body>

	</html>