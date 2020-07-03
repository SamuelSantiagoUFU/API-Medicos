<?php
session_start();
if (!Classes\Validate::validatePOST($_POST)) die(Classes\Base\Parse::toJson(['code'=>0,'logado'=>false, 'msg'=>MSG['not_valid']]));
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$pass = $_POST['pass'];

// Verifica se é paciente
$person = new Classes\Pacient();
$person->login($email);
if (!$person->id) {
  $person = new Classes\Medic();
  $person->login($email);
  if (!$person->id) {
    die(Classes\Base\Parse::toJson(['code'=>200, 'logado'=>false, 'msg'=>MSG['login_fail']]));
  }
}
if (!password_verify($pass, $person->pass)) {
  die(Classes\Base\Parse::toJson(['code'=>200, 'logado'=>false, 'msg'=>MSG['user_not_match']]));
}
foreach ($person as $key => $value) {
  if ($key == 'pass') continue;
  $_SESSION[$key] = $value;
}
die(Classes\Base\Parse::toJson(['code'=>200, 'logado'=>true, 'msg'=>MSG['login_success'], 'user'=>['_sessionId' => session_id()]]));
?>
