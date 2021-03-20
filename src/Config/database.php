<?php

namespace projeto_olx\Config;

class Database
{
  private $database_name = "../projetodb.sqlite";

  public $conn;

  public function getConnection()
  {
    $this->conn = null;
    try {
      $this->conn = new \SQLite3($this->database_name, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
    } catch (\Exception $exception) {
      echo $exception->getMessage();
    }
    return $this->conn;
  }
}
