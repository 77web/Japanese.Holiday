<?php

date_default_timezone_set('Asia/Tokyo');

$loader = require dirname(__DIR__) . '/vendor/autoload.php';
/** @var $loader \Composer\Autoload\ClassLoader */
$loader->addPsr4('Japanese\Holiday\\', __DIR__);
