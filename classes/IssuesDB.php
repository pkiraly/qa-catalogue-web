<?php

class IssuesDB extends SQLite3 {
  private $db;

  function __construct($dir) {
    $file = $dir . '/qa_catalogue.sqlite';
    $this->open($file);
  }

  public function getByCategoryAndType($categoryId, $typeId, $order = 'records DESC', $offset = 0, $limit) {
    $default_order = 'records DESC';
    if (!preg_match('/^(MarcPath|message|instances|records) (ASC|DESC)$/', $order))
      $order = $default_order;
    $stmt = $this->prepare('SELECT *
       FROM issue_summary
       WHERE categoryId = :categoryId AND typeId = :typeId
       ORDER BY ' . $order . ' 
       LIMIT :limit
       OFFSET :offset
    ');
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);
    $stmt->bindValue(':offset', $offset, SQLITE3_INTEGER);
    $stmt->bindValue(':limit', $limit, SQLITE3_INTEGER);

    return $stmt->execute();
  }

  public function getByCategoryTypeAndPath($categoryId, $typeId, $path, $order = 'records DESC', $offset = 0, $limit) {
    $default_order = 'records DESC';
    if (!preg_match('/^(MarcPath|message|instances|records) (ASC|DESC)$/', $order))
      $order = $default_order;
    $stmt = $this->prepare('SELECT *
       FROM issue_summary
       WHERE categoryId = :categoryId AND typeId = :typeId AND MarcPath = :path
       ORDER BY ' . $order . '
       LIMIT :limit
       OFFSET :offset
    ');
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);
    $stmt->bindValue(':path', $path, SQLITE3_TEXT);
    $stmt->bindValue(':offset', $offset, SQLITE3_INTEGER);
    $stmt->bindValue(':limit', $limit, SQLITE3_INTEGER);

    return $stmt->execute();
  }

  public function getByCategoryAndTypeGrouppedByPath($categoryId, $typeId, $order = 'records DESC', $offset = 0, $limit) {
    $default_order = 'records DESC';
    if (!preg_match('/^(path|variants|instances|records) (ASC|DESC)$/', $order))
      $order = $default_order;
    $stmt = $this->prepare('
SELECT s.MarcPath AS path, COUNT(DISTINCT(s.id)) AS variants, SUM(d.instances) AS instances, COUNT(DISTINCT(d.id)) AS records
FROM issue_summary AS s
LEFT JOIN issue_details AS d ON (s.id = d.errorId)
WHERE categoryId = :categoryId AND typeId = :typeId
GROUP BY s.MarcPath
ORDER BY ' . $order . ';');
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);

    return $stmt->execute();
  }
}