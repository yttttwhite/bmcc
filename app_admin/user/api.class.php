<?php
if (empty($_SESSION)) {session_start();}
class user_api{
    public function __construct(){
    }
    public function getUserID(){
        $id = self::id();
         return $id;
    }
    public static function loginStatus(){
        if(self::id()>0){
            return true;
        }else{
            return false;
        }
    }


    public static function login($uname,$passwd="",$code){
        $a = new thrift_aduser_main;
        $user=$a->getAdUserByName($uname);
        $pwd = $user->passwd.$code;
        if(!empty($user->uid) && $pwd==$passwd){
            if($user->account_status == 1){
                $_SESSION['user']=(array)$user;
                return 1;
            }else{
                return -2;//当前用户的状态为禁用
            }
        }else{
            return -3;//当前用户的密码或者用户名称不正确
        }
    }


    public static function auth($auth = '', $authType = ''){
        $authList = self::getAuth();
        if(is_array($authList)){
            if(is_array($auth)){
                if($authType === 'or'){
                    $result = false;
                    foreach ($auth as $temp){
                        $result = $result || in_array($temp, $authList);
                    }
                }else{
                    $result = true;
                    foreach ($auth as $temp){
                        $result = $result && in_array($temp, $authList);
                    }
                }
            }else{
                $result = in_array($auth, $authList);
            }
            return $result;
        }else{
            return false;
        }
    }
    
    public static function getRoleList(){
        $role = SConfig::getConfigArray(ROOT_CONFIG."/config.php",'role');
        return $role;
    }
    
    public static function getAuthList(){
        $auth = SConfig::getConfigArray(ROOT_CONFIG."/config.php",'auth');
        return $auth;
    }
    
    public static function getAuth(){
        $role = SConfig::getConfigArray(ROOT_CONFIG."/config.php",'role');
        $user = (array)self::getUserByID(self::id());
        if($user['uid']==0 || $user['status']==2){
            return false;
        }else{
            if(isset($user['role_id']) && isset($role[$user['role_id']])){
                $roleAuthList = $role[$user['role_id']]['auth_list'];
                $roleAuthList = explode(',', $roleAuthList);
                if(!is_array($roleAuthList)){
                    $roleAuthList = array();
                }
            }else{
                $roleAuthList = array();
            }
            
            if(isset($user['colum1'])){
                $columAuthList = explode(',', $user['colum1']);
                if(!is_array($columAuthList) || (count($columAuthList == 0) && $columAuthList[0]==="0")){
                    $columAuthList = array();
                }
            }else{
                $columAuthList = array();
            }
            
            $authList = array_merge($roleAuthList,$columAuthList);
            return($authList);
        }
    }
    
    public static function auth2($auth,$user=0,$type="id"){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        $authList = $config['auth'];
        if(isset($authList[$auth])){
            if(is_numeric($user) && $user==0){
                $userInfo = self::info();
            }elseif($type === "id"){
                $userInfo = self::getUserByID($user);
            }elseif($type === "name"){
                $userInfo = self::getUserByName($user);
            }else{
                return false;
            }
            $userInfo = (array)$userInfo;
            if(isset($userInfo['uid']) && $userInfo['uid']>0){
                $roleId = (int)$userInfo['role_id'];
            }else{
                return false;
            }
            
            if(in_array($roleId, $authList[$auth])){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    //退出
    public static function logout(){
        unset($_SESSION['user']);
        return true;
    }
	//获取登录者ID
	public static function id(){
		if(!empty($_SESSION['user'])){
			return $_SESSION['user']['uid'];
		}else{
		    return 0;
		}
	}
	//获取登录者名字
	public static function name(){
		if(!empty($_SESSION['user'])){
			return $_SESSION['user']['user_name'];
		}
		return "";
	}
	//获取登录者信息
	public static function info(){
	    $a = new thrift_aduser_main;
	    return $a->getAdUserById(self::id());
	}
	//通过ID获取用户信息
	public static function getUserByID($id){
	    $a = new thrift_aduser_main;
	    $info = $a->getAdUserById($id);
	    /*
	    $info->roles=array();
	    foreach(user_role::$roles as $id =>$name){
	        if($info->uid==1 || ($info->colum1 & $id)){
	            $info->roles[]=$name;
	            $info->role^=$id;
	        }
	    }*/
	    return($info);
	}
	//通过Name获取用户信息
	public static function getUserByName($name){
		$a = new thrift_aduser_main;
		$info = $a->getAdUserByName($name);
		$info->roles=array();
		foreach(user_role::$roles as $id =>$name){
			if($info->uid==1 || ($info->colum1 & $id)){
				$info->roles[]=$name;
				$info->role^=$id;
			}
		}
		return($info);
	}
	
	//判断登录者权限
	public static function haveRole($role){
	    if(!empty($_SESSION['user'])){
	        if($_SESSION['user']['uid']==1)return true;
	        //return ($_SESSION['user']['colum1'] & $role);
	        return ($_SESSION['user']['colum1'] == $role);
	    }
	    return 0;
	}
	//列出用户权限
	public static function listUsersRoles($users){
		foreach($users as &$info){
			$info->roles=array();
			foreach(user_role::$roles as $id =>$name){
				if($info->uid==1 || ($info->colum1 & $id)){
					$info->roles[]=$name;
					$info->role^=$id;
				}
			}
		}
		return($users);
	}
	//获取当前用户角色
	public static function getCurrentRole(){
	    $columId = $_SESSION['user']['colum1'];
	    return user_role::getRoleByColum($columId);
	}
	public static function generalRole(){
	    $columId = $_SESSION['user']['colum1'];
	    return in_array($columId, user_role::$generalRole);
	}
}
