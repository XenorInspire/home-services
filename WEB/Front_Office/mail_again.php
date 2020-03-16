<?php

session_start();

if (isset($_SESSION['customer']) || !empty($_SESSION['customer'])) {

    $id = $_SESSION['customer'];
} else if (isset($_COOKIE['customer']) || !empty($_COOKIE['customer'])) {

    $id = $_COOKIE['customer'];
} else {

    header('Location: index.php');
    exit;
}

if (isset($_SESSION['enable']) && !empty($_SESSION['enable'])) {

    $enable = $_SESSION['enable'];
} else if (isset($_COOKIE['enable']) && !empty($_SESSION['enable'])) {

    $enable = $_COOKIE['enable'];
} else {

    header('Location: index.php');
    exit;
}

require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

$user = $hm_database->getUserById($id);
if (empty($user)) {

    header('Location: index.php');
    exit;
}

if (hash('sha256', $user['email']) != $enable) {

    header('Location: index.php');
    exit;
}

system('python3 mail/mail.py ' . $user['email'] . ' ' . $id);

header('Location: waiting_register.php');
exit;
