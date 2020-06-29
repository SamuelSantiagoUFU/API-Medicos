<?php
$dataInit = new DateTime("06:00:00");
$duration = new DateTime("08:00:00");

$schedule = new Classes\Schedule;
$schedule = $schedule->get(2);
if (!$schedule['code'])
  die(Classes\Base\Parse::toJson($schedule));
$schedule = $schedule['result'];
$schedule->duration = $duration->format('H:i:s');
echo Classes\Base\Parse::toJson($schedule->update());
?>
