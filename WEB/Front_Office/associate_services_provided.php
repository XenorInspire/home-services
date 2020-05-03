<?php

require_once('include/check_identity.php');
if (!($status == 'associate' && $connected == 1)) {

    header('Location: connect.php?status=associate&error=forb');
    exit;
}

$servicesProvided = $hm_database->getAssociateServicesProvidedOnlyAcceptedAndUndone($id);
$associateProposals = $hm_database->getAssociateProposal($id);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - <?= $associate_services_provided['homepage'] ?></title>
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
                if (isset($_GET['ending'])) {
                    if ($_GET['ending'] == "successful") {
                        echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">' . $associate_services_provided['endConfirmation'] . '</div>';
                    }
                    if ($_GET['ending'] == "error") {
                        echo '<div class="alert alert-danger alert-dismissible" class="close" data-dismiss="alert" role="alert">' . $associate_services_provided['endError'] . '</div>';
                    }
                }
                if (isset($_GET['accept'])) {
                    if ($_GET['accept'] == "successful") {
                        echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">' . $associate_services_provided['acceptanceConfirmation'] . '</div>';
                    }
                }
                if (isset($_GET['deny'])) {
                    if ($_GET['deny'] == "successful") {
                        echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">' . $associate_services_provided['refusalConfirmation'] . '</div>';
                    }
                }
                ?>

                <?php
                $counter = 1;
                if (!empty($associateProposals)) { ?>
                    <div class="display-4"><?= $associate_services_provided['serviceRequest'] ?></div>
                    <hr>
                    <div class="row">
                        <?php
                        foreach ($associateProposals as $proposal) {
                        ?>
                            <div class="col-md bm-3">
                                <a href="associate_proposal_accept.php?associateId=<?= $id ?>&serviceProvidedId=<?= $proposal->getServiceProvidedId() ?>" class="btn btn-dark btn-block">#<?= $counter ?> <?= $associate_services_provided['reply'] ?></a>
                            </div>
                        <?php
                            $counter++;
                        } ?>
                    </div><?php
                            echo '<br>';
                            echo '<br>';
                        }
                            ?>

                <div class="display-4">
                    <?php
                    if ($servicesProvided != NULL)
                        echo $associate_services_provided['currentServices'];
                    else
                        echo $associate_services_provided['noCurrentServices'];
                    ?>
                </div>
                <hr>
                <div class="card-columns">
                    <?php
                    $counter = 1;
                    if ($servicesProvided != NULL) {
                        foreach ($servicesProvided as $serviceProvided) {

                            $parts = explode(".", $serviceProvided->getBeginHour());
                            $service = $hm_database->getService($serviceProvided->getServiceId());
                    ?>
                            <div class="card text-center border-secondary">
                                <div class="card-header border-secondary">
                                    <?= $associate_services_provided['booking'] ?> # <?= $counter ?> <?= $service->getServiceTitle() ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $service->getDescription() ?></h5>
                                    <a href="current_associate_service_provided.php?serviceProvidedId=<?= $serviceProvided->getServiceProvidedId() ?>" class="btn btn-outline-secondary"><?= $associate_services_provided['endService'] ?></a>
                                </div>
                                <div class="card-footer text-muted border-secondary">
                                    <?= $serviceProvided->getDate() ?> à <?= $parts[0] ?>
                                </div>
                            </div>
                    <?php
                            $counter++;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <?php require_once("include/footer.php"); ?>
</body>

</html>