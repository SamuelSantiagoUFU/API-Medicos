<?php
$consult = new Classes\Consult;
$consult->get(4);
$deleted = $consult->delete();
echo Classes\Base\Parse::toJson($deleted);
?>
