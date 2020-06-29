<?php
$medic = new Classes\Medic;
$json = $medic->listSpec($_GET['spec']);
echo Classes\Base\Parse::toJson($json);
?>
