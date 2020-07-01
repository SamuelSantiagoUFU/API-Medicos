<?php
$cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_NUMBER_INT);
$name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
$born = filter_var($_POST['born'], FILTER_SANITIZE_SPECIAL_CHARS);
$sex = filter_var($_POST['sex'], FILTER_SANITIZE_SPECIAL_CHARS);
$phone = filter_var($_POST['phone'], FILTER_SANITIZE_SPECIAL_CHARS);
$cell = filter_var($_POST['cellphone'], FILTER_SANITIZE_SPECIAL_CHARS);
$user = filter_var($_POST['user'], FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
$rg = filter_var($_POST['rg'], FILTER_SANITIZE_SPECIAL_CHARS);
$address = filter_var($_POST['address'], FILTER_SANITIZE_SPECIAL_CHARS);
$lat = $newPerson->getLatLng($address)['lat'];
$lng = $newPerson->getLatLng($address)['lng'];
$number = filter_var($_POST['number'], FILTER_SANITIZE_SPECIAL_CHARS);
$complement = filter_var($_POST['complement'], FILTER_SANITIZE_SPECIAL_CHARS);

$newPerson->cpf = $cpf;
$newPerson->name = $name;
$newPerson->born = $born;
$newPerson->sex = $sex;
$newPerson->phone = $phone;
$newPerson->cellphone = $cell;
$newPerson->user = $user;
$newPerson->email = $email;
$newPerson->pass = $pass;
$newPerson->rg = $rg;
$newPerson->lat = $lat;
$newPerson->lng = $lng;
$newPerson->number = $number;
$newPerson->complement = $complement;
$newPerson->isActive = true;
?>
