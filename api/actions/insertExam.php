<?php
$exam = new Classes\Exam;
$exam->description = $_POST['desc'];
$exam->consult = (new Classes\Consult)->get($_POST['consult']);
$exam->qtd = $_POST['qtd'];
$exam->type = $_POST['type'];
echo Classes\Base\Parse::toJson($exam->insert());
?>
