<?php
/**
 * Class HttpClientMock
 *
 * @package Helper
 * @author Kachit
 */
namespace Helper;

use Codeception\Module;

class HttpClientMock extends Module
{
    /**
     * @return \Mocks\HttpClientMock
     */
    public function mockHttpClient()
    {
        return new \Mocks\HttpClientMock();
    }
}