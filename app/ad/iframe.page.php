<?php
class ad_iframe extends STpl{
    public $config;
    function __construct(){
        $this->config = SConfig::getConfig(ROOT_CONFIG."/js.conf");
        $this->assign("config",$this->config);
    }
    
	public function pageEntry($InPath){
	    $ad = array();
	    $ad['mim_aid'] = $_REQUEST['aid']?$_REQUEST['aid']:'';     //广告ID
	    $ad['mim_src'] = $_REQUEST['src']?$_REQUEST['src']:'';     //流量来源
	    $ad['mim_pushid'] = $_REQUEST['pushid']?$_REQUEST['pushid']:'';    //每次投放的校验值
	    $this->assign('ad',$ad);
	    return $this->render("/ad/iframe_entry.html");
	}
	
	function pageShowBc($inPath){
	    $aid = $_REQUEST['aid']?$_REQUEST['aid']:'';
	    if(!empty($inPath[3])){
	        $aid=$inPath[3];
	    }
	    $this->assign("aid",$aid);
	    return $this->render("/ad/iframe_show.html");
	}
	function pageShow($inPath){
	    /*
            AD_IMAGE = 1,
            AD_FLASH = 2,
            AD_FLASH_DYNAMIC = 3,
            AD_TEXT = 4,
            AD_WORDCHAIN = 5,
            AD_VIDEO = 6,
            AD_IFRAME = 7,
            AD_JS = 8,
            AD_HTML = 9
            show_js_type:1,url;  2,js
	     */
	    if(!empty($_GET['aid']) && is_numeric($_GET['aid'])){
	        $aid   =   $_GET['aid'];
	        $sn    =   empty($_REQUEST['sn'])?"":$_REQUEST['sn'];
	        $db    =   new stat_db;
	        $ad    =   $db->getStuffByAid($_GET['aid']);
	        if(isset($ad['type']) && $ad['type']>6){
	            switch ($ad['type']) {
	                case 7:
	                    $this->assign("ad",$ad);
	                    return $this->render("/ad/iframe_show_iframe.html");
	                break;
	                
	                case 8:
	                    $this->assign("ad",$ad);
	                    return $this->render("/ad/iframe_show_js.html");
	                break;
	                
	                case 9:
	                    $html = $ad['text'];
	                    if(isset($ad['show_js']) && strlen($ad['show_js'])>0){
	                        $statCode = '<span style="display:none !important;">'.$ad['show_js'].'</span>';
	                        $html = str_ireplace(array("</body>"), $statCode."</body>", $html);
	                    }
	                    echo $html;
	                break;
	                
	                default:
	                    ;
	                break;
	            }
	            exit();
	        }
	        
	        if(isset($ad['type']) && $ad['type']==9){
	            $html = $ad['text'];
	            if(isset($ad['show_js']) && strlen($ad['show_js'])>0){
	                $statCode = '<span style="display:none !important;">'.$ad['show_js'].'</span>';
	                $html = str_ireplace(array("</body>"), $statCode."</body>", $html);
	            }
	            echo $html;
	            exit();
	        }elseif(isset($ad['type']) && $ad['type']>7){
	            print_r($ad);
	            exit('仅能为图片或者FLASH提供iframe');
	        }
	        
	        $ad['click_js_iframe'] = 'https://'.$this->config->host->js.'/stat.click?aid='.$aid;
	        
	        if(stripos($ad['landing_page'], 'https') === false && stripos($ad['landing_page'], 'https') === false){
	            $ad['landing_page'] = 'https://'.$ad['landing_page'];
	        }
	        
	        $ad['show_js'] = str_ireplace(array("\r\n","\n"), "", $ad['show_js']);
	        if(filter_var($ad['show_js'], FILTER_VALIDATE_URL)){
	            $ad['show_js_type'] = 1;
	        }else{
	            $ad['show_js_type'] = 2;
	        }
	        
	        $ad['click_js'] = str_ireplace(array("\r\n","\n"), "", $ad['click_js']);
	        if(filter_var($ad['click_js'], FILTER_VALIDATE_URL)){
	            $ad['click_js_type'] = 1;
	            $ad['click_js_url'] = $ad['click_js_type'];
	        }else{
	            $ad['click_js_type'] = 2;
	            
	            $ad['click_js_url'] = $this->getUrlFromJs($ad['click_js_url']);
	        }
	        
	        if(isset($_GET['width'])){
	            $width = " width:".$_GET['width']."px; ";
	            $ad['width'] = $_GET['width'];
	        }else{
	            $width = " ";
	        }
	        if(isset($_GET['height'])){
	            $height = " height:".$_GET['height']."px; ";
	            $ad['height'] = $_GET['height'];
	        }else{
	            $height = " ";
	        }
	        
	        $this->assign("width",$width);
	        $this->assign("height",$height);
	        $this->assign("_GET",$_GET);
	        $this->assign("sn",$sn);
	        $this->assign("ad",$ad);
	        switch ($ad['type']) {
	            case 1:
	            return $this->render("/ad/iframe_show_image.html");
	            break;
	            
	            case 2:
	            return $this->render("/ad/iframe_show_flash.html");
	            break;
	            
	            default:
	            return $this->render("/ad/iframe_show_image.html");
	            break;
	        }
	        
	    }else{
	        echo 'no ad';
	    }
	}
	function pageHtml($inPath){
	    /*
	     AD_IMAGE          = 1,
	     AD_FLASH          = 2,
	     AD_FLASH_DYNAMIC  = 3,
	     AD_TEXT           = 4,
	     AD_WORDCHAIN      = 5,
	     AD_VIDEO          = 6,
	     AD_IFRAME         = 7,
	     AD_JS             = 8,
	     AD_HTML           = 9
	     show_js_type      = 1:url;  2:js
	     */
	    if(!empty($_GET['aid']) && is_numeric($_GET['aid'])){
	        $aid   =   $_GET['aid'];
	        $sn    =   empty($_REQUEST['sn'])?"":$_REQUEST['sn'];
	        $db    =   new stat_db;
	        $ad    =   $db->getStuffByAid($_GET['aid']);
	         
	        if(isset($_GET['click_delay']) && is_numeric($_GET['click_delay'])){
	            $ad['click_delay'] = $_GET['click_delay'];
	        }else{
	            $ad['click_delay'] = 500;
	        }
	         
	        if(isset($ad['type']) && $ad['type']>6){
	            switch ($ad['type']) {
	                case 7:
	                    $this->assign("ad",$ad);
	                    return $this->render("/ad/iframe_html_iframe.html");
	                    break;
	    
	                case 8:
	                    $this->assign("ad",$ad);
	                    return $this->render("/ad/iframe_html_js.html");
	                    break;
	    
	                case 9:
	                    $html = $ad['text'];
	                    if(isset($ad['show_js']) && strlen($ad['show_js'])>0){
	                        $statCode = '<span style="display:none !important;">'.$ad['show_js'].'</span>';
	                        $html = str_ireplace(array("</body>"), $statCode."</body>", $html);
	                    }
	                    echo $html;
	                    break;
	    
	                default:
	                    ;
	                    break;
	            }
	            exit();
	        }
	    
	        if(isset($ad['type']) && $ad['type']==9){
	            $html = $ad['text'];
	            if(isset($ad['show_js']) && strlen($ad['show_js'])>0){
	                $statCode = '<span style="display:none !important;">'.$ad['show_js'].'</span>';
	                $html = str_ireplace(array("</body>"), $statCode."</body>", $html);
	            }
	            echo $html;
	            exit();
	        }elseif(isset($ad['type']) && $ad['type']>7){
	            exit('仅能为图片或者FLASH提供iframe');
	        }
	    
	        $ad['click_js_iframe'] = 'https://'.$this->config->host->js.'/stat.click?aid='.$aid;
	    
	        $urlInfo = parse_url($ad['landing_page']);
	        if( (isset($urlInfo['path'])||isset($urlInfo['host'])) && !isset($urlInfo['scheme'])){
	            $ad['landing_page'] = 'https://'.$ad['landing_page'];
	        }
	    
	        $ad['show_js'] = str_ireplace(array("\r\n","\n"), "", $ad['show_js']);
	        if(filter_var($ad['show_js'], FILTER_VALIDATE_URL)){
	            $ad['show_js_type'] = 1;
	        }else{
	            $ad['show_js_type'] = 2;
	        }
	    
	        $ad['click_js'] = str_ireplace(array("\r\n","\n"), "", $ad['click_js']);
	        if(filter_var($ad['click_js'], FILTER_VALIDATE_URL)){
	            $ad['click_js_type'] = 1;
	            $ad['click_js_url'] = $ad['click_js_type'];
	        }else{
	            $ad['click_js_type'] = 2;
	            $ad['click_js_url'] = $this->getUrlFromJs($ad['click_js_url']);
	        }
	    
	        if(isset($_GET['width']) && $_GET['width']>0){
	            $width = " width:".$_GET['width']."px; ";
	            $ad['width'] = $_GET['width'];
	        }else{
	            $width = " ";
	        }
	        if(isset($_GET['height']) && $_GET['height']>0){
	            $height = " height:".$_GET['height']."px; ";
	            $ad['height'] = $_GET['height'];
	        }else{
	            $height = " ";
	        }
	    
	        $this->assign("width",$width);
	        $this->assign("height",$height);
	        $this->assign("_GET",$_GET);
	        $this->assign("sn",$sn);
	        $this->assign("ad",$ad);
	        switch ($ad['type']) {
	            case 1:
	                return $this->render("/ad/iframe_html_image.html");
	                break;
	    
	            case 2:
	                return $this->render("/ad/iframe_html_flash.html");
	                break;
	    
	            default:
	                return $this->render("/ad/iframe_html_image.html");
	                break;
	        }
	    
	    }else{
	        echo 'no ad';
	    }
	}
	
	function getUrlFromJs(){
	    $str = ' <script src="https://s11.cnzz.com/stat.php?id=1256418352&web_id=1256418352" language="JavaScript"></script>';
	    $str = str_ireplace(array("\r\n","\n",), "", $str);
	    $str = trim($str);
	    if(stripos($str, "<script") === 0){
	        $startPos = stripos($str, "src=")+5;
	        $subStr = substr($str, $startPos);
	        $endPos_1 = stripos($subStr,"'");
	        $endPos_2 = stripos($subStr,'"');
	        if($endPos_1 > 0 && $endPos_2>0){
	            $endPos = min( array($endPos_1, $endPos_2) );
	        }elseif($endPos_1 > 0 || $endPos_2>0){
	            $endPos = max( array($endPos_1, $endPos_2) );
	        }else{
	            return "";
	        }
	        return substr($subStr, 0, $endPos);
	    }else{
	        return "";
	    }
	}
	
}
?>