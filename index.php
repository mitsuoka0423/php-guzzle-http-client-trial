<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\HttpClient;
use GuzzleHttp\Promise\Utils;

$client = HttpClient::getInstance();

for ($i = 1; $i <= 25; $i++) {
    $client->getAsync("https://jsonplaceholder.typicode.com/posts/{$i}")->wait();
}

$promises = [];

for ($i = 1; $i <= 25; $i++) {
    $promises[] = $client->getAsync("https://jsonplaceholder.typicode.com/posts/{$i}");
}

$responses = Utils::all($promises)->wait();

$promises = [];

for ($i = 1; $i <= 25; $i++) {
    $promises[] = $client->getAsync("https://jsonplaceholder.typicode.com/posts/{$i}");
}

$responses = Utils::all($promises)->wait();

// foreach ($responses as $response) {
//     echo $response->getBody() . "\n";
// }