<?php

$mail = htmlspecialchars($_POST['email']);
$password = $_POST['password'];
$password .= "ChrysaleadProject";
$password = hash('sha512', $password);

if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {

    header('Location: connect_customer.php?error=email_inv');
    exit;
}

// Connexion à la base de données
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);

if ($hm_database->doesMailExist($_POST['mail']) != 0) {

    header('Location: connect_customer.php?error=mail_taken');
    exit;
}

