<?php
$id = 3;
$pacient = new Classes\Pacient;
echo Classes\Base\Parse::toJson($pacient->unblock($id));
?>
