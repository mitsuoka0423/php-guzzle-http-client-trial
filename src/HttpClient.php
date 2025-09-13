<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class HttpClient
{
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance(): Client
    {
        if (self::$instance === null) {
            $stack = HandlerStack::create();
            $stack->push(LogMiddleware::create(new Logger()));
            self::$instance = new Client(['handler' => $stack]);
        }
        return self::$instance;
    }
}
