<?php
require_once 'config/database.php';
if ($argc > 2) die('Erro!'.PHP_EOL.'Uso: php db.php [-force | -help | -check]');
$forceCreate = isset($argv[1]) && $argv[1] == '-force';
$help = isset($argv[1]) && $argv[1] == '-help';
$check = isset($argv[1]) && $argv[1] == '-check';

if ($help) {
  echo "Uso: php db.php [-force | -help | -check]", PHP_EOL;
  echo "  -force: forçar a criação das tabelas (isso apagará todas e criará tudo do zero)", PHP_EOL;
  echo "  -help: exibe esta ajuda", PHP_EOL;
  echo "  -check: verifica se todas as tabelas estão corretas", PHP_EOL;
  die();
}
try {
  // Conexão com o banco de dados
  $db = new PDO('mysql:host='.DB['host'].'; dbname='.DB['name'].'; charset='.DB['charset'].';', DB['user'], DB['pass']);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // Pegando as tabelas
  $consults = TB_CONSULTS;
  $exams = TB_EXAMS;
  $medics = TB_MEDICS;
  $pacients = TB_PACIENTS;
  $people = TB_PEOPLE;
  $schedules = TB_SCHEDULES;
  // Verificando as tabelas que existem
  $tablesToCheck = [];
  if ($check) {
    $tables = [$consults, $exams, $medics, $pacients, $people, $schedules];
    $tablesNOTExists = [];
    $tablesWrong = [];
    foreach ($tables as $tb) {
      $name = $tb['_name'];
      array_shift($tb);
      if ($db->query("SHOW TABLES LIKE '$name'")->rowCount() == 0) {
        array_push($tablesNOTExists, $name);
      } else {
        foreach ($tb as $key => $value) {
          if ($db->query("SHOW COLUMNS FROM `$name` WHERE FIELD LIKE '$value'")->rowCount() == 0) {
            array_push($tablesWrong, $name.'.'.$value);
            array_push($tablesToCheck, $name);
          }
        }
      }
    }
    if (count($tablesNOTExists) > 0) {
      echo "Existem tabelas necessárias que não existem na base de dados:".PHP_EOL."[".PHP_EOL;
      echo '  '.implode(','.PHP_EOL.'  ', $tablesNOTExists).PHP_EOL."]";
    } else if (count($tablesWrong) > 0) {
      echo "Existem tabelas necessárias que não condizem com o esquema:".PHP_EOL."[".PHP_EOL;
      echo '  '.implode(','.PHP_EOL.'  ', $tablesWrong).PHP_EOL."]".PHP_EOL;
    } else {
      echo "Tabelas corretas";
      die();
    }
    do {
      if (PHP_OS == 'WINNT') {
        echo 'Deseja resolver essa situação? (S/N): ';
        $choice = stream_get_line(STDIN, 1024, PHP_EOL);
      } else {
        $choice = readline('Deseja resolver essa situação? (S/N): ');
      }
      $choice = strtoupper($choice);
    } while($choice != 'S' && $choice != 'N');
    $install = $choice == 'S';
    if (!$install) die();
  }

  // Criando sqls
  $sqlConsults = "CREATE TABLE IF NOT EXISTS `{$consults['_name']}` (
    `{$consults['id']}` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `{$consults['medic']}` bigint(20) UNSIGNED NOT NULL,
    `{$consults['pacient']}` bigint(20) UNSIGNED NOT NULL,
    `{$consults['date']}` datetime NOT NULL,
    `{$consults['value']}` decimal(10,2) NOT NULL,
    `{$consults['return_from']}` bigint(20) UNSIGNED DEFAULT NULL,
    `{$consults['done']}` tinyint(1) NOT NULL DEFAULT '0',
    `{$consults['created_at']}` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `{$consults['updated_at']}` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`{$consults['id']}`),
    KEY `{$consults['medic']}` (`{$consults['medic']}`),
    KEY `{$consults['pacient']}` (`{$consults['pacient']}`),
    KEY `{$consults['return_from']}` (`{$consults['return_from']}`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
  $sqlExams = "CREATE TABLE IF NOT EXISTS `{$exams['_name']}` (
    `{$exams['id']}` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `{$exams['consult']}` bigint(20) UNSIGNED NOT NULL,
    `{$exams['desc']}` varchar(255) NOT NULL,
    `{$exams['qtd']}` int(10) UNSIGNED NOT NULL,
    `{$exams['type']}` char(1) NOT NULL,
    `{$exams['created_at']}` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `{$exams['updated_at']}` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`{$exams['id']}`),
    KEY `exams_ibfk_2` (`{$exams['consult']}`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
  $sqlMedics = "CREATE TABLE IF NOT EXISTS `{$medics['_name']}` (
    `{$medics['id']}` bigint(20) UNSIGNED NOT NULL,
    `{$medics['title']}` varchar(255) NOT NULL,
    `{$medics['type']}` varchar(255) NOT NULL,
    `{$medics['uf']}` char(2) NOT NULL,
    `{$medics['register']}` varchar(255) NOT NULL,
    `{$medics['clinic']}` varchar(255) NOT NULL,
    `{$medics['cns']}` varchar(255) NOT NULL,
    PRIMARY KEY (`{$medics['id']}`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
  $sqlPacients = "CREATE TABLE IF NOT EXISTS `{$pacients['_name']}` (
    `{$pacients['id']}` bigint(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`{$pacients['id']}`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
  $sqlPeople = "CREATE TABLE IF NOT EXISTS `{$people['_name']}` (
    `{$people['id']}` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `{$people['admin']}` tinyint(1) DEFAULT '0',
    `{$people['cpf']}` char(11) DEFAULT NULL,
    `{$people['name']}` varchar(255) NOT NULL,
    `{$people['born']}` date DEFAULT NULL,
    `{$people['sex']}` char(1) DEFAULT NULL,
    `{$people['phone']}` char(10) DEFAULT NULL,
    `{$people['cell']}` char(11) DEFAULT NULL,
    `{$people['user']}` varchar(255) NOT NULL,
    `{$people['email']}` varchar(255) NOT NULL,
    `{$people['pass']}` varchar(255) NOT NULL,
    `{$people['rg']}` char(9) DEFAULT NULL,
    `{$people['lat']}` varchar(255) NOT NULL,
    `{$people['lng']}` varchar(255) NOT NULL,
    `{$people['number']}` varchar(6) NOT NULL,
    `{$people['comp']}` varchar(255) DEFAULT NULL,
    `{$people['active']}` tinyint(1) DEFAULT '1',
    `{$people['created_at']}` datetime DEFAULT CURRENT_TIMESTAMP,
    `{$people['updated_at']}` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`{$people['id']}`),
    UNIQUE KEY `people_user_unique` (`{$people['user']}`),
    UNIQUE KEY `people_email_unique` (`{$people['email']}`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
  $sqlSchedules = "CREATE TABLE IF NOT EXISTS `{$schedules['_name']}` (
    `{$schedules['id']}` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `{$schedules['medic']}` bigint(20) UNSIGNED NOT NULL,
    `{$schedules['weekday']}` tinyint(3) UNSIGNED NOT NULL,
    `{$schedules['hourInit']}` time NOT NULL,
    `{$schedules['duration']}` time DEFAULT NULL,
    `{$schedules['created_at']}` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `{$schedules['updated_at']}` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`{$schedules['id']}`),
    UNIQUE KEY `medic_weekday` (`{$schedules['medic']}`,`{$schedules['weekday']}`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
  $sqlArrays = [$sqlExams => $exams['_name'],
                $sqlConsults => $consults['_name'],
                $sqlSchedules => $schedules['_name'],
                $sqlMedics => $medics['_name'],
                $sqlPacients => $pacients['_name'],
                $sqlPeople => $people['_name']];
  $sql = '';
  if ($forceCreate)
    foreach ($sqlArrays as $create => $name) {
      $sql .= "DROP TABLE IF EXISTS `$name`; " . $create;
    }
  elseif ($check) {
    $sql = 'SET FOREIGN_KEY_CHECKS=0;';
    foreach ($sqlArrays as $create => $name) {
      if (in_array($name, $tablesToCheck))
        $sql .= "DROP TABLE IF EXISTS `$name`; " . $create;
    }
    $sql .= 'SET FOREIGN_KEY_CHECKS=1;';
  } else $sql = implode(' ', array_keys($sqlArrays));
  // Alterando os sqls
  if (!$check || ($check && in_array($consults['_name'], $tablesToCheck)))
    $sql .= " ALTER TABLE `{$consults['_name']}`
      ADD CONSTRAINT `consults_ibfk_1` FOREIGN KEY (`{$consults['medic']}`) REFERENCES `{$medics['_name']}` (`{$medics['id']}`),
      ADD CONSTRAINT `consults_ibfk_2` FOREIGN KEY (`{$consults['pacient']}`) REFERENCES `{$pacients['_name']}` (`{$pacients['id']}`),
      ADD CONSTRAINT `consults_ibfk_3` FOREIGN KEY (`{$consults['return_from']}`) REFERENCES `{$consults['_name']}` (`{$consults['id']}`);";
      if (!$check || ($check && in_array($exams['_name'], $tablesToCheck)))
    $sql .= " ALTER TABLE `{$exams['_name']}`
      ADD CONSTRAINT `exams_ibfk_2` FOREIGN KEY (`{$exams['consult']}`) REFERENCES `{$consults['_name']}` (`{$consults['id']}`) ON DELETE CASCADE ON UPDATE CASCADE;";
  if (!$check || ($check && in_array($medics['_name'], $tablesToCheck)))
    $sql .= " ALTER TABLE `{$medics['_name']}`
      ADD CONSTRAINT `medics_id_foreign` FOREIGN KEY (`{$medics['id']}`) REFERENCES `{$people['_name']}` (`{$people['id']}`) ON DELETE CASCADE;";
  if (!$check || ($check && in_array($pacients['_name'], $tablesToCheck)))
    $sql .= " ALTER TABLE `{$pacients['_name']}`
      ADD CONSTRAINT `pacients_ibfk_1` FOREIGN KEY (`{$pacients['id']}`) REFERENCES `{$people['_name']}` (`{$people['id']}`) ON DELETE CASCADE;";
  if (!$check || ($check && in_array($schedules['_name'], $tablesToCheck)))
    $sql .= " ALTER TABLE `{$schedules['_name']}`
      ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`{$schedules['medic']}`) REFERENCES `{$medics['_name']}` (`{$medics['id']}`);";

  $db->exec($sql);
  echo "Tables Created Successful";
} catch(PDOException $e) {
  echo $e->getMessage();
}
?>
