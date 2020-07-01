<?php
if (!Classes\Validate::validateGET($_GET)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
$spec = filter_var($_GET['spec'], FILTER_SANITIZE_SPECIAL_CHARS);
$medic = new Classes\Medic;
$json = $medic->listSpec($spec);
echo Classes\Base\Parse::toJson($json);
?>
