<?php
header("content-type: application/x-javascript");
class info_js extends STpl{
    private $config;
    function __construct(){
        $this->config= SConfig::getConfig(ROOT_CONFIG."/js.conf");
        $this->assign("config",$this->config);
    }
	public function pageEntry(){
	    if(!empty($_GET['aid'])){
	        $sn = empty($_REQUEST['sn'])?"":$_REQUEST['sn'];
	        $db = new info_db;
	        $stuff = $db->getStuffByAid($_GET['aid']);
	        $this->assign("sn",$sn);
	        $this->assign("stuff",$stuff);
	        
	        $data = array();
	        $data['aid'] = $stuff['adid'];
	        $data['show_js'] = "https://".$this->config->host->ads."/show.js";
	        $data['click_js'] = "https://".$this->config->host->ads."/click.js";
	        $data['third_show_js'] = urlencode($stuff['show_js']);
	        $data['third_click_js'] = urlencode($stuff['click_js']);
	        $data['src'] = 0;
	        $data['view_type'] = $stuff['adType'];
	        $data['view_position'] = $stuff['colum1'];
	        $data['view_time'] = $stuff['colum2'];
	        $data['pushid'] = sha1(time());
	        $data['src'] = 0;
	        $data['h'] = $stuff['height'];
	        $data['w'] = $stuff['width'];
	        $data['staff'] = array($stuff);
	        $response = array();
	        $response['sn'] = $sn;
	        $response['data'] = $data;
	        $json = json_encode($response);
	        if(isset($_GET['responseType'])){
	            switch ($_GET['responseType']) {
	                case "json":
	                    echo $json;
	                    break;
	                    
	                case "array":
	                    print_r($response);
	                    break;
	                    
	                case "object":
	                    $response = (object)$response;
	                    print_r($response);
	                    break;
	                
	                default:
	                    $json = "BCMain.Info.$sn = ".$json;
	                    echo $json;;
	                break;
	            }
	            
	        }else{
	            $json = "BCMain.Info.$sn = ".$json;
	            echo $json;
	        }
	    }
	}
	
	public function pageSlot(){
	    if(!empty($_GET['slotid'])){
	        $db = new info_db;
	        
	        $types = array(1,2);
	        if(isset($_GET['type']) && in_array($_GET['type'], $types)){
	            $type  = $_GET['type'];
	        }else{
	            $type = 0;
	        }
	        
	        $ads = $db->getAdsBySlotId($_GET['slotid'],$type);
	        if(is_array($ads)){
	            $adIndex = array_rand($ads);
	            $ad = $ads[$adIndex];
	            
	            $ad['third_show_js'] = urlencode($ad['show_js']);
	            $ad['third_click_js'] = urlencode($ad['click_js']);
	            $ad['show_js'] = "https://".$this->config->host->ads."/show.js";
	            $ad['click_js'] = "https://".$this->config->host->ads."/click.js";
	            
	            if(isset($_GET['responseType'])){
	                switch ($_GET['responseType']) {
	                    case "json":
	                        echo json_encode($ad,JSON_NUMERIC_CHECK);
	                        break;
	                         
	                    case "array":
	                        print_r($ad);
	                        break;
	                         
	                    case "object":
	                        $ad = (object)$ad;
	                        print_r($ad);
	                        break;
	                         
	                    default:
	                        $js = $this->adinfoToJs($ad);
	                        echo $js;;
	                        break;
	                }
	                 
	            }else{
	                $js = $this->adinfoToJs($ad);
                    echo $js;;
                    break;
	            }
	        }else{
	            echo json_encode(0);
	        }
	    }else{
            echo json_encode(0);
        }
	}
	
	public function adinfoToJs($ad){
	    if(isset($_GET['sn'])){
	        $sn = $_GET['sn'];
	    }else{
	        $sn = "nosn";
	    }
	    $data = array();
	    $data['aid'] = $ad['adid'];
	    $data['show_js'] = "https://".$this->config->host->ads."/show.js";
	    $data['click_js'] = "https://".$this->config->host->ads."/click.js";
	    $data['third_show_js'] = urlencode($ad['show_js']);
	    $data['third_click_js'] = urlencode($ad['click_js']);
	    $data['src'] = 0;
	    $data['view_type'] = $ad['adType'];
	    $data['view_position'] = $ad['colum1'];
	    $data['view_time'] = $ad['colum2'];
	    $data['pushid'] = sha1(time());
	    $data['src'] = 0;
	    $data['h'] = $ad['height'];
	    $data['w'] = $ad['width'];
	    $data['staff'] = array($ad);
	    $response = array();
	    $response['sn'] = $sn;
	    $response['data'] = $data;
	    $json = json_encode($response);
	    $js = "BCMain.Info.$sn = ".$json;
	    return $js;
	}
}