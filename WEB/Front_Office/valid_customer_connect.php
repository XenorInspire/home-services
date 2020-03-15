<?php

$mail = htmlspecialchars($_POST['mail']);
$password = hash('sha512', $_POST['passwd'] . 'ChrysaleadProject');

if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {

    header('Location: connect_customer.php?error=email_inv');
    exit;
}

// Connexion à la base de données
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);

if ($hm_database->doesMailExist($mail) == 0) {

    header('Location: connect_customer.php?error=mail_nexit');
    exit;
}

$user = $hm_database->getUserByMail($mail);

if ($user->getPassword() != $password) {

    header('Location: connect_customer.php?error=password_inv');
    exit;
}

if ($hm_database->doesAccountIsActivated($user->getId()) == 0) {

    header('Location: connect_customer.php?error=acc_dis');
    exit;
}

session_start();
$_SESSION['customer'] = $user->getId();
setcookie('customer', $user->getId(), time() + 48 * 3600, null, null, false, true);

header('Location: index.php');
exit;
