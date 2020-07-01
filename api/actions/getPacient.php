<?php
if (!Classes\Validate::validateGET($_GET)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
$pacient = new Classes\Pacient;
echo Classes\Base\Parse::toJson($pacient->get($id));
?>
