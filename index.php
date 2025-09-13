<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/helpers.php';

use App\HttpClient;
use App\Logger;
use App\LogMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\Utils;

// Define the base URL for the test server
const TEST_SERVER_BASE_URL = 'http://localhost:8000';

// Measure New Client Each Request Execution
measure_execution_time('New Client Each Request Execution', function () {
    $promises = [];
    for ($i = 1; $i <= 25; $i++) {
        $stack = HandlerStack::create();
        $stack->push(LogMiddleware::create(new Logger()));
        $client = new Client(['handler' => $stack]);

        $promises[] = $client->getAsync(TEST_SERVER_BASE_URL . "/?min_delay=0.01&max_delay=0.1");
    }
    Utils::all($promises)->wait();
});

$client = HttpClient::getInstance();

// Measure Sequential Execution
measure_execution_time('Sequential Execution', function () use ($client) {
    for ($i = 1; $i <= 25; $i++) {
        $client->getAsync(TEST_SERVER_BASE_URL . "/?min_delay=0.01&max_delay=0.1")->wait();
    }
});

$client = HttpClient::getInstance();

// Measure Parallel Execution
measure_execution_time('Parallel Execution', function () use ($client) {
    $promises = [];
    for ($i = 1; $i <= 25; $i++) {
        $promises[] = $client->getAsync(TEST_SERVER_BASE_URL . "/?min_delay=0.01&max_delay=0.1");
    }
    Utils::all($promises)->wait();
});