<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/helpers.php';

use App\HttpClient;
use App\Logger;
use App\LogMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\Utils;

// Measure New Client Each Request Execution
measure_execution_time('New Client Each Request Execution', function () {
    $promises = [];
    for ($i = 1; $i <= 25; $i++) {
        $stack = HandlerStack::create();
        $stack->push(LogMiddleware::create(new Logger()));
        $client = new Client(['handler' => $stack]);

        $promises[] = $client->getAsync("https://jsonplaceholder.typicode.com/posts/{$i}");
    }
    Utils::all($promises)->wait();
});

$client = HttpClient::getInstance();

// Measure Sequential Execution
measure_execution_time('Sequential Execution', function () use ($client) {
    for ($i = 1; $i <= 25; $i++) {
        $client->getAsync("https://jsonplaceholder.typicode.com/posts/{$i}")->wait();
    }
});

$client = HttpClient::getInstance();

// Measure Parallel Execution
measure_execution_time('Parallel Execution', function () use ($client) {
    $promises = [];
    for ($i = 1; $i <= 25; $i++) {
        $promises[] = $client->getAsync("https://jsonplaceholder.typicode.com/posts/{$i}");
    }
    Utils::all($promises)->wait();
});
