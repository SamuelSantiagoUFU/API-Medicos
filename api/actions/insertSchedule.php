<?php
$dataInit = new DateTime("06:00:00");
$duration = new DateTime("08:00:00");

$schedule = new Classes\Schedule;
$schedule->medic = (new Classes\Medic)->get(3);
$schedule->weekday = 0;
$schedule->hourInit = $dataInit->format("HH:MM:ii");
$schedule->duration = $duration->format("HH:MM:ii");
echo Classes\Base\Parse::toJson($schedule->insert());
?>