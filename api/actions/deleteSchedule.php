<?php
if (!Classes\Validate::validatePOST($_POST)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
$schedule = new Classes\Schedule;
$schedule = $schedule->get($id);
if (!$schedule['code'])
  die(Classes\Base\Parse::toJson($schedule));
$schedule = $schedule['result'];
$deleted = $schedule->delete();
echo Classes\Base\Parse::toJson($deleted);
?>
