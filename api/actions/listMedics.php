<?php
if (Classes\Validate::validateGET($_GET)) {
  $value = filter_var($_GET['value'], FILTER_SANITIZE_SPECIAL_CHARS);
}
$medic = new Classes\Medic;
if (isset($value)) {
  $json = $medic->list($value);
} else {
  $json = $medic->list();
}
echo Classes\Base\Parse::toJson($json);
?>
