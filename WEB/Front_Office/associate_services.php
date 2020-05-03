<?php

require_once('include/check_identity.php');
if (!($status == 'associate' && $connected == 1)) {

    header('Location: connect.php?status=associate&error=forb');
    exit;
}


$associateId = $id;
$hm_database = new DBManager($bdd);
$services = $hm_database->getServiceListAssociate($associateId);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - <?= $associate_services['homepage'] ?></title>
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
                    echo '<div class="alert alert-success text-center alert-dismissible" class="close" data-dismiss="alert" role="alert">' . $associate_services['removeServiceConfirmation'] . '</div>';
                }
                if (isset($_GET['create']) == "successful") {
                    echo '<div class="alert alert-success text-center alert-dismissible" class="close" data-dismiss="alert" role="alert">' . $associate_services['addServiceConfirmation'] . '</div>';
                }

                ?>
                <div class="display-4"><?= $associate_services['myServices'] ?></div>
                <br>
                <a href="create_associate_service.php"><button type="button" class="btn btn-dark"><?= $associate_services['addToService'] ?></button></a>
                <hr>
                <div class="display-4"><?= $associate_services['serviceList'] ?></div>
                <hr>
                <div class="container">
                    <?php
                    $counter = 1;
                    foreach ($services as $service) {
                    ?>
                        <div class="row mb-2">
                            <div class="col-md-10 mb-2 btn btn-secondary"><?= $service->getServiceTitle() ?></div>
                            <div class="col-md-2 mb-2">
                                <div class="btn btn-danger" data-toggle="modal" data-target="#modalAdd<?= $counter ?>"><?= $associate_services['remove'] ?></div>
                            </div>
                        </div>

                        <!-- Modal for adding -->
                        <div class=" modal fade" id="modalAdd<?= $counter ?>">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title"><?= $associate_services['removeService'] ?></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <?= $associate_services['removeConfirmation'] ?>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <a href="delete_associate_service.php?associateId=<?= $associateId ?>&serviceId=<?= $service->getServiceId() ?>">
                                            <div class="btn btn-outline-danger"><?= $associate_services['remove'] ?></div>
                                        </a>
                                        <button type=" button" class="btn btn-outline-secondary" data-dismiss="modal"><?= $associate_services['cancel'] ?></button>
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
                        <div class="btn btn-outline-secondary btn-block" onclick="history.back()"><?= $associate_services['back'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once("include/footer.php"); ?>

</body>

</html>
