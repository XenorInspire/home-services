<?php
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
            <?php
            if(isset($_GET['delete']) == "successful"){
                echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">L\'abonnement a bien été supprimé</div>';
            }

            if (isset($_GET['create']) == "successful") {
                echo '<div class="alert alert-success alert-dismissible " class="close" data-dismiss="alert" role="alert">L\'abonnement a bien été créé</div>';
            }

            if (isset($_GET['edit']) == "successful") {
                echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">L\'abonnement a bien été modifié</div>';
            }
            
            ?>
            <br>

            <a href="create_subscription.php"><button type="button" class="btn btn-dark">Créer un abonnement</button></a>

            <br>
            <br>

            <h1>Liste des abonnements</h1>
            <hr>
            <?php
            $hm_database = new DBManager($bdd);
            $subscriptions = [];
            $subscriptions = $hm_database->getSubscriptionTypeList();
            foreach ($subscriptions as $sub) { ?>
                <div class="row justify-content-center">
                    <div class="col-6">
                        <h2><a title="Modifier" class="btn  btn-block" href="edit_subscription.php?id=<?= $sub->getTypeId() ?>"><?= $sub->getTypeName() ?></a></h2>
                    </div>
                </div>
                <hr>
            <?php } ?>
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