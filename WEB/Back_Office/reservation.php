<?php
require_once('class/DBManager.php');

isset($_GET['serviceProvidedId']);
$hm_database = new DBManager($bdd);
$servPro = $hm_database->getServiceProvided($_GET['serviceProvidedId']);
$serv = $hm_database->getService($servPro->getServiceId());
$associates = $hm_database->getAssociateServicesList($serv->getServiceId());
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
            <h1>Infos reservation prestation</h1>
            <?php
            echo $servPro;
            ?>
            <a class="" href="delete_reservation.php?reservationId=<?= $_GET['reservationId'] ?>">
                <div class="btn btn-outline-danger">Annuler la reservation</div>
            </a>

            <h1>Infos service en question</h1>
            <?php
            echo $serv;
            ?>

            <br>
            <br>
            <hr>
            <br>

            <br>
            <br>
            <?php
            $proposal = $hm_database->getProposal($servPro->getServiceProvidedId());
            if ($proposal != NULL) { ?>
                <h1>En attente de la reponse du prestataire</h1>
                <?= $hm_database->getAssociate($proposal->getAssociateId()) ?>
                <a class="" href="delete_proposal.php?associateId=<?= $hm_database->getAssociate($proposal->getAssociateId())->getAssociateId()  ?>">
                    <div class="btn btn-outline-danger">Enlever le prestataire</div>
                </a>

            <?php } else { ?>
                <h1>Liste des prestataires en relation avec la réservation du service</h1>
                <?php
                foreach ($associates as $associate) { ?>
                    <?php echo $associate; ?>
                    <form action="valid_reservation.php" method="POST">
                        <input type="hidden" name="serviceProvidedId" value="<?= $servPro->getServiceProvidedId() ?>">
                        <input type="hidden" type="number" name="status" value="0">
                        <input type="hidden" name="associateId" value="<?= $associate->getAssociateId() ?>">
                        <button type="submit">Selectionner</button>
                    </form>
                <?php } ?>
            <?php } ?>
            <br>
            <br>
            <br>
            <br>
        </section>

    </main>

    <?php require_once("include/footer.php"); ?>

</body>

</html>