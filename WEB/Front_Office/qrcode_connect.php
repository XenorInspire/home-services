<?php
require_once('include/check_identity.php');
if ($connected == 1) {

    header('Location: connect.php?status=customer&error=forb');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QRCode connect</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <?php require_once("include/header.php"); ?>
    <main>
        <br>
        <div class="container-fluid text-center">
            <div class="jumbotron">
                <div class="display-4">Veuillez scanner votre QRcode</div>

                <div>
                    <span id="cam-has-camera" class="text-muted"></span>
                    <br>
                    <video width="320" height="240" muted playsinline id="qr-video"></video>
                </div>
                <!-- <div>
                    <select id="inversion-mode-select">
                        <option value="original">Scan original (dark QR code on bright background)</option>
                        <option value="invert">Scan with inverted colors (bright QR code on dark background)</option>
                        <option value="both">Scan both</option>
                    </select>
                    <br>
                </div>
                <b>Detected QR code: </b>
                <div id="cam-qr-result">None</div> -->
            </div>
        </div>
    </main>

    <?php require_once("include/footer.php"); ?>
    
</body>
<script type="module" type="text/javascript">
    import QrScanner from "./js/qr-scanner.min.js";
    QrScanner.WORKER_PATH = './js/qr-scanner-worker.min.js';

    const video = document.getElementById('qr-video');
    const camHasCamera = document.getElementById('cam-has-camera');
    const camQrResult = document.getElementById('cam-qr-result');
    const fileSelector = document.getElementById('file-selector');
    const fileQrResult = document.getElementById('file-qr-result');

    function setResult(label, result) {
        label.textContent = result;
        label.style.color = 'teal';
        clearTimeout(label.highlightTimeout);
        label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
    }

    // ####### Web Cam Scanning #######

    QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = "Caméra détectée");

    const scanner = new QrScanner(video, result => window.location.replace("valid_qrcode_connect.php?id="+result));
    scanner.start();

    document.getElementById('inversion-mode-select').addEventListener('change', event => {
        scanner.setInversionMode(event.target.value);
    });

</script>

</html>