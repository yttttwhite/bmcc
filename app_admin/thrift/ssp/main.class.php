<?php
@define('THRIFT_ROOT', ROOT.'/libs/thrift/lib/');
require_once(THRIFT_ROOT . '/Thrift/ClassLoader/ThriftClassLoader.php');
require_once(THRIFT_ROOT . '/Thrift/Serializer/TBinarySerializer.php');
use Thrift\ClassLoader\ThriftClassLoader;
$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', THRIFT_ROOT);
$loader->registerDefinition('Thrift', THRIFT_ROOT);
$loader->register();

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Serializer\TBinarySerializer;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Protocol\TJSONProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\TBufferedTransport;
include_once(dirname(__FILE__)."/Types.php");

class thrift_ssp_main{
}