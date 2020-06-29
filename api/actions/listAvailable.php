<?php
/*function distance($lat1, $lon1, $lat2, $lon2, $earthRadius = 6371000) {
  $latFrom = deg2rad($lat1);
  $lonFrom = deg2rad($lon1);
  $latTo = deg2rad($lat2);
  $lonTo = deg2rad($lon2);

  $lonDelta = $lonTo - $lonFrom;
  $a = pow(cos($latTo) * sin($lonDelta), 2) +
    pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
  $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

  $angle = atan2(sqrt($a), $b);
  return round($angle * $earthRadius, 2);
}*/

function distance($origin, $destinations) {
  $origin = implode(',', $origin);
  $destinations = implode('|', array_map(function($el) {
    return implode(',', $el);
  }, $destinations));
  $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origin&destinations=$destinations&key=AIzaSyCCgJgOP49oSDKdTmfI3s6HXdozi9U_8xE";
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $geoloc = json_decode(curl_exec($ch), true);
  $distances = [];
  foreach ($geoloc['rows'][0]['elements'] as $el) {
    array_push($distances, $el['distance']);
  }
  return $distances;
}

$data = new DateTime("now");
$uf = 'MG'; // Estado do médico (para não pegar tudo)

$pacient = (new Classes\Pacient)->get($_GET['id']);
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
  } else { // Senão, pega tudo de novo, com a posição dos médicos (Deveria pelo menos)
    $dist = distance([$pacient->lat, $pacient->lng], $medicsPosition);
    Classes\Cache::createCache('distances-'.$_GET['id'], $dist); // Cria o cache e pronto
  }
  for ($i = 0; $i < count($medicsInConsult); $i++) { // Pra cada médico que tá em consulta que foi pego em (A)
    if ($dist[$i] <= MISC['min_distance']) { // Verifica se a distância é menor que a informada
      array_push($medicsAvailable, $medicsInConsult[$i]); // Se for, adiciona nos médicos disponíveis
    }
  }
  // Pegar os médicos que estão em horário de trabalho
  foreach ($medicsInWork['result'] as $working) {
    if (in_array($working->medic, $medicsInConsult)) continue;
    array_push($medicsAvailable, $working->medic);
  }
}
$medicsAvailable = Classes\Medic::filter($medicsAvailable, 'clinic', 'Interno'); // Filtra os médicos disponíveis pela clinica, apenas Interno (só o que tem no momento)
echo Classes\Base\Parse::toJson($medicsAvailable); // Mostra os médicos disponíveis
?>
