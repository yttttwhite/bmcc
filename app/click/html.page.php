<?php
class click_html extends STpl{
    public $config;
    function __construct(){
        $this->config = SConfig::getConfig(ROOT_CONFIG."/js.conf");
        $this->assign("config",$this->config);
    }
	public function pageEntry(){
	    if(!empty($_GET['aid']) && is_numeric($_GET['aid'])){
	        $aid   =   $_GET['aid'];
	        $sn    =   empty($_REQUEST['sn'])?"":$_REQUEST['sn'];
	        $db    =   new stat_db;
	        $ad    =   $db->getStuffByAid($_GET['aid']);
	        
	        if(!filter_var($ad['landing_page'], FILTER_VALIDATE_URL)){
	            exit('目标地址不存在');
	        }
	        
	        if(isset($_GET['click_delay']) && is_numeric($_GET['click_delay'])){
	            $ad['click_delay'] = $_GET['click_delay'];
	        }else{
	            $ad['click_delay'] = 0;
	        }
	        $this->assign("ad",$ad);
	        return $this->render("/click/html_entry.html");
	    }else{
	        echo "Need aid";
	    }
	}
}