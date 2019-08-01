<?php
class user_main extends STpl{
    public $config;
	public function __construct($inPath){
	    $this->config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
		if(user_api::id()!=0){
		}
	}
	public function pageEntry($inPath){
		return self::pageLogin($inPath);
	}
	public function pageLogin($inPath){
	    if(user_api::loginStatus()){
	        $this->success('已经登录','/account.main.detail');
	    }else{
	        if(!empty($_POST)){
	               if(strtolower(trim($_POST['code']))!==strtolower($_SESSION['authnum_session'])){
	                $logo = $this->config['logo'];
	                $copyRight = $this->config['copyright'];
	                $icp = $this->config['icp'];
	                 
	                $footer="<div class='beian'>$icp</div><div class='copyright'>$copyRight</div>";
	                 
	                $this->assign("loginfooter",   $footer);
	                $this->assign('loginLogo',     $logo);
	                $this->assign('loginCopyRight',$copyRight);
	                $this->assign("error","验证码错误");
	                return $this->render("default/login/login.html");
	            }
	            if(!empty($_POST['username']) && !empty($_POST['password'])){
                    $_POST['username'] = base64_decode($_POST['username']);
                    $status = user_api::login($_POST['username'],$_POST['password'], $_SESSION['authnum_session']);
	                if($status == 1){
                        $userModel = new model_userInfo();
                        $data = $condition = array();
                        $condition['uid'] = user_api::id();
                        $data['last_login_time'] = time(NULL);
                        $userModel->updateData($data,$condition);
	                    header("location:/baichuan_advertisement_manage/");
	                    return;
	                }else if($status==-2){
                        $this->assign("error","该用户已禁用,请联系系统管理人员");
                    }else{
	                    $this->assign("error","用户名或者密码错误");
	                }
	            }else{
	                $this->assign("error","用户名，验证码，密码都不能为空");
	            }


	        }
	        
	        $logo = $this->config['logo'];
	        $copyRight = $this->config['copyright'];
	        $icp = $this->config['icp'];
	        
	        $footer="<div class='beian'>$icp</div><div class='copyright'>$copyRight</div>";
	        
	        $this->assign("loginfooter",   $footer);
	        $this->assign('loginLogo',     $logo);
	        $this->assign('loginCopyRight',$copyRight);
	        return $this->render("v2/login/login.html");
	    }
	}
	public function pageLogout($inPath){
		if(user_api::logout()){
			header("location:/baichuan_advertisement_manage/user");
		}
	}
  
	public  function pagegetCode($inpath){
	    session_start();
	    $_vc = new user_validatecode();  //实例化一个对象
	    $_vc->doimg();
	    $_SESSION['authnum_session'] = strtolower($_vc->getCode());//验证码保存到SESSION中
	    
	}
	public  function pageTest($inpath){
	    echo strtolower("helloWoRd");
		  
	}
}
