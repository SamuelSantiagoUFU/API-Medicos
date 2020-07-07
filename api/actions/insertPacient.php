<?php
if (!Classes\Validate::validatePOST($_POST)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
$newPerson = new Classes\Pacient;
require_once 'definePerson.php';
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
$newPerson->pass = $pass;
echo Classes\Base\Parse::toJson($newPerson->insert());
?>
