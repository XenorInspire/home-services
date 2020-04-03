<?php
require_once('class/DBManager.php');

isset($_GET['serviceTypeId']);
$serviceTypeId = $_GET['serviceTypeId'];
$hm_database = new DBManager($bdd);
$services = $hm_database->getServiceListByType($serviceTypeId);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Services</title>
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
                <?php
                if (isset($_GET['delete']) == "successful") {
                    echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">Le service a bien été supprimé.</div>';
                }

                if (isset($_GET['create']) == "successful") {
                    echo '<div class="alert alert-success alert-dismissible " class="close" data-dismiss="alert" role="alert">Le service a bien été créé.</div>';
                }

                if (isset($_GET['edit']) == "successful") {
                    echo '<div class="alert alert-success alert-dismissible" class="close" data-dismiss="alert" role="alert">Le service a bien été modifié.</div>';
                }

                ?>
                <a href="create_service.php?serviceTypeId=<?= $serviceTypeId ?>"><button type="button" class="btn btn-dark">Créer un service</button></a>
                <br>
                <div class="display-4">Les services disponibles</div>
                <hr>
                <?php
                foreach ($services as $serv) { ?>
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <h2><a title="Modifier" class="btn btn-block btn-outline-secondary" href="edit_service.php?id=<?= $serv->getServiceId() ?>"><?= $serv->getServiceTitle() ?></a></h2>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
            </div>
        </div>

    </main>

    <?php require_once("include/footer.php"); ?>

</body>

<script type="text/javascript">
    $(document).ready(function() {
        $(".custom-select").change(function() {
            var id = $(this).val();
            var dataString = 'serviceTypeId=' + id;
            $.ajax({
                type: "POST",
                url: "get_services.php",
                data: dataString,
                cache: false,
                success: function(html) {
                    $(".services").html(html);
                }
            });
        });
    });
</script>

</html>