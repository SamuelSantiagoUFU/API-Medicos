<?php
namespace Classes;
/**
 * Classe responsável pela validação
 */
class Validate
{
  public static function validatePOST(array $inputs) {
    if (!isset($inputs) || empty($inputs)) return false;
    foreach ($inputs as $key=>$value) {
      if (!isset($_POST[$key]))
        return false;
    }
    return true;
  }

  public static function validateGET(array $inputs) {
    array_shift($inputs);
    if (!isset($inputs) || empty($inputs)) return false;
    foreach ($inputs as $key=>$value) {
      if (!isset($_GET[$key]))
        return false;
    }
    return true;
  }
}

?>
