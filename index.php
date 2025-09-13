<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\HttpClient;
use GuzzleHttp\Promise;

$client = HttpClient::getInstance();

$promises = [
    $client->getAsync('http://httpbin.org/get?source=request1'),
    $client->getAsync('http://httpbin.org/get?source=request2'),
    $client->getAsync('http://httpbin.org/get?source=request3'),
];

$responses = Promise\all($promises)->wait();

foreach ($responses as $response) {
    echo $response->getBody() . "\n";
}