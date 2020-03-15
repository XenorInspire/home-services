<?php
    session_start();
    require_once('class/DBManager.php');

    $hm_database = new DBManager($bdd);
	// $user = new Customer('nicolas', 'fouchard', 'ninini@nonon.com', '0202020', '5 allée des lilas', 'sucy', 'nfkhnfhnkfnhkfnkh');
    // echo $user->getId();
    // echo $hm_database->doesMailExist($user);

    // $mail = 'nicolas.fouchard94370@gmail.com';
    // $q = "dsfsdfsdfsdfdsf";
    //$q = "85fd93fa9f02a6b471ec6b8bbdea08413fb8ff3692d0ce8504407644f454d13d";
    // $user = new Customer();
    // $user = $hm_database->getUserById($q);

    $user = $hm_database->getUserById($_SESSION['customer']);
    if($user == NULL)
        echo "1";
    else
        echo "2";


    // system('python.exe mail/mail.py ' . $mail . ' '. $q);
    // echo 'ok';
