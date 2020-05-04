<?php
require_once('class/DBManager.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Factures</title>
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
                ?>
                <div class="display-4">Liste de toutes les prestations effectuées</div>
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
                            <th>Plus</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php
                        $hm_database = new DBManager($bdd);
                        $bills = [];
                        $bills = $hm_database->getBillList();
                        foreach ($bills as $bill) { ?>
                            <tr class="table-light">
                                <!-- <tr class="table-light table-active"> -->
                                <td><?= $bill->getBillId() ?></td>
                                <td><?= $bill->getCustomerLastName() ?></td>
                                <td><?= $bill->getCustomerFirstName() ?></td>
                                <td><?= $bill->getEmail() ?></td>
                                <td><?= $bill->getCustomerAddress() ?></td>
                                <td><?= $bill->getCustomerTown() ?></td>
                                <td><a class="" href="edit_bill.php?billId=<?= $bill->getBillId() ?>">
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