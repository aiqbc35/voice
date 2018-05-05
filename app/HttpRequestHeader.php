<?php

namespace ROOKIE\VOICE\APP;


class HttpRequestHeader
{

    private static $appId;
    private static $param;
    private static $time;
    private static $apiKey;
    public $msg = null; //错误信息

    /**
     * @param mixed $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }



    public function getHttpHeader($param)
    {
        $this->setCurTime();
        $this->param($param);
        $check = $this->check();

        if ($check === false) {
            return $this->msg;
        }

        $checksum = $this->checkSum();

        $data = [
            'X-CurTime' => self::$time,
            'X-Param' => self::$param,
            'X-Appid' => self::$appId,
            'X-CheckSum' => $checksum,
            'X-Real-Ip' => ''
        ];
    }

    /**
     * md5哈希计算令牌
     * @return string
     */
    private function checkSum()
    {
        return md5(self::$apiKey . self::$time . self::$param);
    }



    /**
     * 检查相关参数
     * @return bool
     */
    private function check()
    {
        if (empty(self::$appId)) {
            $this->msg = 'APPID不能为空！';
            return false;
        }

        if (empty(self::$param)) {
            $this->msg = '参数param串不能为空!';
            return false;
        }

        if(empty(self::$apiKey)){
            $this->msg = 'apikey不能为空';
            return false;
        }
        return true;
    }


    /**
     * 赋值APPI
     * @param mixed $appId
     */
    public static function setAppId($appId)
    {
        self::$appId = $appId;
    }

    /**
     * 时间戳
     * @return int
     */
    private function setCurTime()
    {
        return self::$time = time();
    }

    /**
     * base64加密json字符串
     * @param array $data
     * @return string
     */
    private function param($data)
    {
        return self::$param = base64_encode(json_encode($data));
    }

}