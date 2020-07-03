<?php
if (!Classes\Validate::validateGET($_GET)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
$medic = filter_var($_GET['medic'], FILTER_VALIDATE_INT);
$schedule = new Classes\Schedule;
$json = $schedule->list($medic, false);
echo Classes\Base\Parse::toJson($json);
?>
