<?php

require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);

$hm_database->restoreRemainingHours();
