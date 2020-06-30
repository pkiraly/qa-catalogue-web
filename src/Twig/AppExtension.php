<?php

namespace App\Twig;

use App\Controller\BaseController;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


class AppExtension extends AbstractExtension
{
  public function getFunctions() {
    return [
      new TwigFunction('gettype', 'gettype'),
      new TwigFunction('json_encode', 'json_encode'),

      new TwigFunction('getFacetLabel', [$this, 'getFacetLabel']),
      new TwigFunction('getRecord', [$this, 'getRecord']),
      new TwigFunction('getField', [$this, 'getField']),
      new TwigFunction('getFirstField', [$this, 'getFirstField']),
      new TwigFunction('type2icon', [$this, 'type2icon']),
      new TwigFunction('to_array', [$this, 'to_array']),
      new TwigFunction('opacLink', [$this, 'opacLink']),
      new TwigFunction('hasPublication', [$this, 'hasPublication']),
      new TwigFunction('hasPhysicalDescription', [$this, 'hasPhysicalDescription']),
      new TwigFunction('hasMainPersonalName', [$this, 'hasMainPersonalName']),
      new TwigFunction('hasSimilarBooks', [$this, 'hasSimilarBooks']),
      new TwigFunction('getMarcFields', [$this, 'getMarcFields']),
      new TwigFunction('getAllSolrFields', [$this, 'getAllSolrFields']),
    ];
  }

  public function to_array($obj) {
    return (array) $obj;
  }

  public function type2icon($type) {
    switch ($type) {
      case 'Books': $icon = 'book'; break;
      case 'Maps': $icon = 'map'; break;
      case 'Computer Files': $icon = 'save'; break;
      case 'Music': $icon = 'music'; break;
      case 'Continuing Resources': $icon = 'clone'; break;
      case 'Visual Materials': $icon = 'image'; break;
      case 'Mixed Materials': $icon = 'archive'; break;
    }
    return $icon;
  }

  public function getFacetLabel($facet) {
    $ctr = new BaseController();
    return $ctr->getFacetLabel($facet);
  }

  public function getRecord($doc) {
    return json_decode($doc->record_sni);
  }

  public function getField($record, $fieldName) {
    if (isset($record->{$fieldName}))
      return $record->{$fieldName}[0];
    return null;
  }

  function hasMainPersonalName($doc) {
    return (!empty($doc->{'100a_MainPersonalName_personalName_ss'})
      || !empty($doc->{'100d_MainPersonalName_dates_ss'}));
  }

  public function getFirstField($doc, $fieldName, $withSpaceReplace = FALSE) {
    $value = null;
    if (isset($doc->{$fieldName})) {
      $value = $doc->{$fieldName}[0];
      if ($withSpaceReplace) {
        $value = str_replace(" ", "&nbsp;", $value);
      }
    }
    return $value;
  }

  function hasPublication($doc) {
    return (!empty($doc->{'260a_Publication_place_ss'})
      || !empty($doc->{'260b_Publication_agent_ss'})
      || !empty($doc->{'260c_Publication_date_ss'}));
  }

  function hasPhysicalDescription($doc) {
    return (!empty($doc->{'300a_PhysicalDescription_extent_ss'})
      || !empty($doc->{'300c_PhysicalDescription_dimensions_ss'}));
  }

  public function opacLink($doc, $id) {
    global $configuration;

    $ctr = new BaseController();
    // global $core, $configuration;

    $catalogue = $ctr->getDb() == 'metadata-qa' && isset($configuration['catalogue'])
      ? $configuration['catalogue']
      : $ctr->getDb();

    if ($catalogue == 'szte')
      return 'http://qulto.bibl.u-szeged.hu/record/-/record/' . trim($id);
    else if ($catalogue == 'mokka')
      return 'http://mokka.hu/web/guest/record/-/record/' . trim($id);
    else if ($catalogue == 'cerl') {
      $identifier = '';
      foreach ($doc->{'035a_SystemControlNumber_ss'} as $tag35a) {
        if (!preg_match('/OCoLC/', $tag35a)) {
          $identifier = $tag35a;
          break;
        }
      }
      return 'http://hpb.cerl.org/record/' . $identifier;
    } else if ($catalogue == 'dnb')
      return 'http://d-nb.info/' . trim($id);
    else if ($catalogue == 'gent')
      return 'https://lib.ugent.be/catalog/rug01:' . trim($id);
    else if ($catalogue == 'loc')
      return 'https://lccn.loc.gov/' . trim($id);
    else if ($catalogue == 'mtak')
      return 'https://mta-primotc.hosted.exlibrisgroup.com/permalink/f/1s1uct8/36MTA' . trim($id);
    else if ($catalogue == 'bayern')
      return 'http://gateway-bayern.de/' . trim($id);
    else if ($catalogue == 'bnpl') {
      foreach ($doc->{'035a_SystemControlNumber_ss'} as $tag35a) {
        if (preg_match('/^\d/', $tag35a)) {
          $identifier = $tag35a;
          break;
        }
      }
      return sprintf(
        'https://katalogi.bn.org.pl/discovery/fulldisplay?docid=alma%s&context=L&vid=48OMNIS_NLOP:48OMNIS_NLOP&search_scope=NLOP_IZ_NZ&tab=LibraryCatalog&lang=pl',
        trim($identifier));

    } else if ($catalogue == 'nfi') {
      // return 'https://melinda.kansalliskirjasto.fi/byid/' . trim($id);
      return 'https://kansalliskirjasto.finna.fi/Search/Results?bool0[]=OR&lookfor0[]=ctrlnum%3A%22FCC'
        . trim($id)
        . '%22&lookfor0[]=ctrlnum%3A%22(FI-MELINDA)'
        . trim($id)
        . '%22';
    } else if ($catalogue == 'gbv') {
      return sprintf('https://kxp.k10plus.de/DB=2.1/PPNSET?PPN=%s', trim($id));
    }

    return '';
  }

  function hasSimilarBooks($doc) {
    return (!empty($doc->{'9129_WorkIdentifier_ss'})
      || !empty($doc->{'9119_ManifestationIdentifier_ss'}));
  }

  function getMarcFields($doc) {
    if (is_string($doc->record_sni)) {
      $marc = json_decode($doc->record_sni);
    } else {
      $marc = json_decode($doc->record_sni[0]);
    }

    $rows = [];
    foreach ($marc as $tag => $value) {
      if (preg_match('/^00/', $tag)) {
        $rows[] = [$tag, '', '', '', $value];
      } else if ($tag == 'leader') {
        $rows[] = ['LDR', '', '', '', $value];
      } else {
        foreach ($value as $instance) {
          $firstRow = [$tag, $instance->ind1, $instance->ind2];
          $i = 0;
          foreach ($instance->subfields as $code => $s_value) {
            $i++;
            if ($i == 1) {
              $firstRow[] = '$' . $code;
              $firstRow[] = $s_value;
              $rows[] = $firstRow;
            } else {
              $rows[] = ['', '', '', '$' . $code, $s_value];
            }
          }
        }
      }
    }
    return $rows;
  }

  function getAllSolrFields($doc) {
    $fields = [];
    foreach ($doc as $label => $value) {
      if ($label == 'record_sni' || $label == '_version_') {
        continue;
      }

      $fields[] = (object)['label' => $label, 'value' => $value];
    }
    return $fields;
  }

}