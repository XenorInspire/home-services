<?php

if (!isset($_POST['mail']) || empty(trim($_POST['mail']))) {

    header('Location: connect.php?status=associate&error=mail_nv');
    exit;
}

if (!isset($_POST['passwd']) || empty(trim($_POST['passwd']))) {

    header('Location: connect.php?status=associate&error=passwd_nv');
    exit;
}

if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {

    header('Location: connect.php?status=associate&error=mail_nv');
    exit;
}

$mail = htmlspecialchars($_POST['mail']);
$password = hash('sha512', 'ChrysaleadProject' . $_POST['passwd']);

// Connexion à la base de données
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

if (($associate = $hm_database->getAssociateByMail($mail)) == NULL) {

    header('Location: connect.php?status=associate&error=passwd_nv');
    exit;
}

if ($associate->getPassword() != $password) {

    header('Location: connect.php?status=associate&error=passwd_nv');
    exit;
}

if ($hm_database->doesAssociateAccountIsActivated($associate->getAssociateId()) == 0) {

    header('Location: connect.php?status=associate&error=acc_dis');
    exit;
}

session_start();
$_SESSION['associate'] = $associate->getAssociateId();
setcookie('associate', $associate->getAssociateId(), time() + 48 * 3600, null, null, false, true);

header('Location: index.php');
exit;