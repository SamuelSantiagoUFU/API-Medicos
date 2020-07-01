<?php
if (!Classes\Validate::validatePOST($_POST)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
$description = filter_var($_POST['desc'], FILTER_SANITIZE_SPECIAL_CHARS);
$consult = filter_var($_POST['consult'], FILTER_VALIDATE_INT);
$qtd = filter_var($_POST['qtd'], FILTER_VALIDATE_INT);
$type = filter_var($_POST['type'], FILTER_SANITIZE_SPECIAL_CHARS);

$exam = new Classes\Exam;
$exam->description = $description;
$exam->consult = (new Classes\Consult)->get($consult);
$exam->qtd = $qtd;
$exam->type = $type;
echo Classes\Base\Parse::toJson($exam->insert());
?>
