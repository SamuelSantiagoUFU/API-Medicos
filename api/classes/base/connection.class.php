<?php
namespace Classes\Base;
/**
 * Connection
 * Arquivo: connection.class.php
 * Classe responsável por controlar a conexão com o banco de dados
 * Modifique as coisas aqui apenas caso seja necessário.
 * As configurações mais comuns estão presentes no arquivo config.php
 */
use \PDO;
use \PDOStatement;
use \Exception;
class Connection
{
  private static $pdo = null;
  protected $transactionCounter = 0;

  /**
   * @function getConnection
   * @return PDO
   * Função que estabelece a conexão, ou retorna uma já estabelecida
   */
  protected function getConnection() {
    if (!isset(self::$pdo)) {
      try {
        // Opções do PDO
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.DB['charset'], PDO::ATTR_PERSISTENT => TRUE);
        self::$pdo = new PDO('mysql:host='.DB['host'].'; dbname='.DB['name'].'; charset='.DB['charset'].';', DB['user'], DB['pass'], $options);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        die(json_encode(array('status' => 500, 'msg' => 'Erro: '.$e->getMessage())));
      }
    }
    return self::$pdo;
  }

  /**
   * @function statement
   * @param string $sql
   * @return PDOStatement
   * Função que prepara a query para uso na api
   */
  private final function statement($sql) {
    return $this->getConnection()->prepare($sql);
  }

  /**
   * @function executeSelect
   * @param string $sql
   * @param array $values
   * @return array
   * @return null
   * Função que executa o select no banco de dados e retorna o resultado
   */
  protected final function executeSelect($sql, array $values) {
    $statement = $this->statement($sql);
    if ($statement && $statement->execute(array_values($values))) {
      return (array)$statement->fetchAll(PDO::FETCH_OBJ);
    }
    return null;
  }

  /**
   * @function executeInsert
   * @param string $sql
   * @param array $values
   * @return boolean
   * Função que executa o insert no banco de dados
   */
  protected final function executeInsert($sql, array $values) {
    $statement = $this->statement($sql);
    if ($statement && $statement->execute(array_values($values))) {
      return $this->getConnection()->lastInsertId();
    }
    return false;
  }

  /**
   * @function executeUpdate
   * @param string $sql
   * @param array $values
   * @return boolean
   * Função que executa o update no banco de dados
   */
  protected final function executeUpdate($sql, array $values) {
    return $this->execute($sql, $values);
  }

  /**
   * @function executeDelete
   * @param string $sql
   * @param array $values
   * @return boolean
   * Função que executa o delete no banco de dados
   */
  protected final function executeDelete($sql, array $values) {
    return $this->execute($sql, $values);
  }

  protected final function execute($sql, array $values) {
    $statement = $this->statement($sql);
    if ($statement && $statement->execute(array_values($values))) {
      return $statement->rowCount();
    }
    return false;
  }
}

?>
