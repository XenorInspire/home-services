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

            <br>
            <h1>Liste des types de services</h1>
            <?php
            foreach ($servicesType as $serviceType) { ?>
                <?php
                echo '<h2>Type service</h2>';
                echo $serviceType;
                echo '<br>';
                echo '<h1>Les services</h1>';
                $services = $hm_database->getServiceListByType($serviceType->getServiceTypeId());
                foreach ($services as $serv) { ?>
                    <?php echo $serv; ?>
                    <!-- <a href="valid_create_reservation.php?"><button type="button" class="btn btn-dark">Créer une réservation pour un client</button></a> -->
                <?php }
                ?>
            <?php
            }
            ?>
            <br>
            <br>

           
                <form class="container" action="valid_reservation.php" method="POST">
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

</html>