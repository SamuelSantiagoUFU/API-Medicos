<?php
if (!Classes\Validate::validatePOST($_POST)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
$newPerson = new Classes\Pacient;
$newPerson = $newPerson->get($id);
if (!$newPerson['code']) {
  die(Classes\Base\Parse::toJson($newPerson));
}
$newPerson = $newPerson['result'];
require_once 'definePerson.php';
echo Classes\Base\Parse::toJson($newPerson->update([TB_PACIENTS['id']], [$id]));
?>
