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

        $str = '原来的我可以穿漂亮的白裙子，画着淡淡的妆，当婉转的《茉莉花》音乐响起我在舞台中央翩翩起舞，仿佛整个世界上只有我一个人。舞蹈队里的姐妹们都说我就像一朵美丽茉莉花，也只有我能够把那支舞蹈演绎的那么优雅动人。那时候的我是有多么的骄傲，我活在一个充满鲜花和掌声的世界里，而且我还有一个非常爱我的男朋友，让我觉得我所有的付出都是值得。他每天都像公主一样宠着我，任我撒娇淘气，无理取闹。每次我训练完舞蹈，他都会骑着单车来我训练的地方接我。坐在他骑着的单车上，环着他的腰把脸贴在他的背上，听他均匀的心跳声，我感到无比的踏实。夕阳照在我们身上，在地上留下一道长长的影子。我的头发随着风飞扬舞动，像我在舞台上一样轻盈，还有我长长的白裙子';


        $header = $this->getHttpRequestHeader();

        $httpPost = new HttpRequestPost();

        //$string = new HttpRequestString();
        //$text = $string->getText($str);
        //dump($text);

        //die;

        $text = $this->getText($str);

        $result = $httpPost->post($header,self::$apiUrl,$text);

        $voice = json_decode($result);

        if(isset($voice->code)){
            return $result;
        }
        $this->save($result);
    }

    private function getText()
    {
        return "text=这里是语音测试！";
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



