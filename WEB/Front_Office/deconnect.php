<?php

session_start();
$_SESSION[] = '';

if(isset($_COOKIE['customer']))
    setcookie('customer',NULL,time(),null,null,false,true);

if (isset($_COOKIE['associate']))
    setcookie('associate', NULL, time(), null, null, false, true);
    
session_destroy();
header('Location: index.php');
exit;
