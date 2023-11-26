<?php declare(strict_types=1);

use Utils\Configuration;

class ConfigurationTest extends \PHPUnit\Framework\TestCase {

  public static function invalidFiles(): array {
    return [
      ["tests/files/invalid1.cnf"],
      ["tests/files/invalid2.cnf"]
    ];
  }

  public function testValidConfiguration() {
    $config = Configuration::fromIniFile("tests/files/example.cnf");
    $this->assertEquals($config->getDir(), 'new-value');
    $this->assertEquals($config->getCatalogue(), 'abc');
  }

  /**
   * @dataProvider invalidFiles
   */ 
  public function testInvalidConfiguration($file) {    
    $this->expectException(Exception::class);
    Configuration::fromIniFile($file,["id"=>"path"]);
  }
}
