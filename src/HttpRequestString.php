<?php

namespace RookieVoice;


class HttpRequestString
{
    private static $text;  //原始文本
    private $length = 0;  //文本长度


    public function getText($text)
    {
        self::$text = $text;
        $this->stringLength();
        return $this->length;
    }

    private function stringLength()
    {
        $this->length = strlen(self::$text);
    }

}