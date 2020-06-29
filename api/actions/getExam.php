<?php
$exam = new Classes\Exam;
echo Classes\Base\Parse::toJson($exam->get($_GET['id']));
?>
