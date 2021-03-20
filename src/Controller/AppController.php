<?php

declare(strict_types=1);

namespace projeto_olx\Controller;

use projeto_olx\Config\Database;

use projeto_olx\Model\Brand;
use projeto_olx\Model\Model;

class AppController
{

  private $brand;
  private $db;
  private $model;

  function __construct()
  {
    $this->db = new Database();
  }

  public function getBrands()
  {
    $this->brand = new Brand($this->db->getConnection());
    return json_encode($this->brand->getBrands());
  }

  public function getModels($brandId)
  {
    $this->model = new Model($this->db->getConnection());
    return json_encode($this->model->getModels($brandId));
  }
}
