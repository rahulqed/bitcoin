<?php

namespace Drupal\bitconverter\Services;
use Drupal\Component\Serialization\Json;


class BitService{
   /**
   * @var \GuzzleHttp\Client
   */
    protected $client;

    //protected $settings;

    public function __construct($http_client_factory){
        $this->client = $http_client_factory->fromOptions([
          'base_uri' => 'http://data.fixer.io/api/',
        ]);
    }

    // public function __construct(){
    //     $this->settings = \Drupal::config('DemoForm.settings');
    //}

  public function getDetails($symbols, $access_key){
      $response = $this->client->get('latest', [
        'query' => [
          'access_key' => $access_key,
          'symbols' => $symbols,
          ]
        ]);
      $parsed_json = Json::decode($response->getBody());
      return $parsed_json;
    }

}

// // "latest" endpoint - request the most recent exchange rate data

// http://data.fixer.io/api/latest

//     ? access_key = YOUR_ACCESS_KEY
//     & base = GBP
//     & symbols = USD,AUD,CAD,PLN,MXN

// // Danish, click on the URL above to get the most recent exchange
// // rates for USD, AUD, CAD, PLN and MXN

