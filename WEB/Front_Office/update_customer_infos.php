<?php

if (!isset($_GET['mode']) || empty($_GET['mode'])) {

    echo http_response_code(401);
    exit;
}

if (!isset($_POST['cid']) || empty($_POST['cid'])) {

    echo http_response_code(402);
    exit;
}

// Connexion à la base de données
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

$customer = $hm_database->getUserById($_POST['cid']);
if ($customer == NULL) {

    echo http_response_code(403);
    exit;
}

if ($_GET['mode'] == 1) {

    if (!isset($_POST['lastname']) || empty(trim($_POST['lastname']))) {

        echo http_response_code(404);
        exit;
    }

    if (!isset($_POST['firstname']) || empty(trim($_POST['firstname']))) {

        echo http_response_code(405);
        exit;
    }

    if (!isset($_POST['mail']) || empty(trim($_POST['mail']))) {

        echo http_response_code(406);
        exit;
    }

    if (!isset($_POST['phone_number']) || empty(trim($_POST['phone_number']))) {

        echo http_response_code(407);
        exit;
    }

    if (!isset($_POST['address']) || empty(trim($_POST['address']))) {

        echo http_response_code(408);
        exit;
    }

    if (!isset($_POST['city']) || empty(trim($_POST['city']))) {

        echo http_response_code(409);
        exit;
    }

    if (is_numeric($_POST['lastname']) || is_numeric($_POST['firstname']) || is_numeric($_POST['city'])) {

        echo http_response_code(410);
        exit;
    }

    if (strlen($_POST['lastname']) > 255) {

        echo http_response_code(411);
        exit;
    }

    if (strlen($_POST['firstname']) > 255) {

        echo http_response_code(412);
        exit;
    }

    if (strlen($_POST['city']) > 255) {

        echo http_response_code(413);
        exit;
    }

    if (strlen($_POST['address']) > 255) {

        echo http_response_code(414);
        exit;
    }

    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {

        echo http_response_code(415);
        exit;
    }

    if (strlen($_POST['mail']) > 255) {

        echo http_response_code(416);
        exit;
    }

    if ($customer->getMail() != $_POST['mail']) {

        $potential_user = $hm_database->getUserByMail($_POST['mail']);
        if ($potential_user != NULL) {

            echo http_response_code(430);
            exit;
        }
    }

    $q = "UPDATE Customer SET lastName = :lastname , firstName = :firstname , email = :email , phoneNumber = :phone_number , address = :address , town = :city WHERE customerId = :id";
    $req = $hm_database->getDb()->prepare($q);
    $req->execute(array(
        'lastname' => $_POST['lastname'],
        'firstname' => $_POST['firstname'],
        'email' => $_POST['mail'],
        'phone_number' => $_POST['phone_number'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'id' => $_POST['cid']
    ));

    system('python3 mail/mail.py ' . 3 . ' ' . $_POST['mail']);

    echo http_response_code(200);
    exit;
    
} else if ($_GET['mode'] == 2) {

    if (!isset($_POST['old_password']) || empty(trim($_POST['old_password']))) {

        echo http_response_code(417);
        exit;
    }

    if (!isset($_POST['new_password']) || empty(trim($_POST['new_password']))) {

        echo http_response_code(418);
        exit;
    }

    if (!isset($_POST['new_password2']) || empty(trim($_POST['new_password2']))) {

        echo http_response_code(419);
        exit;
    }

    if ($_POST['new_password'] != $_POST['new_password2']) {

        echo http_response_code(420);
        exit;
    }

    if (strlen($_POST['new_password']) < 6) {

        echo http_response_code(421);
        exit;
    }

    $old_password = hash('sha512', $_POST['old_password'] . 'ChrysaleadProject');

    if ($customer->getPassword() != $old_password) {

        echo http_response_code(422);
        exit;
    }

    $password = hash('sha512', $_POST['new_password'] . 'ChrysaleadProject');

    $q = "UPDATE Customer SET password = :password WHERE customerId = :id";
    $req = $hm_database->getDb()->prepare($q);
    $req->execute(array(
        'password' => $password,
        'id' => $_POST['cid']
    ));

    system('python3 mail/mail.py ' . 4 . ' ' . $customer->getMail());

    echo http_response_code(200);
    exit;

} else {

    echo http_response_code(423);
    exit;
}
