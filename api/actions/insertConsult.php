<?php
$consult = new Classes\Consult;
$consult->medic = (new Classes\Medic)->get(1);
$consult->pacient = (new Classes\Pacient)->get(2)['result'];
$consult->date = new DateTime("now");
$consult->value = 15.00;
$inserted = $consult->insert();
$consult->id = $inserted['code'];
$exams = [
  [
    'desc' => 'Exame qualquer que vai ser passado pelo form 1',
    'qtd' => 2,
    'type' => 'F'
  ],
  [
    'desc' => 'Exame qualquer que vai ser passado pelo form 2',
    'qtd' => 1,
    'type' => 'U'
  ]
];
$success = true;
$exams_error = [];
foreach ($exams as $exam) {
  $e = new Classes\Exam;
  $e->description = $exam['desc'];
  $e->consult = $consult;
  $e->qtd = $exam['qtd'];
  $e->type = $exam['type'];
  $result = $e->insert();
  if (!$result || $result['code'] == 0) {
    array_push($exams_error, $exam);
    $success = false;
  }
}
if (!$success) {
  $inserted['msg'] = 'Erro ao adicionar '.count($exams_error).' exames';
  $inserted['exams'] = $exams_error;
}
echo Classes\Base\Parse::toJson($inserted);
?>
