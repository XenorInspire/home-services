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

            if (($result = $hm_database->checkSubscription($id)) != NULL) {

                $subscriptionType = $hm_database->getSubscriptionTypeById($result->getTypeId());
                sscanf($subscriptionType->getBeginTime(), "%d:%s", $time1, $trash);
                sscanf($subscriptionType->getEndTime(), "%d:%s", $time2, $trash);
                $sub = dateSubtraction(strtotime($result->getBeginDate()) + (365 * 24 * 60 * 60), time());

            ?>

             <section class="container text-center">

                 <br>
                 <h2>Mon abonnement</h2>
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
                     <li class="list-group-item">Nombre total de jours restant : <?php echo $sub['day'] + 1; ?> jours</li>
                 </ul>
                 <br>
                 <button type="button" onclick="window.location.href = 'data_pdf.php?mode=1';" class="btn btn-dark">Télécharger ma facture</button>
             </section>

         <?php
            }

            ?>

     </main>

     <?php require_once("include/footer.php"); ?>
 </body>

 </html>