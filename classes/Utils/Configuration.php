<?php

namespace Utils;

use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\ErrorLogHandler;
use Exception;

class Configuration {
  private array $configuration;
  private string $id;
  private ?string $catalogue;
  private bool $versioning;
  private ?string $dir;
  private bool $showAdvancedSearchForm;
  private ?string $mainSolrEndpoint;
  private ?string $solrForScoresUrl;
  private ?string $indexName;
  private string $dirName;
  private string $templates;
  private string $defaultTab;
  private ?string $label;
  private ?string $url;
  private ?string $schema;
  private ?string $language;
  private ?string $linkTemplate;
  private string $logFile;
  private int $logLevel;
  private string $logHandler;
  private bool $extractGitVersion;
  private array $display = [];

  public static function fromIniFile(string $file, array $defaults=[]) {

    // read INI file, remove sections and fields with empty string value
    $ini = @parse_ini_file($file, false, INI_SCANNER_TYPED);
    if (!$ini) {
      throw new Exception("failed to read config file!");
    }

    if (isset($ini['include']) && file_exists($ini['include'])) {
      $include = @parse_ini_file($ini['include'], false, INI_SCANNER_TYPED);
      if (!$include) {
        throw new Exception("failed to include config file!");
      }
      $ini = array_merge($ini, $include);
    }

    // deprecated parameter, kept for backwards compatibility
    if (!isset($ini['id']) && isset($ini['db'])) {
      $ini['id'] = $ini['db'];
    }

    if (!isset($ini['id']) && isset($ini['catalogue'])) {
      $ini['id'] = $ini['catalogue'];
    }

    // set 'id' from 'dir', if 'id' is not available
    if (!isset($defaults['id']) && !isset($ini['id']) && isset($ini['dir'])) {
      $ini['id'] = $ini['dir'];
    }

    // merge in defaults
    return new Configuration(array_merge($defaults, $ini));
  }

  private function __construct(array $configuration) {
    // global
    $this->configuration = $configuration;
    $this->id = $configuration["id"]; // REQUIRED

    $this->dir = $this->getValue('dir', 'output');
    $this->catalogue = $this->getValue('catalogue', $this->id);
    $this->defaultTab = $this->getValue('default-tab', 'issues');
    $this->indexName = $this->getValue('indexName', $this->id);
    $this->dirName = $this->getValue('dirName', $this->id);
    $this->versioning = $this->getValue('versions', false);
    $this->templates = $this->getValue('templates', 'config');
    $this->mainSolrEndpoint = $this->getValue('mainSolrEndpoint', $this->getDefaultMainSolrEndpoint());
    $this->solrForScoresUrl = $this->getValue('solrForScoresUrl', null);
    $this->showAdvancedSearchForm = $this->getValue('showAdvancedSearchForm', false);
    $this->extractGitVersion = $this->getValue('extractGitVersion', true);

    // logging internals, not made available outside of this class
    $this->logFile = $this->getValue('logFile', 'logs/qa-catalogue.log');
    $this->logHandler = $this->getValue('logHandler', 'error_log');
    $this->logLevel = Logger::toMonologLevel($this->getValue('logLevel', 'WARNING'));

    // for the Catalogue class configuration
    $this->label = $this->getValue('label', null);
    $this->url = $this->getValue('url', null);
    $this->schema = $this->getValue('schema', null); // 'MARC21'
    $this->linkTemplate = $this->getValue('linkTemplate', null);
    $this->language = $this->getValue('language', null); // 'en'

    foreach ($configuration as $key => $value) {
      if (preg_match('/^display-/', $key)) {
      // if (str_starts_with($key, 'display-')) { # str_starts_with is not available in PHP 7.x
        $displayKey = substr($key,8);
        if (is_array($value)) {
          if (isset($value[$this->id]))
            $value = $value[$this->id];
          else
            continue;
        }
        Configuration::expectBool($key, $value);
        $this->display[$displayKey] = $value;
      }
    }
  }

  private static function expectBool($key, $value) {
    $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    if (!is_bool($value)) {
      throw new Exception("$key must be boolean (1/0/true/false/on/off/yes/no). It is '$value' instead");
    }
  }

  private function getValue($key, $defaultValue) {
    if (isset($this->configuration[$key])) {
      if (isset($this->configuration[$key][$this->id])) {
        $value = $this->configuration[$key][$this->id];
      } elseif (is_scalar($this->configuration[$key])) {
        $value = $this->configuration[$key];
      }
    }
    $value ??= $defaultValue;

    if (is_bool($defaultValue))
      Configuration::expectBool($key, $value);
    return $value;
  }

  public function getId(): string {
    return $this->id;
  }

  public function getCatalogue(): ?string {
    return $this->catalogue;
  }

  public function getDir(): ?string {
    return $this->dir;
  }

  public function display(string $tab, bool $default=false): ?bool {
    return $this->display[$tab] ?? $default;
  }

  public function doVersioning(): bool {
    return $this->versioning;
  }

  public function doShowAdvancedSearchForm(): bool {
    return $this->showAdvancedSearchForm;
  }

  public function getMainSolrEndpoint(): string {
    return $this->mainSolrEndpoint;
  }

  public function getSolrForScoresUrl(): ?string {
    return $this->solrForScoresUrl;
  }

  public function getIndexName(): string {
    return $this->indexName;
  }

  public function getDirName(): string {
    return $this->dirName;
  }

  public function getTemplates(): string {
    return $this->templates;
  }

  public function getDefaultTab(): string {
    return $this->defaultTab;
  }

  public function getLabel(): ?string {
    return $this->label;
  }

  public function getUrl(): ?string {
    return $this->url;
  }

  public function getSchema(): ?string {
    return $this->schema;
  }

  public function getLanguage(): ?string {
    return $this->language;
  }

  public function getLinkTemplate(): ?string {
    return $this->linkTemplate;
  }

  public function createLogger($name): Logger {
    $logger = new Logger($name);
    if ($this->logHandler === "file") {
      $logger->pushHandler(new StreamHandler($this->logFile, $this->logLevel));
    } else {
      $handler = new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, $this->logLevel);
      $formatter = new LineFormatter('%channel%.%level_name%: %message% %context% %extra%');
      $handler->setFormatter($formatter);
      $logger->pushHandler($handler);
    }
    return $logger;
  }

  public function doExtractGitVersion(): bool {
    return $this->extractGitVersion;
  }

  private function getDefaultMainSolrEndpoint(): string {
    $protocol = $_ENV["SOLR_PROTOCOL"] ?? "http";
    $host = $_ENV["SOLR_HOST"] ?? "localhost";
    $port = $_ENV["SOLR_PORT"] ?? "8983";
    return $protocol . "://" . $host . ":" . $port . '/solr/';
  }
}
