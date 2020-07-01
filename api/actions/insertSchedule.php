<?php
if (!Classes\Validate::validatePOST($_POST)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
$medic = filter_var($_POST['medic'], FILTER_VALIDATE_INT);
$dataInit = filter_var($_POST['init'], FILTER_SANITIZE_SPECIAL_CHARS);
$duration = filter_var($_POST['duration'], FILTER_SANITIZE_SPECIAL_CHARS);
$weekday = filter_var($_POST['weekday'], FILTER_VALIDATE_INT);

$dataInit = new DateTime($dataInit);
$duration = new DateTime($duration);

$schedule = new Classes\Schedule;
$schedule->medic = (new Classes\Medic)->get($medic);
$schedule->weekday = $weekday;
$schedule->hourInit = $dataInit->format('H:i:s');
$schedule->duration = $duration->format('H:i:s');
echo Classes\Base\Parse::toJson($schedule->insert());
?>
