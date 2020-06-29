<?php
namespace Classes\Base;
/**
 * QueryBuilder
 * Arquivo: querybuilder.class.php
 * Classe responsável por fazer a string de consulta
 */
class QueryBuilder extends Connection
{
  private $clausules = [];
  function __call($name, $arguments)
  {
    $clausule = isset($arguments[0]) ? $arguments[0] : null;
    if (count($arguments) > 1) {
      $clausule = $arguments;
    }
    $this->clausules[$name] = $clausule;
    return $this;
  }

  /**
   * @function count
   * @param string $query
   * @return int
   * Função que conta as linhas da consulta retornada
   * Muito útil em casos de paginação
   * Nessa api ela não foi usada, mas a implementação desse sistema fica mais simples
   */
  public function count($query = '')
  {
    if (!is_array($query))
      $query = ['%'.$query.'%'];
    return $this->fields(['COUNT(*) as total'])->limit()->select($query)[0]->total;
  }

  /**
   * @function select
   * @param array $values
   * @return array
   * @return null
   * Função que monta a query de busca no banco de dados
   */
  public function select($values = [])
  {
    $table = isset($this->clausules['table']) ? $this->clausules['table'] : '<table>';
    $_fields = isset($this->clausules['fields']) ? $this->clausules['fields'] : ['*'];
    $fields = implode(', ', $_fields);
    $join = isset($this->clausules['join']) ? $this->clausules['join'] : '';

    $command = [];
    $command[] = 'SELECT';
    $command[] = $fields;
    $command[] = 'FROM';
    $command[] = $table;
    if ($join) {
      $command[] = $join;
    }

    $clausules = [
      'where' => [
        'instruction' => 'WHERE',
        'separator' => ' '
      ],
      'whereOR' => [
        'instruction' => 'WHERE',
        'separator' => ' OR '
      ],
      'whereAND' => [
        'instruction' => 'WHERE',
        'separator' => ' AND '
      ],
      'group' => [
        'instruction' => 'GROUP BY',
        'separator' => ', '
      ],
      'order' => [
        'instruction' => 'ORDER BY',
        'separator' => ', '
      ],
      'having' => [
        'instruction' => 'HAVING',
        'separator' => ' AND '
      ],
      'limit' => [
        'instruction' => 'LIMIT',
        'separator' => ','
      ]
    ];
    foreach ($clausules as $key => $clausule) {
      if (isset($this->clausules[$key])) {
        $value = $this->clausules[$key];
        if (is_array($value)) {
          $value = implode($clausule['separator'], $this->clausules[$key]);
        }
        $command[] = $clausule['instruction'].' '.$value;
      }
    }
    $sql = implode(' ', $command);
    if (!is_array($values)) $values = [$values];
    return $this->executeSelect($sql, $values);
  }

  /**
   * @function insert
   * @param array $values
   * @return int
   * Função que monta a query de inserção no banco de dados
   */
  public function insert($values)
  {
    $table = isset($this->clausules['table']) ? $this->clausules['table'] : '<table>';
    $_fields = isset($this->clausules['fields']) ? $this->clausules['fields'] : [''];
    $fields = implode(', ', $_fields);
    $_placeholders = array_map(function() { return '?'; }, $_fields);
    $placeholders = implode(', ', $_placeholders);

    $command = [];
    $command[] = 'INSERT INTO';
    $command[] = $table;
    $command[] = '('.$fields.')';
    $command[] = 'VALUES';
    $command[] = '('.$placeholders.')';

    $sql = implode(' ', $command);
    return $this->executeInsert($sql, $values);
  }

  /**
   * @function update
   * @param array $values
   * @param array $filters
   * @return boolean
   * Função que monta a query de atualização no banco de dados
   */
  public function update($values, $filters = [])
  {
    $table = isset($this->clausules['table']) ? $this->clausules['table'] : '<table>';
    $join = isset($this->clausules['join']) ? $this->clausules['join'] : '';
    $_fields = isset($this->clausules['fields']) ? $this->clausules['fields'] : '<fields>';
    $sets = $_fields;

    if (is_array($_fields)) {
      $sets = implode(', ', array_map(function($value) { return $value.' = ?';}, $_fields));
    } else {
      $sets = $_fields . ' = ?';
    }

    $command = [];
    $command[] = 'UPDATE';
    $command[] = $table;
    if ($join) {
        $command[] = $join;
    }
    $command[] = 'SET';
    $command[] = $sets;

    $clausules = [
      'where' => [
        'instruction' => 'WHERE',
        'separator' => ' '
      ],
      'whereOR' => [
        'instruction' => 'WHERE',
        'separator' => ' OR '
      ],
      'whereAND' => [
        'instruction' => 'WHERE',
        'separator' => ' AND '
      ]
    ];
    foreach ($clausules as $key => $clausule) {
      if (isset($this->clausules[$key])) {
        $value = $this->clausules[$key];
        if (is_array($value)) {
          $value = implode($clausule['separator'], $this->clausules[$key]);
        }
        $command[] = $clausule['instruction'].' '.$value;
      }
    }
    if (!is_array($values)) $values = [$values];
    if (!is_array($filters)) $filters = [$filters];
    $sql = implode(' ', $command);
    return $this->executeUpdate($sql, array_merge($values, $filters));
  }

  /**
   * @function delete
   * @param array $filters
   * @return boolean
   * Função que monta a query de remoção no banco de dados
   */
  public function delete($filters)
  {
    $table = isset($this->clausules['table']) ? $this->clausules['table'] : '<table>';
    $join = isset($this->clausules['join']) ? $this->clausules['join'] : '';

    $command = [];
    $command[] = 'DELETE FROM';
    $command[] = $table;
    if ($join) {
      $command[] = $join;
    }

    $clausules = [
      'where' => [
        'instruction' => 'WHERE',
        'separator' => ' '
      ],
      'whereOR' => [
        'instruction' => 'WHERE',
        'separator' => ' OR '
      ],
      'whereAND' => [
        'instruction' => 'WHERE',
        'separator' => ' AND '
      ]
    ];
    foreach ($clausules as $key => $clausule) {
      if (isset($this->clausules[$key])) {
        $value = $this->clausules[$key];
        if (is_array($value)) {
          $value = implode($clausule['separator'], $this->clausules[$key]);
        }
        $command[] = $clausule['instruction'].' '.$value;
      }
    }
    if (!is_array($filters)) $filters = [$filters];
    $sql = implode(' ', $command);
    return $this->executeDelete($sql.'; ALTER TABLE '.$table.' auto_increment = 1;', $filters);
  }
}
?>
