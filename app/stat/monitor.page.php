<?php
class stat_monitor{
	public function pageEntry($inPath){
		header("content-type:image/png");
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
		$data['id']=empty($_REQUEST['id'])?'':$_REQUEST['id'];
		$data['src']=empty($_REQUEST['src'])?'':$_REQUEST['src'];
		$data['width']=empty($_REQUEST['width'])?'':$_REQUEST['width'];
		$data['height']=empty($_REQUEST['height'])?'':$_REQUEST['height'];
		$path="/data/log/".date("Ymd");
		@mkdir($path,0777,true);
		//$i=ceil(date("i")/15);
		//if($i==0)$i=1;
		$i=date("i");
		//$file=$path."/"."oas_log_".date("YmdH")."_".$i.".log";
		$file=$path."/"."oas_monitor_".date("YmdH").".log";
		file_put_contents($file,implode("\x02",$data)."\r\n",FILE_APPEND|LOCK_EX );
	}

}
