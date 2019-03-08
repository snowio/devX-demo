<?php
namespace SnowIO\Demo\Test;

use GuzzleHttp\Client;
use function GuzzleHttp\Promise\all;
use function GuzzleHttp\Promise\coroutine;
use GuzzleHttp\Psr7\Response;
use function ObjectStream\readable;
use PHPUnit\Framework\TestCase;
use SnowIO\Demo\AsyncProgramming\BookDetailService;

class AsyncTest extends TestCase
{
    /** @var Client */
    private $client;

    /**
     * @test
     * @dataProvider bookIdDataProvider
     * @param array $bookIds
     */
    public function externalApiWithPromise(array $bookIds)
    {
        $results = BookDetailService::getBooksWithPromises($bookIds)->wait();
        file_put_contents(__DIR__ . '/output-promises.json', json_encode($results));
        self::assertNotEmpty($results);
    }

    /**
     * @test
     * @dataProvider bookIdDataProvider
     * @param array $bookIds
     */
    public function externalApiWithCoroutine(array $bookIds)
    {
        $results = BookDetailService::getBooksWithCoroutine($bookIds)->wait();
        file_put_contents(__DIR__ . '/output-coroutine.json', json_encode($results));
        self::assertNotEmpty($results);
    }

    /** @test */
    public function streamOfDataFromFile()
    {
        $readable = readable([1,2,3,4,5,6,7,8,9,10]);
        $odd = []; $even = [];
        $readable->on('data', function ($value) use (&$odd, &$even) {
            if ($value % 2 !== 0) {
                $odd[] = $value;
            }
            if ($value % 2 === 0) {
                $even[] = $value;
            }
        });

        $readable->on('end', function () use (&$even, &$odd) {
            self::assertCount(5, $even);
            self::assertCount(5, $odd);
        });

        $readable->resume();
    }

    public function bookIdDataProvider()
    {
        return [
            [
                [
                    'OL741414W.json',
                    'OL38684W.json',
                    'OL15464873W.json',
                    'OL815453W.json'
                ]
            ]
        ];
    }

    private function toJson(Response $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    public function setUp()
    {
        $options = ['base_uri' => 'http://openlibrary.org/authors/'];
        $this->client = new Client($options);
    }
}