<?php
require_once('class/DBManager.php');
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
        <div class="container-fluid text-center">
            <div class="jumbotron">
                <div class="display-4">Liste des prestataires</div>
                <br>
                <a href="associates_bills.php"><button type="button" class="btn btn-dark">Factures des prestatires</button></a>
                <hr>
                <input class="form-control" id="myInput" type="text" placeholder="Recherche..">
                <br>
                <table class="table table-bordered table-responsive-lg table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Numéro</th>
                            <th>Adresse</th>
                            <th>Ville</th>
                            <th>SIREN</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php
                        $hm_database = new DBManager($bdd);
                        $associates = [];
                        $associates = $hm_database->getAssociateList();
                        foreach ($associates as $associate) { ?>
                            <?php
                            if ($associate->getEnable() == 0) {
                                echo '<tr class="table-dark">';
                            } else {
                                echo '<tr class="table-light">';
                            }
                            ?>
                            <!-- <tr class="table-light table-active"> -->
                            <td><?= $associate->getLastName() ?></td>
                            <td><?= $associate->getFirstName() ?></td>
                            <td><?= $associate->getEmail() ?></td>
                            <td><?= $associate->getPhoneNumber() ?></td>
                            <td><?= $associate->getAddress() ?></td>
                            <td><?= $associate->getTown() ?></td>
                            <td><?= $associate->getSirenNumber() ?></td>
                            <td><a class="" href="edit_associate.php?associateId=<?= $associate->getAssociateId() ?>">
                                    <div class="btn btn-outline-secondary"><img src="https://img.icons8.com/windows/32/000000/edit.png"></div>
                                </a> </td>
                            </tr>

                        <?php } ?>

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