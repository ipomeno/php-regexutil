<?php
require __DIR__ . '/vendor/autoload.php';

use Regex\Regex;

$content = file_get_contents(__DIR__ . '/resource/file-02.txt'); 

$exprStart = "/^[a-z]{1,}.* - Tipo:/im";
$exprEnd = "/Telefone: [0-9\(\)\- ]{1,}$/im";

$content = Regex::allStartEnd($exprStart, $exprEnd, $content);
$parts = [
  'nome' => "/(.*) - Tipo:/im",
  'tipo' => "/Tipo: (.*) - LC123/im",
  'cpfcnpj' => "/- Documento ([0-9.\/\-]{1,}) - Endereço:/im",
  'endereco' => "/Endereço: (.*) - CEP:/im",
  'cep' => "/- CEP: ([0-9.\-]{1,}) - UF:/im",
  'uf' => "/- UF: ([a-z]{2}) - Município:/im",
  'municipio' => "/- Município: (.*) - Telefone:/im",
  'telefone' => "/- Telefone: ([0-9\(\)\- ]{1,})/im"
];

foreach($content as $text) {
  $text = str_replace(["\r\n", "\r", "\n"], ' ', $text);
  $data = [];

  foreach($parts as $field => $expr) {
    $data[ $field ] = Regex::find($expr, $text);  
  }

  var_dump($data);
}

// $list = Regex::find($expr, $content, 2);

// $expr = "/([a-z ]{1,}) - ([0-9]{1,})\.([0-9]{1,})/im";
// $list = Regex::find($expr, $content, 3);