<?php
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Clients</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

    <?php require_once("include/header.php"); ?>

    <main>
        <div class="container-fluid text-center">
            <br>
            <div class="jumbotron">
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
                <a href="customers.php"><button type="button" class="btn btn-dark">Créer une réservation pour un client</button></a>
                <hr>
                <div class="display-4">Réservations à traiter</div>
                <hr>
                <div class="card-columns">

                    <?php
                    $reservations = [];
                    $reservations = $hm_database->getReservationList();
                    $counter = 1;
                    foreach ($reservations as $res) {
                        $servPro = $hm_database->getServiceProvided($res->getServiceProvidedId());
                        $proposal = $hm_database->getProposal($servPro->getServiceProvidedId());
                        $customer = $hm_database->getCustomer($res->getCustomerId());
                        if ($res->getStatus() == 0) { ?>
                            <div class="card text-center border-secondary">
                                <div class="card-header border-secondary">
                                    Réservation # <?= $counter ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $customer->getLastname() ?> <?= $customer->getFirstname() ?></h5>
                                    <a href="reservation.php?serviceProvidedId=<?= $res->getServiceProvidedId() ?>&reservationId=<?= $res->getReservationId() ?>" class="btn btn-outline-<?php
                                                                                                                                                                                            if ($proposal == NULL) {
                                                                                                                                                                                                echo 'secondary';
                                                                                                                                                                                            } else {
                                                                                                                                                                                                if ($proposal->getStatus() == 0) {
                                                                                                                                                                                                    echo 'primary';
                                                                                                                                                                                                } else if ($proposal->getStatus() == 1) {
                                                                                                                                                                                                    echo 'success';
                                                                                                                                                                                                } else {
                                                                                                                                                                                                    echo 'danger';
                                                                                                                                                                                                }
                                                                                                                                                                                            } ?>">
                                        <?php
                                        if ($proposal == NULL) {
                                            echo 'Choisir un prestataire';
                                        } else {
                                            if ($proposal->getStatus() == 0)
                                                echo 'En attente de réponse';
                                            else if ($proposal->getStatus() == 1)
                                                echo 'Prestation acceptée';
                                            else
                                                echo 'Prestation refusée';
                                        }
                                        ?>
                                    </a>
                                </div>
                                <div class="card-footer text-muted border-secondary">
                                    <?= $res->getReservationDate() ?>
                                </div>
                            </div>
                        <?php
                            $counter++;
                        } ?>
                    <?php } ?>
                </div>
                <br>
            </div>
        </div>

    </main>

    <?php require_once("include/footer.php"); ?>

</body>

</html>