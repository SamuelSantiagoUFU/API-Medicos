<?php
if (!Classes\Validate::validatePOST($_POST)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
$medic = filter_var($_POST['medic'], FILTER_VALIDATE_INT);
$pacient = filter_var($_POST['pacient'], FILTER_VALIDATE_INT);
$date = filter_var($_POST['date'], FILTER_SANITIZE_SPECIAL_CHARS);
$value = filter_var($_POST['value'], FILTER_VALIDATE_FLOAT);

$consult = new Classes\Consult;
$consult->medic = (new Classes\Medic)->get($medic);
$consult->pacient = (new Classes\Pacient)->get($pacient)['result'];
$consult->date = new DateTime($date);
$consult->value = $value;
$consult->return = (new Classes\Consult)->get($return ?? -1);
if (!$consult->return['code']) {
  $consult->return = null;
}
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
