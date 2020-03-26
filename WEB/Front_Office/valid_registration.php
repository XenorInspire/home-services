<?php

// Page ayant pour but de vérifier la validité et l'intégrité des inputs utilisateurs
session_start();

if (empty($_POST['captcha'])) {

	header('Location: registration.php?error=captcha_inv');
	exit;
}

if ($_POST['captcha'] != $_SESSION['captcha']) {

	header('Location: registration.php?error=captcha_inv');
	exit;
}

// Connexion à la base de données
require_once('class/DBManager.php');

if (
	isset($_POST['lastname']) && !empty(trim($_POST['lastname'])) && isset($_POST['firstname']) && !empty(trim($_POST['firstname'])) && isset($_POST['address']) && !empty(trim($_POST['address'])) && isset($_POST['phone_number']) && !empty(trim($_POST['phone_number'])) &&
	isset($_POST['mail']) && !empty(trim($_POST['mail'])) && isset($_POST['passwd']) && !empty(trim($_POST['passwd'])) && isset($_POST['passwd_confirmed']) &&
	!empty(trim($_POST['passwd_confirmed'])) && isset($_POST['city']) && !empty(trim($_POST['city']))
) {

	if ($_POST['passwd'] != $_POST['passwd_confirmed']) {

		header('Location: registration.php?error=password_inv');
		exit;
	}

	if (strlen($_POST['passwd']) < 6) {

		header('Location: registration.php?error=password_length');
		exit;
	}

	if (is_numeric($_POST['lastname']) || is_numeric($_POST['firstname']) || is_numeric($_POST['city'])) {

		header('Location: registration.php?error=inputs_inv');
		exit;
	}

	if (strlen($_POST['lastname']) > 255) {

		header('Location: registration.php?error=lname_length');
		exit;
	}

	if (strlen($_POST['firstname']) > 255) {

		header('Location: registration.php?error=fname_length');
		exit;
	}

	if (strlen($_POST['city']) > 255) {

		header('Location: registration.php?error=city_length');
		exit;
	}

	if (strlen($_POST['address']) > 255) {

		header('Location: registration.php?error=ad_length');
		exit;
	}

	if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {

		header('Location: registration.php?inscription=email_inv');
		exit;
	}

	if (strlen($_POST['mail']) > 255) {

		header('Location: registration.php?error=mail_length');
		exit;
	}

	$hm_database = new DBManager($bdd);
	if ($hm_database->doesMailExist($_POST['mail']) != 0) {

		header('Location: registration.php?error=mail_taken');
		exit;
	}
	$user = new Customer(NULL,$_POST['firstname'], $_POST['lastname'], $_POST['mail'], $_POST['phone_number'], $_POST['address'], $_POST['city'], NULL);
	$user->setId();
	$user->setPassword($_POST['passwd']);
	$hm_database->addCustomer($user);

	$_SESSION['customer'] = $user->getId();
	setcookie('customer', $user->getId(), time() + 48 * 3600, null, null, false, true);
	//durée de 48 heures

	$_SESSION['enable'] = hash('sha256', $user->getMail());
	setcookie('enable', hash('sha256', $user->getMail()), time() + 2 * 3600, null, null, false, true);

	system('python3 mail/mail.py '. 1 . ' '. $user->getMail() . ' ' . $user->getId());

	header('Location: waiting_register.php');
	exit;

} else {

	header('Location: registration.php?error=inputs_inv');
	exit;
}
