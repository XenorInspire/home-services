<?php

require_once('include/check_identity.php');
if ($connected == 1) {

    header('Location: index.php');
    exit;
}

if (!isset($_GET['status']) || empty(trim($_GET['status']))) {

    header('Location: passwd_forgotten.php?status=customer');
    exit;
}

if ($_GET['status'] == "customer") {

    $connect_status = 1;
} elseif ($_GET['status'] == "associate") {

    $connect_status = 0;
} else {

    header('Location: passwd_forgotten.php?status=customer');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Mot de passe oublié</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

    <?php require_once("include/header.php"); ?>

    <main>

        <section class="container">
            <br>
            <br>
            <br>
            <h1 style="text-align: center;">Mot de passe oublié</h1>
            <br>
            <br>
                <div class="form-group">
                    <label>Veuillez saisir l'adresse mail de votre compte <?php if ($connect_status == 1) echo "client";
                                                                            else echo "prestataire"; ?> :</label>
                    <input onchange="check_mail_connection(<?php echo $connect_status; ?>)" type="email" name="mail" class="form-control" placeholder="Entez votre email" autocomplete="email" maxlength="255" required>
                    <small style="color:red;display:none;" id="emailHelp" class="form-text text-muted">Cette adresse mail n'existe pas !</small>
                </div>
                <button style="margin:auto;display:block;" onclick="resend(<?php echo $connect_status; ?>)" id="regis_button" type="submit" class="btn btn-primary">Confirmer</button>
        </section>

    </main>

    <?php require_once("include/footer.php"); ?>
    <script src="js/ajax_mail.js"></script>
    <script src="js/ajax_passwd.js"></script>

</body>

</html>