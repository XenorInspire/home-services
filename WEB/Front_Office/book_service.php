    <?php
    require_once('include/check_identity.php');

    if (!($status == 'customer' && $connected == 1)) {

        header('Location: connect.php?status=customer&error=forb');
        exit;
    }

    if (!isset($_GET['i']) || empty($_GET['i'])) {

        header('Location: shop.php');
        exit;
    }

    $hm_database = new DBManager($bdd);
    if (($service = $hm_database->getService($_GET['i'])) == NULL) {

        header('Location: shop.php');
        exit;
    }

    sscanf($service->getTimeMin(), "%d:%d:%d.%s", $trash1, $trash2, $time, $trash3);

    ?>

    <!DOCTYPE html>
    <html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home Services - <?= $service->getServiceTitle() ?></title>
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
                <h1><?= $service->getServiceTitle() ?></h1>
                <br>
                <ul style="margin:auto;width:50%;padding:0px;">
                    <li class="list-group-item list-group-item-info"><?= $service->getDescription() ?></li>
                    <li class="list-group-item">Minimum de <?= $time ?>h</li>
                    <li class="list-group-item">Prix : <?= $service->getServicePrice() ?>€ TTC</li>
                    <br>
                    <div class="form-group">
                        <label>Date de la prestation</label>
                        <input type="date" name="date" class="form-control" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Heure de la prestation</label>
                        <input type="time" name="beginHour" class="form-control" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre d'heures</label>
                        <input type="number" name="hours" class="form-control" placeholder="" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Adresse</label>
                            <input type="text" name="address" class="form-control" placeholder="" value="<?= $user->getAddress() ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Ville</label>
                            <input type="text" name="town" class="form-control" placeholder="" value="<?= $user->getCity() ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md mb-3">
                                <div class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalSave">Réserver</a></div>
                            </div>
                            <div class="col-md mb-3">
                                <div class="btn btn-primary btn-block text center" onclick="history.back()">Annuler</div>
                            </div>
                        </div>
                    </div>
                    <br>
                </ul>

            </section>

            <!-- Modal for saving -->
            <div class="modal fade" id="modalSave">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Réservation</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            Voulez-vous vraiment réserver ce service ?
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button class="btn btn-outline-success" onclick="window.location.href = 'insert_reservation.php?i=<?= $service->getServiceId() ?>';">Réserver</button>
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <?php require_once("include/footer.php"); ?>

    </body>

    </html>