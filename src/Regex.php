<?php 

namespace Regex;

class Regex {
  
  public static function test(string $expr, string $text): bool {
    return preg_match($expr, $text);
  }

  public static function find($expr, string $text, int $limit = 0) {
    if (!self::test($expr, $text)) {
      return '';
    }

    $result = [];
    $ret = preg_match_all($expr, $text, $match);
    if (!$ret) {
      return '';
    }

    array_shift($match);
    foreach($match as $item) {
      if (is_array($item)) {
        foreach ($item as $val) {
          $result[] = $val;
        }
        continue;
      }

      $result[] = $item[0];
    }
    unset($match);

    if ($limit > 0) {
      $result = array_slice($result, 0, $limit);
    }

    return $result;
  }

  public static function all($exprs, string $text, int $limit = 0) {
    $result = [];

    if (is_string($exprs)) {
      $list = self::find($exprs, $text, $limit);
      $result = array_merge($result, $list);
    }

    if (is_array($exprs)) {
      foreach($exprs as $expr) {
        $list = self::find($expr, $text, $limit);
        $result = array_merge($result, $list);
      }
    }

    return $result;
  }

}