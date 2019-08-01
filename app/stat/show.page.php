<?php
class stat_show extends STpl{
    function __construct(){
        $config= SConfig::getConfig(ROOT_CONFIG."/js.conf");
        $this->assign("config",$config);
        $this->assign("_GET",$_GET);
    }
	public function pageEntry($inPath){
		if(!empty($_GET['aid'])){
			$db = new stat_db;
			$stuff = $db->getStuffByAid($_GET['aid']);
			if(!empty($stuff)){
				$this->assign('stuff',$stuff);
				if(isset($_GET['debug'])){print_r($stuff);}
				switch ($stuff['type']) {
				    case 1:
				    return $this->render("stat/show_image.html");
				    break;
				    
				    case 2:
				    return $this->render("stat/show_flash.html");
				    break;
				    
				    case 7:
				    return $this->render("stat/show_iframe.html");
				    break;
				    
				    default:
				    return $this->render("stat/show_stat_only.html");
				    break;
				}
			}else{
    		    echo "广告展示监控：没有匹配到广告信息";
    		}
		}else{
		    echo "广告展示监控：请指定ID";
		}
	}
}
