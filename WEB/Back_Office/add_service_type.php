<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Home Services - Création Catégorie</title>
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
                <div class="display-4 text-center">Création d'une catégorie</div>

                <?php
                if (isset($_GET['error']) == "name_tasken") {
                    echo '<div class="alert alert-danger text-center" role="alert">Ce nom a déjà été utilisé</div>';
                }
                ?>

                <br>
                <form action="valid_service_type.php" method="POST">
                    <div class="form-group">
                        <label>Nom de la catégorie</label>
                        <input type="text" name="typeName" class="form-control" placeholder="Entrez le nom" maxlength="255" required>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="btn btn-block btn-outline-success" data-toggle="modal" data-target="#modalSave">Créer la catégorie</a></div>
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
                                    <h4 class="modal-title">Création de la catégorie</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    Voulez-vous créer cette catégorie ?
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