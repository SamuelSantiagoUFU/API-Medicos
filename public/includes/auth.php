<?
$ch = curl_init('http://api.jefersson.net.br/verify');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIE, 'id='.($_COOKIE['id'] ?? 0));
$level = json_decode(curl_exec($ch));
if ($level->code == 200) {
  $logged = $level->permission->level >= 0;
  $medic = $level->permission->level == 1;
  $admin = $level->permission->level == 2;
} else {
  $logged = $admin = false;
}
?>
