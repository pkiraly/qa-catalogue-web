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
  private bool $useDataElementInValidationSearch = false;
  private array $display = [];
  private bool $groupSearchByNames = false;
  private ?string $recordApiForDiff = null;

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
    $this->groupSearchByNames = $this->getValue('groupSearchByNames', false);

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
    $this->recordApiForDiff = $this->getValue('recordApiForDiff', null);

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

  /**
   * the machine name of the data directory
   * @return string
   */
  public function getId(): string {
    return $this->id;
  }

  /**
   * the catalogue class (in lowercase)
   * @return string|null
   */
  public function getCatalogue(): ?string {
    return $this->catalogue;
  }

  /**
   * the base output directory of data analysis
   * @return string|null
   */
  public function getDir(): ?string {
    return $this->dir;
  }

  /**
   * whether the selected tab should be displayed
   * @param string $tab
   * @param bool $default (applied if no direct value is set)
   * @return bool|null
   */
  public function display(string $tab, bool $default = false): ?bool {
    return $this->display[$tab] ?? $default;
  }

  /**
   * denotes if there are versions for a catalogue
   * @return bool
   */
  public function doVersioning(): bool {
    return $this->versioning;
  }

  /**
   * show or hide advanced search form
   * @return bool
   */
  public function doShowAdvancedSearchForm(): bool {
    return $this->showAdvancedSearchForm;
  }

  /**
   * the URL of the main Solr endpoint
   * @return string
   */
  public function getMainSolrEndpoint(): string {
    return $this->mainSolrEndpoint;
  }

  /**
   * the URL of the Solr core that is used for storing the results of validation
   * @return string|null
   */
  public function getSolrForScoresUrl(): ?string {
    return $this->solrForScoresUrl;
  }

  /**
   * name of the Solr index of a particular catalogue, if it is different from
   * the name of the catalogue or the URL path
   * @return string
   */
  public function getIndexName(): string {
    return $this->indexName;
  }

  /**
   * name of the data directory of a particular catalogue, if it is different from
   * the name of the catalogue or the URL path
   * @return string
   */
  public function getDirName(): string {
    return $this->dirName;
  }

  /**
   * directory with additional, custom Smarty templates for customization
   * @return string
   */
  public function getTemplates(): string {
    return $this->templates;
  }

  /**
   * the tab which will be displayed when no tab is selected
   * @return string
   */
  public function getDefaultTab(): string {
    return $this->defaultTab;
  }

  /**
   * name of the library catalogue
   * @return string|null
   */
  public function getLabel(): ?string {
    return $this->label;
  }

  /**
   * link to library catalogue homepage
   * @return string|null
   */
  public function getUrl(): ?string {
    return $this->url;
  }

  /**
   * metadata schema type (`MARC21` as default, `PICA`  or `UNIMARC`)
   * @return string|null
   */
  public function getSchema(): ?string {
    return $this->schema;
  }

  /**
   * default language of the user interface
   * @return string|null
   */
  public function getLanguage(): ?string {
    return $this->language;
  }

  /**
   * URL template to link into the library catalogue
   * @return string|null
   */
  public function getLinkTemplate(): ?string {
    return $this->linkTemplate;
  }

  
  /**
   * URL template for the record API of the library catalogue
   * @return string|null
   */
  public function getRecordApiForDiff(): ?string {
    return $this->recordApiForDiff;
  }

  /**
   * Create a logget
   * @param $name The name of the logger
   * @return Logger
   */
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

  public function groupSearchByNames(): bool {
    return $this->groupSearchByNames;
  }

  private function getDefaultMainSolrEndpoint(): string {
    if (isset($_ENV['SORL_HOST']) && !empty($_ENV['SORL_HOST'])) {
      return $_ENV['SORL_HOST'] . '/solr/';
    }
    $protocol = $_ENV["SOLR_PROTOCOL"] ?? "http";
    $domain = $_ENV["SOLR_DOMAIN"] ?? "localhost";
    $port = $_ENV["SOLR_PORT"] ?? "8983";
    return $protocol . "://" . $domain . ":" . $port . '/solr/';
  }
}
