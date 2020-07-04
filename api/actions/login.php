<?php
//if (!Classes\Validate::validatePOST($_POST)) die(Classes\Base\Parse::toJson(['code'=>0,'logado'=>false, 'msg'=>MSG['not_valid']]));
$email = filter_var('samuel@email.com', FILTER_VALIDATE_EMAIL);
$pass = '123456789';

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
if (!$person->isActive) {
  die(Classes\Base\Parse::toJson(['code'=>200, 'logado'=>false, 'msg'=>MSG['user_block']]));
}
if (!password_verify($pass, $person->pass)) {
  die(Classes\Base\Parse::toJson(['code'=>200, 'logado'=>false, 'msg'=>MSG['user_not_match']]));
}
$valid = time() + MISC['valid_session'];
foreach ($person as $key => $value) {
  if ($key == 'pass') continue;
  setcookie($key, $value, $valid, '/', MISC['host_url'], false, true);
}
setcookie("login", true, $valid, '/', MISC['host_url'], false, true);
die(Classes\Base\Parse::toJson(['code'=>200, 'logado'=>true, 'msg'=>MSG['login_success'], 'user'=>$valid]));
?>
