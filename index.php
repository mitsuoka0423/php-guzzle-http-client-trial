<?php

namespace App;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/helpers.php';

use App\HttpClient;
use App\Logger;
use App\LogMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\Utils;

const TEST_SERVER_BASE_URL = 'http://localhost:8000/';
const NUM_OF_TRIALS = 10;
const DELAY_COEFFICIENT = 0.25;

$logger = new Logger();

$logger->log("回数：" . NUM_OF_TRIALS . " / 遅延係数：" . DELAY_COEFFICIENT);

// Measure New Client Each Request Execution
measure_execution_time('New Client Each Request Execution', function () use ($logger) {
    $promises = [];
    for ($i = 1; $i <= NUM_OF_TRIALS; $i++) {
        $stack = HandlerStack::create();
        $stack->push(LogMiddleware::create($logger));
        $client = new Client(['handler' => $stack]);

        $delay = $i * DELAY_COEFFICIENT;
        $promises[] = $client->getAsync(TEST_SERVER_BASE_URL . "?delay={$delay}");
    }
    Utils::all($promises)->wait();
});
$logger->log('想定処理時間: ' . expected_execution_time('sequential', NUM_OF_TRIALS, DELAY_COEFFICIENT));

$client = HttpClient::getInstance();
measure_execution_time('Sequential Execution', function () use ($client) {
    for ($i = 1; $i <= NUM_OF_TRIALS; $i++) {
        $delay = $i * DELAY_COEFFICIENT;
        $client->getAsync(TEST_SERVER_BASE_URL . "?delay={$delay}")->wait();
    }
});
$logger->log('想定処理時間: ' . expected_execution_time('sequential', NUM_OF_TRIALS, DELAY_COEFFICIENT));


$client = HttpClient::getInstance();
measure_execution_time('Parallel Execution', function () use ($client) {
    $promises = [];
    for ($i = 1; $i <= NUM_OF_TRIALS; $i++) {
        $delay = $i * DELAY_COEFFICIENT;
        $promises[] = $client->getAsync(TEST_SERVER_BASE_URL . "?delay={$delay}");
    }
    Utils::all($promises)->wait();
});
$logger->log('想定処理時間: ' . expected_execution_time('parallel', NUM_OF_TRIALS, DELAY_COEFFICIENT));
