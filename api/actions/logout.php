<?php
session_start();
if (!Classes\Validate::validatePOST($_POST)) die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
$session = $_POST['_sessionId'];

$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

if (session_destroy())
  die(Classes\Base\Parse::toJson(['code'=>200, 'logado'=>false, 'msg'=>MSG['logout_success']]));
?>
