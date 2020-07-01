# API Médicos
> API para agendamento de consultas de médicos baseados na sua proximidade

![](https://img.shields.io/badge/php->=%207.3-brightgreen)
![](https://img.shields.io/badge/mysql-v10.1.37-brightgreen)

## Objetivo da API
Esta foi uma API desenvolvida para servir de busca por médicos cadastrados
previamente, baseados na distância e na disponibilidade de horários.

## Como usar
Primeiramente, coloque a pasta **api** no diretório raiz do site e siga com as
configurações indicadas.

### Configurações
Dentro da pasta **config** estão todas as configurações que se fazem necessárias
cada qual no seu próprio arquivo/pasta. Lembrando que todos os arquivos de configurações possuem o esquema
```javascript
'NOME_DA_CONFIGURAÇÃO' => 'VALOR';
```
onde o que deve ser mudado é apenas o valor, a menos que mude no código posteriormente.
#### Arquivos
##### database.php
Aqui estão as configurações gerais do banco de dados, tais como host, nome, usuário...
##### directory.php
Aqui estão as configurações gerais das pastas da aplicação, tais como o nome da pasta onde está a api, a pasta das classes e do cache utilizado para o carregamento mais rápido da API.
##### message.php
Este arquivo apenas contém a configuração para o idioma das mensagens retornadas pela API. O valor deve ser o mesmo nome do arquivo contido em config/lang
##### misc.php
Contém as configurações gerais que não se aplicam a nenhuma outra categoria, como a extensão dos arquivos de classe, o host permitido para o acesso e algumas outras configurações.
* **host_url:** O host que a API permitirá o acesso. **MUDE PARA O LINK DO SEU SITE, CASO CONTRÁRIO, PERMITIRÁ QUE QUALQUER UM ACESSE**
* **convert_space:** A configuração que irá transformar os caracteres vazios (espaços) para serem passadas pela url sem erro.
* **min_hour:** A quantidade de horas necessárias para que não haja consultas em um espaço muito curto de tempo. Só serão aceitas consultas próximas, caso o horário marcado esteja nesse intervalo.
* **max_distance:** A distância máxima a ser considerada para o agendamento de consultas no horário próximo. (É medida em metros).
* **valid_cache:** O tempo máximo que o cache da consulta terá validade. Após esse tempo, será necessário a criação de um novo arquivo atualizado, porém poderá levar um tempo maior.
* **valid_cache_unit:** Unidade de medida do tempo do cache. São aceitos:
  * S => segundos (Valor padrão)
  * M => minutos
  * H => horas
#### Pastas
##### /database
Contém todos os arquivos das tabelas necessárias para o banco de dados, assim como suas colunas. Devem ser mudados os nomes, conforme necessidade apenas do lado do `=> 'Valor'`
##### /lang
Pasta com os idiomas para as mensagens da API. Podem ser modificadas para apresentar as mensagens escolhidas por você.

As mensagens também podem conter variáveis pré-definidas que serão substituidas pelo valor especificado na documentação
* **{class_name}** será substituído pelo nome da classe onde está sendo chamado o script.

### Instalação
Caso não possua alguma tabela necessária para o funcionamento, é fortemente recomendado criá-la, ou simplesmente executar o script chamado `db.php` que serão criadas as tabelas restantes de forma automática.
```cmd
$ php db.php [-force | -help | -check]
```
O uso dos atributos é opcional
* **-force:** forçar a criação das tabelas (isso apagará todas e criará tudo do zero). Nunca use em servidores que estejam em produção, apenas para fins de testes.
* **-help:** exibe esta ajuda.
* **-check:** verifica se todas as tabelas estão corretas.
