<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['customerId']);
$servicesType = $hm_database->getServiceTypeList();

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
        <section class="container-fluid text-center">
            <br>
            <br>
            <br>
            <h1 class="text-center"></h1>

            <?php
            // if (isset($_GET['error']) == "name_tasken") {
            //     echo '<div class="alert alert-danger text-center alert-dismissible" class="close" data-dismiss="alert" role="alert">Ce nom a déjà été utilisé</div>';
            // }
            ?>


            <h1>Réservation d'un service</h1>
            <br>
            <form class="container" action="valid_reservation.php" method="POST">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Type de service</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01">
                        <option selected disabled>Choisir un type de service...</option>
                        <?php
                        foreach ($servicesType as $serviceType) { ?>
                            <option value="<?= $serviceType->getServiceTypeId() ?>"><?= $serviceType->getTypeName() ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="btn-group-toggle services" data-toggle="buttons">
                    <?php
                    $services = $hm_database->getServiceListByType($serviceType->getServiceTypeId());
                    foreach ($services as $serv) { ?>
                        <label class="btn btn-outline-secondary btn-block">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked> <?= $serv->getServiceTitle() ?> : <?= $serv->getDescription() ?>
                        </label>
                    <?php } ?>
                    <label class="btn btn-outline-secondary btn-block">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked> <?= $serv->getServiceTitle() ?> : <?= $serv->getDescription() ?>
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
                <div class="form-group">
                    <button class="btn btn-outline-success" type="submit">Creer la reservation</button>
                </div>

            </form>
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

<script type="text/javascript">
    $(document).ready(function() {
        $(".custom-select").change(function() {
            var id = $(this).val();
            var dataString = 'serviceTypeId=' + id;
            console.log(dataString);
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