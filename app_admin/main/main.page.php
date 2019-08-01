<?php
class main_main extends STpl{
    private $config;
	public function __construct($inPath){
	    $this->config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
	    $version = SConfig::getConfigArray(ROOT_CONFIG."/config.php",'version');
	    $version = $version['version'];
	    $this->assign('version',$version);
	}
	public function pageEntry($inPath){
	    if(user_api::id()==0){
	        header("location:/baichuan_advertisement_manage/user");
	    }else{
	        header("location:/baichuan_advertisement_manage/ad/");
	    }
	    $api = new ad_api;
	    $start=date("Y-m-d",time()-30*24*3600);
	    $end=date("Y-m-d",time());
	    $plans = $api->listPlansReport($start,$end);
	    $this->assign("plans2",$plans);
	    $this->assign("start",$start);
	    $this->assign("end",$end);
	    return $this->render("v2/index.html");
	}
	public function pageHeader($inPath){
		$this->assign("logo",$this->config['logo']);
		return $this->render("v2/header.tpl","",$this->config['theme']);
	}
	public function pageFooter($inPath){
	    $copyRight = $this->config['copyright'];
	    $icp = $this->config['icp'];
		$footer="<div class='beian'>$icp</div><div class='copyright'>$copyRight</div>";
		$this->assign("footer",$footer);
		return $this->render("v2/footer.tpl");
	}
	public function pageLoginFooter($inPath){
		return $this->render("v2/footer-login.tpl");
	}
	public function pageNav($inPath){
		if(user_api::id()==0){
			header("location:/baichuan_advertisement_manage/user");
		}
		$config = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'version');
		$this->assign("config",$config);
		
		$a = new thrift_aduser_main;
		//获取当前用户创建的用户列表
		/*
		$users = $a->getAdUsersByCid(user_api::id(),AccountStatus::NORMAL);
		$users[] = user_api::info();
		$this->assign("users",$users);
		*/
		$currentUser = $a->getAdUserById(user_api::id());
		$this->assign("currentUser",$currentUser);
		$currentUrl = explode('?',$_SERVER['REQUEST_URI']);
		$nav = 0;
		if($currentUrl[0] =="/admin.contract.Audited"){
			$nav =7;
		}elseif($currentUrl[0] =="/admin.caiwu.list"){
			$nav =5;
		}else{
			if(isset($_GET['nav']) && $_GET['nav'] >0){
				$nav = $_GET['nav'];
			}
		}
		if($nav ==0){
			$ad = "ad";
		  $this->assign("ad",$ad);
		}

		$this->assign("nav",$nav);
		$userName = user_api::name();
		$message = new message_api; //初始化消息数据库
		//待审核计划
		$plan = $message->getPlanCheck();
		//待审核素材
		$stuff = $message->getStuffCheck();
		//获取未读消息
		$msgCount = $message->getMsgCount();

		$this->assign('checkplan', $plan->totalSize);
		$this->assign('checkstuff', $stuff->totalSize);
		$this->assign('msgCount', $msgCount);
		return $this->render("v2/nav.html","",$this->config['theme']);
	}
}
