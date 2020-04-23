<?php require_once('include/check_identity.php');
    if (!($status == 'customer' && $connected == 1)) {

        header('Location: connect.php?status=customer&error=forb');
        exit;
    }
?>
<!DOCTYPE html>

<?php require_once('include/check_identity.php');
      require_once('include/lang.php');
?>

<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Services - <?= $calendar['services'] ?></title>
    <link rel="icon" sizes="32x32" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body>

    <?php require_once("include/header.php"); ?>

    <main>
      <div id="calendar" class="calendar"></div>

      <table class="table table-bordered table-responsive-lg table-hover">
          <thead class="thead-dark">
              <tr>
                  <th><?= $calendar['address'] ?></th>
                  <th><?= $calendar['hour'] ?></th>
                  <th><?= $calendar['service'] ?></th>
              </tr>
          </thead>
          <br>
          <br>
          <tbody id="myTable">

          </tbody>
      </table>

    </main>

    <?php require_once("include/footer.php"); ?>
</body>


<script type="text/javascript" src="js/calendar.js"> </script>
<script>
  allocate(<?php echo $id ?>);
</script>

</html>
