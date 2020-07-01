<?php
$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
$description = filter_var($_POST['desc'], FILTER_SANITIZE_SPECIAL_CHARS);
$consult = filter_var($_POST['consult'], FILTER_VALIDATE_INT);
$qtd = filter_var($_POST['qtd'], FILTER_VALIDATE_INT);
$type = filter_var($_POST['type'], FILTER_SANITIZE_SPECIAL_CHARS);

$exam = new Classes\Exam;
$exam->get($id);
$exam->description = $description;
$exam->consult = (new Classes\Consult)->get($consult);
$exam->qtd = $qtd;
$exam->type = $type;
$updated = $exam->update([TB_EXAMS['id']], [$id]);
echo Classes\Base\Parse::toJson($updated);
?>
