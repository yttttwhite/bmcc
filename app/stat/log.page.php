<?php
class stat_log{
	public function pageEntry($inPath){
		//header("content-type:image/png");
		header("Content-Type:application/x-javascript");
		$data=array();
		$data['time']	=time();//date("Y-m-d H:i:s");
		$data['ip']		=SUtil::getIP();
		$data['sid']	=empty($_REQUEST['sid'])?0:$_REQUEST['sid'];
		$data['screen']	=empty($_REQUEST['screen'])?0:$_REQUEST['screen'];
		$data['ua']		=empty($_SERVER['HTTP_USER_AGENT'])?'':$_SERVER['HTTP_USER_AGENT'];
		$data['bcdata_sid']	=empty($_COOKIE['bcdata_sid'])?'':$_COOKIE['bcdata_sid'];
		$data['url']=empty($_REQUEST['url'])?'':$_REQUEST['url'];
		$data['referer']=empty($_REQUEST['referer'])?'':$_REQUEST['referer'];
		$keyword = stat_keyword::get($data['referer'],$engine);
		$data['engine']= $engine;
		$data['keyword']= $keyword;
		$path="/data/log/".date("Ymd");
		@mkdir($path,0777,true);
		//$i=ceil(date("i")/15);
		//if($i==0)$i=1;
		$i=date("i");
		//$file=$path."/"."oas_log_".date("YmdH")."_".$i.".log";
		$file=$path."/"."oas_log_".date("YmdH").".log";
		file_put_contents($file,implode("\x02",$data)."\r\n",FILE_APPEND|LOCK_EX );
		//readfile(dirname(__FILE__)."/null.gif");
		//{{{cookie
		if(!empty($_COOKIE['bcdata_sid'])){
			$cookie = array("bcdata_sid"=>$_COOKIE['bcdata_sid']);
			echo "BCStat.set(".SJson::encode($cookie).")";
		}
		//}}}
	}
	public function pageTest($inPath){
		header("content-type:image/png");
		unset($_REQUEST['rand']);
		unset($_REQUEST['PATH_INFO']);
		$data=date("Y-m-d H:i:s")." ".SUtil::getIP();
		foreach($_REQUEST as $k=>$v){
			$data.='{'.$k.':'.$v.'}';
		}
		$cookie='';
		foreach($_COOKIE as $k=>$v){
			$cookie.= $k.'='.$v.';';
		}
		$data.='{COOKIE:'.$cookie.'}';
			if(!empty($_SERVER['HTTP_USER_AGENT'])){
				$data.='{'.$_SERVER['HTTP_USER_AGENT'].'}';
			}
		$path="/data/log/".date("Ymd");
		@mkdir($path,0777,true);
		$file=$path."/"."info_log_".date("YmdH").".log";
		file_put_contents($file,$data."\r\n",FILE_APPEND|LOCK_EX );
	}
	public function pageRedirect($inPath){
		header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
		header('Pragma: no-cache'); // HTTP 1.0.
		header('Expires: 0'); // Proxies.
		if(empty($_REQUEST['url'])){
		    return;
		}

		unset($_REQUEST['rand']);
		unset($_REQUEST['PATH_INFO']);
		$ip = SUtil::getIP();
		$data=date("Y-m-d H:i:s")." ".$ip;
		foreach($_REQUEST as $k=>$v){
			$data.='{'.$k.':'.$v.'}';
		}
		$cookie='';
		foreach($_COOKIE as $k=>$v){
			$cookie.= $k.'='.$v.';';
		}
		$data.='{COOKIE:'.$cookie.'}';
			if(!empty($_SERVER['HTTP_USER_AGENT'])){
				$data.='{'.$_SERVER['HTTP_USER_AGENT'].'}';
			}
		$path="/data/log/".date("Ymd");
		@mkdir($path,0777,true);
		$file=$path."/"."info_redirect_".date("YmdH").".log";
		file_put_contents($file,$data."\r\n",FILE_APPEND|LOCK_EX );
		header("Location:".$_REQUEST['url']);
	}

}
