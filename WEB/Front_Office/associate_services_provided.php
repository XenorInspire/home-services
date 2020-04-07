<?php

require_once('include/check_identity.php');
if (!($status == 'associate' && $connected == 1)) {

    header('Location: connect.php?status=associate&error=forb');
    exit;
}

$servicesProvided = $hm_database->getAssociateServicesProvidedOnlyAcceptedAndUndone($id);

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
            <div class="jumbotron text-center">
                <?php
                isset($_GET['ending']);
                if ($_GET['ending'] == "successful") {
                    echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">La prestation a bien été terminée</div>';
                }
                if ($_GET['ending'] == "error") {
                    echo '<div class="alert alert-danger alert-dismissible" class="close" data-dismiss="alert" role="alert">Il y \'a eu une erreur</div>';
                }
                ?>
                <div class="display-4">Préstations actuelles</div>
                <hr>
                <div class="card-columns">
                    <?php
                    $counter = 1;
                    foreach ($servicesProvided as $serviceProvided) {

                        $service = $hm_database->getService($serviceProvided->getServiceId());
                    ?>
                        <div class="card text-center border-secondary">
                            <div class="card-header border-secondary">
                                Réservation # <?= $counter ?> <?= $service->getServiceTitle() ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $service->getDescription() ?></h5>
                                <a href="current_associate_service_provided.php?serviceProvidedId=<?= $serviceProvided->getServiceProvidedId() ?>" class="btn btn-outline-secondary">Terminer la prestation</a>
                            </div>
                            <div class="card-footer text-muted border-secondary">
                                <?= $serviceProvided->getDate() ?> à <?= $serviceProvided->getBeginHour() ?>
                            </div>
                        </div>
                    <?php
                        $counter++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <?php require_once("include/footer.php"); ?>
</body>

</html>