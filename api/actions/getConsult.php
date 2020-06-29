<?php
$consult = new Classes\Consult;
$consult = $consult->get($_GET['id'], true);
echo Classes\Base\Parse::toJson($consult);
?>
