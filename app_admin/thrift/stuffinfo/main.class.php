<?php
@define('THRIFT_ROOT', ROOT.'/libs/thrift/lib/');
require_once(THRIFT_ROOT . '/Thrift/ClassLoader/ThriftClassLoader.php');
use Thrift\ClassLoader\ThriftClassLoader;
$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', THRIFT_ROOT);
$loader->registerDefinition('Thrift', THRIFT_ROOT);
$loader->register();

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Protocol\TJSONProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\TBufferedTransport;
include_once(dirname(__FILE__)."/Types.php");
include_once(dirname(__FILE__)."/StuffInfoService.php");

class thrift_stuffinfo_main{
	public function __call($name,$arguments){

		$config = SConfig::getConfig(ROOT_CONFIG."/thrift.conf","stuffinfo");
		$socket = new TSocket($config->host, $config->port);
		if(isset($config->timeout)){
		    $socket->setSendTimeout($config->timeout);
		    $socket->setRecvTimeout($config->timeout*2);
		}
		$transport = new TBufferedTransport($socket, 1024, 1024);
		$protocol = new TBinaryProtocol($transport);
		$transport->open();
		$client = new StuffInfoServiceClient($protocol);  
		try{
		$r = call_user_func_array(array($client,$name),$arguments);
		$transport->close();
		return $r;
		}catch(Exception $e){
			error_log(var_export($e,true));
		}
	}

}