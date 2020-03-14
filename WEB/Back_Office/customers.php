<?php
require_once('class/DBManager.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Home Services - Clients</title>
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

            <h1>Liste des clients</h1>
            <hr>

            <input class="form-control" id="myInput" type="text" placeholder="Recherche..">
            <br>



            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Lastname</th>
                        <th>Firstname</th>
                        <th>Email</th>
                        <th>Numero</th>
                        <th>Adresse</th>
                        <th>Ville</th>
                        <th>Modifier</th>
                    </tr>
                </thead>
                <tbody id="myTable">


                    <?php
                    $hm_database = new DBManager($bdd);
                    $users = [];
                    $users = $hm_database->getCustomerList();
                    foreach ($users as $user) { ?>
                        <!-- <div class="row justify-content-center">
                            <div class="col-6">
                                <h2><a title="Modifier" class="btn  btn-block" href="edit_subscription.php?id=<?= $user->getId() ?>"><?= $user->getLastname() ?></a></h2>
                            </div>
                        </div>
                        <hr> -->
                        <?php
                            if($user->getEnable() == 0){
                                echo '<tr class="table-light">';
                            }else{
                                echo '<tr class="table-light table-active">';
                            }
                        ?>
                        <!-- <tr class="table-light table-active"> -->
                            <td><?= $user->getLastname() ?></td>
                            <td><?= $user->getFirstName() ?></td>
                            <td><?= $user->getEmail() ?></td>
                            <td><?= $user->getPhoneNumber() ?></td>
                            <td><?= $user->getAddress() ?></td>
                            <td><?= $user->getTown() ?></td>
                            <td><a class="" href="edit_customer.php?id=<?= $user->getId() ?>">
                                    <div class="btn btn-outline-secondary"><img src="https://img.icons8.com/windows/32/000000/edit.png"></div>
                                </a> </td>
                        </tr>

                    <?php } ?>

                </tbody>
            </table>
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