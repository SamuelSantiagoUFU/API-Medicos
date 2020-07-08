<?php
namespace Classes;
/**
 * Schedule
 * Arquivo: shcedule.class.php
 */
use Classes\Base\QueryBuilder as QueryBuilder;
use Classes\Base\Objecto as Objecto;
class Schedule extends Objecto
{
  public $id;
  public $weekday;
  public $hourInit;
  public $duration;
  public $created_at;
  public $updated_at;

  /**
   * @function loadAttributes
   * @param object $result
   * @return Schedule
   * Função que carrega os valores do resultado para as variáveis
   */
  private function loadAttributes($result, bool $showMedic = true) {
    if (!is_array($result)) $result = (array)$result;
    $this->id = $result[TB_SCHEDULES['id']];
    if ($showMedic) $this->medic = (new Medic)->get($result[TB_SCHEDULES['medic']]);
    $this->weekday = $result[TB_SCHEDULES['weekday']];
    $this->hourInit = $result[TB_SCHEDULES['hourInit']];
    $this->duration = $result[TB_SCHEDULES['duration']];
    $this->created_at = $result[TB_SCHEDULES['created_at']];
    $this->updated_at = $result[TB_SCHEDULES['updated_at']];
    return $this;
  }

  /**
   * @function insert
   * @return int
   * Função que realiza a inserção na tabela
   */
  public function insert() {
    $date = date("Y-m-d H:i:s");
    $fields = TB_SCHEDULES;
    array_shift($fields);
    $qb = new QueryBuilder;
    try {
      $result = $qb->table(TB_SCHEDULES['_name'])->fields($fields)->insert([
        $this->id,
        $this->medic->id,
        $this->weekday,
        $this->hourInit,
        $this->duration,
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
  public function update($whereField = [TB_SCHEDULES['id']], $whereValues = null) {
    if ($whereValues == null)
      $whereValues = [$this->id];
    $date = date("Y-m-d H:i:s");
    $fields = TB_SCHEDULES;
    array_shift($fields);
    $qb = new QueryBuilder;
    try {
      $result = $qb->table(TB_SCHEDULES['_name'])->fields($fields)
      ->whereAND(array_map(function ($el) {
        return $el.' = ?';
      }, $whereField))->update([
        $this->id,
        $this->medic->id,
        $this->weekday,
        $this->hourInit,
        $this->duration,
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
      $result = $qb->table(TB_SCHEDULES['_name'])->where(TB_SCHEDULES['id'].' = ?')->delete($this->id);
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
   * @return Schedule
   * Função que realiza a busca na tabela e retorna um determinado
   * horário de atendimento passada no parâmetro pelo ID
   */
  public function get(int $id) {
    if (!$id) {
      return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data'])];
    }
    $qb = new QueryBuilder;
    $result = $qb->table(TB_SCHEDULES['_name'])->where([TB_SCHEDULES['id'].' = ?'])->select([$id]);
    if (!$result || empty($result)) {
      return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_reg'])];
    }
    return ['code' => 200, 'msg' => $this->replaceVars(MSG['regs_found']), 'result' => $this->loadAttributes($result[0])];
  }

  /**
   * @function list
   * @param int $medic
   * @return array
   * Função que realiza a busca na tabela e retorna todos os
   * horários daquele médico
   */
  public function list(int $medic, bool $showMedic = true) {
    $result = ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data']), 'result' => []];
    $qb = new QueryBuilder;
    $results = $qb->table(TB_SCHEDULES['_name'])->where([TB_SCHEDULES['medic'].' = ?'])->select([$medic]);
    if (!$results || empty($results)) {
      $result['msg'] = $this->replaceVars(MSG['no_reg']);
      return $result;
    }
    foreach ($results as $r) {
      $p = new $this;
      array_push($result['result'], $p->loadAttributes($r, $showMedic));
    }
    $result['code'] = 200;
    $result['msg'] = $this->replaceVars(MSG['regs_found']);
    return $result;
  }

  /**
   * @function listAvailable
   * @param DateTime $date
   * @return array
   * Função que realiza a busca na tabela e retorna todos os
   * médicos trabalhando no momento
   */
  public function listAvailable(\DateTime $date, string $uf) {
    $result = ['code' => 0, 'total' => 0, 'msg' => $this->replaceVars(MSG['no_data']), 'result' => []];
    $qb = new QueryBuilder;
    $results = $qb->table(TB_SCHEDULES['_name'].' S')->join('INNER JOIN '.TB_MEDICS['_name'].' M ON M.'.TB_MEDICS['id'].' = S.'.TB_SCHEDULES['medic'])
    ->whereAND([
      'S.'.TB_SCHEDULES['weekday'].' = ?',
      '? BETWEEN S.'.TB_SCHEDULES['hourInit'].' AND S.'.TB_SCHEDULES['hourInit'].' + S.'.TB_SCHEDULES['duration'],
      'M.'.TB_MEDICS['uf'].' = ?'
    ])->select([
      $date->format('w'),
      $date->format('H:i'),
      $uf
    ]);
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
}

?>
