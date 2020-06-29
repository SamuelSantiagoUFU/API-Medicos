<?php
$schedule = new Classes\Schedule;
$json = $schedule->list($_GET['medic']);
echo Classes\Base\Parse::toJson($json);
?>
