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
        <div class="container-fluid text-center">
            <h1>Creer une reservation</h1>
            <hr>
            <a href="create_reservation.php?customerId=<?= $_GET['customerId']?>"><button type="button" class="btn btn-dark">Créer une réservation</button></a>
            <br>
            <h1>Regenerer Qrcode</h1>
            <hr>
            <br>
            <h1>Modifer les infos</h1>
            <hr>
            <br>
            <h1>Renvoyer le mdp</h1>
            <hr>
            <br>
        </div>
    </main>

    <?php require_once("include/footer.php"); ?>

</body>

</html>