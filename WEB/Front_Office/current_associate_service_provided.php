<?php
if (
    isset($_GET['serviceProvidedId']) && !empty($_GET['serviceProvidedId'])
) {
    require_once('include/check_identity.php');
    if (!($status == 'associate' && $connected == 1)) {

        header('Location: connect.php?status=associate&error=forb');
        exit;
    }

    $serviceProvidedId = $_GET['serviceProvidedId'];
    $reservation = $hm_database->getReservationByServiceProvidedId($serviceProvidedId);

    if ($reservation->getStatus() == 1) {
        header('Location : index.php');
        exit;
    }

    $serviceProvided = $hm_database->getServiceProvided($serviceProvidedId);
    $serviceId = $serviceProvided->getServiceId();
    $service = $hm_database->getService($serviceId);
} else {
    header('Location : index.php');
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
                <div class="card border-secondary">
                    <div class="card-header text-center">
                        Informations Service
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center"><?= $service->getServiceTitle() ?></h5>
                        <p class="card-text">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control" value="<?= $service->getDescription() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" class="form-control" value="<?= $serviceProvided->getDate() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Heure de la prestation</label>
                                <input type="text" class="form-control" value="<?= $serviceProvided->getBeginHour() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Lieu</label>
                                <input type="text" class="form-control" value="<?= $serviceProvided->getAddress() ?>, <?= $serviceProvided->getTown() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nombres d'heures demandées</label>
                                <input type="text" class="form-control" value="<?= $serviceProvided->getHours() ?>" readonly>
                            </div>
                        </p>
                    </div>
                </div>
                <hr>

                <form action="valid_current_associate_service_provided.php" method="POST">
                    <div class="form-group">
                        <label>Heures effectuées</label>
                        <input type="text" name="hoursAssociate" class="form-control" maxlength="255" value="" required>
                    </div>


                    <!-- <div class="container text-center"><small class="form-text text-muted">Frais supplémentaire</small></div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" placeholder="Descriptif du frais suplémentaire" name="" required>
                    </div>
                    <div class="form-group">
                        <label>Montant</label>
                        <input type="number" class="form-control" value="" min="0" step="0.01" name="" required>
                    </div> -->
                    <div id="form">

                    </div>

                    <input type="hidden" id="totalAdditionalPrice" name="totalAdditionalPrice" value="0">
                    <input type="hidden" name="serviceProvidedId" value="<?= $serviceProvidedId ?>">

                    <div class="row">
                        <div class="col-md mb-3">
                            <div class="btn btn-secondary btn-block" onclick="addCharge()">Ajouter un frais suplémentaire</div>
                        </div>
                        <div class="col-md mb-3">
                            <div class="btn btn-secondary btn-block" onclick="deleteCharge()">Enlever un frais suplémentaire</div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-4">
                            <button class="btn btn-outline-success btn-block">Terminer la prestation</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </main>
    <?php require_once("include/footer.php"); ?>
</body>

<script>
    var counter = 0;

    function addCharge() {
        counter++;
        var form = document.getElementById("form");
        var node = document.createElement("div");
        node.id = "field" + counter;
        node.innerHTML = '<div class="container text-center"><small class="form-text text-muted">Frais supplémentaire #' + counter + '</small></div><div class="form-group"><label>Description</label><input type="text" class="form-control" placeholder="Descriptif du frais suplémentaire" name="description' + counter + '" required></div> <div class="form-group"><label>Montant</label><input type="number" class="form-control" value="" min="0" step="0.01" name="price' + counter + '" required></div>';
        form.appendChild(node);

        var total = document.getElementById("totalAdditionalPrice");
        total.value = counter;
    }

    function deleteCharge() {
        if (counter >= 1) {
            var field = "field" + counter;
            var form = document.getElementById(field);

            form.remove();
            counter--;
            var total = document.getElementById("totalAdditionalPrice");
            total.value = counter;
        }
    }
</script>

</html>