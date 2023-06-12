<?php

class DataFetch {

  public static function readCount($countPath) {
    if (file_exists($countPath)) {
      $counts = readCsv($countPath);
      if (empty($counts)) {
        $count = trim(file_get_contents($countPath));
      } else {
        $counts = $counts[0];
        $count = isset($counts->processed) ? $counts->processed : $counts->total;
      }
    } else {
      $count = 0;
    }
    return intval($count);
  }

  public static function filterByGroup($statistics, $key, $groupId = NULL) {
    $filtered = [];
    foreach ($statistics as $record) {
      if ($record->groupId != $groupId)
        continue;
      unset($record->groupId);
      $filtered[$record->{$key}] = $record;
    }
    return $filtered;
  }

  public static function readIssueCsv($filepath, $keyField) {
    return readCsv($filepath, $keyField);
  }

  public static function readTotal($filepath, $total, $group = NULL) {
    if (!is_null($group)) {
      $statistics = DataFetch::filterByGroup(DataFetch::readIssueCsv($filepath, ''), 'type', $group->id);
      $total = $group->count;
    } else {
      $statistics = DataFetch::readIssueCsv($filepath, 'type');
    }

    foreach ($statistics as &$item) {
      $item->good = $total - $item->records;
      $item->goodPercent = ($item->good / $total) * 100;
      $item->bad = $item->records;
      $item->badPercent = ($item->bad / $total) * 100;
    }

    if (!isset($statistics["0"]))
      $statistics["0"] = (object)[
        "type" => "0",
        "instances" => "0",
        "records" => "0",
        "percent" => 0
      ];
      
      
    $result = (object)[
      "statistics" => $statistics,
      "summary" => (object)[
        "good" => $statistics[1]->good,
        "unclear" => $statistics[2]->good - $statistics[1]->good,
        "bad" => $statistics[2]->bad
      ]
    ];

    return $result;
  }
}
