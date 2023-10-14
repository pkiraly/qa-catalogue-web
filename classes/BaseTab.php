<?php

include_once 'catalogue/Catalogue.php';

abstract class BaseTab implements Tab {

  protected $configuration;
  protected $db;
  protected $count = 0;
  protected static $marcBaseUrl = 'https://www.loc.gov/marc/bibliographic/';
  protected $solrFields;
  protected $fieldDefinitions;
  protected $catalogueName;
  protected Catalogue $catalogue;
  protected $marcVersion ;
  protected $lastUpdate = '';
  protected $output = 'html';
  protected $displayNetwork = false;
  protected $displayShacl = false;
  protected $historicalDataDir = null;
  protected $versioning = false;
  protected $lang = 'en';
  public $analysisParameters = null;
  public $indexingParameters = null;
  protected $grouped = false;
  protected $groupId = false;
  protected $groupBy;
  protected $parameterFile;

  /**
   * BaseTab constructor.
   * @param $configuration
   * @param $db
   */
  public function __construct($configuration, $db) {
    $this->configuration = $configuration;
    $this->db = $db;
    $this->catalogueName = isset($configuration['catalogue']) ? $configuration['catalogue'] : $db;
    $this->catalogue = $this->createCatalogue();
    $this->marcVersion = $this->catalogue->getMarcVersion();
    $this->displayNetwork = isset($configuration['display-network']) && (int) $configuration['display-network'] == 1;
    $this->displayShacl = isset($configuration['display-shacl']) && (int) $configuration['display-shacl'] == 1;
    $this->versioning = (isset($this->configuration['versions'][$this->db]) && $this->configuration['versions'][$this->db] === true);

    $this->count = $this->readCount();
    $this->readLastUpdate();
    $this->handleHistoricalData();
    $this->lang = getOrDefault('lang', $this->catalogue->getDefaultLang(), ['en', 'de', 'pt']);
    setLanguage($this->lang);
  }

  public function prepareData(Smarty &$smarty) {
    global $languages;

    $smarty->assign('db', $this->db);
    $smarty->assign('catalogueName', $this->catalogueName);
    $smarty->assign('catalogue', $this->catalogue);
    $smarty->assign('count', $this->count);
    $smarty->assign('lastUpdate', $this->lastUpdate);
    $smarty->assign('displayNetwork', $this->displayNetwork);
    $smarty->assign('displayShacl', $this->displayShacl);
    $smarty->assign('historicalDataDir', $this->historicalDataDir);
    $smarty->assign('controller', $this);
    $smarty->assign('lang', $this->lang);
    $smarty->assign('languages', $languages);
    $smarty->assign('generalParams', $this->concatParams($this->getGeneralParams()));

    $this->readAnalysisParameters();
    if (!is_null($this->analysisParameters)) {
      $smarty->assign('analysisParameters', $this->analysisParameters);
      $smarty->assign('analysisTimestamp', $this->analysisParameters->analysisTimestamp);
    }
  }

  protected function concatParams($params): string {
    return '&' . join('&', $params);
  }

  protected function getGeneralParams(): array {
    $params = [
      'lang=' . $this->lang
    ];
    return $params;
  }

  public function createCatalogue() {
    $className = strtoupper(substr($this->catalogueName, 0, 1)) . substr($this->catalogueName, 1);
    $classFile = 'catalogue/' . $className . '.php';
    if ($className != "catalogue" && file_exists('classes/' . $classFile)) {
      include_once $classFile;
      return new $className();
    } else {
      return new Catalogue($this->configuration);
    }
  }

  public function getTemplate() {
    // TODO: Implement getTemplate() method.
  }

  protected function getFilePath($name) {
    return sprintf('%s/%s/%s', $this->configuration['dir'], $this->getDirName(), $name);
  }

  protected function getVersionedFilePath($version, $name) {
    return sprintf('%s/_historical/%s/%s/%s', $this->configuration['dir'], $this->getDirName(), $version, $name);
  }

  protected function readCount($countFile = null) {
    if (is_null($countFile))
      $countFile = $this->getFilePath('count.csv');
    if (file_exists($countFile)) {
      $counts = readCsv($countFile);
      if (empty($counts)) {
        $count = trim(file_get_contents($countFile));
      } else {
        $counts = $counts[0];
        $count = isset($counts->processed) ? $counts->processed : $counts->total;
      }
    } else {
      $count = 0;
    }
    return intval($count);
  }

  protected function readLastUpdate() {
    $file = $this->getFilePath('last-update.csv');
    if (file_exists($file))
      $this->lastUpdate = trim(file_get_contents($file));
  }

  protected function getSolrFieldMap() {
    $solrFieldMap = [];
    $fields = $this->getSolrFields();
    foreach ($fields as $field) {
      $parts = explode('_', $field);
      $solrFieldMap[$parts[0]] = $field;
    }

    return $solrFieldMap;
  }

  /**
   * @param array $db
   * @return array
   */
  protected function getSolrFields() {
    if (!isset($this->solrFields)) {
      $solrPath = $this->getIndexName();
      $baseUrl = $this->getMainSolrEndpoint() . $solrPath; // $this->db;
      $url = $baseUrl . '/select/?q=*:*&wt=csv&rows=0';
      $all_fields = file_get_contents($url);
      $this->solrFields = explode(',', $all_fields);
    }
    return $this->solrFields;
  }

  protected function getSolrModificationDate() {
    $indexName = $this->getIndexName();
    $url = $this->getMainSolrEndpoint() . 'admin/cores?action=STATUS&core=' . $indexName;
    error_log('url: ' . $url);
    $raw_response = file_get_contents($url);
    $response = json_decode($raw_response);
    error_log('response: ' . json_encode($response->status->{$indexName}));
    $lastModified = $response->status->{$indexName}->lastModified;
    // lastModified
    return $lastModified;
  }

  /**
   * Get the main Solr index' base URL (default 'http://localhost:8983/solr/')
   * @return string
   */
  protected function getMainSolrEndpoint() {
    if (isset($this->configuration['mainSolrEndpoint'])) {
      if (isset($this->configuration['mainSolrEndpoint'][$this->db]))
        $mainSolrEndpoint = $this->configuration['mainSolrEndpoint'][$this->db];
      else
        $mainSolrEndpoint = $this->configuration['mainSolrEndpoint'];
    } else {
      $mainSolrEndpoint =  'http://localhost:8983/solr/';
    }
    return $mainSolrEndpoint;
  }

  protected function getSolrEndpoint4ValidationResults() {
    if (isset($this->configuration['solrEndpoint4ValidationResults'])) {
      if (isset($this->configuration['solrEndpoint4ValidationResults'][$this->db]))
        $solrEndpoint4ValidationResults = $this->configuration['solrEndpoint4ValidationResults'][$this->db];
      else
        $solrEndpoint4ValidationResults = $this->configuration['solrEndpoint4ValidationResults'];
    } else {
      $solrEndpoint4ValidationResults =  'http://localhost:8983/solr/';
    }
    return $solrEndpoint4ValidationResults;
  }

  protected function getSolrResponse($params) {
    $solrPath = $this->getIndexName();
    $url = $this->getMainSolrEndpoint() . $solrPath . '/select?' . join('&', $this->encodeSolrParams($params));
    $solrResponse = json_decode(file_get_contents($url));
    if (!$solrResponse) throw new Exception("Solr request failed");
    return (object)[
      'numFound' => $solrResponse->response->numFound,
      'docs' => $solrResponse->response->docs,
      'facets' => (isset($solrResponse->facet_counts) ? $solrResponse->facet_counts->facet_fields : []),
      'params' => $solrResponse->responseHeader->params,
    ];
  }

  protected function hasValidationIndex() {
    return $this->isCoreAvailable($this->getIndexName() . '_validation');
  }

  /**
   * @param $core The name of the Solr core
   * @return bool
   */
  protected function isCoreAvailable($core): bool {
    $url = $this->getSolrEndpoint($core) . $core . '/admin/ping';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $content = curl_exec($ch);
    $info = curl_getinfo($ch);
    $http_code = $info["http_code"];
    curl_close($ch);
    if ($http_code == 200) {
      $response = json_decode($content);
      return ($response->status == 'OK');
    }
    return false;
  }

  protected function getSolrEndpoint($core): string {
    return preg_match('/validation$/', $core)
      ? $this->getSolrEndpoint4ValidationResults()
      : $this->getMainSolrEndpoint();
  }

  protected function getFacets($facet, $query, $limit, $offset = 0, $termFilter = '', $filters = []) {
    $parameters = [
      'q=' . $query,
      'facet=on',
      'facet.limit=' . $limit,
      'facet.offset=' . $offset,
      'facet.field=' . $facet,
      'facet.mincount=1',
      'core=' . $this->db,
      'rows=0',
      'wt=json',
      'json.nl=map',
    ];
    if (!empty($termFilter)) {
      $parameters[] = sprintf('f.%s.facet.contains=%s', $facet, $termFilter);
      $parameters[] = sprintf('f.%s.facet.contains.ignoreCase=true', $facet);
    }
    if (!empty($filters))
      foreach ($filters as $filter)
        $parameters[] = 'fq=' . $filter;

    try {
        return $this->getSolrResponse($parameters)->facets;
    } catch(Exception $e) {
        // TODO: don't catch here but at caller and set error response
    }
  }

  protected function countFacets($facet, $query, $termFilter = '', $filters = []) {
    $limit = 10000;
    $offset = 0;
    $total = 0;
    do {
      $facets = $this->countFacets2($facet, $query, $limit, $offset, $termFilter, $filters);
      $count = count((array) $facets->{$facet});
      $total += $count;
      $offset += $limit;
    } while ($count == $limit);

    return $total;
  }
  protected function countFacets2($facet, $query, $limit, $offset = 0, $termFilter = '', $filters = []) {
    $parameters = [
      'q=' . $query,
      'facet=on',
      'facet.limit=' . $limit,
      'facet.offset=' . $offset,
      'facet.field=' . $facet,
      'facet.mincount=1',
      'core=' . $this->db,
      'rows=0',
      'wt=json',
      'json.nl=map',
    ];
    if (!empty($termFilter)) {
      $parameters[] = sprintf('f.%s.facet.contains=%s', $facet, $termFilter);
      $parameters[] = sprintf('f.%s.facet.contains.ignoreCase=true', $facet);
    }
    if (!empty($filters))
      foreach ($filters as $filter)
        $parameters[] = 'fq=' . $filter;

    try {
        return $this->getSolrResponse($parameters)->facets;
    } catch(Exception $e) {
        // TODO: don't catch here but at caller and set error response
    }
  }

  private function encodeSolrParams($parameters) {
    $encodedParams = [];
    foreach ($parameters as $parameter) {
      if ($parameter == '')
        continue;

      list($k, $v) = explode('=', $parameter);
      if ($k == 'core' || $k == '_'  || $k == 'json.wrf' || $v == '') { //
        continue;
      }
      if ($k == 'q') {
        // error_log('query: ' . $v);
      }
      if (!preg_match('/%/', $v))
        $v = urlencode($v);

      $encodedParams[] = $k . '=' . $v;
    }
    $encodedParams[] = 'indent=false';
    return $encodedParams;
  }

  protected function readHistogram($histogramFile) {
    $records = [];
    if (file_exists($histogramFile)) {
      $records = readCsv($histogramFile);
      $records = array_filter($records, function($record) {
        return ($record->name != 'id' && $record->name != 'total');
      });
    }
    return $records;
  }

  protected function getFieldMapFileName() {
    return 'cache/field-map-' . $this->db . '.js';
  }

  protected function getFacetFile() {
    return 'cache/selected-facets-' . $this->db . '.js';
  }

  protected function getSelectedFacets() {
    $selectedFacets = [];
    $file = $this->getFacetFile();
    if (file_exists($file)) {
      $facets = file_get_contents($file);
    } elseif ($this->catalogue->getSchemaType() == 'MARC21' && file_exists('cache/selected-facets.js')) {
      $facets = file_get_contents('cache/selected-facets.js');
    }
    if (isset($facets) && !is_null($facets)) {
      $facets = preg_replace(['/var selectedFacets = /', '/;$/', '/\'/'], ['', '', '"'], $facets);
      $selectedFacets = json_decode($facets);
    }
    return $selectedFacets;
  }

  public function getFieldDefinitions() {
    if (!isset($this->fieldDefinitions))
      $this->fieldDefinitions = json_decode(file_get_contents('schemas/marc-schema-with-solr-and-extensions.json'));
    return $this->fieldDefinitions;
  }

  public function getSolrField($tag, $subfield = '') {
    $this->getFieldDefinitions();

    if ($subfield == '' && strstr($tag, '$') !== false)
      list($tag, $subfield) = explode('$', $tag);

    if (isset($this->fieldDefinitions->fields->{$tag})) {
      $tagDefinition = $this->getTagDefinition($tag);

      if (isset($tagDefinition->subfields->{$subfield}->solr)) {
        $solrField = $tagDefinition->subfields->{$subfield}->solr . '_ss';
      } elseif ($this->hasVersionSpecificSolrField($tagDefinition, $subfield)) {
        $solrField = $tagDefinition->versionSpecificSubfields->{$this->marcVersion}->{$subfield}->solr . '_ss';
      } elseif (isset($tagDefinition->solr)) {
        $solrField = sprintf('%s%s_%s_%s_ss', $tag, $subfield, $tagDefinition->solr, $subfield);
      } else {
        // leader\d+
      }
    }

    if ($this->catalogue->getSchemaType() == 'PICA'
        && !isset($solrField)
        && preg_match('/[^a-zA-Z0-9]/', $tag)) {
      $solrField = $this->picaToSolr($tag . $subfield) . '_ss';
    }

    if (!isset($solrField) || !in_array($solrField, $this->getSolrFields())) {
      $solrField1 = isset($solrField) ? $solrField : false;
      $solrField = $tag;
      if ($subfield != '')
        $solrField .= preg_match('/[0-9a-zA-Z]/', $subfield) ? $subfield : 'x' . bin2hex($subfield);
      $candidates = [];
      $found = FALSE;
      $solrField = str_replace('?', '\?', $solrField);
      $solrField = str_replace('/', '\/', $solrField);
      $existingSolrFields = $this->getSolrFields();
      foreach ($existingSolrFields as $existingSolrField) {
        if (preg_match('/^' . $solrField . '_/', $existingSolrField)) {
          $parts = explode('_', $existingSolrField);
          if (count($parts) == 4) {
            $found = TRUE;
            $solrField = $existingSolrField;
            unset($existingSolrFields[$existingSolrField]);
            break;
          } else {
            $candidates[] = $existingSolrField;
          }
        }
      }

      if (count($candidates) == 1) {
        $solrField = $candidates[0];
        $found = TRUE;
      }

      if (!$found) {
        $solrField = FALSE;
      }
    }
    return $solrField;
  }

  protected function picaToSolr($input) {
    $input = str_replace('/', '_', $input);
    return preg_replace_callback('/([^a-zA-Z0-9])/', function ($matches) { return 'x' . dechex(ord($matches[1])); }, $input);
  }

  protected function solrToPica($input) {
    return preg_replace_callback('/x([0-9a-f]{2})/', function ($matches) { return chr(hexdec($matches[1])); }, $input);
  }

  public function resolveSolrField($solrField) {
    if ($solrField == '')
      return '';

    $this->getFieldDefinitions();

    $solrField = preg_replace('/_ss$/', '', $solrField);
    if ($solrField == 'type'
        || ($this->catalogue->getSchemaType() == 'MARC21'
            && (substr($solrField, 0, 2) == '00'
                || substr($solrField, 0, 6) == 'Leader'
                || substr($solrField, 0, 6) == 'leader'))) {
      $found = false;
      if (substr($solrField, 0, 2) == '00') {
        $parts = explode('_', $solrField);
        if (property_exists($this->fieldDefinitions->fields, $parts[0]) &&
            isset($this->fieldDefinitions->fields->{$parts[0]}) &&
            !is_null($this->fieldDefinitions->fields->{$parts[0]})) {
          if (!isset($this->fieldDefinitions->fields->{$parts[0]}->types))
            error_log('no types for ' . $parts[0]);
          if (!is_array($this->fieldDefinitions->fields->{$parts[0]}->types))
            error_log(sprintf('$s is not an array, but %s', $parts[0], gettype($this->fieldDefinitions->fields->{$parts[0]}->types)));
          foreach ($this->fieldDefinitions->fields->{$parts[0]}->types as $name => $type)
            foreach ($type->positions as $position => $definition)
              if ($position == $parts[1]) {
                $label = sprintf('%s/%s %s', $parts[0], $parts[1], $definition->label);
                $found = true;
                break;
              }
        }
      }
      if (!$found) {
        $solrField = preg_replace('/^(00.|leader|Leader_)/', "$1/", $solrField);
        $solrField = preg_replace('/_/', ' ', $solrField);
        $label = $solrField;
      }
    } else {
      if ($this->catalogue->getSchemaType() == 'MARC21') {
        $field = substr($solrField, 0, 3);
        $pos3_7 = substr($solrField, 3, 4);

        if ($pos3_7 == 'ind1' || $pos3_7 == 'ind2')
          $label = sprintf('%s/%s', $field, substr($solrField, 3, 4));
        else
          $label = sprintf('%s$%s', $field, substr($solrField, 3, 1));
        $found = false;
        if (isset($this->fieldDefinitions->fields->{$field})) {
          $fieldDefinition = $this->fieldDefinitions->fields->{$field};
          if ($pos3_7 == 'ind1' && isset($fieldDefinition->indicator1)) {
            $label .= ': ' . $fieldDefinition->label . ' / ' . $fieldDefinition->indicator1->label;
            $found = true;
          } else if ($pos3_7 == 'ind2' && isset($fieldDefinition->indicator2)) {
            $label .= ': ' . $fieldDefinition->label . ' / ' . $fieldDefinition->indicator2->label;
            $found = true;
          } else if (isset($fieldDefinition->subfields->{substr($solrField, 3, 1)})) {
            $subfieldDefinition = $fieldDefinition->subfields->{substr($solrField, 3, 1)};
            $label .= ': ' . $fieldDefinition->label;
            if ($fieldDefinition->label != $subfieldDefinition->label)
              $label .= ' / ' . $subfieldDefinition->label;
            $found = true;
          }
        }
        if (!$found) {
          foreach ($this->fieldDefinitions->fields as $fieldDefinition)
            if (isset($fieldDefinition->subfields))
              foreach ($fieldDefinition->subfields as $code => $subfieldDefinition)
                if (isset($subfieldDefinition->solr) && $subfieldDefinition->solr == $solrField) {
                  $label = sprintf('%s$%s %s', $fieldDefinition->tag, $code, $fieldDefinition->label);
                  if ($fieldDefinition->label != $subfieldDefinition->label)
                    $label .= ' / ' . $subfieldDefinition->label;
                  break;
                }
        }
      } elseif ($this->catalogue->getSchemaType() == 'PICA') {
        $label = $this->getLabelForPica($solrField);
      }
    }

    return $label;
  }

  protected function solrToMarcCode($solrField) {
    $solrField = preg_replace('/_ss$/', '', $solrField);
    if ($this->catalogue->getSchemaType() == 'MARC21') {
      if ($solrField == 'type' || substr($solrField, 0, 2) == '00' || substr($solrField, 0, 6) == 'Leader') {
        if (substr($solrField, 0, 2) == '00' || substr($solrField, 0, 6) == 'Leader') {
          $parts = explode('_', $solrField);
          $label = sprintf('%s/%s', $parts[0], $parts[1]);
        } else {
          $label = $solrField;
        }
      } else {
        $label = sprintf('%s$%s', substr($solrField, 0, 3), substr($solrField, 3, 1));
      }
    } else if ($this->catalogue->getSchemaType() == 'PICA') {
      $solrField = preg_replace('/_ss$/', '', $solrField);
      $solrField = $this->solrToPica($solrField);
      if (preg_match('/_full$/', $solrField))
        $label = preg_replace('/_full$/', '', $solrField);
      else
        $label = sprintf('%s$%s', substr($solrField, 0, -1), substr($solrField, -1));
    }
    return $label;
  }

  public function getOutputType() {
    return $this->output;
  }

  /**
   * @return mixed
   */
  protected function getIndexName() {
    $solrPath = (isset($this->configuration['indexName']) && isset($this->configuration['indexName'][$this->db]))
      ? $this->configuration['indexName'][$this->db]
      : $this->db;
    return $solrPath;
  }

  private function handleHistoricalData() {
    $historicalDir = sprintf('%s/_historical/%s', $this->configuration['dir'], $this->getDirName());
    if (file_exists($historicalDir))
      $this->historicalDataDir = $historicalDir;
  }

  protected function getVersions() {
    $versions = [];
    $candidates = array_diff(scandir($this->historicalDataDir,  SCANDIR_SORT_ASCENDING), ['..', '.']);
    foreach ($candidates as $version) {
      if (is_dir($this->historicalDataDir . '/' . $version))
        $versions[] = $version;
    }
    return $versions;
  }

  protected function getHistoricalFilePaths($name) {
    $files = [];
    if (!is_null($this->historicalDataDir)) {
      foreach ($this->getVersions() as $version) {
        $files[$version] = sprintf('%s/%s/%s', $this->historicalDataDir, $version, $name);
      }
    }
    return $files;
  }

  /**
   * @return mixed
   */
  protected function getDirName() {
    $path = (isset($this->configuration['dirName']) && isset($this->configuration['dirName'][$this->db]))
      ? $this->configuration['dirName'][$this->db]
      : $this->db;
    return $path;
  }

  protected function sqliteExists() {
    return file_exists($this->getFilePath('qa_catalogue.sqlite'));
  }

  private function getTagDefinition($tag) {
    if (is_array($this->fieldDefinitions->fields->{$tag})) {
      $tagDefinition = null;
      $tagDefinitionDefault = null;
      foreach ($this->fieldDefinitions->fields->{$tag} as $candidate) {
        if ($candidate->version == $this->marcVersion) {
          $tagDefinition = $candidate;
          break;
        } elseif ($candidate->version == 'MARC21') {
          $tagDefinitionDefault = $candidate;
        }
      }
      if (is_null($tagDefinition) && !is_null($tagDefinitionDefault))
        $tagDefinition = $tagDefinitionDefault;
    } else {
      $tagDefinition = $this->fieldDefinitions->fields->{$tag};
    }
    return $tagDefinition;
  }

  /**
   * @param $tagDefinition
   * @param $subfield
   * @return bool
   */
  private function hasVersionSpecificSolrField($tagDefinition, $subfield): bool
  {
    return !is_null($this->marcVersion)
      && isset($tagDefinition->versionSpecificSubfields)
      && isset($tagDefinition->versionSpecificSubfields->{$this->marcVersion})
      && isset($tagDefinition->versionSpecificSubfields->{$this->marcVersion}->{$subfield})
      && isset($tagDefinition->versionSpecificSubfields->{$this->marcVersion}->{$subfield}->solr);
  }

  public function selectLanguage($lang) {
    parse_str($_SERVER['QUERY_STRING'], $params);
    if (isset($lang)) {
      unset($params['lang']);
      $params['lang'] = $lang;
    }
    return http_build_query($params);
  }

  protected function readAnalysisParameters() {
    if (!is_null($this->parameterFile)) {
      $path = $this->getFilePath($this->parameterFile);
      if (file_exists($path)) {
        $this->analysisParameters = json_decode(file_get_contents($path));
        $this->analysisParameters->analysisTimestamp = date("Y-m-d H:i:s", filemtime($path));
      }
    }
  }

  protected function readIndexingParameters($paramFile) {
    $path = $this->getFilePath($paramFile);
    if (file_exists($path)) {
      $this->indexingParameters = json_decode(file_get_contents($path));
      $this->analysisParameters->analysisTimestamp = date("Y-m-d H:i:s", filemtime($path));
    }
  }

  /**
   * @param $solrField
   * @return array|false|string|string[]|null
   */
  private function getLabelForPica($solrField) {
    $isFull = preg_match('/_full$/', $solrField);
    if ($isFull) {
      $solrField = preg_replace('/_full$/', '', $solrField);
    }

    $solrField = $this->solrToPica($solrField);

    $field = $isFull ? $solrField : substr($solrField, 0, -1);
    $subfield = $isFull ? '' : substr($solrField, -1);
    $label = $isFull ? $field : sprintf('%s$%s', $field, $subfield);

    include_once('classes/pica/PicaSchemaManager.php');
    $manager = new PicaSchemaManager();
    $f = $manager->lookup($field);
    if ($f !== FALSE) {
      $label .= ': ' . $f->label;
      if ($subfield != ''
        && property_exists($f->subfields, $subfield)
        && isset($f->subfields->{$subfield}->label))
        $label .= ' / ' . $f->subfields->{$subfield}->label;
    }
    return $label;
  }

  /**
   * Get the list of groups
   * @return sorted array of groups
   */
  protected function readGroups(): array {
    $groups = readCsv($this->getFilePath('completeness-groups.csv'));
    usort($groups, function ($a, $b) {
      if ($a->group == $b->group) {
        return 0;
      }
      return ($a->group < $b->group) ? -1 : 1;
    });
    return $groups;
  }

  /**
   * @return Catalogue
   */
  public function getCatalogue(): Catalogue {
    return $this->catalogue;
  }

  protected function selectCurrentGroup() {
    foreach ($this->groups as $group) {
      if ($group->id == $this->groupId) {
        return $group;
        break;
      }
    }
  }

  protected function getRawGroupQuery() {
    if ($this->grouped && $this->groupId != 0)
      return sprintf('%s:%s',
        $this->picaToSolr(str_replace('$', '', $this->groupBy)) . '_ss',
        urlencode(sprintf('"%s"', $this->groupId)));
    return '';
  }

  protected function addParam(&$params, $object, $key, $defaulValue, $excludeKeys = []) {
    if (!in_array($key, $excludeKeys) && isset($object->{$key}) && $object->{$key} != $defaulValue)
      $params[] = sprintf('%s=%s', $key, urlencode($object->{$key}));
  }

  protected function getDbDir() {
    return sprintf('%s/%s', $this->configuration['dir'], $this->getDirName());
  }
}
