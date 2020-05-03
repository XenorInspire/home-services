 <?php

    require_once('include/check_identity.php');
    if (!($status == 'customer' && $connected == 1)) {

        header('Location: connect.php?status=customer&error=forb');
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
     <title>Home Services - <?= $profile_customer['myProfile'] ?></title>
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
             <h1><?= $profile_customer['myProfile'] ?></h1>
             <br>
             <br>
             <div class="form-row">
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account"><?= $profile_customer['name'] ?></span>
                     </div><!--
                  --><input type="text" name="lastname" class="form-control inputs_account" value="<?php echo $customer->getLastname(); ?>" disabled>
                 </div>
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account"><?= $profile_customer['firstName'] ?></span>
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
                         <span class="input-group-text labels_account"><?= $profile_customer['phone'] ?></span>
                     </div><!--
                    --><input style="width: 72% !important;" name="phone_number" type="text" class="form-control inputs_account" value="<?php echo $customer->getPhone_number(); ?>" disabled>
                 </div>
             </div>
             <br>
             <div class="input-group" style="width: 94.2%;margin: auto;margin-left: 3.3%;">
                 <div class="input-group-prepend">
                     <span class="input-group-text"><?= $profile_customer['address'] ?></span>
                 </div>
                 <input type="text" name="address" class="form-control inputs2_account" value="<?php echo $customer->getAddress(); ?>" disabled>
                 <input type="text" name="city" class="form-control inputs2_account" value="<?php echo $customer->getCity(); ?>" disabled>
             </div>
             <br>
             <small id="infos" class="form-text text-muted"></small>
             <br>
             <button type="button" class="btn btn-dark" onclick="enable()"><?= $profile_customer['changeMyProfile'] ?></button>
         </section>
         <br>
         <br>
         <br>

         <section class="container text-center">

             <h2><?= $profile_customer['myPasswd'] ?></h2>
             <br>
             <br>
             <div class="form-row">
                 <div class="col">
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account"><?= $profile_customer['passwd'] ?></span>
                     </div><!--
                  --><input style="width: 50% !important;" name="old_password" type="password" class="form-control inputs_account" disabled>
                     <br>
                     <br>
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account"><?= $profile_customer['newPasswd'] ?></span>
                     </div><!--
                  --><input style="width: 48.1% !important;" id="password_length" onkeyup="checkPassword()" name="new_password" type="password" class="form-control inputs_account" disabled>
                     <br>
                     <small id="password_size" class="form-text"><?= $profile_customer['minChar'] ?></small>
                     <br>
                     <div class="input-group-prepend" style="display:inline-block !important;">
                         <span class="input-group-text labels_account"><?= $profile_customer['confirm'] ?></span>
                     </div><!--
                  --><input id="same" onkeyup="samePassword()" style="width: 54.3% !important;" name="new_password2" type="password" class="form-control inputs_account" disabled>
                     <br>
                     <small id="password_same" class="form-text"><?= $profile_customer['passwdDifferent'] ?></small>
                     <br>
                     <small id="infos_passwd" class="form-text text-muted"></small>
                     <br>

                 </div>

             </div>
            <button type="button" onclick="enablePasswd()" class="btn btn-dark"><?= $profile_customer['changePasswd'] ?></button>
         </section>
         <br>
         <br>
         <br>
        <button type="button" id="delete_button" data-toggle="modal" data-target="#modalSave" class="btn btn-dark"><?= $profile_customer['disableAcc'] ?></button>
        <br>
        <br>
        <!-- Modal for saving -->
         <div class="modal fade" id="modalSave">
             <div class="modal-dialog modal-dialog-centered">
                 <div class="modal-content">
                     <!-- Modal Header -->
                     <div class="modal-header">
                         <h4 class="modal-title"><?= $profile_customer['accDisabling'] ?></h4>
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                     <!-- Modal body -->
                     <div class="modal-body">
                          <?= $profile_customer['confirmDisable'] ?>
                        </div>
                     <!-- Modal footer -->
                     <div class="modal-footer">
                         <button class="btn btn-outline-success" onclick="window.location.href = 'disable_account.php';" type="submit"><?= $profile_customer['disable'] ?></button>
                         <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?= $profile_customer['cancel'] ?></button>
                        </div>
                 </div>
              </div>
         </div>
        <br>
     </main>

     <?php require_once("include/footer.php"); ?>
     <script type="text/javascript"> var lang= "<?php echo $_SESSION['lang']; ?>"</script>
    <script src="js/profile_customer.js"></script>
    <script src="js/password.js"></script>
    <script>
         allocate("<?php echo $id; ?>");
     </script>
 </body>

 </html>
