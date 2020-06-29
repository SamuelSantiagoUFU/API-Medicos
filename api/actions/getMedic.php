<?php
$medic = new Classes\Medic;
echo Classes\Base\Parse::toJson($medic->get($_GET['id'], true));
?>
