<?php
require __DIR__ . '/vendor/autoload.php';

use Regex\Regex;

$content = "
uma coisa
10/10/2022
outra coisa
10/10/2022
10/10/2022
10/10/2022
10/10/2022
meu item - 0394.039
"; 

$expr = "/(\d{2}\/\d{2}\/\d{4})/im";
$list = Regex::find($expr, $content, 2);
var_dump($list);


// $list = Regex::find($expr, $content, 2);

// $expr = "/([a-z ]{1,}) - ([0-9]{1,})\.([0-9]{1,})/im";
// $list = Regex::find($expr, $content, 3);
var_dump($list);