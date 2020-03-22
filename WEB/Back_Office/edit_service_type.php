<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
isset($_GET['id']);
$sub = $hm_database->getServiceType($_GET['id']);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Création Catégorie</title>
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
            <h1 class="text-center">Modification de la catégorie : <?= $sub->getTypeName() ?></h1>

            <?php
            if (isset($_GET['error']) == "name_tasken") {
                echo '<div class="alert alert-danger text-center alert-dismissible" class="close" data-dismiss="alert" role="alert">Ce nom a déjà été utilisé</div>';
            }
            ?>

            <br>
            <form action="valid_edit_service_type.php" method="POST">
                <div class="form-group">
                    <label>Nom de la catégorie</label>
                    <input type="text" name="typeName" class="form-control" maxlength="255" value="<?= $sub->getTypeName() ?>" required>
                </div>
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">

                <div class="text-center">
                    <div class="btn btn-outline-success" data-toggle="modal" data-target="#modalSave"><img src="https://img.icons8.com/color/24/000000/checkmark.png">Enregistrer les modifications</a></div>
                    <div class="btn btn-outline-danger" data-toggle="modal" data-target="#modalDelete"><img src="https://img.icons8.com/color/24/000000/delete-sign.png">Supprimer la catégorie</a></div>
                    <a class="" href="service_type.php">
                        <div class="btn btn-outline-secondary">Annuler</div>
                    </a>
                </div>

                <!-- Modal for saving -->
                <div class="modal fade" id="modalSave">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Modification de la catégorie : <?= $sub->getTypeName() ?></h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                Voulez-vous enregistrer les modifications de cette catégorie ?
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button class="btn btn-outline-success" type="submit">Enregistrer les modifications</button>
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for delete -->
                <div class="modal fade" id="modalDelete">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Suppression de la catégorie : <?= $sub->getTypeName() ?></h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                Êtes-vous certain de vouloir supprimer cette catégorie ?
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <a class="" href="delete_service_type.php?id=<?= $_GET['id'] ?>">
                                    <div class="btn btn-outline-danger">Supprimer la catégorie</div>
                                </a>
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>


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
