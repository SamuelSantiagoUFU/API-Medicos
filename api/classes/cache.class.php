<?php
namespace Classes;
/**
 * Cache
 * Arquivo: cache.class.php
 */
class Cache {
  private static $file = '../../'.DIR['cache'].'/{fileName}.html';

  public static function getCache($name, $valid = MISC['valid_cache'], $unit = MISC['valid_cache_unit']) {
    $validSeconds = self::timeSeconds($valid, $unit);
    self::$file = str_replace('{fileName}', $name, self::$file);
    if (file_exists(self::$file) && filemtime(self::$file) > time() - $validSeconds) {
      return file_get_contents(self::$file);
    }
    return null;
  }

  public static function createCache($name, $content) {
    self::$file = str_replace('{fileName}', $name, self::$file);
    return file_put_contents(self::$file, $content);
  }

  private static function timeSeconds($time, $unit) {
    $unit = strtoupper($unit);
    if ($unit == 'H') {
      return $time * 3600;
    } else if ($unit == 'M') {
      return $time * 60;
    }
    return $time;
  }
}
