<?php declare(strict_types=1);

use Utils\Configuration;

class ConfigurationTest extends \PHPUnit\Framework\TestCase {

  public static function invalidFiles(): array {
    return [
      ["tests/files/configuration/invalid1.cnf"],
      ["tests/files/configuration/invalid2.cnf"]
    ];
  }

  public function testValidConfiguration() {
    $config = Configuration::fromIniFile("tests/files/configuration/valid1.cnf");
    $this->assertEquals($config->getDir(), 'new-value');
    $this->assertEquals($config->getCatalogue(), 'abc');
    $this->assertEquals($config->display("foo"), true);
    $this->assertEquals($config->display("bar"), false);
    $this->assertEquals($config->display("bar", true), false);
    $this->assertEquals($config->display("undefined"), false);
    $this->assertEquals($config->display("undefined", true), true);
  }

  public function testValidConfiguration_embedded() {
    $config = Configuration::fromIniFile("tests/files/configuration/valid2.cnf");
    $this->assertEquals($config->getDir(), 'qa-catalogue');
    $this->assertEquals($config->getId(), 'qa-catalogue');
    $this->assertEquals($config->getCatalogue(), 'qa-catalogue');
    $this->assertEquals($config->getDefaultTab(), "completeness");
    $this->assertEquals($config->getLabel(), "My custom Catalogue");
    $this->assertEquals($config->getUrl(), "https://my-catalogue.org");
    $this->assertEquals($config->getLinkTemplate(), "https://my-catalogue.org/catalogue/{id}");
    $this->assertEquals($config->getLanguage(), "de");
  }

  /**
   * @dataProvider invalidFiles
   */
  public function testInvalidConfiguration($file) {
    $this->expectException(Exception::class);
    Configuration::fromIniFile($file,["id"=>"path"]);
  }
}
