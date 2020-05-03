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

        header('Location: connect.php?status=customer&error=forb');
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

    if ($hm_database->checkEnableSubscriptionType($subscriptionType->getTypeId()) == NULL) {

        header('Location: shop.php?err=na');
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
     <title>Home Services - <?= $subscription['shop'] ?></title>
     <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
     <link rel="stylesheet" href="css/style.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
 </head>

 <body onload="load_stripe(1)">

     <?php require_once("include/header.php"); ?>

     <main>
         <br>
         <br>

         <section id="subscription_block" class="container text-center">
             <br>
             <h2><?= $subscription['subscription'] ?> <?php echo $subscriptionType->getTypeName(); ?></h2>
             <br>
             <ul style="margin:auto;width:50%;padding:0px;">
                 <li class="list-group-item list-group-item-info"><?= $subscription['moreInformations'] ?></li>
                 <li class="list-group-item"><?php echo $subscriptionType->getDays(); ?><?= $subscription['daysAWeek'] ?></li>
                 <?php

                    if ($time1 == 24 && $time2 == 24) {

                    ?>

                     <li class="list-group-item"><?= $subscription['allDay'] ?></li>

                 <?php

                    } else {

                    ?>
                     <li class="list-group-item"><?= $subscription['from'] ?><?php echo $time1; ?><?= $subscription['to'] ?><?php echo $time2; ?><?= $subscription['clock'] ?></li>

                 <?php

                    }

                    ?>

                 <li class="list-group-item"><?= $subscription['withMax'] ?><?php echo $subscriptionType->getServiceTime(); ?><?= $subscription['hoursAMonth'] ?></li>
                 <li class="list-group-item">Prix : <?php echo $subscriptionType->getPrice(); ?><?= $subscription['yearPrice'] ?></li>
             </ul>
             <br>
             <h3><?= $subscription['payment'] ?></h3>
             <br>
             <input id="cardholder-name" type="text" placeholder="<?= $subscription['cardOwner'] ?>">
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
             <button onclick="loading()" class="btn btn-lg btn-block btn-primary" id="card-button" data-secret="<?= $intent->client_secret; ?>"><?= $subscription['pay'] ?></button>
             <br>
             <small style="color:red;display:none;" id="payInfos" class="form-text text-muted"><?= $subscription['invalidCard'] ?></small>
             <br>
         </section>

     </main>

     <?php require_once("include/footer.php"); ?>
     <script type="text/javascript" src="js/stripe.js"></script>
     <script>
         allocate("<?php echo $id; ?>", "<?php echo $_GET['s']; ?>", "<?php echo $_SESSION['lang']; ?>");
     </script>
     <script src="https://js.stripe.com/v3/"></script>

 </body>

 </html>
