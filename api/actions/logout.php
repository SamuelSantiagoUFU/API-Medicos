<?php

foreach ($_COOKIE as $key => $value) {
  setcookie($key, $value, time() - 1, '/', MISC['host_url'], false, true);
}
die(Classes\Base\Parse::toJson(['code'=>200, 'logado'=>false, 'msg'=>MSG['logout_success']]));
?>
