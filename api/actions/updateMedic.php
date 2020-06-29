<?php
$id = 3;
$medic = new Classes\Medic;
$medic->get($id);
$medic->name = "Juliana";
$medic->title = "Dra.";
echo Classes\Base\Parse::toJson($medic->update([TB_MEDICS['id']], [$id]));
?>
