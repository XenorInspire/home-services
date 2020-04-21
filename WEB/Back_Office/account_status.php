<?php

require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

if ($_GET['mode'] == 1) {

    $hm_database->enableCustomerAccount($_GET['id']);
} elseif ($_GET['mode'] == 2) {


    $hm_database->disableCustomerAccount($_GET['id']);
}

header('Location: customers.php');
exit;
