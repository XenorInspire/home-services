 <?php
    if (!isset($_GET['sp']) || empty($_GET['sp'])) {

        header('Location: orders.php');
        exit;
    }

    require_once('include/check_identity.php');
    if (!($status == 'customer' && $connected == 1)) {

        header('Location: connect.php?status=customer&error=forb');
        exit;
    }

    $hm_database = new DBManager($bdd);

    if (($serviceProvided = $hm_database->getServiceProvided($_GET['sp'])) == NULL) {

        header('Location: orders.php');
        exit;
    }

    if (($result = $hm_database->checkBill($_GET['sp'])) == NULL) {

        header('Location: orders.php?error=nr');
        exit;
    }

    $service = $hm_database->getService($serviceProvided->getServiceId());

    require_once('stripe-php-master/init.php');
    \Stripe\Stripe::setApiKey('sk_test_do0SvWS6wTl1fj8ZorABYc7f00nVz5JTWp');
    $customer = \Stripe\Customer::create();

    $intent = \Stripe\PaymentIntent::create([
        'amount' => $result['totalPrice'] * 100,
        'currency' => 'eur',
        'customer' => $customer->id,
    ]);

    $parts = explode(".", $serviceProvided->getBeginHour());

    ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Home Services - <?= $pay_service['servicePayment'] ?></title>
     <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
     <link rel="stylesheet" href="css/style.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
 </head>

 <body onload="load_stripe(2)">

     <?php require_once("include/header.php"); ?>

     <main>
         <br>
         <br>

         <section id="subscription_block" class="container text-center">
             <br>
             <h2><?= $pay_service['service'] ?><?= $service->getServiceTitle() ?></h2>
             <br>
             <ul style="margin:auto;width:50%;padding:0px;">
                 <li class="list-group-item list-group-item-info"><?= $service->getDescription() ?></li>
                 <li class="list-group-item"><?= $serviceProvided->getHours() ?><?= $pay_service['timeOfService'] ?></li>
                 <li class="list-group-item"><?= $pay_service['madeThisDay'] ?><?= $serviceProvided->getDate() ?></li>
                 <li class="list-group-item"><?= $pay_service['at'] ?><?= $parts[0] ?></li>
                 <li class="list-group-item"><?= $pay_service['price'] ?><?= $result['totalPrice'] ?><?= $pay_service['allTax'] ?></li>
             </ul>
             <br>
             <h3><?= $pay_service['payment'] ?></h3>
             <br>
             <input id="cardholder-name" type="text" placeholder=<?= $pay_service['cardHolder'] ?>>
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
             <button onclick="loading()" class="btn btn-lg btn-block btn-primary" id="card-button" data-secret="<?= $intent->client_secret; ?>"><?= $pay_service['pay'] ?></button>
             <br>
             <small style="color:red;display:none;" id="payInfos" class="form-text text-muted"><?= $pay_service['invalidCreditCard'] ?></small>
             <br>
         </section>

     </main>

     <?php require_once("include/footer.php"); ?>
     <script src="js/stripe.js"></script>
     <script src="https://js.stripe.com/v3/"></script>
     <script>
         sp("<?php echo $id; ?>", "<?php echo $_GET['sp']; ?>","<?php echo $_SESSION['lang']; ?>" );
     </script>

 </body>

 </html>
