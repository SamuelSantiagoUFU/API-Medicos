<?php
namespace Classes\Base;
/**
 * Parse
 * Arquivo: parse.class.php
 * Classe responsável por transformar os dados
 */
abstract class Parse
{
  /**
   * @static function getObject
   * @param object $obj
   * @return string
   * Função que recebe um objeto de classe e transforma as variáveis dele
   * em um objeto JSON
   */
  public static function getObject(object $obj) : string {
    return self::toJson(get_object_vars($obj));
  }

  /**
   * @static function toJson
   * @param object $var
   * @return string
   * Função que recebe uma variável(mais comumente um array)
   * e transforma em um objeto JSON
   */
  public static function toJson($var) : string {
    return json_encode($var, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRESERVE_ZERO_FRACTION);
  }
}
 ?>
