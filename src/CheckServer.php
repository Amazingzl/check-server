<?php

namespace Amazingzl\CheckServer;

use Amazingzl\CheckServer\TargetType\Server;

class CheckServer
{

    /**
     * Description:
     * @var Server
     */
    private $checkServer;

    /**
     * @throws ServerErrorException
     */
    public function getCheckServer($type)
    {
        switch ($type) {
            case 'mysql':
                $this->checkServer = new TargetType\Mysql();
            default:
                throw new ServerErrorException('type error');
        }
    }


    /**
     * @param int $socketReceiveTimeout
     */
    public function setSocketReceiveTimeout($socketReceiveTimeout)
    {
        $this->checkServer->setSocketReceiveTimeout($socketReceiveTimeout);
    }

    /**
     * @param int $socketSendTimeout
     */
    public function setSocketSendTimeout($socketSendTimeout)
    {
        $this->checkServer->setSocketSendTimeout($socketSendTimeout);
    }

    public function setHost($host)
    {
        $this->checkServer->setHost($host);
    }

    public function setPort($port)
    {
        $this->checkServer->setPort($port);
    }

    public function check()
    {
        return $this->checkServer->check();
    }
}
