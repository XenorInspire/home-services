<?php
require_once('class/DBManager.php');
isset($_GET['customerId']);
$customerId = $_GET['customerId'];
$hm_database = new DBManager($bdd);
$customer = $hm_database->getCustomer($customerId);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Client</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <?php require_once('include/config.php'); ?>
    <?php require_once("include/header.php"); ?>

    <main>
        <br>
        <div class="container-fluid">
            <div class="jumbotron text-center">
                <div class="display-4"><?= $customer->getLastname() ?> <?= $customer->getFirstname() ?></div>
                <br>
                <section class="container text-center">
             <h1>Informations personnelles du client</h1>
             <br>
             <br>
             <div class="form-row">
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Nom</span>
                     </div><!--
                  --><input type="text" name="lastname" class="form-control inputs_account" value="<?php echo $customer->getLastname(); ?>" disabled>
                 </div>
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Prénom</span>
                     </div><!--
                  --><input type="text" name="firstname" class="form-control inputs_account" value="<?php echo $customer->getFirstname(); ?>" disabled>
                 </div>
             </div>
             <br>
             <div class="form-row">
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">@</span>
                     </div><!--
                  --><input style="width: 79% !important;" name="mail" type="text" class="form-control inputs_account" value="<?php echo $customer->getEmail(); ?>" disabled>
                 </div>
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Téléphone</span>
                     </div><!--
                    --><input style="width: 72% !important;" name="phone_number" type="text" class="form-control inputs_account" value="<?php echo $customer->getPhoneNumber(); ?>" disabled>
                 </div>
             </div>
             <br>
             <div class="input-group" style="width: 94.2%;margin: auto;margin-left: 3.3%;">
                 <div class="input-group-prepend">
                     <span class="input-group-text">Adresse</span>
                 </div>
                 <input type="text" name="address" class="form-control inputs2_account" value="<?php echo $customer->getAddress(); ?>" disabled>
                 <input type="text" name="city" class="form-control inputs2_account" value="<?php echo $customer->getTown(); ?>" disabled>
             </div>
             <br>
             <small id="infos" class="form-text text-muted"></small>
             <br>
             <button type="button" class="btn btn-dark" onclick="enable()">Modifier ses informations</button>
         </section>
         <br>
         <br>
         <br>

         <section class="container text-center">

             <h2>Mot de passe du client</h2>
             <br>
             <br>
             <div class="form-row">
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Nouveau mot de passe</span>
                     </div><!--
                  --><input style="width: 48.1% !important;" id="password_length" onkeyup="checkPassword()" name="new_password" type="password" class="form-control inputs_account" disabled>
                     <br>
                     <small id="password_size" class="form-text">6 caractères minimum</small>
                     <br>
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Confirmation</span>
                     </div><!--
                  --><input id="same" onkeyup="samePassword()" style="width: 54.3% !important;" name="new_password2" type="password" class="form-control inputs_account" disabled>
                     <br>
                     <small id="password_same" class="form-text">Ce mot de passe est différent du champs précédent !</small>
                     <br>
                     <small id="infos_passwd" class="form-text text-muted"></small>
                     <br>
                     
                 </div>
                 
             </div>
            <button type="button" onclick="enablePasswd()" class="btn btn-dark">Changer son mot de passe</button>
         </section>
         <br>
         <br>
         <br>

        <?php
        if($customer->getEnable() == 0){
            ?>
        <button type="button" data-toggle="modal" data-target="#modalSave" class="btn btn-success">Activer son compte</button>
        <br>
        <br>
        <!-- Modal for saving -->
         <div class="modal fade" id="modalSave">
             <div class="modal-dialog modal-dialog-centered">
                 <div class="modal-content">
                     <!-- Modal Header -->
                     <div class="modal-header">
                         <h4 class="modal-title">Activation du compte</h4>
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                     <!-- Modal body -->
                     <div class="modal-body">
                          Voulez-vous vraiment activer le compte de ce client ?
                        </div>
                     <!-- Modal footer -->
                     <div class="modal-footer">
                         <button class="btn btn-outline-success" onclick="window.location.href = 'account_status.php?mode=1&id=<?= $customer->getCustomerId() ?>';" type="submit">Activer</button>
                         <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                        </div>
                 </div>
              </div>
         </div>
         <?php
        } else {

            ?>

            <button type="button" data-toggle="modal" data-target="#modalSave" class="btn btn-danger">Désactiver son compte</button>
        <br>
        <br>
        <!-- Modal for saving -->
         <div class="modal fade" id="modalSave">
             <div class="modal-dialog modal-dialog-centered">
                 <div class="modal-content">
                     <!-- Modal Header -->
                     <div class="modal-header">
                         <h4 class="modal-title">Désactivation du compte</h4>
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                     <!-- Modal body -->
                     <div class="modal-body">
                          Voulez-vous vraiment désactiver le compte de ce client ?
                        </div>
                     <!-- Modal footer -->
                     <div class="modal-footer">
                         <button class="btn btn-outline-danger" onclick="window.location.href = 'account_status.php?mode=2&id=<?= $customer->getCustomerId() ?>';" type="submit">Désactiver</button>
                         <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                        </div>
                 </div>
              </div>
         </div>

            <?php

        }
        ?>
        <br>

                <div class="display-4">Liste des réservations</div>
                <br>
                <a href="create_reservation.php?customerId=<?= $_GET['customerId'] ?>"><button type="button" class="btn btn-dark">Ajouter une réservation</button></a>
                <hr>
                <?php
                if (($services = $hm_database->getReservationsByCustomerId($customer->getCustomerId())) != NULL) {
                ?>
                    <section class="container text-center">
                        <br>
                        <?php
                        if (isset($_GET['error'])) {

                            if ($_GET['error'] == 'nr') {

                                echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">La prestation n\'a pas encore été réalisée.</div>';
                                echo '<br>';
                            }

                            if ($_GET['error'] == 'inp') {

                                echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Veuillez remplir correctement les différents champs de saisie</div>';
                                echo '<br>';
                            }
                        }
                        ?>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Service</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Heure</th>
                                    <th scope="col">Prix</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                for ($i = 0; $i < count($services); $i++) {

                                    $parts = explode(".", $services[$i]['beginHour']);

                                ?>
                                    <tr>
                                        <td><?= $services[$i]['serviceTitle'] ?></td>
                                        <td><?= $services[$i]['date'] ?></td>
                                        <td><?= $parts[0] ?></td>
                                        <td><?= $services[$i]['servicePrice'] ?>€/h TTC</td>

                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <br>

                    </section>

                <?php
                } else {

                ?>
                    <section class="container text-center">
                        <h3><i>Ce client n'a encore aucune réservation à ce jour.</i></h3>
                    </section>

                <?php

                }
                ?>
                <hr>
            </div>
        </div>
    </main>

    <?php require_once("include/footer.php"); ?>
    <script src="js/profile_customer.js"></script>
    <script src="js/password.js"></script>
    <script>
         allocate("<?php echo $customer->getCustomerId(); ?>");
     </script>

</body>

</html>