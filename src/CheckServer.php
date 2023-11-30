<?php

namespace Amazingzl\CheckServer;

class CheckServer
{

    protected $host;
    protected $port;

    private $socketReceiveTimeout = 3;
    private $socketSendTimeout = 3;

    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

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

    /**
     * @return bool
     * @throws ConnectErrorException
     * @throws ServerErrorException
     * Date:2023/11/30
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
                // 构建 MySQL 握手消息
                $handshake = "\x0\x0\x0\x10\x4a\x4d\x20\x20\x20\x20\x20\x20\x00\x00\x00\x00\x001";

                // 发送 MySQL 握手消息
                socket_write($socket, $handshake, strlen($handshake));
                // 读取并输出服务器的响应
                $response = socket_read($socket, 1024);

                if ($response === false){
                    throw new ServerErrorException('The server '.$this->host.':'.$this->port.' response timed out or may not be a MySQL server.');
                }
                // 关闭 socket 连接
                socket_close($socket);
            }
        }
        return true;
    }
}
