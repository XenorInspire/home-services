<?php

session_start();

require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

if (isset($_SESSION['customer']) && !empty($_SESSION['customer'])) {

    $id = $_SESSION['customer'];
    $status = 'customer';
} else if (isset($_COOKIE['customer']) && !empty($_COOKIE['customer'])) {

    $id = $_COOKIE['customer'];
    $status = 'customer';
}

if (isset($_SESSION['associate']) && !empty($_SESSION['associate'])) {

    $id = $_SESSION['associate'];
    $status = 'associate';
} else if (isset($_COOKIE['associate']) && !empty($_COOKIE['associate'])) {

    $id = $_COOKIE['associate'];
    $status = 'associate';
}

if (isset($id)) {

    if($status == 'customer'){

        if (($user = $hm_database->getUserById($id)) != NULL) {

            $connected = 1;
        } else {

            $connected = 0;
        }

    }else{

        //check associate identity

    }

    
} else {

    $connected = 0;
}
