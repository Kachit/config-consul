<?php
/**
 * Class HttpClientMock
 *
 * @author Kachit
 */
namespace Mocks;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class HttpClientMock
{
    /**
     * @var MockHandler
     */
    protected $mockHandler;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var Request[]
     */
    protected $history = [];

    /**
     *
     */
    public function __construct()
    {
        $history = Middleware::history($this->history);
        $this->mockHandler = new MockHandler();
        $handler = HandlerStack::create($this->mockHandler);
        $handler->push($history);
        $this->httpClient = new Client(['handler' => $handler]);
    }

    /**
     * @param Response $response
     * @return $this
     */
    public function addStubResponse(Response $response)
    {
        $this->mockHandler->append($response);
        return $this;
    }

    /**
     * @return MockHandler
     */
    public function getMockHandler(): MockHandler
    {
        return $this->mockHandler;
    }

    /**
     * @return Client
     */
    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    /**
     * @return Request[]
     */
    public function getHistory(): array
    {
        return $this->history;
    }

    /**
     * @return Request
     */
    public function getLastRequest(): Request
    {
        $index = count($this->history) - 1;
        return $this->history[$index]['request'];
    }
}