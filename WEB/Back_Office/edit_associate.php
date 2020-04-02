<?php
isset($_GET['associateId']);
require_once('class/DBManager.php');

$associateId = $_GET['associateId'];
$hm_database = new DBManager($bdd);
$associate = $hm_database->getAssociate($associateId);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Accueil</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body onload="">
    <?php require_once("include/header.php"); ?>

    <main>
        <br>
        <div class="container-fluid">
            <div class="jumbotron text-center">
                <div class="display-4">Prestataire</div>
                <div class="display-4"><?= $associate->getLastName() ?> <?= $associate->getFirstName() ?></div>
                <br>
                <a href="associate_services.php?associateId=<?= $_GET['associateId'] ?>">
                    <div class="btn btn-secondary">Voir ses services</div>
                </a>
                <hr>
                <div id="button" class="btn btn-secondary" onclick="generateQrcode(); setTimeout(link, 1000);">Regénérer son QRcode</div>
                <input id="text" type="hidden" value="cc">
                <div class="container text-center">
                    <a id="qrcode" class="text-center"></a>
                </div>

                <hr>
                <div class="display-4">Modifer les infos</div>
                <hr>
                <div class="display-4">Renvoyer le mdp</div>
                <hr>
            </div>
        </div>
    </main>

    <?php require_once("include/footer.php"); ?>

</body>

<!-- <script type="text/javascript" src="lib/jquery.min.js"></script> -->
<script type="text/javascript" src="lib/qrcode.js"></script>
<script type="text/javascript">
    function generateQrcode() {
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 150,
            height: 150
        });

        function makeCode() {
            var elText = document.getElementById("text");

            if (!elText.value) {
                alert("Input a text");
                elText.focus();
                return;
            }

            qrcode.makeCode(elText.value);
        }

        makeCode();
        document.getElementById("button").removeAttribute("onclick");
    }

    function link() {
        link = document.getElementById("QRcode").src;
        console.log(link);
        document.getElementById("qrcode").setAttribute("href", link);
        document.getElementById("qrcode").setAttribute("download", "QRcode");
    }
</script>

</html>