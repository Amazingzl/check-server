<?php

namespace Amazingzl\CheckServer\TargetType;

use Amazingzl\CheckServer\ConnectErrorException;
use Amazingzl\CheckServer\ServerErrorException;

class Mysql extends Execute implements Server
{

    /**
     * @return bool
     * @throws ConnectErrorException
     * @throws ServerErrorException
     * Description: check server
     */
    public function check()
    {
        // 创建一个 socket 连接
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, ["sec"=>$this->socketReceiveTimeout, "usec"=>0]);
        socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, ["sec"=>$this->socketSendTimeout, "usec"=>0]);

        if ($socket === false) {
            throw new ConnectErrorException($this->host.':'.$this->port.' connect error:'.socket_strerror(socket_last_error()));
        } else {
            // 尝试连接到 MySQL 服务器
            $result = socket_connect($socket, $this->host, $this->port);

            if ($result === false) {
                throw new ConnectErrorException($this->host.':'.$this->port.' connect error:'.socket_strerror(socket_last_error()));
            } else {
                // 读取服务器的响应
                $response = socket_read($socket, 1024);

                $checkMysql = stripos($response, 'mysql');

                if ($checkMysql === false){
                    throw new ServerErrorException('The server '.$this->host.':'.$this->port.' response timed out or may not be a MySQL server.');
                }
                // 关闭 socket 连接
                socket_close($socket);
            }
        }
        return true;
    }
}