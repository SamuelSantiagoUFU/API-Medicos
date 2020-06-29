<?php
$pacient = new Classes\Pacient;
echo Classes\Base\Parse::toJson($pacient->get($_GET['id']));
?>
