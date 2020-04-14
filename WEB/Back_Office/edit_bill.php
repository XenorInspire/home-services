<?php
require_once('class/DBManager.php');

if (
    isset($_GET['billId']) && !empty($_GET['billId'])
) {
    $billId = $_GET['billId'];

    $hm_database = new DBManager($bdd);

    $bill = $hm_database->getBill($billId);

    $serviceProvided = $hm_database->getServiceProvided($bill->getServiceProvidedId());
} else {
    header('Location: services_provided_bills.php');
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
                <div class="display-4 text-center"><?= $bill->getCustomerLastName() ?> <?= $bill->getCustomerFirstName() ?></div>

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
                        <h5 class="card-title"><?= $bill->getServiceTitle() ?></h5>
                        <p class="card-text">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" class="form-control" value="<?= $bill->getDate() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Heure</label>
                                <input type="text" class="form-control" value="<?= $serviceProvided->getBeginHour() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Lieu</label>
                                <input type="text" class="form-control" value="<?= $serviceProvided->getAddress() ?>, <?= $serviceProvided->getTown() ?>" readonly>
                            </div>
                        </p>
                        <br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md mb-3">
                                    <a class="btn btn-dark btn-block" href="generate_bill.php?billId=<?= $billId ?>">Générer la facture</a>
                                </div>
                                <div class="col-md mb-3">
                                    <div class="btn btn-outline-secondary btn-block" onclick="history.back()">Retour</div>
                                </div>
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