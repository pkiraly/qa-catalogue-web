<?php

class IssuesDB extends SQLite3 {
  private $db;

  function __construct($dir) {
    $file = $dir . '/qa_catalogue.sqlite';
    $this->open($file);
  }

  public function getByCategoryAndType($categoryId, $typeId, $offset = 0, $limit) {
    $stmt = $this->prepare('SELECT *
       FROM issue_summary
       WHERE categoryId = :categoryId AND typeId = :typeId
       ORDER BY records DESC 
       LIMIT :limit
       OFFSET :offset
    ');
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);
    $stmt->bindValue(':offset', $offset, SQLITE3_INTEGER);
    $stmt->bindValue(':limit', $limit, SQLITE3_INTEGER);

    return $stmt->execute();
  }

  public function getByCategoryAndTypeGrouppedByPath($categoryId, $typeId, $offset = 0, $limit) {
    $stmt = $this->prepare('
      SELECT MarcPath as path, COUNT(MarcPath) AS c_variants, SUM(instances) AS c_instances, SUM(records) AS c_records
      FROM issue_summary
      WHERE categoryId = :categoryId AND typeId = :typeId
      GROUP BY MarcPath
      ORDER BY c_records DESC, MarcPath;
    ');
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);

    return $stmt->execute();
  }

  /**
  SELECT MarcPath, COUNT(MarcPath) AS c_variants, SUM(instances) AS c_instances, SUM(records) AS c_records
  FROM issue_summary
  WHERE categoryId = 2 AND typeId = 6
  GROUP BY MarcPath
  ORDER BY c_records DESC, MarcPath;
   */
}