<?php
if (!Classes\Validate::validatePOST($_POST)) die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);


?>
