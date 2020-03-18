 <?php

    require_once('include/check_identity.php');
    if(!($status == 'customer' && $connected == 1)){

        header('Location: connect_customer.php?error=forb');
        exit;

    }

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
 </head <body>

 <?php require_once("include/header.php"); ?>

 <main>

 </main>

 <?php require_once("include/footer.php"); ?>
 <script src="js/stripe.js"></script>
 <script src="https://js.stripe.com/v3/"></script>

 </body>

 </html>