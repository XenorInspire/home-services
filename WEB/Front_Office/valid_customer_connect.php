<?php

if (!isset($_POST['mail']) || empty(trim($_POST['mail']))) {

    header('Location: connect.php?status=customer&error=mail_nv');
    exit;
}

if (!isset($_POST['passwd']) || empty(trim($_POST['passwd']))) {

    header('Location: connect.php?status=customer&error=passwd_nv');
    exit;
}

if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {

    header('Location: connect.php?status=customer&error=mail_nv');
    exit;
}

$mail = htmlspecialchars($_POST['mail']);
$password = hash('sha512', $_POST['passwd'] . 'ChrysaleadProject');

// Connexion à la base de données
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);

if ($hm_database->doesMailExist($mail) == 0) {

    header('Location: connect.php?status=customer&error=mail_nexit');
    exit;
}

$user = $hm_database->getUserByMail($mail);

if ($user->getPassword() != $password) {

    header('Location: connect.php?status=customer&error=passwd_nv');
    exit;
}

if ($hm_database->doesAccountIsActivated($user->getId()) == 0) {

    header('Location: connect.php?status=customer&error=acc_dis');
    exit;
}

session_start();
$_SESSION['customer'] = $user->getId();
setcookie('customer', $user->getId(), time() + 48 * 3600, null, null, false, true);

header('Location: index.php');
exit;
