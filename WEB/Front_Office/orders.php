 <?php

    require_once('include/check_identity.php');
    if (!($status == 'customer' && $connected == 1)) {

        header('Location: connect.php?status=customer&error=forb');
        exit;
    }
    $hm_database = new DBManager($bdd);
    $customer = $hm_database->getUserById($id);

    date_default_timezone_set('Europe/Paris');
    $today = date("Y-m-d");

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
    function dateSubtractionNotAbs($date1, $date2)
    {
        $sub = $date1 - $date2; // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
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

    $estimates = $hm_database->getEstimateListByCustomerId($id);

    ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Home Services - <?= $orders['myOrders'] ?></title>
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
                    echo '<div class="alert alert-info alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $orders['stopSubscription'] . '</div>';
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
                 <h1><?= $orders['mySubscription'] ?></h1>
                 <br>
                 <ul style="margin:auto;width:50%;padding:0px;">
                     <li class="list-group-item list-group-item-info"><?= $orders['subscriptionType'] ?><?php echo $subscriptionType->getTypeName(); ?></li>
                     <li class="list-group-item"><?php echo $subscriptionType->getDays(); ?> <?= $orders['daysAWeek'] ?></li>
                     <?php

                        if ($time1 == 24 && $time2 == 24) {

                        ?>

                         <li class="list-group-item"><?= $orders['allDay'] ?></li>

                     <?php

                        } else {

                        ?>
                         <li class="list-group-item"><?= $orders['from'] ?><?php echo $time1; ?><?= $orders['to'] ?><?php echo $time2; ?><?= $orders['clock'] ?></li>

                     <?php

                        }

                        ?>

                     <li class="list-group-item"><?= $orders['withMax'] ?><?php echo $subscriptionType->getServiceTime(); ?><?= $orders['hoursAMonth'] ?></li>
                     <li class="list-group-item"><?= $orders['price'] ?><?php echo $subscriptionType->getPrice(); ?><?= $orders['priceYear'] ?></li>
                     <li class="list-group-item"><?= $orders['youHave'] ?><?php echo $result->getRemainingHours(); ?><?= $orders['leftThisMonth'] ?></li>
                     <li class="list-group-item"><?= $orders['daysLeft'] ?> <?php echo $sub['day'] + 1; ?><?= $orders['days'] ?></li>

                 </ul>
                 <br>

                 <!-- <button type="button" onclick="window.open('subscription_bill.php?i=<?= $subscriptionBill['billId'] ?>');" class="btn btn-dark"><?= $orders['dlBill'] ?></button>
                 <button type="button" data-toggle="modal" data-target="#modalSave" class="btn btn-dark"><?= $orders['cancelSubscription'] ?></button> -->

                 <!-- <button type="button" onclick="window.open('subscription_bill.php?i=<?= $subscriptionBill['billId'] ?>');" class="btn btn-dark">Télécharger ma facture</button>
                 <button type="button" data-toggle="modal" data-target="#modalSave" class="btn btn-dark">Résilier mon abonnement</button> -->


                 <div class="btn-group btn-group-toggle" data-toggle="buttons">
                     <label class="btn btn-dark">
                         <button type="button" onclick="window.open('subscription_bill.php?i=<?= $subscriptionBill['billId'] ?>');" class="btn btn-dark"><?= $orders['dlBill']?></button>
                     </label>
                     <label class="btn btn-dark">
                         <button type="button" data-toggle="modal" data-target="#modalSave" class="btn btn-dark"><?= $orders['cancelSubscription']?></button>
                     </label>
                     <?php
                        $isEstimate = FALSE;
                        if (!empty($estimates)) {
                            foreach ($estimates as $estimate) {
                                $service = $hm_database->getService($estimate->getServiceId());
                                $estimateDate = $estimate->getEstimateDate();
                                $serviceProvidedDate = $estimate->getServiceProvidedDate();

                                $diffEstimateToday = dateSubtractionNotAbs(strtotime($estimateDate), strtotime($today));
                                $diffServiceToday = dateSubtractionNotAbs(strtotime($serviceProvidedDate), strtotime($today));

                                if ($diffEstimateToday['day'] >= 0 && $diffServiceToday['day'] >= 0 && $service != NULL) {
                                    $isEstimate = TRUE;
                                }
                            }
                        }

                        if (!empty($estimates) && $isEstimate == TRUE) {
                        ?>
                         <label class="btn btn-dark">
                             <button type="button" onclick="window.location.href = 'estimates.php';" class="btn btn-dark"><?= $orders['myEstimates']?></button>
                         </label>
                     <?php
                        }
                        ?>
                 </div>

                 <!-- Modal for saving -->
                 <div class="modal fade" id="modalSave">
                     <div class="modal-dialog modal-dialog-centered">
                         <div class="modal-content">
                             <!-- Modal Header -->
                             <div class="modal-header">
                                 <h4 class="modal-title"><?= $orders['subscriptionTermination'] ?></h4>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                             </div>
                             <!-- Modal body -->
                             <div class="modal-body">
                                 <?= $orders['confirmTermination'] ?>
                             </div>
                             <!-- Modal footer -->
                             <div class="modal-footer">
                                 <button class="btn btn-outline-danger" onclick="window.location.href = 'delete_subscription.php';" type="submit"><?= $orders['terminate'] ?></button>
                                 <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?= $orders['cancel'] ?></button>
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
                 <h1><?= $orders['myHistory'] ?></h1>
                 <br>
                 <table class="table">
                     <thead class="thead-dark">
                         <tr>
                             <th scope="col"><?= $orders['subscription'] ?></th>
                             <th scope="col"><?= $orders['subscriptionDate'] ?></th>
                             <th scope="col"><?= $orders['price1'] ?></th>
                             <th scope="col"><?= $orders['action'] ?></th>
                         </tr>
                     </thead>
                     <tbody>

                         <?php


                            for ($i = 0; $i < count($oldSubscriptions); $i++) {

                            ?>

                             <tr>
                                 <td><?= $oldSubscriptions[$i]['typeName'] ?></td>
                                 <td><?= $oldSubscriptions[$i]['billDate'] ?></td>
                                 <td><?= $oldSubscriptions[$i]['price'] ?><?= $orders['includingAllTax'] ?></td>
                                 <td><button type="button" class="btn btn-primary mb-2" onclick="window.open('subscription_bill.php?i=<?= $oldSubscriptions[$i]['billId'] ?>');"><?= $orders['getBill'] ?></button></td>
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
                 <h1><?= $orders['myBookings'] ?></h1>
                 <br>
                 <?php
                    if (isset($_GET['error'])) {

                        if ($_GET['error'] == 'nr') {

                            echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $orders['notDoneYet'] . '</div>';
                            echo '<br>';
                        }

                        if ($_GET['error'] == 'inp') {

                            echo '<div class="alert alert-danger alert-dimissible text-center" class="close" data-dismiss="alert" role="alert">' . $orders['formStillEmpty'] . '</div>';
                            echo '<br>';
                        }
                    }
                    ?>
                 <table class="table">
                     <thead class="thead-dark">
                         <tr>
                             <th scope="col"><?= $orders['service'] ?></th>
                             <th scope="col"><?= $orders['date'] ?></th>
                             <th scope="col"><?= $orders['time'] ?></th>
                             <th scope="col"><?= $orders['price1'] ?></th>
                             <th scope="col"><?= $orders['action'] ?></th>
                         </tr>
                     </thead>
                     <tbody>

                         <?php
                            $counter = 1;
                            for ($i = 0; $i < count($services); $i++) {

                                $parts = explode(".", $services[$i]['beginHour']);

                            ?>

                             <tr>
                                 <td><?= $services[$i]['serviceTitle'] ?></td>
                                 <td><?= $services[$i]['date'] ?></td>
                                 <td><?= $parts[0] ?></td>
                                 <td><?= $services[$i]['servicePrice'] ?><?= $orders['priceHourWithTax'] ?></td>

                                 <?php
                                    $bill = $hm_database->checkBill($services[$i]['serviceProvidedId']);
                                    if ($result != NULL && $services[$i]['status'] == 1 && $bill != NULL && $bill['paidStatus'] == 1) {

                                    ?>

                                     <td><button type="button" class="btn btn-primary mb-2" onclick="window.open('service_bill.php?i=<?= $services[$i]['serviceProvidedId'] ?>');"><?= $orders['getBill'] ?></button></td>

                                 <?php

                                    } elseif ($services[$i]['status'] == 1 && $bill['paidStatus'] == 0) {

                                    ?>

                                     <td><button type="button" class="btn btn-primary mb-2" onclick="window.location.href = 'pay_service.php?sp=<?= $services[$i]['serviceProvidedId'] ?>';"><?= $orders['pay'] ?></button></td>

                                 <?php

                                    } elseif ($services[$i]['status'] == 1 && $bill != NULL && $bill['paidStatus'] == 1) {

                                    ?>

                                     <td><button type="button" class="btn btn-primary mb-2" onclick="window.open('service_bill.php?i=<?= $services[$i]['serviceProvidedId'] ?>');"><?= $orders['getBill'] ?></button></td>

                                 <?php

                                    } else {

                                    ?>

                                     <td><button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalAdd<?= $counter ?>"><?= $orders['cancel'] ?></button></td>

                                 <?php

                                    }

                                    ?>

                             </tr>
                             <!-- Modal for saving -->
                             <div class="modal fade" id="modalAdd<?= $counter ?>">
                                 <div class="modal-dialog modal-dialog-centered">
                                     <div class="modal-content">
                                         <!-- Modal Header -->
                                         <div class="modal-header">
                                             <h4 class="modal-title"><?= $orders['booking'] ?></h4>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                         </div>
                                         <!-- Modal body -->
                                         <div class="modal-body">
                                             <?= $orders['confirmCancel'] ?>
                                         </div>
                                         <!-- Modal footer -->
                                         <div class="modal-footer">
                                             <button class="btn btn-outline-success" onclick="window.location.href = 'cancel_reservation.php?&rid=<?= $services[$i]['reservationId'] ?>';" type="submit"><?= $orders['cancelBooking'] ?></button>
                                             <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?= $orders['back'] ?></button>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                         <?php
                                $counter++;
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