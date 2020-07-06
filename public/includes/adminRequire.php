<?
require_once '../includes/auth.php';
if (!$admin) {
  header("Location: /403.php");
  die();
}
require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>
