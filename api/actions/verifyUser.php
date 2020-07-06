<?php
$id = filter_var($_COOKIE['id'], FILTER_VALIDATE_INT);
$permission = ['level'=>0, 'desc'=>'pacient'];
$person = new Classes\Medic();
$person->get($id);
if (!$person->id) {
  $person = new Classes\Pacient();
  $person->get($id);
  if (!$person->id) {
    die(Classes\Base\Parse::toJson(['code'=>0,'permission'=>null, 'msg'=>MSG['unauthorized']]));
  }
} else {
  $permission = ['level'=>1, 'desc'=>'medic'];
}
if ($person->admin) {
  $permission = ['level'=>2, 'desc'=>'admin'];
}
die(Classes\Base\Parse::toJson(['code'=>200,'permission'=>$permission]));
?>
