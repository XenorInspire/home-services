<?php session_start();

if (empty(trim($_GET['a'])) || !isset($_GET['a'])) {

    header('Location: index.php');
    exit;
}

if (isset($_SESSION['customer']) || !empty($_SESSION['customer'])) {

    $id = $_SESSION['customer'];
} else if (isset($_COOKIE['customer']) || !empty($_COOKIE['customer'])) {

    $id = $_COOKIE['customer'];
}

if (isset($id)) {

    if ($id != $_GET['a']) {

        header('Location: index.php');
        exit;
    }
} else {

    $id = $_GET['a'];
}

require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

if ($hm_database->doesAccountIsActivated($id) == 1) {

    header('Location: index.php');
    exit;
}

if (isset($_SESSION['enable']) && !empty($_SESSION['enable'])) {

    $enable = $_SESSION['enable'];
} else if (isset($_COOKIE['enable']) && !empty($_SESSION['enable'])) {

    $enable = $_COOKIE['enable'];
} else {

    header('Location: index.php');
    exit;
}

$user = $hm_database->getUserById($id);
if ($user == NULL) {

    header('Location: index.php');
    exit;
}

if (hash('sha256', $user->getMail()) != $enable) {

    header('Location: index.php');
    exit;
}

$hm_database->enableCustomerAccount($id);
$_SESSION['enable'] = '';
setcookie('enable', NULL, time(), null, null, false, true);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Home Services - Inscription validée !</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body onload="activate()">

    <?php require_once("include/header.php"); ?>

    <main>
        <br>
        <br>
        <br>
        <br>
        <br>
        <section class="container text-center"">
            <h1><i>Votre compte client est maintenant activé !</i></h1>
            <br>
            <li>Vous allez être redirigé automatiquement vers l'accueil</li>
            <br>
            <div class=" spinner-border" role="status">
            <span class="sr-only">Loading...</span>
            </div>
            <br>
            <br>
            <li>Cliquez sur le bouton si vous n'êtes pas redirigé automatiquement</li>
            <br>
            <button type=" button" onclick="window.location.href = 'index.php';" class="btn btn-dark">Accueil</button>
        </section>
    </main>
    <script src="js/redirect.js"></script>
    <?php require_once("include/footer.php"); ?>

</body>

</html>