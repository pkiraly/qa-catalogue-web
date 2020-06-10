<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends BaseController
{
  /**
   * @Route("/search", name="search")
   */
  public function run(Request $request) {
    $errorId = $request->query->get('error-id');
    if (!is_null($errorId) && preg_match('/^\d+$/', $errorId)) {
      $ids = $this->getRecordIdsByErrorId($errorId);
      $query = join(' OR ', $ids);
    } else {
      $query = $request->query->get('query');
    }

    $this->selectTab('search');
    return $this->render('search/main.html.twig', [
      'commons' => $this->commons,
      'number' => $query,
    ]);
  }

  public function getRecordIdsByErrorId($errorId) {
    $elementsFile = $this->getDir() . '/issue-collector.csv';
    $recordIds = [];
    $types = [];
    $max = 0;
    if (file_exists($elementsFile)) {
      // $keys = ['errorId', 'recordIds']
      $lineNumber = 0;
      $header = [];
      $in = fopen($elementsFile, "r");
      while (($line = fgets($in)) != false) {
        if (count($recordIds) < 10) {
          $lineNumber++;
          if ($lineNumber == 1) {
            $header = str_getcsv($line);
          } else {
            if (preg_match('/^' . $errorId . ',/', $line)) {
              $values = str_getcsv($line);
              $record = (object)array_combine($header, $values);
              $recordIds = explode(';', $record->recordIds);
              $recordIds = array_slice($recordIds, 0, 10);
              break;
            }
          }
        }
      }
      fclose($in);
    } else {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    }

    return $recordIds;
  }
}