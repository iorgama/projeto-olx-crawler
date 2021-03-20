<?php

namespace projeto_olx\Model;

class Model
{

  private $conn;

  // Instance
  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function getModels($brand_id)
  {

    $stmt = $this->conn->prepare('SELECT * FROM model WHERE brand_id = :brand_id');
    $stmt->bindParam(':brand_id', $brand_id);
    $res = $stmt->execute();

    $data = array();

    while ($resp = $res->fetchArray(SQLITE3_ASSOC)) {
      array_push($data, $resp);
    }

    return $data;
  }
}
