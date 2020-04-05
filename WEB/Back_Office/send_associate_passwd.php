<?php

function random()
{
    $string = '';
    for ($i = 0; $i < 10; $i++) {

        $type = rand(0, 100) % 3;

        if ($type == 0)
            $nb = rand(48, 57);
        elseif ($type == 1)
            $nb = rand(65, 90);
        else
            $nb = rand(97, 122);

        $string .= chr($nb);
    }
    return $string;
}

// Connexion à la base de données
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

$associate = $hm_database->getAssociate($_POST['associateId']);

$password = random();
$secure_password = hash('sha512', 'ChrysaleadProject' . $password);
$hm_database->setNewPasswdAssociate($secure_password, $associate->getAssociateId());
system('python3 mail/mail.py ' . 'first_connect' . ' ' . $associate->getEmail() . ' ' . $password . ' ' . $associate->getAssociateId() . ' ' . $secure_password);

http_response_code(200);
echo http_response_code();
return;
