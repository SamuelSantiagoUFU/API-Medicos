<?php
namespace Classes;
/**
 * Person
 * Arquivo: person.class.php
 */
use Classes\Base\QueryBuilder as QueryBuilder;
use Classes\Base\Objecto as Objecto;
abstract class Person extends Objecto
{
  public $id;
  public $cpf;
  public $name;
  public $born;
  public $sex;
  public $phone;
  public $cellphone;
  public $user;
  public $email;
  public $pass;
  public $rg;
  public $address;
  public $lat;
  public $lng;
  public $number;
  public $complement;
  public $isActive;
  public $created_at;
  public $updated_at;

  /**
   * @function loadAttributes
   * @param object $result
   * @return Person
   * Função que carrega os valores do resultado para as variáveis
   */
  private function loadAttributes($result) {
    if (!is_array($result)) $result = (array)$result;
    $this->id = (int)$result[TB_PEOPLE['id']];
    $this->cpf = $result[TB_PEOPLE['cpf']];
    $this->name = $result[TB_PEOPLE['name']];
    $this->born = $result[TB_PEOPLE['born']];
    $this->sex = $result[TB_PEOPLE['sex']];
    $this->phone = $result[TB_PEOPLE['phone']];
    $this->cellphone = $result[TB_PEOPLE['cell']];
    $this->user = $result[TB_PEOPLE['user']];
    $this->email = $result[TB_PEOPLE['email']];
    $this->pass = $result[TB_PEOPLE['pass']];
    $this->rg = $result[TB_PEOPLE['rg']];
    $this->lat = $result[TB_PEOPLE['lat']];
    $this->lng = $result[TB_PEOPLE['lng']];
    $this->address = $this->getAddress();
    $this->number = $result[TB_PEOPLE['number']];
    $this->complement = $result[TB_PEOPLE['comp']];
    $this->isActive = (bool)$result[TB_PEOPLE['active']];
    $this->created_at = $result[TB_PEOPLE['created_at']];
    $this->updated_at = $result[TB_PEOPLE['updated_at']];
  }

  /**
   * @function _insert
   * @return int
   * Função que realiza a inserção na tabela
   */
  function _insert() {
    $date = date("Y-m-d H:i:s");
    $fields = TB_PEOPLE;
    array_shift($fields);
    $qb = new QueryBuilder;
    $result = $qb->table(TB_PEOPLE['_name'])->fields($fields)->insert([
      $this->id,
      $this->cpf,
      $this->name,
      $this->born,
      $this->sex,
      $this->phone,
      $this->cellphone,
      $this->user,
      $this->email,
      $this->pass,
      $this->rg,
      $this->lat,
      $this->lng,
      $this->number,
      $this->complement,
      $this->isActive,
      $date, $date
    ]);
    if ($result === false) {
      return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data'])];
    }
    return ['code' => $result];
  }

  /**
   * @function _update
   * @return int
   * Função que realiza a inserção na tabela
   */
  function _update($whereField, $whereValues) {
    $date = date("Y-m-d H:i:s");
    $fields = TB_PEOPLE;
    array_shift($fields);
    $qb = new QueryBuilder;
    try {
      $result = $qb->table(TB_PEOPLE['_name'])->fields($fields)
      ->whereAND(array_map(function ($el) {
        return $el.' = ?';
      }, $whereField))->update([
        $this->id,
        $this->cpf,
        $this->name,
        $this->born,
        $this->sex,
        $this->phone,
        $this->cellphone,
        $this->user,
        $this->email,
        $this->pass,
        $this->rg,
        $this->lat,
        $this->lng,
        $this->number,
        $this->complement,
        $this->isActive,
        $this->created_at,
        $date
      ], $whereValues);
      if ($result === false) {
        return ['code' => 0, 'msg' => $this->replaceVars(MSG['no_data'])];
      }
    } catch (Exception $e) {
      return ['code' => 0, 'msg' => $e->getMessage()];
    }
    return ['code' => $this->id];
  }

  /**
   * @function _get
   * @param int $id
   * @return array
   * Função que realiza a busca na tabela e retorna uma determinada
   * pessoa passada no parâmetro pelo ID
   */
  function _get(int $id = 0) {
    if (!$id) {
      return null;
    }
    $qb = new QueryBuilder;
    $result = $qb->table(TB_PEOPLE['_name'])->where(TB_PEOPLE['id'].' = ?')->select($id);
    if (!$result || empty($result)) {
      return null;
    }
    return $this->loadAttributes($result[0]);
  }

  /**
   * @function block
   * @param int $id
   * @return boolean
   * Função que realiza o bloqueio de uma pessoa pelo seu ID
   */
  public function block(int $id = 0) {
    if (!$this->id) {
      if (!$id) return false;
      else $this->id = $id;
    }
    $qb = new QueryBuilder;
    $result = $qb->table(TB_PEOPLE['_name'])->fields(TB_PEOPLE['active'])->where(TB_PEOPLE['id'].' = ?')->update(false, $this->id);
    return ['code' => 200 * $result, 'msg' => $this->replaceVars(MSG['block'])];
  }

  /**
   * @function unblock
   * @param int $id
   * @return boolean
   * Função que realiza o desbloqueio de uma pessoa pelo seu ID
   */
  public function unblock(int $id = 0) {
    if (!$this->id) {
      if (!$id) return false;
      else $this->id = $id;
    }
    $qb = new QueryBuilder;
    $result = $qb->table(TB_PEOPLE['_name'])->fields(TB_PEOPLE['active'])->where(TB_PEOPLE['id'].' = ?')->update(true, $this->id);
    return ['code' => 200 * $result, 'msg' => $this->replaceVars(MSG['unblock'])];
  }

  public function getAddress($lat = null, $lng = null) {
    if (!$lat) $lat = $this->lat;
    if (!$lng) $lng = $this->lng;
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&key={$_ENV['GOOGLE_API_KEY']}";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $geoloc = json_decode(curl_exec($ch), true);
    return $geoloc['results'][0]['formatted_address'];
  }

  public function getLatLng(string $address) {
    $address = str_replace(MISC['convert_space'], '+', $address);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key={$_ENV['GOOGLE_API_KEY']}";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $geoloc = json_decode(curl_exec($ch), true);
    return $geoloc['results'][0]['geometry']['location'];
  }

  function _login(string $email) {
    $qb = new QueryBuilder;
    $result = $qb->table(TB_PEOPLE['_name'])->fields([TB_PEOPLE['id']])->where(TB_PEOPLE['email'].' LIKE ?')->select($email);
    if (!$result || empty($result)) {
      return null;
    }
    return json_decode(json_encode($result[0]), true)[TB_PEOPLE['id']];
  }
}

?>
