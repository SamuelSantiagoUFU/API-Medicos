<?php
######################################
#                                    #
#    TODAS AS CONFIGURAÇÕES ESTÃO    #
#       DENTRO DA PASTA CONFIG       #
#     COM SEUS RESPECIVOS NOMES      #
#                                    #
######################################

# Aqui só é importada cada uma delas #

/* Banco de Dados */
require_once 'config/database.php';
/* Diretórios */
require_once 'config/directory.php';
/* Mensagens */
require_once 'config/message.php';
require_once 'config/lang/'.LANG.'.php';
/* Demais configurações */
require_once 'config/misc.php';
?>
