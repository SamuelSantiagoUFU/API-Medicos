<?php
$exam = new Classes\Exam;
$exam->get(4);
$deleted = $exam->delete();
echo Classes\Base\Parse::toJson($deleted);
?>
