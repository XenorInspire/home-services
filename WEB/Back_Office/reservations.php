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

        <section class="container text-center">
            <br>
            <br>
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
            <h1>Creer une reservation</h1>
            <hr>
            <br>
            <br>
            <h1>Liste des réservations</h1>
            <hr>
            <br>
            <?php
            $reservations = [];
            $reservations = $hm_database->getReservationList();
            foreach ($reservations as $res) {
                $servPro = $hm_database->getServiceProvided($res->getServiceProvidedId());
                $proposal = $hm_database->getProposal($servPro->getServiceProvidedId());
                if ($res->getStatus() == 0) { ?>
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <?php
                            echo $res;
                            if ($proposal == NULL) {
                                echo 'Choisir un prestataire';
                            } else {
                                if ($proposal->getStatus() == 0)
                                    echo 'En attente de reponse du prestataire';
                            }
                            ?>

                            <a href="reservation.php?serviceProvidedId=<?= $res->getServiceProvidedId() ?>&reservationId=<?= $res->getReservationId() ?>">Affecter / Voir le prestataire</a>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
            <?php } ?>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </section>

    </main>

    <?php require_once("include/footer.php"); ?>

</body>

</html>