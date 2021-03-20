<?php

namespace projeto_olx\Config;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ResponseInterface;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlObservers\CrawlObserver;


class CrawlerUtils
{
  static function  formatUrl($brand, $model)
  {
    return 'https://rs.olx.com.br/regioes-de-porto-alegre-torres-e-santa-cruz-do-sul/autos-e-pecas/carros-vans-e-utilitarios/' . $brand . '/' . $model;
  }

  static function  startCrawler($brand, $model, $modelId)
  {
    $url = self::formatUrl($brand, $model);
    Crawler::create()
      ->setCrawlObserver(new OlxCrawler($modelId))
      ->setMaximumDepth(1)
      ->setTotalCrawlLimit(1)
      ->startCrawling($url);
  }
}


class OlxCrawler extends CrawlObserver
{

  function __construct($modelId)
  {
    $this->modelId = $modelId;
  }

  public function willCrawl(UriInterface $url)
  {
  }

  public function crawled(UriInterface $url, ResponseInterface $response, ?UriInterface $foundOnUrl = null): void
  {

    $db = new \SQLite3('../projetodb.db',  SQLITE3_OPEN_READWRITE);

    $doc = new \DOMDocument();
    @$doc->loadHTML($response->getBody());
    $brandModelLists = $doc->getElementById('ad-list');

    if (!is_null($brandModelLists)) {
      //Pass through each <li> tag
      foreach ($brandModelLists->getElementsByTagName('li') as $li) {
        //Pass through each <a> tag inside the li and extract the title of each ad
        foreach ($li->getElementsByTagName('a') as $links) {
          $adCrawled = $links->getAttribute("title");

          $sql = ('INSERT INTO ad (description, model_id, created_at) VALUES (:adCrawled, :modelId, datetime())');
          $stmt = $db->prepare($sql);
          $stmt->bindValue(':adCrawled', $adCrawled);
          $stmt->bindValue(':modelId', $this->modelId);
          $stmt->execute();
        }
      }
    }
  }

  public function crawlFailed(UriInterface $url, RequestException $requestException, ?UriInterface $foundOnUrl = null): void
  {
    echo $requestException->getMessage() . PHP_EOL;
  }
}
