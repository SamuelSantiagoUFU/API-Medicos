<?php
if (!Classes\Validate::validatePOST($_POST)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
$medic = new Classes\Medic;
echo Classes\Base\Parse::toJson($medic->unblock($id));
?>
