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

  public static function allStartEnd($exprStart, $exprEnd, $text) {
    $lista = array();
    $data = self::infoStartEnd($exprStart, $exprEnd, $text);
    while ($data['clip'] != '') {
        array_push($lista, $data['clip']);
        $data = self::infoStartEnd($exprStart, $exprEnd, $text, $data['offset']);
    }

    return $lista;
  }

  public static function findStartEnd($exprStart, $exprEnd, string $text, int $offset = 0) {
    $data = self::infoStartEnd($exprStart, $exprEnd, $text, $offset);
    return $data['clip'];
  }

  public static function infoStartEnd($exprStart, $exprEnd, string $text, int $offset = 0) {
    $data = array(
        'clip' => '',
        'offset' => 0,
        'start' => 0,
        'end' => 0
    );
    
    preg_match($exprStart, $text, $match, PREG_OFFSET_CAPTURE, $offset);
    if (isset($match[0][1])) {
        $offsetStart = $match[0][1];
    } else {
        return $data;
    }

    preg_match($exprEnd, $text, $match, PREG_OFFSET_CAPTURE, $offsetStart);
    if (isset($match[0][1])) {
        $offsetEnd = $match[0][1];
        $offsetEnd += strlen($match[0][0]);
    } else {
        $offsetEnd = strlen($text);
    }

    $length = $offsetEnd - $offsetStart;
    $clip = substr($text, $offsetStart, $length);

    $data['clip'] = $clip;
    $data['offset'] = $offsetEnd;
    $data['start'] = $offsetStart;
    $data['end'] = $offsetEnd;

    return $data;
  }

}