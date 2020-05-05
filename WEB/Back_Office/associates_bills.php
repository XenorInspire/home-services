<?php
require_once('class/DBManager.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Factures Prestatires</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

    <?php require_once("include/header.php"); ?>

    <main>
        <br>
        <div class="container-fluid text-center">
            <div class="jumbotron">
                <?php
                if (isset($_GET['info']) && !empty($_GET['info'])) {
                    if ($_GET['info'] == "checked_success")
                        echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">Devis validé</div>';
                    if ($_GET['info'] == "unchecked_success")
                        echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">Devis annulé</div>';
                }
                ?>
                <div class="display-4">Factures prestataires</div>
                <hr>
                <input class="form-control" id="myInput" type="text" placeholder="Recherche..">
                <br>
                <table class="table table-bordered table-responsive-lg table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Ville</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php
                        $hm_database = new DBManager($bdd);
                        $associateBills = [];
                        $associateBills = $hm_database->getAssociateBillList();
                        $counter = 1;
                        foreach ($associateBills as $bill) {

                            if ($bill->getPaidStatus() == 0) {
                                echo '<tr class="table-light">';
                            } else {
                                echo '<tr class="table-dark">';
                            }
                        ?>
                            <td><?= $bill->getAssociateBillId() ?></td>
                            <td><?= $bill->getAssociateLastName() ?></td>
                            <td><?= $bill->getAssociateFirstName() ?></td>
                            <td><?= $bill->getEmail() ?></td>
                            <td><?= $bill->getAssociateAddress() ?></td>
                            <td><?= $bill->getAssociateTown() ?></td>
                            <td>
                                <a target="_blank" href="generate_associate_bill.php?id=<?= $bill->getAssociateBillId() ?>">
                                    <div class="btn btn-outline-secondary"><img src="https://img.icons8.com/wired/64/000000/pdf.png" width="30" /></div>
                                </a>
                                <?php
                                if ($bill->getPaidStatus() == 0) {
                                ?>
                                    <div class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalAdd<?= $counter ?>"><img src="https://img.icons8.com/android/48/000000/checkmark.png" width="30" /></div>
                                <?php
                                } else { ?>
                                    <div class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalDel<?= $counter ?>"><img src="https://img.icons8.com/material-rounded/48/000000/delete-sign.png" width="30" /></div>
                                <?php
                                } ?>
                            </td>
                            </tr>


                            <!-- Modal for adding -->
                            <div class=" modal fade" id="modalAdd<?= $counter ?>">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Facture numéro <?= $bill->getAssociateBillId() ?></h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            Voulez-vous valider le paiement de cette facture ?
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <a href="valid_associate_bill.php?id=<?= $bill->getAssociateBillId() ?>">
                                                <div class="btn btn-outline-success" data-toggle="modal" data-target="#modalAdd<?= $counter ?>">Valider</div>
                                            </a>
                                            <button type=" button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal for adding -->
                            <div class=" modal fade" id="modalDel<?= $counter ?>">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Facture numéro <?= $bill->getAssociateBillId() ?></h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            Voulez-vous annuler le paiement de cette facture ?
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <a href="unvalid_associate_bill.php?id=<?= $bill->getAssociateBillId() ?>">
                                                <div class="btn btn-outline-danger" data-toggle="modal" data-target="#modalAdd<?= $counter ?>">Annuler</div>
                                            </a>
                                            <button type=" button" class="btn btn-outline-secondary" data-dismiss="modal">Ignorer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php
                            $counter++;
                        } ?>
                    </tbody>
                </table>
                <br>
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