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

### Uso
O uso é todo feito por chamadas HTTP/JS. O retorno de todas as chamadas é um objeto JSON que pode ser tratado da melhor maneira pelo cliente. Os exemplos aqui serão dados com base na função fetch, implementada no HTML5, mas podem ser facilmente adaptados para funcionar com AJAX.
#### Listar médicos
Para listar os médicos existentes, pode-se fazer a seguinte chamada http
```apache
$ GET /medic/list
```
ou em JS
```javascript
fetch('/medic/list')
.then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 200,
  "total": 5,
  "msg": "Registros encontrados",
  "result": [
    {
      "id": 5,
      "title": "Dr",
      "name": "Joaquim"
    },{
      "id": 6,
      "title": "Dra",
      "name": "Manuela"
    }
  ]
}
```
#### Listar médicos por especialidade
```apache
$ GET /medic/list/specialist/{SPEC}
```
```javascript
fetch('/medic/list/specialist/{SPEC}')
.then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **SPEC:** Todo ou parte do nome da especialidade

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 200,
  "total": 5,
  "msg": "Registros encontrados",
  "result": [
    {
      "id": 5,
      "title": "Dr",
      "name": "Joaquim"
    },{
      "id": 6,
      "title": "Dra",
      "name": "Manuela"
    }
  ]
}
```
#### Listar médicos disponíveis para atendimento
```apache
$ POST /medic/list/area/{PACIENT}
```
```javascript
var form = new FormData(document.getElementById('consult'));
fetch('/medic/list/area/{PACIENT}', {
  method: "POST",
  body: form
})
.then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **PACIENT:** Id do paciente que está procurando por uma consulta

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 200,
  "total": 5,
  "msg": "Registros encontrados",
  "result": [
    {
      "id": 5,
      "title": "Dr",
      "name": "Joaquim"
    },{
      "id": 6,
      "title": "Dra",
      "name": "Manuela"
    }
  ]
}
```
#### Resgatar um médico específico
Também é possível resgatar um médico tendo o seu id. É útil para fazer alterações.
```apache
$ GET /medic/get/{ID}
```
```javascript
fetch('/medic/get/{ID}')
.then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **ID:** Id do médico

A resposta esperada é um JSON similar ao abaixo
```json
{
  "id": 5,
  "title": "Dr",
  "name": "Joaquim",
  "consults": [
    {
      "id": 1,
      "pacient": {
        "id": 653,
        "name": "Rafael",
        "sex": "M"
      },
      "value": 279.00,
      "done": true
    }
  ]
}
```
#### Inserir um médico novo
```apache
$ POST /medic/post
```
```javascript
var form = new FormData(document.getElementById('medic'));
fetch('/medic/post', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **name:** Nome do novo médico
* **user:** Usuário do novo médico
* **email:** Email do novo médico
* **pass:** Senha do novo médico
* **address:** Endereço do consultório do novo médico
* **number:** Número do consultório do novo médico
* **title:** Título do novo médico (Dr. / Dra. ...)
* **type:** Tipo de registro (CRM)
* **uf:** UF do registro
* **register:** Número do registro
* **clinic:** Especialização do médico (cardiologista, clínico geral...)
* **CNS:** Número do cns
##### Dados opcionais
* **cpf:** CPF do novo médico
* **born:** Data de nascimento do novo médico
* **sex:** Sexo do novo médico
* **phone:** Telefone do novo médico
* **cellphone:** Celular do novo médico
* **rg:** RG do novo médico
* **complement:** Complemento do consultório do novo médico (caso tenha)

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 678,
  "msg": "Dados salvos com sucesso!"
}
```
#### Atualizar um médico existente
```apache
$ POST /medic/put
```
```javascript
var form = new FormData(document.getElementById('medic'));
fetch('/medic/put', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **id:** ID do médico que vai sofrer a alteração
* **name:** Nome do médico que vai sofrer a alteração
* **user:** Usuário do médico que vai sofrer a alteração
* **email:** Email do médico que vai sofrer a alteração
* **pass:** Senha do médico que vai sofrer a alteração
* **address:** Endereço do consultório do médico que vai sofrer a alteração
* **number:** Número do consultório do médico que vai sofrer a alteração
* **title:** Título do médico que vai sofrer a alteração (Dr. / Dra. ...)
* **type:** Tipo de registro (CRM)
* **uf:** UF do registro
* **register:** Número do registro
* **clinic:** Especialização do médico (cardiologista, clínico geral...)
* **CNS:** Número do cns
##### Dados opcionais
* **cpf:** CPF do médico que vai sofrer a alteração
* **born:** Data de nascimento do médico que vai sofrer a alteração
* **sex:** Sexo do médico que vai sofrer a alteração
* **phone:** Telefone do médico que vai sofrer a alteração
* **cellphone:** Celular do médico que vai sofrer a alteração
* **rg:** RG do médico que vai sofrer a alteração
* **complement:** Complemento do consultório do médico que vai sofrer a alteração (caso tenha)

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 678,
  "msg": "Dados salvos com sucesso!"
}
```
#### Bloquear um médico
```apache
$ POST /medic/block
```
```javascript
var form = new FormData(document.getElementById('medic'));
fetch('/medic/block', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **id:** ID do médico que será bloqueado

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 200,
  "msg": "Bloqueio realizado com sucesso!"
}
```
#### Desbloquear um médico
```apache
$ POST /medic/unblock
```
```javascript
var form = new FormData(document.getElementById('medic'));
fetch('/medic/unblock', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **id:** ID do médico que será desbloqueado

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 200,
  "msg": "Desbloqueio realizado com sucesso!"
}
```
#### Listar pacientes
Para listar os pacientes existentes, pode-se fazer a seguinte chamada http.
O parâmetro {query} é opcional
```apache
$ GET /pacient/list/{query}
```
ou em JS
```javascript
fetch('/pacient/list/{QUERY}')
.then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **QUERY:** Nome ou parte do nome do paciente

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 200,
  "total": 5,
  "msg": "Registros encontrados",
  "result": [
    {
      "id": 5,
      "title": "Dr",
      "name": "Joaquim"
    },{
      "id": 6,
      "title": "Dra",
      "name": "Manuela"
    }
  ]
}
```
#### Resgatar um paciente específico
Também é possível resgatar um paciente tendo o seu id. É útil para fazer alterações.
```apache
$ GET /pacient/get/{ID}
```
```javascript
fetch('/pacient/get/{ID}')
.then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **ID:** Id do paciente

A resposta esperada é um JSON similar ao abaixo
```json
{
  "id": 5,
  "title": "Dr",
  "name": "Joaquim",
  "consults": [
    {
      "id": 1,
      "pacient": {
        "id": 653,
        "name": "Rafael",
        "sex": "M"
      },
      "value": 279.00,
      "done": true
    }
  ]
}
```
#### Inserir um paciente novo
```apache
$ POST /pacient/post
```
```javascript
var form = new FormData(document.getElementById('pacient'));
fetch('/pacient/post', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **name:** Nome do novo paciente
* **user:** Usuário do novo paciente
* **email:** Email do novo paciente
* **pass:** Senha do novo paciente
* **address:** Endereço do novo paciente
* **number:** Número do novo paciente
##### Dados opcionais
* **cpf:** CPF do novo paciente
* **born:** Data de nascimento do novo paciente
* **sex:** Sexo do novo paciente
* **phone:** Telefone do novo paciente
* **cellphone:** Celular do novo paciente
* **rg:** RG do novo paciente
* **complement:** Complemento do endereço do novo paciente (caso tenha)

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 678,
  "msg": "Dados salvos com sucesso!"
}
```
#### Atualizar um paciente existente
```apache
$ POST /pacient/put
```
```javascript
var form = new FormData(document.getElementById('pacient'));
fetch('/pacient/put', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **id:** ID do paciente que vai sofrer a alteração
* **name:** Nome do paciente que vai sofrer a alteração
* **user:** Usuário do paciente que vai sofrer a alteração
* **email:** Email do paciente que vai sofrer a alteração
* **pass:** Senha do paciente que vai sofrer a alteração
* **address:** Endereço do paciente que vai sofrer a alteração
* **number:** Número do paciente que vai sofrer a alteração
##### Dados opcionais
* **cpf:** CPF do paciente que vai sofrer a alteração
* **born:** Data de nascimento do paciente que vai sofrer a alteração
* **sex:** Sexo do paciente que vai sofrer a alteração
* **phone:** Telefone do paciente que vai sofrer a alteração
* **cellphone:** Celular do paciente que vai sofrer a alteração
* **rg:** RG do paciente que vai sofrer a alteração
* **complement:** Complemento do endereço do paciente que vai sofrer a alteração (caso tenha)

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 678,
  "msg": "Dados salvos com sucesso!"
}
```
#### Bloquear um paciente
```apache
$ POST /pacient/block
```
```javascript
var form = new FormData(document.getElementById('pacient'));
fetch('/pacient/block', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **id:** ID do paciente que será bloqueado

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 200,
  "msg": "Bloqueio realizado com sucesso!"
}
```
#### Desbloquear um paciente
```apache
$ POST /pacient/unblock
```
```javascript
var form = new FormData(document.getElementById('pacient'));
fetch('/pacient/unblock', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **id:** ID do paciente que será desbloqueado

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 200,
  "msg": "Desbloqueio realizado com sucesso!"
}
```
#### Listar a agenda de um médico
```apache
$ GET /schedule/list/{MEDIC}
```
```javascript
fetch('/schedule/list/{MEDIC}')
.then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **MEDIC:** ID do médico que quer ver a agenda

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 200,
  "msg": "Registros encontrados!",
  "result": [
     {"id":"1","weekday":"0","hourInit":"06:00:00","duration":"12:00:00","created_at":"2020-06-17 15:19:39","updated_at":"2020-06-17 15:19:39"},
     {"id":"2","weekday":"1","hourInit":"06:00:00","duration":"08:00:00","created_at":"2020-06-17 20:11:50","updated_at":"2020-06-29 14:05:17"},
     {"id":"3","weekday":"2","hourInit":"06:00:00","duration":"12:00:00","created_at":"2020-06-17 20:22:18","updated_at":"2020-06-17 20:22:18"}
   ]
}
```
#### Resgatar um horário específico
```apache
$ GET /schedule/get/{ID}
```
```javascript
fetch('/schedule/get/{ID}')
.then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **ID:** ID da agenda específica

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 200,
  "msg": "Registros encontrados!",
  "result": {"id":"1","weekday":"0","hourInit":"06:00:00","duration":"12:00:00","created_at":"2020-06-17 15:19:39","updated_at":"2020-06-17 15:19:39","medic":{"..."}}
}
```
#### Inserir um horário novo
```apache
$ POST /schedule/post
```
```javascript
var form = new FormData(document.getElementById('schedule'));
fetch('/schedule/post', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **medic:** ID do médico que criou a agenda
* **init:** Horário de início do trabalho
* **duration:** Duração do trabalho
* **weekday:** Dia da semana daquele horário (0 = domingo, 1 = segunda, 2 = terça...)

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 678,
  "msg": "Dados salvos com sucesso!"
}
```
#### Atualizar um horário existente
```apache
$ POST /schedule/put
```
```javascript
var form = new FormData(document.getElementById('schedule'));
fetch('/schedule/put', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **id:** ID do horário em questão que vai sofrer a alteração
* **medic:** ID do médico que criou a agenda
* **init:** Horário de início do trabalho
* **duration:** Duração do trabalho
* **weekday:** Dia da semana daquele horário (0 = domingo, 1 = segunda, 2 = terça...)

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 678,
  "msg": "Dados salvos com sucesso!"
}
```
#### Deletar um horário existente
```apache
$ POST /schedule/delete
```
```javascript
var form = new FormData(document.getElementById('schedule'));
fetch('/schedule/delete', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **id:** ID do horário em questão que vai ser apagado

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 678,
  "msg": "Dados deletados com sucesso!"
}
```
#### Resgatar um exame específico
```apache
$ GET /exam/get/{ID}
```
```javascript
fetch('/exam/get/{ID}')
.then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **ID:** ID do exame específico

A resposta esperada é um JSON similar ao abaixo
```json
{
  "id":"235",
  "description":"Hemograma completo",
  "qtd":"1",
  "type":"Sangue",
  "consult": {
    "id":"1",
    "pacient": {"id":542,"cpf":null,"name":"Rafael"},
    "value":"15.00",
    "return": {"code":0,"msg":"Não existem registros"},
    "done":true
  }
}
```
#### Inserir um exame novo
```apache
$ POST /exam/post
```
```javascript
var form = new FormData(document.getElementById('exam'));
fetch('/exam/post', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **desc:** Descrição do exame
* **consult:** ID da consulta
* **qtd:** Quantidade de amostras
* **type:** Tipo de exame (S = sangue, F = fezes, U = urina...)

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 678,
  "msg": "Dados salvos com sucesso!"
}
```
#### Atualizar um exame existente
```apache
$ POST /exam/put
```
```javascript
var form = new FormData(document.getElementById('exam'));
fetch('/exam/put', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **id:** ID do exame em questão que vai sofrer a alteração
* **desc:** Descrição do exame
* **consult:** ID da consulta
* **qtd:** Quantidade de amostras
* **type:** Tipo de exame (S = sangue, F = fezes, U = urina...)

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 678,
  "msg": "Dados salvos com sucesso!"
}
```
#### Deletar um exame existente
```apache
$ POST /exam/delete
```
```javascript
var form = new FormData(document.getElementById('exam'));
fetch('/exam/delete', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **id:** ID do exame em questão que vai ser apagado

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 678,
  "msg": "Dados deletados com sucesso!"
}
```
#### Resgatar uma consulta específica
```apache
$ GET /consult/get/{ID}
```
```javascript
fetch('/consult/get/{ID}')
.then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **ID:** ID da consulta específica

A resposta esperada é um JSON similar ao abaixo
```json
{
  "id":"1",
  "pacient": {"id":542,"cpf":null,"name":"Rafael"},
  "value":"15.00",
  "return": {"code":0,"msg":"Não existem registros"},
  "done":true,
  "medic": {"id":215,"cpf":null,"name":"Fernanda","title":"Dra.","type":"CRM","uf":"SP"},
  "exams":[
    {"id":"1","description":"Hemograma completo","qtd":"1","type":"Sangue"},
    {"id":"2","description":"Corpocultura","qtd":"1","type":"Urina"}
  ]
}
```
#### Inserir uma consulta nova
```apache
$ POST /consult/post
```
```javascript
var form = new FormData(document.getElementById('consult'));
fetch('/consult/post', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **medic:** ID do médico
* **pacient:** ID do paciente
* **date:** Data e hora que está marcado
* **value:** Valor da consulta
* **return:** A consulta principal, se essa for um retorno

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 678,
  "msg": "Dados salvos com sucesso!"
}
```
#### Atualizar uma consulta existente
```apache
$ POST /consult/put
```
```javascript
var form = new FormData(document.getElementById('consult'));
fetch('/consult/put', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **id:** ID da consulta em questão que vai sofrer a alteração
* **medic:** ID do médico
* **pacient:** ID do paciente
* **date:** Data e hora que está marcado
* **value:** Valor da consulta
* **return:** A consulta principal, se essa for um retorno

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 678,
  "msg": "Dados salvos com sucesso!"
}
```
#### Deletar uma consulta existente
```apache
$ POST /consult/delete
```
```javascript
var form = new FormData(document.getElementById('consult'));
fetch('/consult/delete', {
  method: "POST",
  body: form
}).then(data => data.json())
.then((data) => {
  // Faça alguma coisa aqui
}).catch(error => console.error(error));
```
##### Dados necessários
* **id:** ID da consulta em questão que vai ser apagada

A resposta esperada é um JSON similar ao abaixo
```json
{
  "code": 678,
  "msg": "Dados deletados com sucesso!"
}
```
