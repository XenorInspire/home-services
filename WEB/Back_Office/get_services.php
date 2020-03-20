<?php
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);

if (isset($_POST['serviceTypeId'])) {
    $id = $_POST['serviceTypeId'];
    $hm_database->getServiceListByType($id);

    $services = $hm_database->getServiceListByType($id);
    foreach ($services as $serv) { ?>
        <label class="btn btn-outline-secondary btn-block">
            <input type="radio" name="serviceId" id="option1" autocomplete="off" value="<?= $serv->getServiceId() ?>" required> <?= $serv->getServiceTitle() ?> : <?= $serv->getDescription() ?>
        </label>
    <?php } ?>
<?php } ?>