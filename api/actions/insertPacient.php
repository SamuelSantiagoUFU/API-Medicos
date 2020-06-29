<?php
$pacient = new Classes\Pacient;
$pacient->name = "Manuela";
$pacient->sex = "F";
$pacient->user = "Manu";
$pacient->email = "manu@eemail.ocm";
$pacient->pass = password_hash("123456789", PASSWORD_DEFAULT);
$pacient->lat = "52,32651651";
$pacient->lng = "52,32651651";
$pacient->number = "452";
$pacient->isActive = true;
echo Classes\Base\Parse::toJson($pacient->insert());
?>
