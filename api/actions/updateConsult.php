<?php
if (!Classes\Validate::validatePOST($_POST)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
$medic = filter_var($_POST['medic'], FILTER_VALIDATE_INT);
$pacient = filter_var($_POST['pacient'], FILTER_VALIDATE_INT);
$date = filter_var($_POST['date'], FILTER_SANITIZE_SPECIAL_CHARS);
$value = filter_var($_POST['value'], FILTER_VALIDATE_FLOAT);

$consult = new Classes\Consult;
$consult->medic = (new Classes\Medic)->get($medic);
$consult->pacient = (new Classes\Pacient)->get($pacient)['result'];
$consult->date = new DateTime($date);
$consult->value = $value;
$consult->return = null;
$updated = $consult->update([TB_CONSULTS['id']], [$id]);
echo Classes\Base\Parse::toJson($updated);
?>
