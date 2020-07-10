<?
require_once '../includes/auth.php';
if (!$medic) {
  header("Location: /403.php");
  die();
}
$ch = curl_init($apiLink.'/medic/get/'.$_COOKIE['id']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$medic = json_decode(curl_exec($ch));
require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>
