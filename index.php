<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/helpers.php';

use App\HttpClient;
use GuzzleHttp\Promise\Utils;

$client = HttpClient::getInstance();

// Measure Sequential Execution
measure_execution_time('Sequential Execution', function () use ($client) {
    for ($i = 1; $i <= 25; $i++) {
        $client->getAsync("https://jsonplaceholder.typicode.com/posts/{$i}")->wait();
    }
});

// Measure Parallel Execution
measure_execution_time('Parallel Execution', function () use ($client) {
    $promises = [];
    for ($i = 1; $i <= 25; $i++) {
        $promises[] = $client->getAsync("https://jsonplaceholder.typicode.com/posts/{$i}");
    }
    Utils::all($promises)->wait();
});
