<?php
if (Classes\Validate::validateGET($_GET)) {
  $value = filter_var($_GET['value'], FILTER_SANITIZE_SPECIAL_CHARS);
}
$pacient = new Classes\Pacient;
if (isset($value)) {
  $json = $pacient->list($value);
} else {
  $json = $pacient->list();
}
echo Classes\Base\Parse::toJson($json);
?>
