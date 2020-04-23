<?php

if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location : connect.php?status=associate");
    exit;
}
$associateId = $_GET['id'];

// Connexion à la base de données
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

$associate = $hm_database->getAssociateById($associateId);

if($associate == NULL){
    header("Location: connect.php?status=associate&error=qrcode_inv");
    exit;
}

if ($hm_database->doesAssociateAccountIsActivated($associateId) == 0) {
    header('Location: connect.php?status=associate&error=acc_dis');
    exit;
}

session_start();
$_SESSION['associate'] = $associateId;
setcookie('associate', $associateId, time() + 48 * 3600, null, null, false, true);

header('Location: index.php');
exit;
