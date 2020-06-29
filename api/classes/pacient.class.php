<?php
namespace Classes;
/**
 * Pacient
 * Arquivo: pacient.class.php
 */
use Classes\Base\QueryBuilder as QueryBuilder;
class Pacient extends Person
{
  /**
   * @function loadAttributes
   * @param object $result
   * @return Pacient
   * Função que carrega os valores do resultado para as variáveis
   */
  private function loadAttributes($result) {
    if (!is_array($result)) $result = (array)$result;
    parent::_get($result[TB_PACIENTS['id']]);
    return $this;
  }

  /**
   * @function insert
   * @return int
   * Função que realiza a inserção na tabela
   */
  public function insert() {
    $fields = TB_PACIENTS;
    array_shift($fields);
    $qb = new QueryBuilder;
    $person = parent::_insert();
    if ($person['code'] == 0) {
      return $person;
    }
    try {
      $result = $qb->table(TB_PACIENTS['_name'])->fields($fields)->insert([
        $person['code']
      ]);
      if ($result === false) {
        parent::_delete($person['code']);
        return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data'])];
      }
    } catch (Exception $e) {
      parent::_delete($person['code']);
      return ['code' => 0, 'msg' => $e->getMessage()];
    }
    return ['code' => $result, 'msg' => $this->replaceVars(MSG['reg_insert'])];
  }

  /**
   * @function update
   * @return int
   * Função que realiza a atualização na tabela
   */
  public function update($whereField, $whereValues) {
    if (!parent::_update($whereField, $whereValues)['code'])
      return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data'])];
    $fields = TB_PACIENTS;
    array_shift($fields);
    $qb = new QueryBuilder;
    try {
      $result = $qb->table(TB_PACIENTS['_name'])->fields($fields)
      ->whereAND(array_map(function ($el) {
        return $el.' = ?';
      }, $whereField))->update([
        $this->id
      ], $whereValues);
      if ($result === false) {
        return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data'])];
      }
    } catch (Exception $e) {
      return ['code' => 0, 'msg' => $e->getMessage()];
    }
    return ['code' => $this->id, 'msg' => $this->replaceVars(MSG['reg_update'])];
  }

  /**
   * @function get
   * @param int $id
   * @return Pacient
   * Função que realiza a busca na tabela e retorna um determinado
   * paceintes passada no parâmetro pelo ID
   */
  public function get(int $id) {
    if (!$id) {
      return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data'])];
    }
    $qb = new QueryBuilder;
    $result = $qb->table(TB_PACIENTS['_name'])->where(TB_PACIENTS['id'].' = ?')->select($id);
    if (!$result || empty($result)) {
      return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_reg'])];
    }
    return ['code' => 200, 'result' => $this->loadAttributes($result[0])];
  }

  /**
   * @function list
   * @param string $value
   * @return array
   * Função que realiza a busca na tabela e retorna todos os
   * paceintes de acordo com a busca
   */
  public function list(string $value = '%%') {
    $fieldsWhere = [TB_PEOPLE['name'], TB_PEOPLE['phone'], TB_PEOPLE['cell'], TB_PEOPLE['user'], TB_PEOPLE['email']];
    $result = ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data']), 'result' => []];
    $value = "%{$value}%";
    $qb = new QueryBuilder;
    $results = $qb->table(TB_PACIENTS['_name'].' PA')->join('INNER JOIN '.TB_PEOPLE['_name'].' PO ON PO.'.TB_PEOPLE['id'].' = PA.'.TB_PACIENTS['id'])
              ->whereOR(array_map(function($a) { return "PO.{$a} LIKE ?"; }, $fieldsWhere))->select(array_fill(0, count($fieldsWhere), $value));
    if (!$results || empty($results)) {
      $result['msg'] = $this->replaceVars(MSG['no_reg']);
      return $result;
    }
    foreach ($results as $r) {
      $p = new $this;
      array_push($result['result'], $p->loadAttributes($r));
    }
    $result['code'] = 200;
    $result['msg'] = $this->replaceVars(MSG['regs_found']);
    return $result;
  }
}

?>
