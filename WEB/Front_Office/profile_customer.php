 <?php

    require_once('include/check_identity.php');
    if (!($status == 'customer' && $connected == 1)) {

        header('Location: connect_customer.php?error=forb');
        exit;
    }
    $hm_database = new DBManager($bdd);
    $customer = $hm_database->getUserById($id);

    ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Home Services - Mes informations personnelles</title>
     <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
     <link rel="stylesheet" href="css/style.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
 </head>

 <body>

     <?php require_once("include/header.php"); ?>

     <main>
         <br>
         <br>
         <section class="container text-center">
             <h1>Mes informations personnelles</h1>
             <br>
             <br>
             <div class="form-row">
                 <div class="col">
                     <label class="input-group-text labels_account">Nom</label><!--
                  --><input type="text" class="form-control inputs_account" placeholder="<?php echo $customer->getLastname(); ?>" disabled>
                 </div>
                 <div class="col">
                     <label class="input-group-text labels_account">Prénom</label><!--
                  --><input type="text" class="form-control inputs_account" placeholder="<?php echo $customer->getFirstname(); ?>" disabled>
                 </div>
             </div>
             <br>
             <div class="form-row">
                 <div class="col">
                     <label class="input-group-text labels_account">@</label><!--
                  --><input style="width: 79% !important;" type="text" class="form-control inputs_account" placeholder="<?php echo $customer->getMail(); ?>" disabled>
                 </div>
                 <div class="col">
                     <label class="input-group-text labels_account">Téléphone</label><!--
                  --><input style="width: 72% !important;" type="text" class="form-control inputs_account" placeholder="<?php echo $customer->getPhone_number(); ?>" disabled>
                 </div>
             </div>
             <br>
             <div class="input-group" style="width: 94.2%;margin: auto;margin-left: 3.3%;">
                 <div class="input-group-prepend">
                     <span class="input-group-text" id="">Adresse</span>
                 </div>
                 <input type="text" class="form-control inputs2_account" placeholder="<?php echo $customer->getAddress(); ?>"disabled>
                 <input type="text" class="form-control inputs2_account" placeholder="<?php echo $customer->getCity(); ?>"disabled>
             </div>

         </section>


     </main>

     <?php require_once("include/footer.php"); ?>

 </body>

 </html>