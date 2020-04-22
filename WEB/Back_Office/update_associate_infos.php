<?php

if (!isset($_GET['mode']) || empty($_GET['mode'])) {

    http_response_code(400);
    echo http_response_code();
    return;
}

if (!isset($_POST['aid']) || empty($_POST['aid'])) {

    http_response_code(400);
    echo http_response_code();
    return;
}

// Connexion à la base de données
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

$associate = $hm_database->getAssociate($_POST['aid']);
if ($associate == NULL) {

    http_response_code(400);
    echo http_response_code();
    return;
}

if ($_GET['mode'] == 1) {

    if (!isset($_POST['lastname']) || empty(trim($_POST['lastname']))) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (!isset($_POST['firstname']) || empty(trim($_POST['firstname']))) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (!isset($_POST['mail']) || empty(trim($_POST['mail']))) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (!isset($_POST['phone_number']) || empty(trim($_POST['phone_number']))) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (!isset($_POST['address']) || empty(trim($_POST['address']))) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (!isset($_POST['city']) || empty($_POST['city'])) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (is_numeric($_POST['lastname']) || is_numeric($_POST['firstname']) || is_numeric($_POST['city'])) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (strlen($_POST['lastname']) > 255) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (strlen($_POST['firstname']) > 255) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (strlen($_POST['city']) > 255) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (strlen($_POST['address']) > 255) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (strlen($_POST['mail']) > 255) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if ($associate->getEmail() != $_POST['mail']) {

        $potential_associate = $hm_database->getAssociateByMail($_POST['mail']);
        if ($potential_associate != NULL) {

            http_response_code(400);
            echo http_response_code();
            return;
        }
    }

    $q = "UPDATE Associate SET lastName = :lastname , firstName = :firstname , email = :email , phoneNumber = :phone_number , address = :address , town = :city WHERE associateId = :id";
    $req = $hm_database->getDb()->prepare($q);
    $req->execute(array(
        'lastname' => $_POST['lastname'],
        'firstname' => $_POST['firstname'],
        'email' => $_POST['mail'],
        'phone_number' => $_POST['phone_number'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'id' => $_POST['aid']
    ));

    http_response_code(200);
    echo http_response_code();
    return;
} else if ($_GET['mode'] == 2) {

    if (!isset($_POST['new_password']) || empty(trim($_POST['new_password']))) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (!isset($_POST['new_password2']) || empty(trim($_POST['new_password2']))) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if ($_POST['new_password'] != $_POST['new_password2']) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    if (strlen($_POST['new_password']) < 6) {

        http_response_code(400);
        echo http_response_code();
        return;
    }

    $password = hash('sha512', 'ChrysaleadProject' . $_POST['new_password']);

    $q = "UPDATE Associate SET password = :password WHERE associateId = :id";
    $req = $hm_database->getDb()->prepare($q);
    $req->execute(array(
        'password' => $password,
        'id' => $_POST['aid']
    ));

    http_response_code(200);
    echo http_response_code();
    return;
} else {

    http_response_code(400);
    echo http_response_code();
    return;
}
