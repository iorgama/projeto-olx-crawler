<?php

namespace projeto_olx\Model;

use projeto_olx\Config;

class Ad
{

  private $conn;

  // Instance
  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function getAds($modelId)
  {

    $stmt = $this->conn->prepare('SELECT description FROM ad WHERE model_id = :model_id');
    $stmt->bindParam(':model_id', $modelId);
    $resp = $stmt->execute();
    $data = array();

    //Checks if there are already advertisements for this car model in the database.
    if ($resp->fetchArray(SQLITE3_ASSOC) > 0) {
      while ($r = $resp->fetchArray(SQLITE3_ASSOC)) {
        array_push($data, $r);
      }
    } else {
      //If there are no advertisements, then save the information in the database.
      $stmt =  $this->conn->prepare('SELECT 
                        model.id as modelId, model.description as modelDescription, brand.id, brand.description as brandDescription
                        FROM model 
                        INNER JOIN brand 
                          on brand.id = model.brand_id 
                        WHERE model.id = :model_id');
      $stmt->bindParam(':model_id', $modelId);
      $res = $stmt->execute();

      $data = array();
      $i = 0;
      while ($resp = $res->fetchArray(SQLITE3_ASSOC)) {
        $modelDescription = $resp['modelDescription'];
        $brandDescription = $resp['brandDescription'];
        $modelId          = $resp['modelId'];
        $i++;
      }

      Config\CrawlerUtils::startCrawler($brandDescription, $modelDescription, $modelId);

      $stmt = $this->conn->prepare('SELECT description FROM ad WHERE model_id = :model_id');
      $stmt->bindParam(':model_id', $modelId);
      $resp = $stmt->execute();
      $data = array();

      while ($r = $resp->fetchArray(SQLITE3_ASSOC)) {
        array_push($data, $r);
      }
    }

    return $data;
  }
}
