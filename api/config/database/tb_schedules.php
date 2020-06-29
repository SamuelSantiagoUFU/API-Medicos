<?php
######################################
#               CONFIG               #
#      Arquivo de configurações      #
#        da tabela de horários       #
#         Renomear conforme a        #
# necessidade, apenas o lado direito #
######################################

// Nome da tabela de horários de atendimento
define('TB_SCHEDULES', [
  '_name' => 'schedules',
  'id' => 'id',
  'medic' => 'medic',
  'weekday' => 'weekday',
  'hourInit' => 'hourInit',
  'duration' => 'duration',
  'created_at' => 'created_at',
  'updated_at' => 'updated_at'
]);
?>
