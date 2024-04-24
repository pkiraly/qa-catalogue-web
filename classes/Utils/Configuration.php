<?php

namespace Utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\ErrorLogHandler;
use Exception;

class Configuration {
  private array $configuration;
  private string $id;
  private ?string $catalogue;
  private bool $multitenant = false;
  private bool $displayNetwork;
  private bool $displayShacl;
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
  private bool $extractGitVersion;

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

    // merge in defaults
    return new Configuration(array_merge($defaults, $ini));
  }

  private function __construct(array $configuration) {

    // global
    $this->configuration = $configuration;
    $this->id = $configuration["id"]; // REQUIRED
    $this->multitenant = $configuration['multitenant'] ?? false;

    // multi-tennant
    // $this->displayNetwork = isset($configuration['display-network']) && (int) $configuration['display-network'] == 1;
    // $this->displayShacl = isset($configuration['display-shacl']) && (int) $configuration['display-shacl'] == 1;
    $this->dir = $this->getValue('dir', 'output');
    $this->catalogue = $this->getValue('catalogue', $this->id);
    $this->defaultTab = $this->getValue('default-tab', 'issues');
    $this->indexName = $this->getValue('indexName', $this->id);
    $this->dirName = $this->getValue('dirName', $this->id);
    $this->versioning = $this->getValue('versions', false);
    $this->displayNetwork = $this->getValue('display-network', false);
    $this->displayShacl = $this->getValue('display-shacl', false);
    $this->templates = $this->getValue('templates', 'config');
    $this->mainSolrEndpoint = $this->getValue('mainSolrEndpoint', 'http://localhost:8983/solr/');
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
  }

  private function getValue($key, $defaultValue) {
    if ($this->multitenant) {
      $value = $this->getMultitenantValue($key, $defaultValue);
    } else {
      $value = $this->configuration[$key] ?? $defaultValue;
    }
    // expected boolean
    if (is_bool($defaultValue)) {
      $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
      if (!is_bool($value)) {
        throw new Exception("$key must be boolean (1/0/true/false/on/off/yes/no)");
      }
    }
    return $value;
  }

  private function getMultitenantValue($key, $defaultValue) {
    // error_log($key . ': ' . gettype($this->{$key}));
    if (isset($this->configuration[$key]) && isset($this->configuration[$key][$this->id])) {
      $value = $this->configuration[$key][$this->id];
    } else if (isset($this->configuration[$key]) && is_scalar($this->configuration[$key])) {
      $value = $this->configuration[$key];
    } else {
      $value = $defaultValue;
    }
    return $value;
  }

  public function getId(): string {
    return $this->id;
  }

  public function getCatalogue(): ?string {
    return $this->catalogue;
  }

  public function isMultitenant(): bool {
    return $this->multitenant;
  }

  public function getDir(): ?string {
    return $this->dir;
  }

  public function doDisplayNetwork(): bool {
    return $this->displayNetwork;
  }

  public function doDisplayShacl(): bool {
    return $this->displayShacl;
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
      $logger->pushHandler(new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, $this->logLevel));
    }
    return $logger;
  }

  public function doExtractGitVersion(): bool {
    return $this->extractGitVersion;
  }
}
