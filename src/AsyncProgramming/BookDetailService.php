<?php

namespace SnowIO\Demo\AsyncProgramming;

use GuzzleHttp\Client;
use function GuzzleHttp\Promise\all;
use function GuzzleHttp\Promise\coroutine;
use GuzzleHttp\Psr7\Response;

class BookDetailService
{
    public static function getBooksWithPromises(array $bookIds)
    {
        $client = self::getClient();
        $playerGetPromises = array_map(function ($bookId) use ($client) {
            return $client->getAsync($bookId);
        }, $bookIds);
        $results = [];
        return all($playerGetPromises)
            ->then(function ($responses) use (&$results) {
                return array_map(function (Response $response) {
                    return self::toJson($response);
                }, $responses);
            });
    }

    public static function getBooksWithCoroutine(array $bookIds)
    {
        return  coroutine(function () use ($bookIds) {
            $client = self::getClient();
            $results = [];
            foreach ($bookIds as $bookId) {
                $response = yield $client->getAsync($bookId);
                $results[] = self::toJson($response);
            }
            return $results;
        });
    }


    private static function toJson(Response $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    private static function getClient()
    {
        $options = ['base_uri' => 'http://openlibrary.org/authors/'];
        return new Client($options);
    }
}