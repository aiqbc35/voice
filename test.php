<?php
require "./vendor/autoload.php";

define('DEBUG',true);

if (DEBUG) {
    $whoops = new \Whoops\Run;
    $optionTitle = "框架出错了";
    $option = new \Whoops\Handler\PrettyPageHandler();
    $option->setPageTitle($optionTitle);
    $whoops->pushHandler($option);
    $whoops->register();
    ini_set('display_errors','on');
}

$voice = new \RookieVoice\Voice();
$voice->getVoice();