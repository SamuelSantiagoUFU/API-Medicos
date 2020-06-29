<?php
namespace Classes\Base;
/**
 * Objecto
 * Arquivo: objecto.class.php
 * Esta classe é pai de todos os objetos
 */
abstract class Objecto
{
  private $str_vars = ['{class_name}' => 'get_called_class()'];

  /**
   * @function replaceVars
   * @param string $string
   * @return string
   * Função que substitui as variáveis definidas pelos valores correspondentes
   */
  public function replaceVars(string $string) {
    foreach ($this->str_vars as $key => $value) {
      if (strpos($value, '(')) {
        $nameFunction = explode('(', $value)[0];
        $params = explode('(', $value)[1];
        $params = substr($params, 0, -1);
        $nameFunction = $this->dynamic($nameFunction, $params);
      } else {
        $nameFunction = $value;
      }
      $string = str_replace($key, $nameFunction, $string);
    }
    return $string;
  }

  function dynamic($what, $with = '') {
    if ($with)
      $return = $what($with);
    else
      $return = $what();
    $return = explode('\\', $return);
    return $return[count($return) - 1];
  }

  /**
   * @static function filter
   * @param array $objects
   * @param string $field
   * @param $value
   * @return array
   * Função que realiza o filtro de determinado array de objetos, baseando-se no campo
   * escolhido, retornando apenas aqueles que possuam o valor definido em $value
   */
  public static function filter(array $objects, string $field, $value) {
    $vars = array_filter($objects, function($var) use ($field, $value) {
      return $var->$field == $value;
    });
    return $vars;
  }
}

?>
