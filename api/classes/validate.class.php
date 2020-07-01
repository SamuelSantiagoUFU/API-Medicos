<?php
namespace Classes;
/**
 * Classe responsável pela validação
 */
class Validate
{
  public static function validatePOST(array $inputs) {
    if (!isset($inputs) || empty($inputs)) return false;
    foreach ($inputs as $input) {
      if (!isset($_POST[$input]))
        return false;
    }
    return true;
  }

  public static function validateGET(array $inputs) {
    if (!isset($inputs) || empty($inputs)) return false;
    foreach ($inputs as $input) {
      if (!isset($_GET[$input]))
        return false;
    }
    return true;
  }
}

?>
