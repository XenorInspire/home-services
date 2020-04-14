<?php

if (!isset($_GET['i']) || empty(trim($_GET['i']))) {

    header('Location: index.php');
    exit;
}

if (!isset($_GET['p']) || empty(trim($_GET['p']))) {

    header('Location: index.php');
    exit;
}

// Connexion à la base de données
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

if (($associate = $hm_database->getAssociateById($_GET['i'])) == NULL) {

    header('Location: index.php');
    exit;
}

if ($associate->getPassword() != $_GET['p']) {

    header('Location: index.php');
    exit;
}

$hm_database->enableAssociateAccount($_GET['i']);
header('Location: connect.php?status=associate&info=first_connect');
exit;