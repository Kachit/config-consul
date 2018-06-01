<?php
/**
 * Class Common
 *
 * @package Kachit\Config\Consul
 * @author Kachit
 */
namespace Kachit\Config\Consul;

use SensioLabs\Consul\Services\KVInterface;

class Common
{
    /**
     * @var KVInterface
     */
    protected $kv;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * Common constructor
     *
     * @param KVInterface $kv
     * @param array $options
     */
    public function __construct(KVInterface $kv, array $options = [])
    {
        $this->kv = $kv;
        $this->options = $options;
    }
}