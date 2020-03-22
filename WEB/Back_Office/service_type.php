<?php
require_once('class/DBManager.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Catégories</title>
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
            if (isset($_GET['delete']) == "successful") {
                echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">La catégorie a bien été supprimée.</div>';
            }

            if (isset($_GET['create']) == "successful") {
                echo '<div class="alert alert-success alert-dismissible " class="close" data-dismiss="alert" role="alert">La catégorie a bien été créée.</div>';
            }

            if (isset($_GET['edit']) == "successful") {
                echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">La catégorie a bien été modifiée.</div>';
            }

            ?>
            <br>

            <a href="add_service_type.php"><button type="button" class="btn btn-dark">Créer une catégorie</button></a>

            <br>
            <br>

            <h1>Liste des catégories</h1>
            <hr>
            <?php
            $hm_database = new DBManager($bdd);
            $services = [];
            $services = $hm_database->getServiceTypeList();
            foreach ($services as $service) { ?>
                <div class="row justify-content-center">
                    <div class="col-6">
                        <h2><a title="Modifier" class="btn  btn-block" href="edit_service_type.php?id=<?= $service->getServiceTypeId() ?>"><?= $service->getTypeName() ?></a></h2>
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
