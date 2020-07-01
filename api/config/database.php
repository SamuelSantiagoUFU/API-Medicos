<?php
######################################
#               CONFIG               #
#      Arquivo de configurações      #
#      gerais do banco de dados      #
#         Renomear conforme a        #
# necessidade, apenas o lado direito #
######################################
define('DB', [
  'host' => 'localhost',
  'name' => 'api_teste',
  'user' => 'root',
  'pass' => '',
  'charset' => 'utf8'
]);

// Autorequire Definitions
chdir(__DIR__.'/database');
$file = glob("{*.php}", GLOB_BRACE);
foreach ($file as $config) {
  require_once $config;
}
?>
