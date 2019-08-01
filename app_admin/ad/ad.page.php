<?php
class ad_ad extends STpl{
    public $config;
    function __construct(){
        $stuffType = array(
            1=>"图片",
            2=>"Flash",
            3=>"Flash·动态",
            4=>"文本",
            5=>"文字链",
            6=>"视频",
            7=>"IFrame",
            8=>"JS",
            9=>"HTML",
        );
        $viewType = array(
            1=>'嵌入式',
            2=>'浮窗',
            4=>'背投',
            8=>'重定向[禁用]',
            16=>'重定向[DPC]',
            32=>'通栏',
            64=>'无线APP',
            128=>'无线浮标',
            256=>'插页',
            512=>'对联',
        );
        $position = array(
            0=>"默认",
            1=>"正上方",
            2=>"右上角",
            3=>"右侧居中",
            4=>"右下角",
            5=>"正下方",
            6=>"左下角",
            7=>"左侧居中",
            8=>"左上角"
        );
        $this->assign("viewType",$viewType);
        $this->assign("position",$position);
        $this->assign("stuffType",$stuffType);
    }
    
	function pageEntry($inPath){
	}
	
	function pageInfo(){
	    $bidders = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'bidder');
	    
	    $aid   =   $_GET['aid'];
	    $sn    =   empty($_REQUEST['sn'])?"":$_REQUEST['sn'];
	    $db    =   new model_ad;
	    $ad    =   $db->getStuffByAid($_GET['aid']);
	     
	    $iframe = array();
	    if($ad['width'] < 440 && $ad['height'] <320){
	        $iframe['width'] = $ad['width'];
	        $iframe['height'] = $ad['height'];
	    }else{
	        if(440/$ad['width'] < 320/$ad['height']){
	            $iframe['width'] = 440;
	            $iframe['height'] = $ad['height']*440/$ad['width'];
	        }else{
	            $iframe['height'] = 320;
	            $iframe['width'] = $ad['width']*320/$ad['height'];
	        }
	    }
	    $iframe['top'] = (360 - $iframe['height'])/2;
	    $this->assign("ad",$ad);
	    $this->assign("iframe",$iframe);
	    $this->assign("bidders",$bidders);
	    return $this->render("/ad/ad_info.html");
	}
}
