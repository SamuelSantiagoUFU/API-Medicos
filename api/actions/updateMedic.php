<?php
if (!Classes\Validate::validatePOST($_POST)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
$newPerson = new Classes\Medic;
$newPerson->get($id);
require_once 'definePerson.php';
$title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
$type = filter_var($_POST['type'], FILTER_SANITIZE_SPECIAL_CHARS);
$uf = filter_var($_POST['type'], FILTER_SANITIZE_SPECIAL_CHARS);
$clinic = filter_var($_POST['clinic'], FILTER_SANITIZE_SPECIAL_CHARS);
$register = filter_var($_POST['register'], FILTER_SANITIZE_SPECIAL_CHARS);
$cns = filter_var($_POST['cns'], FILTER_SANITIZE_SPECIAL_CHARS);

$newPerson->title = $title;
$newPerson->type = $type;
$newPerson->uf = $uf;
$newPerson->register = $register;
$newPerson->clinic = $clinic;
$newPerson->cns = $cns;
echo Classes\Base\Parse::toJson($medic->update([TB_MEDICS['id']], [$id]));
?>
