<?php
if (!Classes\Validate::validatePOST($_POST) || !Classes\Validate::validateGET($_GET)) {
  die(Classes\Base\Parse::toJson(['code'=>0, 'msg'=>MSG['not_valid']]));
}
function distance($origin, $destinations) {
  $origin = implode(',', $origin);
  $destinations = implode('|', array_map(function($el) {
    return implode(',', $el);
  }, $destinations));
  $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origin&destinations=$destinations&key={$_ENV['GOOGLE_API_KEY']}";
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $geoloc = json_decode(curl_exec($ch), true);
  $distances = [];
  foreach ($geoloc['rows'][0]['elements'] as $el) {
    array_push($distances, $el['distance']);
  }
  return $distances;
}

$data = new DateTime(filter_var($_POST['data'], FILTER_SANITIZE_SPECIAL_CHARS));
$uf = filter_var($_POST['type'], FILTER_SANITIZE_SPECIAL_CHARS); // Estado do médico (para não pegar tudo)
$pacient = filter_var($_GET['id'], FILTER_VALIDATE_INT);
$clinic = filter_var($_POST['clinic'], FILTER_SANITIZE_SPECIAL_CHARS);

$pacient = (new Classes\Pacient)->get($pacient);
$medicsInWork = (new Classes\Schedule)->listAvailable($data, $uf);
$consults = (new Classes\Consult)->listDate($data, $uf);
$medicsAvailable = [];
// Se não existir o paciente, já mostra o erro
if (!$pacient['code']) {
  die(Classes\Base\Parse::toJson($pacient));
}
$pacient = $pacient['result'];
if ($consults['total'] == 0) {
  // Nenhum médico trabalhando
  foreach ($medicsInWork['result'] as $schedule) {
    if (!$schedule->medic->isActive) continue; // Se o médico estiver bloqueado, não pega ele
    array_push($medicsAvailable, $schedule->medic);
  }
} else {
  // Pegar médicos que estão em consulta
  $medicsPosition = [];
  $medicsInConsult = [];
  foreach ($consults['result'] as $consult) {
    $medic = $consult->medic;
    if (!$medic->isActive) continue; // Se o médico da consulta estiver bloqueado, não pega ele
    array_push($medicsPosition, [$medic->lat, $medic->lng]); // Vai pegando todas as posições dos médicos e colocando no array
    array_push($medicsInConsult, $medic); // Pega o médico tbm pra mais tarde (A)
  }
  $cache = Classes\Cache::getCache('distances-'.$_GET['id']); // Tenta pegar o cache, com as distâncias, pra ser mais rápido
  if ($cache != null) { // Se existir o cache e for válido
    $dist = $cache; // A distância vai ser pega do arquivo
  } else { // Senão, pega tudo de novo, com a posição dos médicos
    $dist = distance([$pacient->lat, $pacient->lng], $medicsPosition);
    Classes\Cache::createCache('distances-'.$_GET['id'], $dist); // Cria o cache e pronto
  }
  for ($i = 0; $i < count($medicsInConsult); $i++) { // Pra cada médico que tá em consulta que foi pego em (A)
    if ($dist[$i] <= MISC['max_distance']) { // Verifica se a distância é menor que a informada
      array_push($medicsAvailable, $medicsInConsult[$i]); // Se for, adiciona nos médicos disponíveis
    }
  }
  // Pegar os médicos que estão em horário de trabalho
  foreach ($medicsInWork['result'] as $working) {
    if (in_array($working->medic, $medicsInConsult)) continue;
    array_push($medicsAvailable, $working->medic);
  }
}
$medicsAvailable = Classes\Medic::filter($medicsAvailable, 'clinic', $clinic); // Filtra os médicos disponíveis pela clinica
echo Classes\Base\Parse::toJson($medicsAvailable); // Mostra os médicos disponíveis
?>
