<?php
/**
 * Class Reader
 *
 * @package Kachit\Config\Consul
 * @author Kachit
 */
namespace Kachit\Config\Consul;

use Kachit\Config\ReaderInterface;
use SensioLabs\Consul\ConsulResponse;

class Reader extends Common implements ReaderInterface
{
    /**
     * @param null $path
     * @return array
     */
    public function read($path = null): array
    {
        /* @var ConsulResponse $response */
        $response = $this->kv->get($path);
        $result = $response->json();
        $data = [];
        if (isset($result[0]['Value'])) {
            $result = $result[0]['Value'];
            $result = base64_decode($result);
            $data = json_decode($result, true);
        }
        return $data;
    }
}