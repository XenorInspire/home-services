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
        <div class="container">
            <div class="jumbotron">
                <div class="display-4 text-center">Création Abonnement</div>

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

                    <div class="row">
                        <div class="col-md">
                            <div class="btn btn-outline-success btn-block" data-toggle="modal" data-target="#modalSave">Créer l'abonnement</a></div>
                        </div>
                        <div class="col-md">
                            <div class="text-center btn btn-outline-secondary btn-block" onclick="history.back()">Annuler</div>
                        </div>
                    </div>


                    <!-- Modal for saving -->
                    <div class="modal fade" id="modalSave">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Création de l'abonnement</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    Voulez-vous créer cet abonnement ?
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button class="btn btn-outline-success" type="submit">Créer l'abonnement</button>
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

</html>