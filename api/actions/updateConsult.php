<?php
$consult = new Classes\Consult;
$consult->get(1, true);
$consult->value = 15.00;
$updated = $consult->update([TB_CONSULTS['id']], [1]);
echo Classes\Base\Parse::toJson($updated);
?>
