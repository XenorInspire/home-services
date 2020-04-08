<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);

if (!isset($_GET['customerId']) || empty($_GET['customerId'])) {
    header('Location: customers.php');
    exit;
}

$customerId = $_GET['customerId'];
$servicesType = $hm_database->getServiceTypeList();
$user = $hm_database->getCustomer($customerId);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Création Abonnement</title>
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
                <div class="display-4 text-center">Réservation d'un service</div>
                <?php

                // if (isset($_GET['delete']) == "successful") {
                //     echo '<div class="alert alert-success text-center alert-dismissible" class="close" data-dismiss="alert" role="alert">Le service a bien été retiré</div>';
                // }
                ?>
                <br>
                <form class="container-fluid" action="valid_create_reservation.php" method="POST">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Type de service</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01" required>
                            <option selected disabled>Choisir un type de service...</option>
                            <?php
                            foreach ($servicesType as $serviceType) { ?>
                                <option value="<?= $serviceType->getServiceTypeId() ?>"><?= $serviceType->getTypeName() ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="btn-group-toggle services" data-toggle="buttons">
                        <label class="btn btn-outline-secondary btn-block">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked> Pas de service
                        </label>
                    </div>

                    <br>

                    <div class="form-group">
                        <label>Date de la prestation</label>
                        <input type="date" name="date" class="form-control" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Heure de la prestation</label>
                        <input type="time" name="beginHour" class="form-control" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre d'heures</label>
                        <input type="number" name="hours" class="form-control" placeholder="" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Adresse</label>
                            <input type="text" name="address" class="form-control" placeholder="" value="<?= $user->getAddress() ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Ville</label>
                            <input type="text" name="town" class="form-control" placeholder="" value="<?= $user->getTown() ?>" required>
                        </div>
                    </div>

                    <input type="hidden" name="customerId" id="" value="<?= $_GET['customerId'] ?>">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md mb-3">
                                <div class="btn btn-outline-success btn-block" data-toggle="modal" data-target="#modalSave">Créer la réservation</a></div>
                            </div>
                            <div class="col-md mb-3">
                                <div class="btn btn-outline-secondary btn-block text center" onclick="history.back()">Annuler</div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for saving -->
                    <div class="modal fade" id="modalSave">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Création de la réservation</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    Etes-vous certain de créer cette réservation ?
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button class="btn btn-outline-success" type="submit">Créer la réservation</button>
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <?php require_once("include/footer.php"); ?>

</body>

<script type="text/javascript">
    $(document).ready(function() {
        $(".custom-select").change(function() {
            var id = $(this).val();
            var dataString = 'serviceTypeId=' + id;
            $.ajax({
                type: "POST",
                url: "get_services.php",
                data: dataString,
                cache: false,
                success: function(html) {
                    $(".services").html(html);
                }
            });
        });
    });
</script>

</html>