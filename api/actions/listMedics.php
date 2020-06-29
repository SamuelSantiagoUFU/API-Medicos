<?php
$medic = new Classes\Medic;
if (isset($_GET['value'])) {
  $json = $medic->list($_GET['value']);
} else {
  $json = $medic->list();
}
echo Classes\Base\Parse::toJson($json);
?>
