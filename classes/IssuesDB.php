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

  public function getByCategoryTypeAndGroup($categoryId, $typeId, $groupId = '', $order = 'records DESC', $offset = 0, $limit) {
    $default_order = 'records DESC';
    if (!preg_match('/^(MarcPath|message|instances|records) (ASC|DESC)$/', $order))
      $order = $default_order;
    $groupCriterium = ($groupId !== '') ? ' AND groupId = :groupId' : '';

    $stmt = $this->prepare('SELECT *
       FROM issue_summary
       WHERE categoryId = :categoryId AND typeId = :typeId' . $groupCriterium . '
       ORDER BY ' . $order . ' 
       LIMIT :limit
       OFFSET :offset
    ');
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);
    $stmt->bindValue(':offset', $offset, SQLITE3_INTEGER);
    $stmt->bindValue(':limit', $limit, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_TEXT);

    return $stmt->execute();
  }

  public function getByCategoryTypeAndGroupCount($categoryId, $typeId, $groupId = '') {
    $groupCriterium = ($groupId !== '') ? ' AND groupId = :groupId' : '';
    $stmt = $this->prepare('SELECT COUNT(*) AS count
       FROM issue_summary
       WHERE categoryId = :categoryId AND typeId = :typeId ' . $groupCriterium
    );
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_TEXT);

    return $stmt->execute();
  }

  public function getByCategoryTypePathAndGroup($categoryId, $typeId, $path = null, $groupId = '', $order = 'records DESC', $offset = 0, $limit) {
    $default_order = 'records DESC';
    if (!preg_match('/^(MarcPath|message|instances|records) (ASC|DESC)$/', $order))
      $order = $default_order;
    $groupCriterium = ($groupId !== '') ? ' AND groupId = :groupId' : '';
    $stmt = $this->prepare('SELECT *
       FROM issue_summary
       WHERE categoryId = :categoryId AND typeId = :typeId AND MarcPath = :path' . $groupCriterium . '
       ORDER BY ' . $order . '
       LIMIT :limit
       OFFSET :offset
    ');
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);
    $stmt->bindValue(':path', $path, SQLITE3_TEXT);
    $stmt->bindValue(':offset', $offset, SQLITE3_INTEGER);
    $stmt->bindValue(':limit', $limit, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_TEXT);

    return $stmt->execute();
  }

  public function getByCategoryTypePathAndGroupCount($categoryId, $typeId, $path, $groupId = '') {
    $groupCriterium = ($groupId !== '') ? ' AND groupId = :groupId' : '';
    $stmt = $this->prepare('SELECT COUNT(*) AS count
       FROM issue_summary
       WHERE categoryId = :categoryId AND typeId = :typeId AND MarcPath = :path' . $groupCriterium
    );
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);
    $stmt->bindValue(':path', $path, SQLITE3_TEXT);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_TEXT);

    return $stmt->execute();
  }

  public function getByCategoryAndTypeGroupedByPath($categoryId, $typeId, $groupId = '', $order = 'records DESC', $offset = 0, $limit) {
    $default_order = 'records DESC';
    if (!preg_match('/^(path|variants|instances|records) (ASC|DESC)$/', $order))
      $order = $default_order;
    $groupCriterium = ($groupId !== '') ? ' AND groupId = :groupId' : '';
    $stmt = $this->prepare(
      'SELECT path, variants, instances, records
      FROM issue_groups AS s
      WHERE categoryId = :categoryId AND typeId = :typeId' . $groupCriterium . '
      ORDER BY ' . $order
    );
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_TEXT);
    // error_log(preg_replace('/[\s\n]+/', ' ', $stmt->getSQL(true)));

    return $stmt->execute();
  }

  public function getByCategoryAndTypeGroupedByPathCount($categoryId, $typeId, $groupId = '') {
    $groupCriterium = ($groupId !== '') ? ' AND groupId = :groupId' : '';
    $stmt = $this->prepare(
      'SELECT COUNT(*) AS count
      FROM issue_groups AS s
      WHERE categoryId = :categoryId AND typeId = :typeId' . $groupCriterium
    );
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_TEXT);

    return $stmt->execute();
  }

  public function getRecordNumberByTypeGrouped($typeId, $groupId = '') {
    $groupCriterium = ($groupId !== '') ? ' AND groupId = :groupId' : '';
    $stmt = $this->prepare(
      'SELECT record_nr AS count
      FROM issue_grouped_types AS s
      WHERE typeId = :typeId' . $groupCriterium
    );
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_TEXT);

    return $stmt->execute();
  }

  public function getRecordNumberByCategoryGrouped($categoryId, $groupId = '') {
    $groupCriterium = ($groupId !== '') ? ' AND groupId = :groupId' : '';
    $stmt = $this->prepare(
      'SELECT record_nr AS count
      FROM issue_grouped_types AS s
      WHERE categoryId = :categoryId' . $groupCriterium
    );
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_TEXT);

    return $stmt->execute();
  }

  public function getRecordNumberByPathGrouped($typeId, $groupId = '') {
    $groupCriterium = ($groupId !== '') ? ' AND groupId = :groupId' : '';
    $stmt = $this->prepare(
      'SELECT record_nr AS count
      FROM issue_grouped_types AS s
      WHERE categoryId = :categoryId' . $groupCriterium
    );
    $stmt->bindValue(':categoryId', $typeId, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_TEXT);

    return $stmt->execute();
  }

  public function getRecordNumberAndVariationsForPathGrouped($typeId, $groupId = '', $order = 'records DESC', $offset = 0, $limit) {
    $groupCriterium = ($groupId !== '') ? ' AND p.groupId = :groupId' : '';
    $default_order = 'records DESC';
    if (!preg_match('/^(path|variants|instances|records) (ASC|DESC)$/', $order))
      $order = $default_order;
    $stmt = $this->prepare(
      'SELECT p.path,
              p.record_nr AS records,
              p.instance_nr AS instances,
              COUNT(s.id) AS variants
       FROM issue_grouped_paths p 
       LEFT JOIN issue_summary s 
         ON (p.groupId = s.groupId AND p.typeId = s.typeId AND p.path = s.MarcPath) 
       WHERE p.typeId = :typeId' . $groupCriterium .' 
       GROUP BY p.path
       ORDER BY ' . $order
    );
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_INTEGER);

    return $stmt->execute();
  }

  public function getRecordIdsByErrorIdCount($errorId, $groupId = '') {
    if ($groupId === '')
      $sql = 'SELECT COUNT(distinct(id)) AS count FROM issue_details WHERE errorId = :errorId';
    else
      $sql = 'SELECT COUNT(distinct(id)) AS count 
              FROM issue_details JOIN id_groupid USING (id) 
              WHERE errorId = :errorId AND groupId = :groupId';
    $stmt = $this->prepare($sql);
    $stmt->bindValue(':errorId', $errorId, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_INTEGER);
    error_log(preg_replace('/[\s\n]+/', ' ', $stmt->getSQL(true)));

    return $stmt->execute();
  }

  public function getRecordIdsByErrorId($errorId, $groupId = '', $offset = 0, $limit = -1) {
    if ($groupId === '')
      $sql = 'SELECT distinct(id) FROM issue_details WHERE errorId = :id';
    else
      $sql = 'SELECT distinct(id) FROM issue_details JOIN id_groupid USING (id) WHERE errorId = :id AND groupId = :groupId';
    return $this->getRecordIdsById($sql, $errorId, $groupId, $offset, $limit);
  }

  public function getRecordIdsByCategoryIdCount($categoryId, $groupId = '') {
    if ($groupId === '')
      $sql = 'SELECT COUNT(distinct(id)) AS count
              FROM issue_details
              WHERE errorId IN (SELECT distinct(id) FROM issue_summary WHERE categoryId = :categoryId)';
    else
      $sql = 'SELECT COUNT(distinct(id)) AS count 
              FROM issue_details JOIN id_groupid USING(id) 
              WHERE errorId IN (SELECT distinct(id) FROM issue_summary WHERE categoryId = :categoryId AND groupId = :groupId) 
                AND groupId = :groupId';
    $stmt = $this->prepare($sql);
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_TEXT);

    // error_log(preg_replace('/[\s\n]+/', ' ', $stmt->getSQL(true)));

    return $stmt->execute();
  }

  public function getRecordIdsByCategoryId($categoryId, $groupId = '', $offset = 0, $limit = -1) {
    if ($groupId === '')
      $sql = 'SELECT distinct(id)
              FROM issue_details
              WHERE errorId IN (SELECT distinct(id) FROM issue_summary WHERE categoryId = :id)';
    else
      $sql = 'SELECT distinct(id)
              FROM issue_details JOIN id_groupid USING(id)
              WHERE errorId IN (SELECT distinct(id) FROM issue_summary WHERE categoryId = :id AND groupId = :groupId)
                AND groupId = :groupId';
    return $this->getRecordIdsById($sql, $categoryId, $groupId, $offset, $limit);
  }

  public function getErrorIdsByCategoryId($categoryId, $groupId = '') {
    if ($groupId === '')
      $sql = 'SELECT distinct(id) FROM issue_summary WHERE categoryId = :categoryId';
    else
      $sql = 'SELECT distinct(id) FROM issue_summary WHERE categoryId = :categoryId AND groupId = :groupId';

    $stmt = $this->prepare($sql);
    $stmt->bindValue(':categoryId', $categoryId, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_INTEGER);

    // error_log(preg_replace('/[\s\n]+/', ' ', $stmt->getSQL(true)));
    return $stmt->execute();
  }

  public function getErrorIdsByTypeId($typeId, $groupId = '') {
    if ($groupId === '')
      $sql = 'SELECT distinct(id) FROM issue_summary WHERE typeId = :typeId';
    else
      $sql = 'SELECT distinct(id) FROM issue_summary WHERE typeId = :typeId AND groupId = :groupId';

    $stmt = $this->prepare($sql);
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_INTEGER);

    // error_log(preg_replace('/[\s\n]+/', ' ', $stmt->getSQL(true)));
    return $stmt->execute();
  }

  public function getRecordIdsByTypeIdCount($typeId, $groupId = '') {
    $groupCriterium = ($groupId !== '') ? ' AND groupId = :groupId' : '';
    $stmt = $this->prepare(
      'SELECT COUNT(distinct(id)) AS count
       FROM issue_details
       WHERE errorId IN 
            (SELECT distinct(id) FROM issue_summary WHERE typeId = :typeId' . $groupCriterium . ')');
    $stmt->bindValue(':typeId', $typeId, SQLITE3_INTEGER);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_TEXT);

    // error_log(preg_replace('/[\s\n]+/', ' ', $stmt->getSQL(true)));

    return $stmt->execute();
  }

  public function getRecordIdsByTypeId($typeId, $groupId = '', $offset = 0, $limit = -1) {
    $groupCriterium = ($groupId !== '') ? ' AND groupId = :groupId' : '';
    $sql = 'SELECT distinct(id)
       FROM issue_details
       WHERE errorId IN 
            (SELECT distinct(id) FROM issue_summary WHERE typeId = :id' . $groupCriterium . ')';
    return $this->getRecordIdsById($sql, $typeId, $groupId, $offset, $limit);
  }

  private function getRecordIdsById($sql, $id, $groupId = '', $offset = 0, $limit = -1) {
    if ($limit != -1) {
      $sql .= ' LIMIT :limit OFFSET :offset';
    }
    $stmt = $this->prepare($sql);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    if ($limit != -1) {
      $stmt->bindValue(':limit', $limit, SQLITE3_INTEGER);
      $stmt->bindValue(':offset', $offset, SQLITE3_INTEGER);
    }
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_INTEGER);

    error_log(preg_replace('/[\s\n]+/', ' ', $stmt->getSQL(true)));

    return $stmt->execute();
  }

  public function hasMarcElementTable() {
    $stmt = $this->prepare('SELECT COUNT(name) AS count FROM sqlite_master WHERE type = :table AND name = :tableName');
    $stmt->bindValue(':table', 'table', SQLITE3_TEXT);
    $stmt->bindValue(':tableName', 'marc_elements', SQLITE3_TEXT);
    // error_log(preg_replace('/[\s\n]+/', ' ', $stmt->getSQL(true)));
    return $stmt->execute();
  }

  public function getMarcElements($documenttype, $groupId = '') {
    $groupCriterium = ($groupId !== '') ? ' AND groupId = :groupId' : '';
    $stmt = $this->prepare('SELECT * 
      FROM marc_elements
      WHERE documenttype = :documenttype' . $groupCriterium . '
      ORDER BY packageid, sortkey');
    $stmt->bindValue(':documenttype', $documenttype, SQLITE3_TEXT);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_INTEGER);
    error_log(preg_replace('/[\s\n]+/', ' ', $stmt->getSQL(true)));
    return $stmt->execute();
  }

  public function getDocumentTypes($groupId = '') {
    $groupCriterium = ($groupId !== '') ? ' AND groupId = :groupId' : '';
    $stmt = $this->prepare('SELECT documenttype, COUNT(documenttype) AS count 
      FROM marc_elements
      WHERE documenttype != :documenttype' . $groupCriterium . '
      GROUP BY documenttype
      ORDER BY count DESC');
    $stmt->bindValue(':documenttype', "all", SQLITE3_TEXT);
    if ($groupId !== '')
      $stmt->bindValue(':groupId', $groupId, SQLITE3_INTEGER);
    error_log(preg_replace('/[\s\n]+/', ' ', $stmt->getSQL(true)));
    return $stmt->execute();
  }


  // select * from issue_details JOIN id_groupid USING (id) WHERE errorId = 1 AND groupId = 77 LIMIT 30;

  public function fetchAll(SQLite3Result $result, $name): array {
    $values = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $values[] = $row[$name];
    }
    return $values;
  }

}