<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['associateId']);
$associateId = $_GET['associateId'];
$servicesType = $hm_database->getServiceTypeList();
$associate = $hm_database->getAssociate($associateId);
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
                <div class="display-4 text-center">Ajout de service au prestataire :</div>
                <div class="display-4 text-center"><?= $associate->getLastName() ?> <?= $associate->getFirstName() ?> </div>
                <?php
                // if (isset($_GET['error']) == "name_tasken") {
                //     echo '<div class="alert alert-danger text-center alert-dismissible" class="close" data-dismiss="alert" role="alert">Ce nom a déjà été utilisé</div>';
                // }
                ?>
                <br>
                <form class="container-fluid" action="valid_create_associate_service.php" method="POST">
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
                    <input type="hidden" name="associateId" value="<?= $associateId ?>">

                    <hr>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md mb-3">
                                <div class="btn btn-outline-success btn-block" data-toggle="modal" data-target="#modalSave">Ajouter ce service</a></div>
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
                                    <h4 class="modal-title">Ajout du service</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    Etes-vous certain d'ajouter ce service ?
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button class="btn btn-outline-success" type="submit">Ajouter</button>
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