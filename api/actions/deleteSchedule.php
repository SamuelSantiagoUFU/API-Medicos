<?php
$schedule = new Classes\Schedule;
$schedule = $schedule->get(15);
if (!$schedule['code'])
  die(Classes\Base\Parse::toJson($schedule));
$schedule = $schedule['result'];
$deleted = $schedule->delete();
echo Classes\Base\Parse::toJson($deleted);
?>
