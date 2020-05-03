<?php

if(isset($_GET['id']) && !empty($_GET['id'])){

    $associateBillId = $_GET['id'];
    require_once('class/DBManager.php');
    $hm_database = new DBManager($bdd);
    
    $hm_database->validAssociateBill($associateBillId);

    header('Location: associates_bills.php?info=checked_success');
    exit;
}else{
    header('Location: associates_bills.php');
    exit;
}