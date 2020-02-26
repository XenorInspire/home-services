<?php
require_once('include/config.php');
require_once('class/DBManager.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Home Services - Abonnements</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

    <?php require_once("include/header.php"); ?>

    <main>

        <section class="container text-center">
            <br>
            <br>
            <br>

            <a href="create_subscription.php"><button type="button" class="btn btn-dark">Créer un abonnement</button></a>

            <br>
            <br>
            
            <h1>Liste des abonnements</h1>
            <?php
            $hm_database = new DBManager($bdd);
            $subscriptions = [];
            $subscriptions = $hm_database->getSubscriptionTypeList();
            foreach ($subscriptions as $sub) {
                echo $sub->getTypeName() . "<br>";
            }

            ?>
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