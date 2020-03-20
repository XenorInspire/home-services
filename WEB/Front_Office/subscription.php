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

         <section class="container-fluid">

             <input id="cardholder-name" type="text">
             </input>

             <div id="card-element">
                 <!-- Elements will create input elements here -->
             </div>

             <!-- We'll put the error messages in this element -->
             <div id="card-errors" role="alert"></div>

             <button id="card-button" data-secret="<?= $intent->client_secret; ?>">Pay</button>

         </section>

     </main>

     <?php require_once("include/footer.php"); ?>
     <script src="js/stripe.js"></script>
     <script src="https://js.stripe.com/v3/"></script>

 </body>

 </html>