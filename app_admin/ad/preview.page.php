<?php
class ad_preview extends STpl{
	function pageEntry($inPath){
	    if(isset($_GET['url']) && strlen($_GET['url'])>3){
	        $data  = $_GET;
	        $url   = $_GET['url'];
	        unset($data['PATH_INFO']);
	        unset($data['url']);
	        $url = $this->createUrl($url, $data);
	    }else{
	        $url = "";
	    }
	    
		$aid="";
		$config= SConfig::getConfig(ROOT_CONFIG."/js.conf");
		$this->assign("config",$config);
		if(!empty($inPath[3])){
			$aid=$inPath[3];
		}
		$this->assign("url",$url);
		$this->assign("aid",$aid);
		return $this->render("v2/ad/preview.html");
	}
	
	private function createUrl($url,$data){
	    $param = array();
	    foreach ($data as $key=>$value){
	        $param[] = $key.'='.$value;
	    }
	    if(count($param)>0){
	        $getStr = implode('&', $param);
	    }else{
	        $getStr = '';
	    }
		
		if(stripos($url, 'https') === false && stripos($url, 'http') === false) {
	        $url = 'http://'.$url;
	    }
	
	    if(stripos($url, '?') !== false){
	        $url = $url.'&'.$getStr;
	    }else{
	        $url = $url.'?'.$getStr;
	    }
	    return $url;
	}
}
