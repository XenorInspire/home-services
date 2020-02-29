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
            <h1 style="text-align: center;">Création Abonnement</h1>

            <?php
            if (isset($_GET['error']) == "name_tasken") {
                echo '<div class="alert alert-danger text-center" role="alert">Ce nom a déjà été utilisé</div>';
            }
            ?>

            <br>
            <form action="valid_subscription.php" method="POST">
                <div class="form-group">
                    <label>Nom de l'abonnement</label>
                    <input type="text" name="typeName" class="form-control" placeholder="Entrez le nom" maxlength="255" required>
                </div>
                <div class="form-group">
                    <label>Jours disponibles dans la semaine</label>
                    <input type="number" class="form-control" value="5" min="1" max="7" name="openDays" required>
                    <small class="form-text text-muted">Exemple : 5j/7</small>
                </div>
                <div class="form-group">
                    <label>Horaire de debut des services</label>
                    <input type="time" class="form-control" value="09:00" name="openTime" required>
                </div>
                <div class="form-group">
                    <label>Horaire de fin des services</label>
                    <input type="time" class="form-control" value="20:00" name="closeTime" required>
                </div>
                <div class="form-group">
                    <label>Temps de services offert dans l'abonnement en <strong>heures / mois</strong></label>
                    <input type="number" class="form-control" value="12" min="0" name="serviceTimeAmount" required>
                </div>
                <div class="form-group">
                    <label>Montant de l'abonnement en <strong>euros / an</strong></label>
                    <input type="number" class="form-control" value="12" min="0" name="price" step="0.01" required>
                </div>
                <button id="regis_button" type="submit" class="btn btn-primary">Créer l'abonnement</button>
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