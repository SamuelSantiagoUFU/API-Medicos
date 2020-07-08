<?php
namespace Classes;
/**
 * Medic
 * Arquivo: medic.class.php
 */
use Classes\Base\QueryBuilder as QueryBuilder;
class Medic extends Person
{
  public $title;
  public $type;
  public $uf;
  public $register;
  public $clinic;
  public $cns;
  public $value;

  /**
   * @function loadAttributes
   * @param object $result
   * @return Medic
   * Função que carrega os valores do resultado para as variáveis
   */
  private function loadAttributes($result, bool $readed = false) {
    if (!is_array($result)) $result = (array)$result;
    parent::_get($result[TB_MEDICS['id']]);
    $this->title = $result[TB_MEDICS['title']];
    $this->type = $result[TB_MEDICS['type']];
    $this->uf = $result[TB_MEDICS['uf']];
    $this->register = $result[TB_MEDICS['register']];
    $this->clinic = $result[TB_MEDICS['clinic']];
    $this->cns = $result[TB_MEDICS['cns']];
    $this->value = $result[TB_MEDICS['value']];
    if ($readed) $this->consults = (new Consult)->listMedic($result[TB_MEDICS['id']]);
    return $this;
  }

  /**
   * @function insert
   * @return int
   * Função que realiza a inserção na tabela
   */
  public function insert() {
    $fields = TB_MEDICS;
    array_shift($fields);
    $qb = new QueryBuilder;
    $person = parent::_insert();
    if ($person['code'] == 0) {
      return $person;
    }
    try {
      $result = $qb->table(TB_MEDICS['_name'])->fields($fields)->insert([
        $person['code'],
        $this->title,
        $this->type,
        $this->uf,
        $this->register,
        $this->clinic,
        $this->cns,
        $this->value
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
    $fields = TB_MEDICS;
    array_shift($fields);
    $qb = new QueryBuilder;
    try {
      $result = $qb->table(TB_MEDICS['_name'])->fields($fields)
      ->whereAND(array_map(function ($el) {
        return $el.' = ?';
      }, $whereField))->update([
        $this->id,
        $this->title,
        $this->type,
        $this->uf,
        $this->register,
        $this->clinic,
        $this->cns,
        $this->value
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
   * @return Medic
   * Função que realiza a busca na tabela e retorna um determinado
   * médico passada no parâmetro pelo ID
   */
  public function get(int $id = 0, bool $readed = false) {
    if (!$id) {
      return null;
    }
    $qb = new QueryBuilder;
    $result = $qb->table(TB_MEDICS['_name'])->where(TB_MEDICS['id'].' = ?')->select($id);
    if (!$result || empty($result)) {
      return null;
    }
    return $this->loadAttributes($result[0], $readed);
  }

  /**
   * @function list
   * @param string $value
   * @return array
   * Função que realiza a busca na tabela e retorna todos os
   * médicos de acordo com a busca
   */
  public function list(string $value = null) {
    $result = ['code' => 0, 'total' => 0, 'msg' => $this->replaceVars(MSG['no_data']), 'result' => []];
    $value = "%{$value}%";
    $qb = new QueryBuilder;
    $results = $qb->table(TB_MEDICS['_name'].' PA')->join('INNER JOIN '.TB_PEOPLE['_name'].' PO ON PO.'.TB_PEOPLE['id'].' = PA.'.TB_MEDICS['id'])
              ->whereAND(['PO.'.TB_PEOPLE['name'].' LIKE ?'])->select($value);
    if (!$results || empty($results)) {
      $result['msg'] = $this->replaceVars(MSG['no_reg']);
      return $result;
    }
    foreach ($results as $r) {
      $p = new $this;
      $result['total']++;
      array_push($result['result'], $p->loadAttributes($r, true));
    }
    $result['code'] = 200;
    $result['msg'] = $this->replaceVars(MSG['regs_found']);
    return $result;
  }

  /**
   * @function listSpec
   * @param string $spec
   * @return array
   * Função que realiza a busca na tabela e retorna todos os
   * médicos de acordo com a especialidade
   */
  public function listSpec(string $spec) {
    $result = ['code' => 0, 'total' => 0, 'msg' => $this->replaceVars(MSG['no_data']), 'result' => []];
    $spec = "%{$spec}%";
    $qb = new QueryBuilder;
    $results = $qb->table(TB_MEDICS['_name'])->where(TB_MEDICS['clinic'].' LIKE ?')->select($spec);
    if (!$results || empty($results)) {
      $result['msg'] = $this->replaceVars(MSG['no_reg']);
      return $result;
    }
    foreach ($results as $r) {
      $p = new $this;
      $result['total']++;
      array_push($result['result'], $p->loadAttributes($r));
    }
    $result['code'] = 200;
    $result['msg'] = $this->replaceVars(MSG['regs_found']);
    return $result;
  }

  public function login(string $email) {
    $result = parent::_login($email);
    if (!$result)
      return null;
    return $this->get($result);
  }
}

?>
