<?php
$id = 3;
$medic = new Classes\Medic;
echo Classes\Base\Parse::toJson($medic->unblock($id));
?>
