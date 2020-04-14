<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Création Service</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

    <?php require_once("include/header.php"); ?>

    <main>
        <br>
        <div class="container-fluid">
            <div class="jumbotron">
                <div class="display-4 text-center">Création Service</div>

                <?php
                if (!isset($_GET['serviceTypeId']) || empty($_GET['serviceTypeId'])) {
                    header('Location: service_types.php');
                    exit;
                }
                $serviceTypeId = $_GET['serviceTypeId'];
                if (isset($_GET['error']) == "name_tasken") {
                    echo '<div class="alert alert-danger text-center" role="alert">Ce nom a déjà été utilisé</div>';
                }
                ?>

                <br>
                <form action="valid_create_service.php" method="POST">
                    <div class="form-group">
                        <label>Titre</label>
                        <input type="text" name="serviceTitle" class="form-control" placeholder="Entrez le titre du service" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" placeholder="Entrez la description du service" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label>Recurrence du service</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="recurrence" id="gridRadios1" value="0" required>
                            <label class="form-check-label" for="gridRadios1">
                                Service simple
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="recurrence" id="gridRadios2" value="1" required>
                            <label class="form-check-label" for="gridRadios2">
                                Service récurrent
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Temps miniminum du service en <strong>heure</strong></label>
                        <input type="number" class="form-control" min="0" name="timeMin" required>
                    </div>
                    <div class="form-group">
                        <label>Montant du service en <strong>€ / heure</strong></label>
                        <input type="number" class="form-control" value="" min="0" name="servicePrice" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Pourcentage de la commission</label>
                        <input type="number" class="form-control" value="" min="0" max="100.00" name="commission" step="0.01" required>
                        <small class="form-text text-muted">Exemple : 10 pour 10%</small>
                    </div>

                    <input type="hidden" name="serviceTypeId" value="<?= $serviceTypeId ?>">

                    <div class="row">
                        <div class="col-md mb-3">
                            <div class="btn btn-outline-success btn-block" data-toggle="modal" data-target="#modalSave">Créer le service</a></div>
                        </div>
                        <div class="col-md mb-3">
                            <div class="text-center btn btn-outline-secondary btn-block" onclick="history.back()">Annuler</div>
                        </div>
                    </div>


                    <!-- Modal for saving -->
                    <div class="modal fade" id="modalSave">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Création du service</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    Voulez-vous créer ce service ?
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button class="btn btn-outline-success" type="submit">Créer le service</button>
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