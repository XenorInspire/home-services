<?php

session_start();
$_SESSION[] = '';

if(isset($_COOKIE['customer']))
    setcookie('customer',NULL,time(),null,null,false,true);
    
session_destroy();
header('Location: index.php');
exit;
