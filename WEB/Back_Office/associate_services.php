<?php
isset($_GET['associateId']);
require_once('class/DBManager.php');

if (!isset($_GET['associateId']) || empty($_GET['associateId'])) {
    header('Location: associates.php');
    exit;
}

$associateId = $_GET['associateId'];
$hm_database = new DBManager($bdd);
$associate = $hm_database->getAssociate($associateId);
$services = $hm_database->getServiceListAssociate($associateId);

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

<body onload="">
    <?php require_once("include/header.php"); ?>

    <main>
        <br>
        <div class="container-fluid">
            <div class="jumbotron text-center">
                <?php
                if (isset($_GET['delete']) == "successful") {
                    echo '<div class="alert alert-success text-center alert-dismissible" class="close" data-dismiss="alert" role="alert">Le service a bien été retiré</div>';
                }
                if (isset($_GET['create']) == "successful") {
                    echo '<div class="alert alert-success text-center alert-dismissible" class="close" data-dismiss="alert" role="alert">Le service a bien été ajouté</div>';
                }

                ?>
                <div class="display-4">Services de <?= $associate->getLastName() ?> <?= $associate->getFirstName() ?></div>
                <br>
                <a href="create_associate_service.php?associateId=<?= $_GET['associateId'] ?>"><button type="button" class="btn btn-dark">Ajouter un service pour le prestataire</button></a>
                <hr>
                <div class="display-4">Liste des services</div>
                <hr>
                <div class="container">
                    <?php
                    $counter = 1;
                    foreach ($services as $service) {
                    ?>
                        <div class="row mb-2">
                            <div class="col-md-10 mb-2 btn btn-outline-secondary"><?= $service->getServiceTitle() ?></div>
                            <div class="col-md-2 mb-2">
                                <div class="btn btn-outline-danger" data-toggle="modal" data-target="#modalAdd<?= $counter ?>">Retirer</div>
                            </div>
                        </div>

                        <!-- Modal for adding -->
                        <div class=" modal fade" id="modalAdd<?= $counter ?>">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Retirement du service</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        Etes-vous certain de vouloir retirer ce service de ce prestataire ?
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <a href="delete_associate_service.php?associateId=<?= $associateId ?>&serviceId=<?= $service->getServiceId() ?>">
                                            <div class="btn btn-outline-danger">Retirer</div>
                                        </a>
                                        <button type=" button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                        $counter++;
                    }
                    ?>
                </div>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="btn btn-outline-secondary btn-block" onclick="history.back()">Annuler</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once("include/footer.php"); ?>

</body>

</html>