<?php

namespace projeto_olx\Model;

class Brand
{

  private $conn;

  // Instance
  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function getBrands()
  {

    $stmt = $this->conn->prepare("SELECT * FROM brand");
    $res = $stmt->execute();
    $data = array();

    while ($resp = $res->fetchArray(SQLITE3_ASSOC)) {
      array_push($data, $resp);
    }

    return $data;
  }
}
