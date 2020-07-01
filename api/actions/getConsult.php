<?php
if (!Classes\Validate::validateGET($_GET)) {
  var_dump($_GET);
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
$consult = new Classes\Consult;
$consult = $consult->get($id, true);
echo Classes\Base\Parse::toJson($consult);
?>
