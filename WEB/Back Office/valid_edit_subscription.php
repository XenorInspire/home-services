<?php

require_once('include/config.php');
require_once('class/DBManager.php');

if (
    isset($_POST['id']) && !empty($_POST['id']) &&
    isset($_POST['typeName']) && !empty($_POST['typeName'])
    && is_numeric($_POST['openDays']) && !empty($_POST['openDays'])
    && !empty(trim($_POST['openTime']))
    && !empty($_POST['closeTime'])
    && is_numeric($_POST['serviceTimeAmount']) && !empty($_POST['serviceTimeAmount'])
    && is_numeric($_POST['price']) && !empty($_POST['price'])
) {

    // all verif with if

    $hm_database = new DBManager($bdd);

    $subscription = new SubscriptionType($_POST['id'], $_POST['typeName'], $_POST['openDays'], $_POST['openTime'], $_POST['closeTime'], $_POST['serviceTimeAmount'], $_POST['price']);

    $hm_database->updateSubscriptionType($subscription);

    header('Location: subscriptions.php?edit=successful');
    exit;
} else {

    header('Location: subscriptions.php?error=inputs_inv');
    exit;
}
