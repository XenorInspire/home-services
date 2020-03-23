<?php
isset($_GET['customerId']);
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
    <?php require_once('include/config.php'); ?>
    <?php require_once("include/header.php"); ?>

    <main>
        <br>
        <div class="container">
            <div class="jumbotron text-center">
                <a href="create_reservation.php?customerId=<?= $_GET['customerId'] ?>"><button type="button" class="btn btn-dark">Créer une réservation</button></a>
                <hr>
                <div class="display-4">Réservation</div>
                <hr>
                <div class="display-4">Regenerer Qrcode</div>
                <hr>
                <div class="display-4">Modifer les infos</div>
                <hr>
                <div class="display-4">Renvoyer le mdp</div>
                <hr>
            </div>
        </div>
    </main>

    <?php require_once("include/footer.php"); ?>

</body>

</html>