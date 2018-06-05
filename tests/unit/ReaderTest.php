<?php
use Mocks\HttpClientMock;
use Kachit\Config\Consul\Reader;
use SensioLabs\Consul\ServiceFactory;
use GuzzleHttp\Psr7\Response;

class ReaderTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var HttpClientMock
     */
    protected $mock;

    /**
     * @var Reader
     */
    protected $testable;

    /**
     *
     */
    protected function _before()
    {
        $this->mock = $this->tester->mockHttpClient();
        $sf = new ServiceFactory(['base_uri' => 'http://consul.service.local'], null, $this->mock->getHttpClient());
        $this->testable = new Reader($sf->get('kv'));
    }

    // tests
    public function testSuccess()
    {
        $value = [
            'foo' => ['bar' => 'baz']
        ];

        $stub = [[
            'LockIndex' => 0,
            'Key' => 'foo/bar/qwerty',
            'Flags' => 0,
            'Value' => base64_encode(json_encode($value)),
            'CreateIndex' => 1,
            'ModifyIndex' => 1,
        ]];
        $this->mock->addStubResponse(new Response(200, [], json_encode($stub)));
        $result = $this->testable->read('foo/bar/qwerty');
        $this->assertNotEmpty($result);
        $this->assertTrue(is_array($result));
        $this->assertEquals($value, $result);
    }

    // tests
    public function testEmpty()
    {
        $stub = [[
            'LockIndex' => 0,
            'Key' => 'foo/bar/qwerty',
            'Flags' => 0,
            'Value' => null,
            'CreateIndex' => 1,
            'ModifyIndex' => 1,
        ]];
        $this->mock->addStubResponse(new Response(200, [], json_encode($stub)));
        $result = $this->testable->read('foo/bar/qwerty');
        $this->assertEmpty($result);
        $this->assertTrue(is_array($result));
    }

    /**
     * @expectedException SensioLabs\Consul\Exception\ServerException
     * @expectedExceptionMessage Something went wrong when calling consul (Client error: `GET v1/kv/foo/bar/qwerty` resulted in a `404 Not Found
     */
    public function testNotFound()
    {
        $this->mock->addStubResponse(new Response(404, []));
        $result = $this->testable->read('foo/bar/qwerty');
        $this->assertEmpty($result);
        $this->assertTrue(is_array($result));
    }
}