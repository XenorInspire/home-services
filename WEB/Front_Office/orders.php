 <?php

    require_once('include/check_identity.php');
    if (!($status == 'customer' && $connected == 1)) {

        header('Location: connect.php?status=customer&error=forb');
        exit;
    }
    $hm_database = new DBManager($bdd);
    $customer = $hm_database->getUserById($id);

    function dateSubtraction($date1, $date2)
    {
        $sub = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
        $result = array();

        $tmp = $sub;
        $result['second'] = $tmp % 60;

        $tmp = floor(($tmp - $result['second']) / 60);
        $result['minute'] = $tmp % 60;

        $tmp = floor(($tmp - $result['minute']) / 60);
        $result['hour'] = $tmp % 24;

        $tmp = floor(($tmp - $result['hour'])  / 24);
        $result['day'] = $tmp;

        return $result;
    }

    ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Home Services - Mes commandes</title>
     <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
     <link rel="stylesheet" href="css/style.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
 </head>

 <body>

     <?php require_once("include/header.php"); ?>

     <main>
         <?php

            if (isset($_GET['info'])) {

                if ($_GET['info'] == 'sub_del') {

                    echo '<br>';
                    echo '<br>';
                    echo '<div class="alert alert-info alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">Votre abonnement est bien résilié.</div>';
                }
            }

            ?>

         <?php

            if (($result = $hm_database->checkSubscription($id)) != NULL) {

                $subscriptionType = $hm_database->getSubscriptionTypeById($result->getTypeId());
                sscanf($subscriptionType->getBeginTime(), "%d:%s", $time1, $trash);
                sscanf($subscriptionType->getEndTime(), "%d:%s", $time2, $trash);
                $sub = dateSubtraction(strtotime($result->getBeginDate()) + (365 * 24 * 60 * 60), time());
                $subscriptionBill = $hm_database->getLastSubscriptionBill($id);

            ?>

             <section class="container text-center">

                 <br>
                 <h1>Mon abonnement</h1>
                 <br>
                 <ul style="margin:auto;width:50%;padding:0px;">
                     <li class="list-group-item list-group-item-info">Type d'abonnement : <?php echo $subscriptionType->getTypeName(); ?></li>
                     <li class="list-group-item"><?php echo $subscriptionType->getDays(); ?> jours par semaine</li>
                     <?php

                        if ($time1 == 24 && $time2 == 24) {

                        ?>

                         <li class="list-group-item">24h sur 24 !</li>

                     <?php

                        } else {

                        ?>
                         <li class="list-group-item">De <?php echo $time1; ?>h à <?php echo $time2; ?>h</li>

                     <?php

                        }

                        ?>

                     <li class="list-group-item">Avec un maximum de <?php echo $subscriptionType->getServiceTime(); ?>h par mois !</li>
                     <li class="list-group-item">Prix : <?php echo $subscriptionType->getPrice(); ?>€ TTC/an</li>
                     <li class="list-group-item">Il vous reste ce mois-ci : <?php echo $result->getRemainingHours(); ?> heures</li>
                     <li class="list-group-item">Votre abonnement est encore valable <?php echo $sub['day'] + 1; ?> jour(s)</li>

                 </ul>
                 <br>
                 <button type="button" onclick="window.location.href = 'subscription_bill.php?i=<?= $subscriptionBill['billId'] ?>';" class="btn btn-dark">Télécharger ma facture</button>
                 <button type="button" data-toggle="modal" data-target="#modalSave" class="btn btn-dark">Résilier mon abonnement</button>

                 <!-- Modal for saving -->
                 <div class="modal fade" id="modalSave">
                     <div class="modal-dialog modal-dialog-centered">
                         <div class="modal-content">
                             <!-- Modal Header -->
                             <div class="modal-header">
                                 <h4 class="modal-title">Résiliation de mon abonnement</h4>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                             </div>
                             <!-- Modal body -->
                             <div class="modal-body">
                                 Voulez-vous vraiment résilier votre abonnement ?
                             </div>
                             <!-- Modal footer -->
                             <div class="modal-footer">
                                 <button class="btn btn-outline-success" onclick="window.location.href = 'delete_subscription.php';" type="submit">Résilier</button>
                                 <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Retour</button>
                             </div>
                         </div>
                     </div>
                 </div>

             </section>

         <?php
            }
            ?>

         <?php

            if (($oldSubscriptions = $hm_database->getInactiveSubscriptionsByCustomerId($id)) != NULL) {
            ?>
             <section class="container text-center">
                 <br>
                 <br>
                 <h1>Mes anciens abonnements</h1>
                 <br>
                 <table class="table">
                     <thead class="thead-dark">
                         <tr>
                             <th scope="col">Abonnement</th>
                             <th scope="col">Date de souscription</th>
                             <th scope="col">Prix</th>
                             <th scope="col">Action</th>
                         </tr>
                     </thead>
                     <tbody>

                         <?php


                            for ($i = 0; $i < count($oldSubscriptions); $i++) {

                            ?>

                             <tr>
                                 <td><?= $oldSubscriptions[$i]['typeName'] ?></td>
                                 <td><?= $oldSubscriptions[$i]['billDate'] ?></td>
                                 <td><?= $oldSubscriptions[$i]['price'] ?>€ TTC</td>
                                 <td><button type="button" class="btn btn-primary mb-2" onclick="window.location.href = 'subscription_bill.php?i=<?= $oldSubscriptions[$i]['billId'] ?>';">Obtenir ma facture</button></td>
                             </tr>
                         <?php

                            }
                            ?>
                     </tbody>
                 </table>
                 <br>

             </section>
         <?php
            }
            ?>

         <?php
            if (($services = $hm_database->getReservationsByCustomerId($customer->getId())) != NULL) {
            ?>
             <section class="container text-center">
                 <br>
                 <br>
                 <h1>Mes réservations</h1>
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
                             <th scope="col">Action</th>
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

                                 <?php
                                    $bill = $hm_database->checkBill($services[$i]['serviceProvidedId']);
                                    if ($result != NULL && $services[$i]['status'] == 1 && $bill != NULL && $bill['paidStatus'] == 1) {

                                    ?>

                                     <td><button type="button" class="btn btn-primary mb-2" onclick="window.location.href = 'service_bill.php?i=<?= $services[$i]['serviceProvidedId'] ?>';">Obtenir ma facture</button></td>

                                 <?php

                                    } elseif ($services[$i]['status'] == 1 && $bill['paidStatus'] == 0) {

                                    ?>

                                     <td><button type="button" class="btn btn-primary mb-2" onclick="window.location.href = 'pay_service.php?sp=<?= $services[$i]['serviceProvidedId'] ?>';">Payer</button></td>

                                 <?php

                                    } elseif ($services[$i]['status'] == 1 && $bill != NULL && $bill['paidStatus'] == 1) {

                                    ?>

                                     <td><button type="button" class="btn btn-primary mb-2" onclick="window.location.href = 'service_bill.php?i=<?= $services[$i]['serviceProvidedId'] ?>';">Obtenir ma facture</button></td>

                                 <?php

                                    } else {

                                    ?>

                                     <td><button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalSave">Annuler</button></td>

                                 <?php

                                    }

                                    ?>

                             </tr>
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
                                             Voulez-vous vraiment annuler cette réservation ?
                                         </div>
                                         <!-- Modal footer -->
                                         <div class="modal-footer">
                                             <button class="btn btn-outline-success" onclick="window.location.href = 'cancel_reservation.php?&rid=<?= $services[$i]['reservationId'] ?>';" type="submit">Annuler</button>
                                             <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Retour</button>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                         <?php
                            }

                            ?>

                     </tbody>
                 </table>
                 <br>

             </section>

         <?php
            }
            ?>
     </main>
     <?php require_once("include/footer.php"); ?>
 </body>

 </html>