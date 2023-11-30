<?php
/**
 *
 * User:wuzhenlong
 * Date:2023/11/30
 * Email: <wuzhenlong@onemt.com.cn>
 */

namespace Amazingzl\CheckServer\TargetType;

interface Server
{
    public function check();

    /**
     * @param int $socketReceiveTimeout
     */
    public function setSocketReceiveTimeout($socketReceiveTimeout);

    /**
     * @param int $socketSendTimeout
     */
    public function setSocketSendTimeout($socketSendTimeout);

    public function setHost($host);

    public function setPort($port);

}