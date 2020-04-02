<?php

function random()
{
    $string = '';
    for ($i = 0; $i < 10; $i++) {
        $nb = rand(63, 122);
        $string .= chr(floor($nb));
    }
    return $string;
}

if (!isset($_POST['mail']) || empty(trim($_POST['mail']))) {

    http_response_code(400);
    echo http_response_code();
    return;
}

if (!isset($_GET['st']) || empty(trim($_GET['st']))) {

    http_response_code(400);
    echo http_response_code();
    return;
}

// Connexion à la base de données
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
$mail = htmlspecialchars($_POST['mail']);

if ($_GET['st'] == 'c') {

    if (($customer = $hm_database->getUserByMail($mail)) == NULL) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    $password = htmlspecialchars(random());
    $hm_database->setNewPasswdCustomer(hash('sha512', $password . 'ChrysaleadProject'),$customer->getId());
    system('python3 mail/mail.py ' . 5 . ' ' . $mail . ' ' . $password);

    http_response_code(200);
    echo http_response_code();
    return;

} elseif ($_GET['st'] == 'a') {

    if (($associate = $hm_database->getAssociateByMail($mail)) == NULL) {

        http_response_code(402);
        echo http_response_code();
        return;
    }

    $password = htmlspecialchars(random());
    $hm_database->setNewPasswdAssociate(hash('sha512', 'ChrysaleadProject' . $password), $associate->getAssociateId());
    system('python3 mail/mail.py ' . 5 . ' ' . $mail . ' ' . $password);

    http_response_code(200);
    echo http_response_code();
    return;

} else {

    http_response_code(401);
    echo http_response_code();
    return;
}
