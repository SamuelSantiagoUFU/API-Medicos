<?php
######################################
#               CONFIG               #
#      Arquivo de configurações      #
#        da tabela de exames         #
#         Renomear conforme a        #
# necessidade, apenas o lado direito #
######################################

// Nome da tabela de exames
define('TB_EXAMS', [
  '_name' => 'exams',
  'id' => 'id',
  'consult' => 'consult',
  'desc' => 'description',
  'qtd' => 'qtd',
  'type' => 'type',
  'created_at' => 'created_at',
  'updated_at' => 'updated_at'
]);

define('EXAMS_TYPES', [
  'U' => 'Urina',
  'S' => 'Sangue',
  'F' => 'Fezes'
]);
?>
