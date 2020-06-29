<?php
/*
Arquivo: index.php
*/
clearstatcache();
date_default_timezone_set('America/Sao_Paulo');
// Incluindo o arquivo com as configurações
include 'config.php';
// Dando acesso a api por locais externos
header("Access-Control-Allow-Origin: ".MISC['host_url']);
header("Access-Control-Allow-Credentials: true");
// Incluindo arquivo para tratar a url na parte da api
include_once 'url_response.php';
// Incluindo arquivo de autoload
include_once 'autoload.php';
(new Autoload);
// Rotas da api (não modificar caso não seja estritamente necessário)
$routes = array(
  '/medic/list/specialist/{spec:string}' => 'listMedicsSpec',
  '/medic/list/area/{id:int}' => 'listAvailable',
  '/medic/get/{id:int}' => 'getMedic',
  '/medic/post' => 'insertMedic',
  '/medic/put' => 'updateMedic',
  '/medic/block' => 'blockMedic',
  '/medic/unblock' => 'unblockMedic',
  '/pacient/list' => 'listPacients',
  '/pacient/list/{value:string}' => 'listPacients',
  '/pacient/get/{id:int}' => 'getPacient',
  '/pacient/post' => 'insertPacient',
  '/pacient/put' => 'updatePacient',
  '/pacient/block' => 'blockPacient',
  '/pacient/unblock' => 'unblockPacient',
  '/schedule/list/{medic:int}' => 'listSchedule',
  '/schedule/get/{id:int}' => 'getSchedule',
  '/schedule/post' => 'insertSchedule',
  '/schedule/put' => 'updateSchedule',
  '/schedule/delete' => 'deleteSchedule',
  '/exam/get/{id:int}' => 'getExam',
  '/exam/post' => 'insertExam',
  '/exam/put' => 'updateExam',
  '/exam/delete' => 'deleteExam',
  '/consult/get/{id:int}' => 'getConsult',
  '/consult/post' => 'insertConsult',
  '/consult/put' => 'updateConsult',
  '/consult/delete' => 'deleteConsult'
);
url_response($routes);
?>
