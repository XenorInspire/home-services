<?php

require_once('include/check_identity.php');
if (!($status == 'customer' && $connected == 1)) {

    header('Location: connect.php?status=customer&error=forb');
    exit;
}
$hm_database = new DBManager($bdd);
$hm_database->disableCustomerAccount($id);

header('Location: connect.php?status=customer&info=dis');
exit;