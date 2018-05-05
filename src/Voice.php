<?php
namespace RookieVoice;

class Voice
{
    private $auf = 'audio/L16;rate=16000';   //音频采样率

    private $aue = 'raw';    //音频编码 可选值：raw（未压缩的pcm或wav格式），lame（mp3格式）

    public $voice_name = 'xiaoyan';  //发音人

    public $speed = '50';  //语速，可选值：[0-100]，默认为50

    public $volume = '50'; //音量，可选值：[0-100]，默认为50

    public $pitch = '50'; //音高，可选值：[0-100]，默认为50

    public $engine_type = 'intp65';  //引擎类型，可选值：aisound（普通效果），intp65（中文），intp65_en（英文），mtts（小语种，需配合小语种发音人使用），x（优化效果），默认为inpt65

    private $text_type = 'text';  //文本类型

    public $appid = null;  //appid
    public $apiKey = null;

    private static $apiUrl = 'http://api.xfyun.cn/v1/service/v1/tts';

    public function getVoice()
    {
        echo $header = $this->getHttpRequestHeader();

        $httpPost = new HttpRequestPost();
        $text = $this->getText();
        $result = $httpPost->post($header,self::$apiUrl,"text=this is test");
        dump($result);
    }

    private function getText()
    {
        return json_encode([
            'text' => '这里是语音测试！'
        ],JSON_UNESCAPED_UNICODE);
    }

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



