<?php
$id = 2;
$pacient = new Classes\Pacient;
$pacient = $pacient->get($id);
if (!$pacient['code']) {
  die(Classes\Base\Parse::toJson($pacient));
}
$pacient = $pacient['result'];
$pacient->name = "Rafael";
echo Classes\Base\Parse::toJson($pacient->update([TB_PACIENTS['id']], [$id]));
?>
