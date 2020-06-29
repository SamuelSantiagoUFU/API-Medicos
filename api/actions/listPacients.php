<?php
$pacient = new Classes\Pacient;
if (isset($_GET['value'])) {
  $json = $pacient->list($_GET['value']);
} else {
  $json = $pacient->list();
}
echo Classes\Base\Parse::toJson($json);
?>
