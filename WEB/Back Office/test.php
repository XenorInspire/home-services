<?php

require_once('include/config.php');
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
$subscription = new SubscriptionType("dsadsa",, $_POST['phone_number'], $_POST['address'], $_POST['city'], $_POST['passwd']);

