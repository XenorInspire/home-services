<?php
require_once('include/config.php');
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['id']);
$sub = $hm_database->getSubscriptionType($_GET['id']);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Home Services - Création Abonnement</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

    <?php require_once("include/header.php"); ?>

    <main>
        <section class="container">
            <br>
            <br>
            <br>
            <h1 class="text-center">Modification de l'abonnement : <?= $sub->getTypeName() ?></h1>

            <?php
            if (isset($_GET['error']) == "name_tasken") {
                echo '<div class="alert alert-danger text-center" role="alert">Ce nom a déjà été utilisé</div>';
            }
            ?>

            <br>
            <form action="valid_edit_subscription.php" method="POST">
                <div class="form-group">
                    <label>Nom de l'abonnement</label>
                    <input type="text" name="typeName" class="form-control" maxlength="255" value="<?= $sub->getTypeName() ?>" required>
                </div>
                <div class="form-group">
                    <label>Jours disponibles dans la semaine</label>
                    <input type="number" class="form-control" value="<?= $sub->getOpenDays() ?>" min="1" max="7" name="openDays" required>
                    <small class="form-text text-muted">Exemple : 5j/7</small>
                </div>
                <div class="form-group">
                    <label>Horaire de debut des services</label>
                    <?php
                    $input = $sub->getOpenTime();
                    $output = explode(":", $input);
                    ?>
                    <input type="time" class="form-control" value="<?php echo $output[0] . ':' . $output[1]; ?>" name="openTime" required>
                </div>
                <div class="form-group">
                    <label>Horaire de fin des services</label>
                    <?php
                    $input = $sub->getCloseTime();
                    $output = explode(":", $input);
                    ?>
                    <input type="time" class="form-control" value="<?php echo $output[0] . ':' . $output[1]; ?>" name="closeTime" required>
                </div>
                <div class="form-group">
                    <label>Temps de services offert dans l'abonnement en <strong>heures / mois</strong></label>
                    <input type="number" class="form-control" value="<?= $sub->getServiceTimeAmount() ?>" min="0" name="serviceTimeAmount" required>
                </div>
                <div class="form-group">
                    <label>Montant de l'abonnement en <strong>euros / an</strong></label>
                    <input type="number" class="form-control" value="<?= $sub->getPrice() ?>" min="0" name="price" step="0.01" required>
                </div>

                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">

                <!-- <button id="regis_button" type="submit" class="btn btn-primary"><img src="https://img.icons8.com/color/24/000000/checkmark.png">Modifier l'abonnement</button> -->

                <button class="btn btn-outline-success" type="submit"><a onclick="return confirm('Enregistrer les modifications ?');"><img src="https://img.icons8.com/color/24/000000/checkmark.png">Enregistrer les modifications</a></button>
                <a class="" onclick="return confirm('Etes-vous certain de supprimer cet abonnement ?');" href="delete_subscription.php?id=<?= $_GET['id'] ?>"><div class="btn btn-outline-danger"><img src="https://img.icons8.com/color/24/000000/delete-sign.png">Supprimer l'abonnement</div></a>
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