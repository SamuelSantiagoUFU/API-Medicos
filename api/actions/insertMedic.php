<?php
$medic = new Classes\Medic;
$medic->name = "Manuela";
$medic->sex = "F";
$medic->user = "Manu";
$medic->email = "manu@eemail.ocm";
$medic->pass = password_hash("123456789", PASSWORD_DEFAULT);
$medic->lat = "52,32651651";
$medic->lng = "52,32651651";
$medic->number = "452";
$medic->isActive = true;
$medic->title = "Dra";
$medic->type = "CRM";
$medic->uf = "MG";
$medic->register = "1235456";
$medic->clinic = "Interno";
$medic->cns = "12345";
echo Classes\Base\Parse::toJson($medic->insert());
?>
