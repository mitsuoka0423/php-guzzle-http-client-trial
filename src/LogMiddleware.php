<?php

namespace App;

use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LogMiddleware
{
    public static function create(Logger $logger): callable
    {
        return Middleware::tap(
            function (RequestInterface $request, array $options) use ($logger) {
                $logger->log("[before] Request: " . $request->getMethod() . " " . $request->getUri());
            },
            function (RequestInterface $request, array $options, PromiseInterface $promise) use ($logger) {
                $promise->then(
                    function (ResponseInterface $response) use ($request, $logger) {
                        $logger->log("[after] Request: " . $request->getMethod() . " " . $request->getUri());
                        $logger->log("[after] Response: " . $response->getStatusCode() . " " . $response->getReasonPhrase());
                    },
                    function ($reason) use ($logger) {
                        $message = $reason instanceof \Exception ? $reason->getMessage() : 'Unknown error';
                        $logger->log(sprintf('[after] Error: %s', $message));
                    }
                );

                return $promise;
            }
        );
    }
}
