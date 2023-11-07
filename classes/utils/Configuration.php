<?php

namespace Utils;

class Configuration {
  private array $configuration;
  private string $id;
  /**
   * @var string|null
   */
  private ?string $catalogue;
  private bool $multitenant = false;
  private bool $displayNetwork;
  private bool $displayShacl;
  private bool $versioning;
  /**
   * @var string
   */
  private ?string $dir;
  /**
   * @var bool|mixed
   */
  private bool $showAdvancedSearchForm;
  /**
   * @var string|null
   */
  private ?string $mainSolrEndpoint;
  /**
   * @var string|null
   */
  private ?string $solrForScoresUrl;
  /**
   * @var string|null
   */
  private ?string $indexName;
  /**
   * @var string
   */
  private string $dirName;
  /**
   * @var string
   */
  private string $templates;
  /**
   * @var string
   */
  private string $defaultTab;
  /**
   * @var string|null
   */
  private ?string $label;
  /**
   * @var string|null
   */
  private ?string $url;
  /**
   * @var string|null
   */
  private ?string $schema;
  /**
   * @var string|null
   */
  private ?string $language;
  /**
   * @var string|null
   */
  private ?string $linkTemplate;

  public function __construct(array $configuration, string $id) {
    $this->configuration = $configuration;
    $this->id = $id;
    $this->initialize();
  }

  private function initialize() {
    $this->multitenant = $this->configuration['multitenant'] ?? false;
    $this->dir = $this->configuration['dir'] ?? null;
    error_log('id: ' . $this->id);

    // $this->displayNetwork = isset($this->configuration['display-network']) && (int) $this->configuration['display-network'] == 1;
    // $this->displayShacl = isset($this->configuration['display-shacl']) && (int) $this->configuration['display-shacl'] == 1;
    $this->indexName = $this->getValue('indexName', $this->id);
    $this->dirName = $this->getValue('dirName', $this->id);
    $this->defaultTab = $this->getValue('default-tab', 'completeness');
    $this->displayNetwork = $this->getValue('display-network', false);
    $this->displayShacl = $this->getValue('display-shacl', false);
    $this->templates = $this->getValue('templates', 'config');
    $this->catalogue = $this->getValue('catalogue', $this->id);
    $this->mainSolrEndpoint = $this->getValue('mainSolrEndpoint', 'http://localhost:8983/solr/');
    $this->solrForScoresUrl = $this->getValue('solrForScoresUrl', null);
    $this->label = $this->getValue('label', null);
    $this->url = $this->getValue('url', null);
    $this->schema = $this->getValue('schema', null); // 'MARC21'
    $this->language = $this->getValue('language', null); // 'en'
    $this->linkTemplate = $this->getValue('linkTemplate', null);

    if ($this->multitenant) {
      $this->versioning = (isset($this->configuration['versions'][$this->id]) && $this->configuration['versions'][$this->id] === true);
      $this->showAdvancedSearchForm = (isset($this->configuration['showAdvancedSearchForm'][$this->id]) && $this->configuration['showAdvancedSearchForm'][$this->id] === true);
    } else {
      $this->versioning = $this->configuration['versions'] ?? false;
      $this->showAdvancedSearchForm = $this->configuration['showAdvancedSearchForm'] ?? false;
    }
  }

  private function getValue($key, $defaultValue) {
    if ($this->multitenant) {
      $value = $this->getMultitenantValue($key, $defaultValue);
    } else {
      $value = $this->configuration[$key] ?? $defaultValue;
    }
    error_log('multitenant: ' . (int)$this->multitenant . ' -- ' . json_encode($value));
    return $value;
  }

  private function getMultitenantValue($key, $defaultValue) {
    if (isset($this->configuration[$key])) {
      $value = $this->configuration[$key][$this->id] ?? $this->configuration[$key];
    } else {
      $value = $defaultValue;
    }
    return $value;
  }

  public function getCatalogue(): ?string {
    return $this->catalogue;
  }

  public function isMultitenant(): bool {
    return $this->multitenant;
  }

  public function getDir(): string {
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
}