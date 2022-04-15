<?php 

use PHPUnit\Framework\TestCase;
use Regex\Regex;

class RegexTest extends TestCase
{
  
  public function testTest() {
    $content = "
      uma coisa
      10/10/2022
      outra coisa
    ";

    $expr = "/\d{2}\/\d{2}\/\d{4}/im";
    $this->assertTrue(Regex::test($expr, $content));
    $expr = "/\d{4}\/\d{2}\/\d{2}/im";
    $this->assertFalse(Regex::test($expr, $content));
  }

  public function testFind() {
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
    $list = Regex::find($expr, $content);
    $this->assertEquals(5, count($list));

    $expr = "/([a-z ]{1,}) - ([0-9]{1,})\.([0-9]{1,})/im";
    $list = Regex::find($expr, $content);
    $this->assertEquals(3, count($list));

    $expect = [
      'meu item',
      '0394',
      '039'
    ];

    $this->assertEquals($expect, $list);
    

    $list = Regex::find($expr, $content, 2);
    $this->assertEquals(2, count($list));

    $expr = "/([a-z ]{1,}) - ([0-9.]{1,})/im";
    $list = Regex::find($expr, $content, 2);
    $this->assertEquals(2, count($list));
  }

  public function testAll() {
    $content = "
uma coisa
10/10/2022
outra coisa
10/10/2022
10/10/2022
10/10/2022
10/10/2022
meu item - 0394.0395
    ";

    

    $exprs = [
      "/(\d{2}\/\d{2}\/\d{4})/im",
      "/([a-z ]{1,}) - ([0-9]{1,})\.([0-9]{1,})/im",
      "/([0-9]{4})/im"
    ];

    $list = Regex::all($exprs, $content);
    $this->assertEquals(15, count($list));

    $list = Regex::all($exprs, $content, 2);
    $this->assertEquals(6, count($list));

    $expect = [
      "10/10/2022",
      "10/10/2022",
      "meu item",
      "0394",
      "2022",
      "2022",
    ];

    $this->assertEquals($expect, $list);

    $expr = "/([0-9]{4})/im";
    $list = Regex::all($expr, $content);
    $this->assertEquals(7, count($list));

    $expect = [
      "2022",
      "2022",
      "2022",
      "2022",
      "2022",
      "0394",
      "0395",
    ];

    $this->assertEquals($expect, $list);
  }

}
