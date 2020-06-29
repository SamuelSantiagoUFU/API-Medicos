<?php
$exam = new Classes\Exam;
$exam->get(8);
$exam->description = "Exame atualizado nesse bagulho da coisa";
$updated = $exam->update([TB_EXAMS['id']], [8]);
echo Classes\Base\Parse::toJson($updated);
?>
