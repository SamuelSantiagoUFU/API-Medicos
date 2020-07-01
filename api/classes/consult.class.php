<?php
namespace Classes;
/**
 * Consult
 * Arquivo: consult.class.php
 */
use Classes\Base\QueryBuilder as QueryBuilder;
use Classes\Base\Objecto as Objecto;
class Consult extends Objecto
{
  public $id;
  public $pacient;
  public $date;
  public $value;
  public $return;
  public $done = false;
  public $created_at;
  public $updated_at;

  /**
   * @function loadAttributes
   * @param object $result
   * @return Consult
   * Função que carrega os valores do resultado para as variáveis
   */
  private function loadAttributes($result, bool $readed = false) {
    if (!is_array($result)) $result = (array)$result;
    $this->id = $result[TB_CONSULTS['id']];
    if ($readed) $this->medic = (new Medic)->get($result[TB_CONSULTS['medic']]);
    $this->pacient = (new Pacient)->get($result[TB_CONSULTS['pacient']])['result'];
    $this->date = new \DateTime($result[TB_CONSULTS['date']]);
    $this->value = $result[TB_CONSULTS['value']];
    if ($readed) $this->exams = (new Exam)->listConsult($result[TB_CONSULTS['id']]);
    $this->return = (new Consult)->get($result[TB_CONSULTS['return_from']] ?? -1, $readed);
    $this->done = $result[TB_CONSULTS['done']] == true;
    $this->created_at = $result[TB_CONSULTS['created_at']];
    $this->updated_at = $result[TB_CONSULTS['updated_at']];
    return $this;
  }

  /**
   * @function insert
   * @return int
   * Função que realiza a inserção na tabela
   */
  public function insert() {
    $date = date("Y-m-d H:i:s");
    $fields = TB_CONSULTS;
    array_shift($fields);
    $qb = new QueryBuilder;
    try {
      $result = $qb->table(TB_CONSULTS['_name'])->fields($fields)->insert([
        $this->id,
        $this->medic->id,
        $this->pacient->id,
        $this->date->format('Y-m-d H:i'),
        $this->value,
        $this->return->id,
        $this->done,
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
    $fields = TB_CONSULTS;
    array_shift($fields);
    $qb = new QueryBuilder;
    try {
      $result = $qb->table(TB_CONSULTS['_name'])->fields($fields)
      ->whereAND(array_map(function ($el) {
        return $el.' = ?';
      }, $whereField))->update([
        $this->id,
        $this->medic->id,
        $this->pacient->id,
        $this->date->format('Y-m-d H:i'),
        $this->value,
        $this->return->id,
        $this->done,
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
      $result = $qb->table(TB_CONSULTS['_name'])->where([TB_CONSULTS['id'].' = ?'])->delete([$this->id]);
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
   * @return Consult
   * Função que realiza a busca na tabela e retorna uma determinada
   * consulta passada no parâmetro pelo ID
   */
  public function get(int $id, bool $readed = false) {
    if (!$id) {
      return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data'])];
    }
    $qb = new QueryBuilder;
    $result = $qb->table(TB_CONSULTS['_name'])->where([TB_CONSULTS['id'].' = ?'])->select([$id]);
    if (!$result || empty($result)) {
      return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_reg'])];
    }
    return $this->loadAttributes($result[0], $readed);
  }

  /**
   * @function listMedic
   * @param int $id
   * @return array
   * Função que realiza a busca na tabela e retorna todos as
   * consultas de acordo com o ID do médico
   */
  public function listMedic(int $id) {
    $result = [];
    if (!$id) {
      return $result;
    }
    $qb = new QueryBuilder;
    $results = $qb->table(TB_CONSULTS['_name'])->where([TB_CONSULTS['medic'].' = ?'])->select([$id]);
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
   * @function listDate
   * @param DateTime $date
   * @return array
   * Função que realiza a busca na tabela e retorna todas as
   * consultas de acordo com a data
   */
  public function listDate(\DateTime $date, string $uf) {
    $result = ['code' => 0, 'total' => 0, 'msg' => '', 'result' => []];
    $qb = new QueryBuilder;
    $results = $qb->table(TB_CONSULTS['_name'].' C')->join('INNER JOIN '.TB_MEDICS['_name'].' M ON M.'.TB_MEDICS['id'].' = C.'.TB_CONSULTS['medic'])
                  ->whereAND(['NOT C.'.TB_CONSULTS['done'],'C.'.TB_CONSULTS['date'].' BETWEEN ? AND ?','M.'.TB_MEDICS['uf'].' = ?'])
                  ->select([$date->sub((new \DateInterval('PT'.(MISC['min_hour']).'H')))->format('Y-m-d H:i:s'), $date->add(new \DateInterval('PT'.(MISC['min_hour']*2).'H'))->format('Y-m-d H:i:s'), $uf]);
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
}

?>
