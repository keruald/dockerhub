<?php

namespace Keruald\DockerHub\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

trait WithMockHttpClient {

     /**
      * Mocks HTTP client
      *
      * @param int $httpResponseCode The HTTP response code to mock
      * @return \GuzzleHttp\Client
      */
    protected function mockHttpClient ($httpResponseCode) {
        $handler = self::getCustomMockHttpClientHandler($httpResponseCode);
        return new Client(['handler' => $handler]);
    }

    /**
     * @return \GuzzleHttp\HandlerStack
     */
    protected static function getCustomMockHttpClientHandler ($code) {
        return HandlerStack::create(new MockHandler([
            new Response($code),
        ]));
    }

}
