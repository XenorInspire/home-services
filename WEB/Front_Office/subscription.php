 <?php
    if (!isset($_GET['s']) || empty($_GET['s'])) {

        header('Location: shop.php');
        exit;
    }

    if (!is_numeric($_GET['s'])) {

        header('Location: shop.php');
        exit;
    }

    require_once('include/check_identity.php');
    if (!($status == 'customer' && $connected == 1)) {

        header('Location: connect_customer.php?error=forb');
        exit;
    }

    $hm_database = new DBManager($bdd);

    if ($hm_database->checkSubscription($id) != NULL) {

        header('Location: shop.php?err=alr');
        exit;
    }

    $subscriptionType = $hm_database->getSubscriptionTypeById($_GET['s']);
    if ($subscriptionType == NULL) {

        header('Location: shop.php');
        exit;
    }

    require_once('stripe-php-master/init.php');
    \Stripe\Stripe::setApiKey('sk_test_do0SvWS6wTl1fj8ZorABYc7f00nVz5JTWp');
    $customer = \Stripe\Customer::create();

    $intent = \Stripe\PaymentIntent::create([
        'amount' => $subscriptionType->getPrice() * 100,
        'currency' => 'eur',
        'customer' => $customer->id,
    ]);
    sscanf($subscriptionType->getBeginTime(), "%d:%s", $time1, $trash);
    sscanf($subscriptionType->getEndTime(), "%d:%s", $time2, $trash);

    ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Home Services - Boutique</title>
     <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
     <link rel="stylesheet" href="css/style.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
 </head>

 <body onload="subscribe()">

     <?php require_once("include/header.php"); ?>

     <main>
         <br>
         <br>

         <section id="subscription_block" class="container text-center">
             <br>
             <h2>Abonnement <?php echo $subscriptionType->getTypeName(); ?></h2>
             <br>
             <ul style="margin:auto;width:50%;padding:0px;">
                 <li class="list-group-item list-group-item-info">Plus d'informations :</li>
                 <li class="list-group-item"><?php echo $subscriptionType->getDays(); ?> jours par semaine</li>
                 <?php

                    if ($time1 == 24 && $time2 == 24) {

                    ?>

                     <li>24h sur 24 !</li>

                 <?php

                    } else {

                    ?>
                     <li class="list-group-item">De <?php echo $time1; ?>h à <?php echo $time2; ?>h</li>

                 <?php

                    }

                    ?>

                 <li class="list-group-item">Avec un maximum de <?php echo $subscriptionType->getServiceTime(); ?>h par mois !</li>
                 <li class="list-group-item">Prix : <?php echo $subscriptionType->getPrice(); ?>€ TTC/an</li>
             </ul>
             <br>
             <h3>Paiement</h3>
             <br>
             <input id="cardholder-name" type="text" placeholder="Titulaire de la carte">
             </input>
             <br>
             <br>
             <div id="card-element" class="text-center">
                 <!-- Elements will create input elements here -->
             </div>

             <!-- We'll put the error messages in this element -->
             <div id="card-errors" role="alert"></div>
             <br>
             <!-- <button id="card-button" data-secret="<?= $intent->client_secret; ?>" type="button" class="btn btn-elegant">Elegant</button> -->
             <button onclick="loading()" class="btn btn-lg btn-block btn-primary" id="card-button" data-secret="<?= $intent->client_secret; ?>">Payer</button>
             <br>
             <small style="color:red;display:none;" id="payInfos" class="form-text text-muted">Vos coordonnées bancaires sont incorrectes</small>
             <br>
         </section>

     </main>

     <?php require_once("include/footer.php"); ?>
     <script src="js/stripe.js"></script>
     <script src="https://js.stripe.com/v3/"></script>
     <script>
         allocate("<?php echo $id; ?>", "<?php echo $_GET['s']; ?>");
     </script>

 </body>

 </html>