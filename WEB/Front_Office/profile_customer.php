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
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Nom</span>
                     </div><!--
                  --><input type="text" class="form-control inputs_account" value="<?php echo $customer->getLastname(); ?>" disabled>
                 </div>
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Prénom</span>
                     </div><!--
                  --><input type="text" class="form-control inputs_account" value="<?php echo $customer->getFirstname(); ?>" disabled>
                 </div>
             </div>
             <br>
             <div class="form-row">
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">@</span>
                     </div><!--
                  --><input style="width: 79% !important;" type="text" class="form-control inputs_account" value="<?php echo $customer->getMail(); ?>" disabled>
                 </div>
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Téléphone</span>
                     </div><!--
                    --><input style="width: 72% !important;" type="text" class="form-control inputs_account" value="<?php echo $customer->getPhone_number(); ?>" disabled>
                 </div>
             </div>
             <br>
             <div class="input-group" style="width: 94.2%;margin: auto;margin-left: 3.3%;">
                 <div class="input-group-prepend">
                     <span class="input-group-text">Adresse</span>
                 </div>
                 <input type="text" class="form-control inputs2_account" value="<?php echo $customer->getAddress(); ?>" disabled>
                 <input type="text" class="form-control inputs2_account" value="<?php echo $customer->getCity(); ?>" disabled>
             </div>
             <br>
             <br>
             <button type="button" class="btn btn-dark" onclick="enable()">Modifier mes informations</button>
         </section>
         <br>
         <br>
         <br>

         <section class="container text-center">

             <h2>Mon mot de passe</h2>
             <br>
             <br>
             <div class="form-row">
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Mot de passe actuel</span>
                     </div><!--
                  --><input style="width: 50% !important;" type="password" class="form-control inputs_account" disabled>
                     <br>
                     <br>
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Nouveau mot de passe</span>
                     </div><!--
                  --><input style="width: 48.1% !important;" type="password" class="form-control inputs_account" disabled>
                     <br>
                     <br>
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Confirmation</span>
                     </div><!--
                  --><input style="width: 54.3% !important;" type="password" class="form-control inputs_account" disabled>
                     <br>
                     <br>
                     <br>
                     
                 </div>
                 
             </div>
            <button type="button" onclick="enablePasswd()" class="btn btn-dark">Changer mon mot de passe</button>
         </section>
         <br>
         <br>
         <br>


     </main>

     <?php require_once("include/footer.php"); ?>
    <script src="js/profile_customer.js"></script>
 </body>

 </html>