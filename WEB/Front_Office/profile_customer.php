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
                  --><input type="text" name="lastname" class="form-control inputs_account" value="<?php echo $customer->getLastname(); ?>" disabled>
                 </div>
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Prénom</span>
                     </div><!--
                  --><input type="text" name="firstname" class="form-control inputs_account" value="<?php echo $customer->getFirstname(); ?>" disabled>
                 </div>
             </div>
             <br>
             <div class="form-row">
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">@</span>
                     </div><!--
                  --><input style="width: 79% !important;" name="mail" type="text" class="form-control inputs_account" value="<?php echo $customer->getMail(); ?>" disabled>
                 </div>
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Téléphone</span>
                     </div><!--
                    --><input style="width: 72% !important;" name="phone_number" type="text" class="form-control inputs_account" value="<?php echo $customer->getPhone_number(); ?>" disabled>
                 </div>
             </div>
             <br>
             <div class="input-group" style="width: 94.2%;margin: auto;margin-left: 3.3%;">
                 <div class="input-group-prepend">
                     <span class="input-group-text">Adresse</span>
                 </div>
                 <input type="text" name="address" class="form-control inputs2_account" value="<?php echo $customer->getAddress(); ?>" disabled>
                 <input type="text" name="city" class="form-control inputs2_account" value="<?php echo $customer->getCity(); ?>" disabled>
             </div>
             <br>
             <small id="infos" class="form-text text-muted"></small>
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
                  --><input style="width: 50% !important;" name="old_password" type="password" class="form-control inputs_account" disabled>
                     <br>
                     <br>
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Nouveau mot de passe</span>
                     </div><!--
                  --><input style="width: 48.1% !important;" id="password_length" onkeyup="checkPassword()" name="new_password" type="password" class="form-control inputs_account" disabled>
                     <br>
                     <small id="password_size" class="form-text">6 caractères minimum</small>
                     <br>
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account">Confirmation</span>
                     </div><!--
                  --><input id="same" onkeyup="samePassword()" style="width: 54.3% !important;" name="new_password2" type="password" class="form-control inputs_account" disabled>
                     <br>
                     <small id="password_same" class="form-text">Ce mot de passe est différent du champs précédent !</small>
                     <br>
                     <small id="infos_passwd" class="form-text text-muted"></small>
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
    <script src="js/password.js"></script>
    <script>
         allocate("<?php echo $id; ?>");
     </script>
 </body>

 </html>