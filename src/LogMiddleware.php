<?php

namespace App;

use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LogMiddleware
{
    public static function create(Logger $logger): callable
    {
        return Middleware::tap(
            function (RequestInterface $request) use ($logger) {
                $logger->log("Request: " . $request->getMethod() . " " . $request->getUri());
            },
            function (RequestInterface $request, ResponseInterface $response) use ($logger) {
                $logger->log("Response: " . $response->getStatusCode() . " " . $response->getReasonPhrase());
            }
        );
    }
}