<?php

namespace Amazingzl\CheckServer\TargetType;

abstract class Execute
{
    protected $socketReceiveTimeout = 3;
    protected $socketSendTimeout = 3;

    protected $host;
    protected $port;

    /**
     * @param int $socketReceiveTimeout
     */
    public function setSocketReceiveTimeout($socketReceiveTimeout)
    {
        $this->socketReceiveTimeout = $socketReceiveTimeout;
    }

    /**
     * @param int $socketSendTimeout
     */
    public function setSocketSendTimeout($socketSendTimeout)
    {
        $this->socketSendTimeout = $socketSendTimeout;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }
}