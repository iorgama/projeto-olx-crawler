<?php

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ResponseInterface;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

require_once __DIR__ . '/../vendor/autoload.php';

class OlxCrawler extends CrawlObserver
{
  public function willCrawl(UriInterface $url)
  {
  }

  public function crawled(UriInterface $url, ResponseInterface $response, ?UriInterface $foundOnUrl = null): void
  {

    $brandModel = explode('/', $url);
    $brandModel = array_reverse($brandModel);
    $model = $brandModel[0];
    $brand = $brandModel[1];

    $filename = $brand . '_' . $model . '.csv';

    $model_id = 5;

    //Verifica se existe pelo menos uma descrição de anúncio relacionado ao modelo do carro
    $db = new SQLite3('projetodb.sqlite');
    $stm = $db->prepare('SELECT description FROM ad WHERE model_id = :model_id');
    $stm->bindParam(':model_id', $model_id);
    $res = $stm->execute();

    if ($res->fetchArray() > 0) {
      echo 'Já existe';
    } else {
      //se não existir, então salva as informações no banco
      $doc = new \DOMDocument();
      @$doc->loadHTML($response->getBody());
      $brandModelLists = $doc->getElementById('ad-list');

      if (!is_null($brandModelLists)) {
        //Passa através de cada tag <li>  
        foreach ($brandModelLists->getElementsByTagName('li') as $li) {
          //Passa através de cada tag <a> dentro da li e extraí o título de cada anúncio
          foreach ($li->getElementsByTagName('a') as $links) {
            $adCrawled = $links->getAttribute("title");
            $db->query('INSERT INTO "ad" ("description", "model_id", "created_at") VALUES ($adCrawled, 5, datetime())');
          }
        }
      }
    }
  }

  public function crawlFailed(UriInterface $url, RequestException $requestException, ?UriInterface $foundOnUrl = null): void
  {
    echo $requestException->getMessage() . PHP_EOL;
  }
}


//marcas possíveis de serem pesquisadas
$marca = ['ford', 'fiat', 'peugeot', 'toyota'];

//modelos
$ford = ['ecosport', 'ka', 'mustang'];
$fiat = ['arco', 'idea', 'siena'];
$peugeot = ['208', '408', '207'];
$toyota = ['yaris', 'corolla', 'hilux'];


$url = 'https://rs.olx.com.br/regioes-de-porto-alegre-torres-e-santa-cruz-do-sul/autos-e-pecas/carros-vans-e-utilitarios/fiat/idea';

Crawler::create()
  ->setCrawlObserver(new OlxCrawler())
  ->setMaximumDepth(1)
  ->setTotalCrawlLimit(1)
  ->startCrawling($url);
