<?php
if (!Classes\Validate::validateGET($_GET)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
session_start();
$key = $_GET['key'];
die(Classes\Base\Parse::toJson(['code' => 200, 'return' => $_SESSION[$key]]));
?>
