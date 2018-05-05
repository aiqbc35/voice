<?php
namespace RookieVoice;

class Voice
{
    private $auf = 'audio/L16;rate=16000';   //音频采样率

    private $aue = 'raw';    //音频编码 可选值：raw（未压缩的pcm或wav格式），lame（mp3格式）

    public $voice_name = 'xiaoyan';  //发音人

    public $speed = '50';  //语速，可选值：[0-100]，默认为50

    public $volume = '70'; //音量，可选值：[0-100]，默认为50

    public $pitch = '50'; //音高，可选值：[0-100]，默认为50

    public $engine_type = 'intp65';  //引擎类型，可选值：aisound（普通效果），intp65（中文），intp65_en（英文），mtts（小语种，需配合小语种发音人使用），x（优化效果），默认为inpt65

    private $text_type = 'text';  //文本类型

    public $appid = null;  //appid
    public $apiKey = null;

    private static $apiUrl = 'http://api.xfyun.cn/v1/service/v1/tts';

    public $isnum = 1; //语音条数

    public $errorMsg = ''; //错误信息


    public function getVoice($str)
    {

        if(empty($str)){
            return 'text not empty';
        }

        $header = $this->getHttpRequestHeader();

        if (is_string($header)) {
            return $header;
        }

        $string = $this->getString($str);

        if ($string == false) {
            return $this->errorMsg;
        }


        $voice = $this->stringToVoice($header,$string);

        if(is_string($voice)){
            $this->save($voice);
        }

        if (is_array($voice)) {
            foreach ($voice as $key=>$vo){
                $this->save($key.'test.wav',$vo);
            }
        }

    }

    /**
     * 文字转语音
     * @param $header http request header
     * @param $string 语音文本
     * @return array|bool|mixed
     */
    private function stringToVoice($header,$string)
    {
        if($this->isnum == 1 && is_string($string)){
            return $this->httpPost($header,$string);
        }
        if ($this->isnum > 1 && is_array($string)){

            $voice = array();

            foreach ($string as $str){
                $voice[] = $this->httpPost($header,$str);
                //sleep(1);
            }
            return $voice;
        }
        return false;
    }


    /**
     * 处理文字
     * @param $str
     * @return array|bool|string
     */
    private function getString($str)
    {
        $string = new HttpRequestString();
        $string->setIsNum($this->isnum);
        $text = $string->getText($str);

        if ($text == false){
            $this->errorMsg = $string->errorMsg;
            return false;
        }

        return $text;
    }

    /**
     * 对接接口
     * @param array $header http request header
     * @param string $text 语音文字
     * @return bool|mixed
     */
    private function httpPost($header,$text)
    {
        $httpPost = new HttpRequestPost();

        $result = $httpPost->post($header,self::$apiUrl,$text);

        $voice = json_decode($result);

        if(isset($voice->code)){
            $this->errorMsg = $result;
            return false;
        }
        return $result;
    }


    private function save($filename,$data)
    {
        file_put_contents($filename,$data);
    }

    /**
     * 获取Header
     * @return array|string
     */
    private function getHttpRequestHeader()
    {
        $param = [
            'auf' => $this->auf,
            'aue' => $this->aue,
            'voice_name' => $this->voice_name,
            'speed' => $this->speed,
            'volume' => $this->volume,
            'pitch' => $this->pitch,
            'engine_type' => $this->engine_type,
            'text_type' => $this->text_type
        ];

        $httpRequestHeader = new HttpRequestHeader();
        $httpRequestHeader->setAppId($this->appid);
        $httpRequestHeader->setApiKey($this->apiKey);
        return $httpRequestHeader->getHttpHeader($param);
    }

    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }
    }

    public function __set($name, $value)
    {
        if (isset($this->$name)) {
            $this->$name = $value;
        }
    }

}



