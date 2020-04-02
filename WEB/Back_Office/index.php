<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Accueil</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php require_once('include/config.php'); ?>
    <?php require_once('include/lang.php'); ?>
    <?php require_once("include/header.php"); ?>

    <main>
        <br>
        <div class="container-fluid">
            <div class="jumbotron text-center">
                <div class="display-4"><?= $index['description'] ?></div>
            </div>
        </div>
    </main>

    <?php require_once("include/footer.php"); ?>

</body>

</html>