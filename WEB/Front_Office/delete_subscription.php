<?php

require_once('include/check_identity.php');
if (!($status == 'customer' && $connected == 1)) {

    header('Location: connect.php?status=customer&error=forb');
    exit;
}
$hm_database = new DBManager($bdd);
$hm_database->deleteSubscription($id);

header('Location: orders.php?info=sub_del');
exit;