<?php
namespace Classes;
/**
 * Exam
 * Arquivo: exam.class.php
 */
use Classes\Base\QueryBuilder as QueryBuilder;
use Classes\Base\Objecto as Objecto;
class Exam extends Objecto
{
  public $id;
  public $description;
  public $qtd;
  public $type;
  public $created_at;
  public $updated_at;

  /**
   * @function loadAttributes
   * @param object $result
   * @return Exam
   * Função que carrega os valores do resultado para as variáveis
   */
  private function loadAttributes($result, bool $getConsult = false) {
    if (!is_array($result)) $result = (array)$result;
    $this->id = $result[TB_EXAMS['id']];
    if ($getConsult) $this->consult = (new Consult)->get($result[TB_EXAMS['consult']]);
    $this->description = $result[TB_EXAMS['desc']];
    $this->qtd = $result[TB_EXAMS['qtd']];
    $this->type = EXAMS_TYPES[$result[TB_EXAMS['type']]];
    $this->created_at = $result[TB_EXAMS['created_at']];
    $this->updated_at = $result[TB_EXAMS['updated_at']];
    return $this;
  }

  /**
   * @function insert
   * @return int
   * Função que realiza a inserção na tabela
   */
  public function insert() {
    $date = date("Y-m-d H:i:s");
    $fields = TB_EXAMS;
    array_shift($fields);
    $qb = new QueryBuilder;
    try {
      $result = $qb->table(TB_EXAMS['_name'])->fields($fields)->insert([
        $this->id,
        $this->consult->id,
        $this->description,
        $this->qtd,
        $this->type,
        $date, $date
      ]);
      if ($result === false) {
        return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data'])];
      }
    } catch (Exception $e) {
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
    $date = date("Y-m-d H:i:s");
    $fields = TB_EXAMS;
    array_shift($fields);
    $qb = new QueryBuilder;
    try {
      $result = $qb->table(TB_EXAMS['_name'])->fields($fields)
      ->whereAND(array_map(function ($el) {
        return $el.' = ?';
      }, $whereField))->update([
        $this->id,
        $this->consult->id,
        $this->description,
        $this->qtd,
        $this->type,
        $this->created_at,
        $date
      ], $whereValues);
      if ($result === false) {
        return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data'])];
      }
    } catch (Exception $e) {
      return ['code' => 0, 'msg' => $e->getMessage()];
    }
    return ['code' => $result, 'msg' => $this->replaceVars(MSG['reg_update'])];
  }

  /**
   * @function delete
   * @return int
   * Função que realiza a remoção dos dados atuais na tabela
   */
  public function delete(int $id = null) {
    $result = ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data'])];
    if (!$this->id) {
      if (!$id) return $result;
      $this->id = $id;
    }
    $qb = new QueryBuilder;
    try {
      $result = $qb->table(TB_EXAMS['_name'])->where([TB_EXAMS['id'].' = ?'])->delete([$this->id]);
      if ($result === false) {
        return $result;
      }
    } catch (Exception $e) {
      return ['code' => 0, 'msg' => $e->getMessage()];
    }

    return ['code' => $result, 'msg' => $this->replaceVars(MSG['reg_delete'])];
  }

  /**
   * @function get
   * @param int $id
   * @return Exam
   * Função que realiza a busca na tabela e retorna um determinado
   * exame passado no parâmetro pelo ID
   */
  public function get(int $id) {
    if (!$id) {
      return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data'])];
    }
    $qb = new QueryBuilder;
    $result = $qb->table(TB_EXAMS['_name'])->where([TB_EXAMS['id'].' = ?'])->select([$id]);
    if (!$result || empty($result)) {
      return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_reg'])];
    }
    return $this->loadAttributes($result[0], true);
  }

  /**
   * @function listConsult
   * @param int $consult
   * @return array
   * Função que realiza a busca na tabela e retorna todos os
   * exames de uma determinada consulta
   */
  public function listConsult(int $consult) {
    $result = [];
    if (!$consult) {
      return $result;
    }
    $qb = new QueryBuilder;
    $results = $qb->table(TB_EXAMS['_name'])->where([TB_EXAMS['consult'].' = ?'])->select([$consult]);
    if (!$results || empty($results)) {
      return $this->replaceVars(MSG['no_reg']);
    }
    foreach ($results as $r) {
      $p = new $this;
      array_push($result, $p->loadAttributes($r));
    }
    return $result;
  }

  /**
   * @function list
   * @param string $value
   * @return array
   * Função que realiza a busca na tabela e retorna todos os
   * exames de acordo com a busca
   */
  public function list(string $value = '%%') {
    $result = ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data']), 'result' => []];
    $value = "%{$value}%";
    $qb = new QueryBuilder;
    $results = $qb->table(TB_EXAMS['_name'])->where(TB_EXAMS['desc'])->select($value);
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
