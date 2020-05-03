<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - Clients</title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

    <?php require_once("include/header.php"); ?>

    <main>
        <br>
        <div class="container-fluid">
            <div id="calendar" class="calendar"></div>

            <table class="table table-bordered table-responsive-lg table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Client</th>
                        <th>Adresse</th>
                        <th>Heure</th>
                        <th>Service</th>
                        <th>Prestataire</th>
                    </tr>
                </thead>
                <tbody id="myTable">

                </tbody>
            </table>
        </div>
    </main>

    <?php require_once("include/footer.php"); ?>
</body>


<script type="text/javascript" src="js/calendar.js"> </script>

</html>