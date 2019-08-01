<?php
header("content-type: application/x-javascript");
header("Access-Control-Allow-Origin: *");
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
	        $json = "BCMain.Info.$sn = ".$json;
	        
	        $responseType = 0;
	        if(isset($_GET['responseType'])){
	            $responseType = $_GET['responseType'];
	        }
	        switch ($responseType) {
	            case 1:
	               echo json_encode($response);
	            break;
	            
	            case 2:
	               print_r($response);
	            break;
	            
	            case 3:
	               print_r($response);
	               echo "\r\n";
	               print_r(json_encode($response));
	            break;
	            
	            default:
	               echo $json;
	            break;
	        }
	    }
	}
}