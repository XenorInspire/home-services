<?php
require_once('class/DBManager.php');

isset($_GET['serviceProvidedId']);
isset($_GET['reservationId']);

$reservationId = $_GET['reservationId'];
$serviceProvidedId = $_GET['serviceProvidedId'];

$hm_database = new DBManager($bdd);
$servPro = $hm_database->getServiceProvided($serviceProvidedId);
if($servPro == NULL){
    header('Location: reservations.php');
    exit;
}

$serv = $hm_database->getService($servPro->getServiceId());
$associates = $hm_database->getAssociateServicesList($serv->getServiceId());
$reservation = $hm_database->getReservation($reservationId);
$customer = $hm_database->getCustomer($reservation->getCustomerId());
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Clients</title>
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
                <div class="display-4 text-center">Réservation de</div>
                <div class="display-4 text-center"><?= $customer->getLastname() ?> <?= $customer->getFirstname() ?></div>
                <?php
                // if (isset($_GET['delete']) == "successful") {
                //     echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">L\'abonnement a bien été supprimé</div>';
                // }

                // if (isset($_GET['create']) == "successful") {
                //     echo '<div class="alert alert-success alert-dismissible " class="close" data-dismiss="alert" role="alert">L\'abonnement a bien été créé</div>';
                // }

                // if (isset($_GET['edit']) == "successful") {
                //     echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">L\'abonnement a bien été modifié</div>';
                // }

                ?>
                <hr>
                <div class="card border-secondary">
                    <div class="card-header text-center">
                        Informations Service
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $serv->getServiceTitle() ?></h5>
                        <p class="card-text">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control" value="<?= $serv->getDescription() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" class="form-control" value="<?= $servPro->getDate() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Heure</label>
                                <input type="text" class="form-control" value="<?= $servPro->getBeginHour() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Lieu</label>
                                <input type="text" class="form-control" value="<?= $servPro->getAddress() ?>, <?= $servPro->getTown() ?>" readonly>
                            </div>
                        </p>
                        <div class="text-center">
                            <div class="btn btn-outline-danger" data-toggle="modal" data-target="#modalCancel">Annuler la réservation</div>
                        </div>
                    </div>
                </div>

                <!-- Modal for cancelling -->
                <div class=" modal fade" id="modalCancel">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Suppression de la réservation</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                Etes-vous certain de vouloir supprimer cette réservation ?
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <a class="" href="delete_reservation.php?reservationId=<?= $_GET['reservationId'] ?>">
                                    <div class="btn btn-outline-danger">Supprimer</div>
                                </a>
                                <button type=" button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>


                <hr>
                <?php
                $proposal = $hm_database->getProposal($servPro->getServiceProvidedId());
                if ($proposal != NULL) { ?>
                    <?php $associate = $hm_database->getAssociate($proposal->getAssociateId()) ?>

                    <div class="card border-secondary">
                        <div class="card-header text-center">
                            Informations Prestataire
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" class="form-control" value="<?= $associate->getLastName() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Prénom</label>
                                <input type="text" class="form-control" value="<?= $associate->getFirstName() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" value="<?= $associate->getEmail() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Téléphone</label>
                                <input type="text" class="form-control" value="<?= $associate->getPhoneNumber() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Adresse</label>
                                <input type="text" class="form-control" value="<?= $associate->getAddress() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Ville</label>
                                <input type="text" class="form-control" value="<?= $associate->getTown() ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Entreprise</label>
                                <input type="text" class="form-control" value="<?= $associate->getCompanyName() ?>" readonly>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="btn btn-outline-danger" data-toggle="modal" data-target="#modalCancelAssociate">Retirer le prestataire</div>
                        </div>

                        <!-- Modal for cancelling associate -->
                        <div class=" modal fade" id="modalCancelAssociate">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Retirement du prestataire</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        Etes-vous certain de vouloir retirer ce prestataire de cette réservation ?
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <a class="" href=" delete_proposal.php?associateId=<?= $hm_database->getAssociate($proposal->getAssociateId())->getAssociateId()  ?>&serviceProvidedId=<?= $servPro->getServiceProvidedId() ?>">
                                            <div class="btn btn-outline-danger">Retirer le prestataire</div>
                                        </a>
                                        <button type=" button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                <?php } else { ?>
                    <div class="text-center">Sélectionner le prestataire</div>
                    <br>
                    <input class="form-control" id="myInput" type="text" placeholder="Recherche..">
                    <br>
                    <table class="table table-bordered table-responsive-lg table-hover">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Numero</th>
                                <th>Adresse</th>
                                <th>Ville</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                            $counter = 1;
                            foreach ($associates as $associate) { ?>
                                <form action="valid_reservation.php" method="POST">
                                    <tr class="table-light text-center">
                                        <td><?= $associate->getLastName() ?></td>
                                        <td><?= $associate->getFirstname() ?></td>
                                        <td><?= $associate->getEmail() ?></td>
                                        <td><?= $associate->getPhoneNumber() ?></td>
                                        <td><?= $associate->getAddress() ?></td>
                                        <td><?= $associate->getTown() ?></td>
                                        <td>
                                            <div class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalAdd<?= $counter ?>">Sélectionner</div>
                                        </td>
                                    </tr>
                                    <input type="hidden" name="serviceProvidedId" value="<?= $servPro->getServiceProvidedId() ?>">
                                    <input type="hidden" type="number" name="status" value="0">
                                    <input type="hidden" name="associateId" value="<?= $associate->getAssociateId() ?>">

                                    <!-- Modal for adding -->
                                    <div class=" modal fade" id="modalAdd<?= $counter ?>">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Sélection du prestataire</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    Etes-vous certain de vouloir sélectionner ce prestataire ?
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-outline-success">Sélectionner</button>
                                                    <button type=" button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php
                                $counter++;
                            } ?>
                        </tbody>
                    </table>
                <?php } ?>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="btn btn-outline-secondary btn-block" onclick="history.back()">Annuler</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once("include/footer.php"); ?>

</body>

<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

</html>