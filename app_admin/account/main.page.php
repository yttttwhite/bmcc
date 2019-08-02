<?php
class account_main extends STpl{
	public function __construct($inPath){
		if(user_api::id()==0){
			header("location:/baichuan_advertisement_manage/user");
		}
	}
	public function pageEntry($inPath){
		$a = new thrift_aduser_main;
		$user=$a->getAdUserByName(user_api::name());
		$this->assign("user",$user);
		return $this->render("v2/zhanghu/jbxx.html");
	}
	
	public function pageDetail(){
	    $user = user_api::getUserById(user_api::id());
	    if( $user->uid > 0 && $user->account_status == AccountStatus::NORMAL){
            $condition = array();
            $contractModel = new model_contractInfo();
            $condition['create_uid'] = $user->uid;    //当前用户uid
            $condition['is_delete'] = 1;  //未删除的
            $condition['verify_status'] = 2;   //审核通过的
            $contractInfo = $contractModel->getData($condition ,0,-1);
            foreach($contractInfo as $key=>$value){
                if($value['contract_type'] ==1){  //竞价制
                    $bid[] = $value['access_budget'];
                }
                if($value['contract_type'] ==2){  //合约制
                    $contract[] = $value['access_budget'];
                    $unitModel = new model_contractUnit();
                    $unit_list = $unitModel->getData(array("uid"=>$user->uid));
                }
            }
            $user->bid_account = array_sum($bid);
            $user->contract_account = array_sum($contract);
	        $this->assign("user",$user);
	        $this->assign("unit_list",$unit_list);
	        $this->assign("roleList",user_api::getRoleList());
			$this->assign('email', $this->getMyEmail());
	        return $this->render("account/user_detail.html");
	    }else{
	        $this->success("该用户不存在，或者已经被冻结","/baichuan_advertisement_manage/admin.user.list");
	    }
	}

    public function pageEdit(){                                                                                                    
        $user = user_api::getUserById(user_api::id());
        if( $user->uid > 0 && $user->account_status == AccountStatus::NORMAL){
            $this->assign("user",$user);
            $this->assign("roleList",user_api::getRoleList());
            $this->assign('email', $this->getMyEmail());
            return $this->render("account/user_info.html");
        }else{
            $this->success("该用户不存在，或者已经被冻结","/admin.user.list");
        }   
    }
	
    public function pageUpdate($inPath){
        require __DIR__ .'../../../tools/SensitiveWordFilter.php';
        $filter = new SensitiveWordFilter(__DIR__ . '../../../tools/dict.txt');
        $word = $_POST;
        if(!empty($_POST)){
            $word = $_POST;
            foreach ($word as $value) {
                $re = $filter->filter($value, 0);
                if($re == false){
                    $this->success("您输入的有敏感词请检查后，再创建", "/baichuan_advertisement_manage/admin.user.list") ;
                    exit;
                }
            }
        
        }
        $a = new thrift_aduser_main;
        $user=$a->getAdUserByName(user_api::name());
        if( strtolower($_SERVER['REQUEST_METHOD'])=="post"){
            $change_pw = !empty($_POST['passwd']);
            // $user->host= $_POST['host'];
            if($_POST['cell_phone']) $user->cell_phone= $_POST['cell_phone'];
            if($_POST['email']) $user->email= $_POST['email'];
            if($_POST['address']) $user->address= $_POST['address'];
            if($_POST['zip_code']) $user->zip_code= $_POST['zip_code'];

            if( $change_pw ){ // 进入改密码流程 
                if ( $_POST['passwd']!=$_POST['password_again'] ){
                    $this->assign("error","新密码为空或者二次输入不相同");
                    return $this->render("default/account/user_info.html");
                }
                if ( strlen($_POST['passwd'])< 6 ){
                    $this->assign("error","新密码太短，最少6位");
                    return $this->render("default/account/user_info.html");
                }
                $valid = preg_match('/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9]{8,20}/',$_POST['passwd']);
                if ($valid != 1) {
                    $this->assign("error","密码必须数字英文加大小写且密码长度是8位到20位");
                    return $this->render("default/account/user_info.html");
                }

                $user->passwd= md5($_POST['passwd']);
            }
            if($a->updateAdUserInfo($user)){
                $user=$a->getAdUserByName(user_api::name());
            }
            if (isset($_POST['email'])) {
                $this->setMyEmail($_POST['email']);
            }
            if($change_pw)  return $this->success("密码修改成功，请重新登陆","/baichuan_advertisement_manage/user.main.logout");
            $this->assign("error","修改成功！");
        }
        $this->assign('email', $this->getMyEmail());
        $this->assign("roleList",user_api::getRoleList());
        $this->assign("user",$user);
        return $this->render("v2/account/user_detail.html");
    }

	public function pageUpdatePWD($inPath){
		$a = new thrift_aduser_main;
		$user=$a->getAdUserByName(user_api::name());
		if(!empty($_POST)){
			if(md5($_POST['passwd'])!=$user->passwd){
				$this->assign("error","密码错误");
			}elseif($_POST['passwd_1']!=$_POST['passwd_2'] || empty($_POST['passwd_1'])){
				$this->assign("error","新密码为空或者二次输入不相同");
			}else{
				$user->passwd= md5($_POST['passwd_1']);
				if($a->updateAdUserInfo($user)){
					$user=$a->getAdUserByName(user_api::name());
				}
				$this->assign("error","修改成功！");
			}
		}
		$this->assign("user",$user);
		return $this->render("v2/zhanghu/xgmm.html");
	}
	
	public function getMyEmail() {
		$db = new SDb();
    	$db->useConfig('adp');
    	$condition = array();
    	$condition['uid'] = user_api::id();
    	$result = $db->selectOne('adp_user_info',$condition);
    	return $result['email'];
	}

	public function setMyEmail($email) {
		$db = new SDb();
    	$db->useConfig('adp');
    	$condition = array();
    	$condition['uid'] = user_api::id();
    	$items = array('email' => $email);
        $result = $db->update('adp_user_info', $condition, $items); //更新
    	return $result == 1;
	}

}
