<?php

require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

if ($_GET['mode'] == 1) {

    $hm_database->enableCustomerAccount($_GET['id']);
    header('Location: customers.php');
    exit;
} elseif ($_GET['mode'] == 2) {


    $hm_database->disableCustomerAccount($_GET['id']);
    header('Location: customers.php');
    exit;
} elseif ($_GET['mode'] == 3) {

    $hm_database->enableAssociateAccount($_GET['id']);
    header('Location: associates.php');
    exit;
} elseif ($_GET['mode'] == 4) {

    $hm_database->disableAssociateAccount($_GET['id']);
    header('Location: associates.php');
    exit;
}
