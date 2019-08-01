<?php
class audient_main extends STpl{
    public function __construct(){
        if(!user_api::auth("audient")){
            $this->success("没有权限",'/user',3);
            exit();
        }
    }
    function GetUserInfo() {
        return array('id' => user_api::id(), 'name' => user_api::name());
    }
    function InitDB() {
		return audient_db::InitDB();
    }
    function GetCode($in) {#var_dump($in);
		$ret = 
         "<script type=\"text/javascript\"> var bcdata_stat_id=\"${in['websiteid']}\"; </script> <script src=\"https://" . ($in['manage']==='1'?'js.bcdata.com.cn':$in['jsserver']) . "/stat.js\" type=\"text/javascript\"></script>";
		 #var_dump($ret);
		 return $ret;
    }
	
	function setCode($in) {
		$db = $this::InitDB();
		$table = 'rmc_audience_website';
		$condition = "user_id=${in['uid']} and name='${in['name']}'"; $item = "id"; $groupby = ""; $orderby = ""; $leftjoin = "";
		$ret = $db->selectOne($table, $condition, $item, $groupby, $orderby, $leftjoin);
		#var_dump($db);
		if($ret !== false){
			$websiteid = $ret['id'];
			$uid = $in['uid'];
			$table = 'rmc_audience_website';
			$condition = "user_id=$uid and id=$websiteid";
			$in['websiteid'] = $websiteid;
			$item = array("code"=>$this::GetCode($in));
			$ret = $db->update($table, $condition, $item);
/* 			var_dump($table);
			var_dump($condition);
			var_dump($item);
			var_dump($ret);
			var_dump($db); */
			if ($ret === false) return false;
			else return true;
		}
		else return false;
	}
    function array_remove_value($arr, $var){
        $ret = array();
        foreach( $arr as $k=>$v ) if ($v['name'] != $var) $ret[] = array('name'=>$v['name']);
        return $ret;
    }
    
    
    
    function ShowWebsite($new = false) {
        $DomainName = array_key_exists('domain_name', $_COOKIE) ? $_COOKIE['domain_name']:'';
        $DomainName = array_key_exists('domain_name', $_POST) ? $_POST['domain_name']:$DomainName;
        $Name = array_key_exists('name', $_COOKIE) ? $_COOKIE['name']:'';
        $Name = array_key_exists('name', $_POST) ? $_POST['name']:$Name;
        $CreateAt = array_key_exists('CreateAt', $_COOKIE) ? $_COOKIE['CreateAt']:'';
        $CreateAt = array_key_exists('CreateAt', $_POST) ? $_POST['CreateAt']:$CreateAt;
		

        if ($new) { $DomainName = ''; $Name = ''; $CreateAt = ''; }
        setcookie("domain_name", $DomainName, time()+3600);
        setcookie("name", $Name, time()+3600);
        setcookie("CreateAt", $CreateAt, time()+3600);
        $uinfo = $this::GetUserInfo();
        $uid = $uinfo['id']; $uname = $uinfo['name'];
        $db = $this::InitDB();
        $table = "rmc_audience_website";
		$condition = "user_id=$uid ";
		if($_REQUEST['is_working']=="normal")$condition.="and is_working!=0"; 
		else $condition.=" and is_working=1";
		$item = ""; $groupby = ""; $orderby = ""; $leftjoin = "";
        if ($DomainName != '') $condition = $condition . " and domain_name like '%$DomainName%'";
        if ($Name != '') $condition = $condition . " and name like '%$Name%'";

		$page=!empty($_REQUEST['page']) ? $_REQUEST['page'] :1 ;
		$db->setPage($page);
		$db->setLimit(50);
        $ret = $db->select($table, $condition, $item, $groupby, $orderby, $leftjoin);
		
        $error = true; $message = ''; $result = array();
        
        if ($ret === false) $message = "查询发生错误，请与管理员联系";
        else if ($ret->totalSize == 0) $message = "没有任何结果，请先创建网站";
        
        else { 
            $error = false;
            $result = $ret->items;
            
            foreach ($result as $k => $v) {
                $result[$k]['IndexCode_Status'] = '未检测';
                $result[$k]['Code_Status'] = $v['is_valid'] == 1 ? '启用' : '禁用';
                $result[$k]['Code_op'] = "<a href='/audient.main.getcode?websiteid=${v['id']}'>获取代码</a>&nbsp;<a href='javascript:void(0)'><S>自动安装</S></a>";
                $result[$k]['Status_op'] = "<a onclick='return confirm(\"你确定要删除吗？\")' href='/audient.main.deletewebsite?websiteid=${v['id']}'>删除</a>&nbsp;<a href='/audient.main.websitestatusswitch?websiteid=${v['id']}&status=${v['is_valid']}'>" . ( $v['is_valid'] == 1 ? '禁用' : '启用' ) . "</a>";
            }
			$pager = pager_api::page($ret,"?&page=%p");
			$this->assign("pager",$pager);
        }
        
        STpl::assign("DomainName", $DomainName);
        STpl::assign("Name", $Name);
        STpl::assign("CreateAt", $CreateAt);
        STpl::assign("error", $error);
        STpl::assign("message", $message);
        STpl::assign("result", $result);
        STpl::assign("is_working", $_REQUEST['is_working']);
        //var_dump($result);
		return $this->render("v2/renqun/jiankong.html");
    }
	function pageEntry($inPath) {
		
        return $this->ShowWebsite($_POST?false:true);
	}
    function pageWebsiteStatusSwitch($inPath) {
        $uinfo = $this::GetUserInfo();
        $uid = $uinfo['id']; $uname = $uinfo['name'];
        $websiteid = $_GET['websiteid'];
        $status = ($_GET['status']+1)%2;
        $db = $this::InitDB();
        $table = 'rmc_audience_website';
        $condition = "user_id=$uid and id=$websiteid";
        $item = array("is_valid"=>$status);
        $db->update($table, $condition, $item);
        return $this->ShowWebsite();
    }
    function pageDeleteWebsite($inPath) {
        $uinfo = $this::GetUserInfo();
        $uid = $uinfo['id']; $uname = $uinfo['name'];
        $websiteid = $_GET['websiteid'];
        $db = $this::InitDB();
        $table = 'rmc_audience_website';
        $condition = "user_id=$uid and id=$websiteid";
		$item = array("is_working"=>0);
        $db->update($table, $condition, $item);
        #$db->delete($table, $condition);
        return $this->ShowWebsite();
    }
    function pageNewWebsite($inPath) {
        if($_POST){
            $name = $_POST['name'];
            $domain_name = $_POST['domain_name'];
			$jsserver = array_key_exists('jsserver', $_POST)?$_POST['jsserver']:'';
			$manage = array_key_exists('manage', $_POST)?$_POST['manage']:'0';
            $db = $this->InitDB();
			
            $table = 'rmc_audience_website';
			
            $uinfo = $this::GetUserInfo();
            $uid = $uinfo['id']; $uname = $uinfo['name'];
			
			$condition = "user_id=$uid and name='$name'"; $item = "user_id"; $groupby = ""; $orderby = ""; $leftjoin = "";
			$ret = $db->select($table, $condition, $item, $groupby, $orderby, $leftjoin);
            
			if (count($ret->items) === 0){
				$code = '';
				$item = array("name"=>$name,"domain_name"=>$domain_name, "user_id"=>$uid, 'create_time'=>date('Y-m-d'), 'code'=>$code, 'is_valid'=>1, 'is_working'=>1);
				$isreplace = false; $isdelayed=  false; $update=array();
				$ret = $db->insert($table,$item,$isreplace,$isdelayed,$update); #var_dump($db);var_dump($ret);
				if ($ret===false ||$this->setCode(array('name'=>$name,'uid'=>$uid,'manage'=>$manage,'domain'=>$domain_name,'jsserver'=>$jsserver)) === false) {
					STpl::assign("e", true);
					return $this->render("v2/renqun/jk_new.html");
				} else {
					STpl::assign("e", false);
					setcookie("domain_name", '', time()+3600);
					setcookie("name", '', time()+3600);
					setcookie("CreateAt", '', time()+3600);
					return $this->ShowWebsite(true);
				}
			} else {
				STpl::assign("e", false);
                setcookie("domain_name", '', time()+3600);
                setcookie("name", '', time()+3600);
                setcookie("CreateAt", '', time()+3600);
                return $this->ShowWebsite(true);
			}
        }
        else return $this->render("v2/renqun/jk_new.html");
    }
    function pageGetCode($inPath) {
        $uinfo = $this::GetUserInfo();
        $uid = $uinfo['id']; $uname = $uinfo['name'];
        $db = $this::InitDB();
        $websiteid = $_GET['websiteid'];
        $table = "rmc_audience_website";
        $condition = "user_id=$uid and id=$websiteid"; $item = "code"; $groupby = ""; $orderby = ""; $leftjoin = "";
        $ret = $db->select($table, $condition, $item, $groupby, $orderby, $leftjoin);
        if ($ret === false || $ret->totalSize != 1) $code = "查询发生错误，请与管理员联系";
        else { $code = $ret->items[0]; $code = $code['code']; }
        STpl::assign("code", $code);
        return $this->render('v2/renqun/jk_code.html');
    }
    
    
    
    
    
    
    
    
    
    function ShowCrowd($new = false) {
        
        $websitename = array_key_exists('web_site_name', $_COOKIE) ? $_COOKIE['web_site_name']:'';
        $websitename = array_key_exists('web_site_name', $_POST) ? $_POST['web_site_name']:$websitename;
        
        $crowd = array_key_exists('crowd', $_COOKIE) ? $_COOKIE['crowd']:'';
        $crowd = array_key_exists('crowd', $_POST) ? $_POST['crowd']:$crowd;
        
        $status = array_key_exists('status', $_COOKIE) ? $_COOKIE['status']:'';
        $status = array_key_exists('status', $_POST) ? $_POST['status']:$status;
        
        $createat = array_key_exists('createat', $_COOKIE) ? $_COOKIE['createat']:'';
        $createat = array_key_exists('createat', $_POST) ? $_POST['createat']:$createat;
        
        if($new) {
            $websitename = '';
            $crowd = '';
            $status = '';
            $createat = '';
        }
        
        setcookie("web_site_name", $websitename, time()+3600);
        setcookie("crowd", $crowd, time()+3600);
        setcookie("status", $status, time()+3600);
        setcookie("createat", $status, time()+3600);
        
        $uinfo = $this::GetUserInfo();
        $uid = $uinfo['id']; $uname = $uinfo['name'];
        $db = $this::InitDB();
        
        $websiteid = '';
        if ($websitename) {
            $table = 'rmc_audience_website';
            $condition = "user_id=$uid and name='$websitename'"; $item = "id"; $groupby = ""; $orderby = ""; $leftjoin = "";
            $ret = $db->selectOne($table, $condition, $item, $groupby, $orderby, $leftjoin);
            #var_dump($db);
            if($ret !== false){
                $websiteid = $ret['id'];$web_site_name_k = $websitename;
            }
        } else $web_site_name_k = '';
        #ar_dump($websiteid);
        $table = "rmc_audience_crowd";
        $condition = "web_site_id in (select id from rmc_audience_website where user_id=$uid)"; $item = ""; $groupby = ""; $orderby = ""; $leftjoin="";
        
        if ($websiteid) { $condition = $condition . " and web_site_id = $websiteid"; }
        
        if ($status === '有效') { $condition = $condition . ' and status = 1'; $status = "<option>有效</option><option value=''>全部</option> <option>无效</option>"; }
        else if ($status === '无效' ) { $condition = $condition . ' and status = 0'; $status = "<option>无效</option><option value=''>全部</option> <option>有效</option>"; }
        else $status = "<option value=''>全部</option><option>无效</option> <option>有效</option>";
        if ($crowd)  { $condition = $condition . " and name like '%$crowd%'"; }
        STpl::assign("status", $status);
        STpl::assign("web_site_name_k", '<option>' . $websitename . '</option>');
        
        STpl::assign("crowd", $crowd);
		$page=!empty($_REQUEST['page']) ? $_REQUEST['page'] :1 ;
		$db->setPage($page);
		$db->setLimit(50);
        $ret = $db->select($table, $condition, $item, $groupby, $orderby, $leftjoin);
        
        
        
        if ($ret === false) {
            STpl::assign("error", true);
            $result = array();
        } else {
            STpl::assign("error", false);
			echo "<!--";
			print_r($ret);
			echo "-->";
            $result = $ret->items;
			$pager = pager_api::page($ret,"?&page=%p");
			$this->assign("pager",$pager);
        }
        
        foreach ( $result as $k=>$v ) {
            $web_site_id = $v['web_site_id'];
            $table = 'rmc_audience_website'; $condition = "user_id=$uid and id=$web_site_id"; $item = "name"; $groupby = ""; $orderby = ""; $leftjoin= "";
            $ret = $db->selectOne($table, $condition, $item, $groupby, $orderby, $leftjoin);
            $result[$k]['wname'] = $ret['name'];
            #var_dump($result);
            $result[$k]['status'] = $result[$k]['status']==1?'有效':'无效';
            $result[$k]['op'] = "<a href='#'><S>统计</S></a> <a href='/audient.main.ModifyCrowd?crowdid=${v['id']}'>修改</a> <a href='/audient.main.deletecrowd?crowdid=${v['id']}'>删除</a> <a href='#'><S>添加投放</S></a>";
        }
        
        STpl::assign("result", $result);
        $table = 'rmc_audience_website';
        $condition = "user_id=$uid"; $item = "name"; $groupby = ""; $orderby = ""; $leftjoin = "";
        $ret = $db->select($table, $condition, $item, $groupby, $orderby, $leftjoin);
        if ($ret === false)
            $websitename = array();
        else
            $websitename = $ret->items;
        
        STpl::assign("websitename", $this->array_remove_value($websitename, $web_site_name_k));
        
        return $this->render("v2/renqun/renqun.html");
    }
	function pageRenqun($inPath){
        $this->ShowCrowd($_POST?false:true);
	}
    function pageDeleteCrowd($inPath) {
        $uinfo = $this::GetUserInfo();
        $uid = $uinfo['id']; $uname = $uinfo['name'];
        $crowdid = $_GET['crowdid'];
        $db = $this::InitDB();
        $table = 'rmc_audience_crowd';
        $condition = "id=$crowdid";
        $db->delete($table, $condition);
        return $this->ShowCrowd();
    }
	function pageModifyCrowd($inPath) {
		if ($_POST) {
			# processssss
		}
		$crowdid = $_GET['crowdid'];
        $db = $this::InitDB();
        $table = 'rmc_audience_crowd';
        $condition = "id=$crowdid";
        
        $item = ""; $groupby = ""; $orderby = ""; $leftjoin = "";
        $ret = $db->selectOne($table, $condition, $item, $groupby, $orderby, $leftjoin);
        
        //var_dump($ret);
        $websitename = '';
		STpl::assign("websitename", array($websitename));
		return $this->render("v2/renqun/rq_new.html");
	}
    function pageNewCrowd($inPath) {
        setcookie("web_site_name", '', time()+3600);
        setcookie("crowd", '', time()+3600);
        setcookie("status", '', time()+3600);
        setcookie("createat", '', time()+3600);
        $db = $this::InitDB();
        $uinfo = $this::GetUserInfo();
        $uid = $uinfo['id']; $uname = $uinfo['name'];#var_dump($_POST);
        if($_POST && array_key_exists('web_site_name', $_POST)){
            
            $web_site_name = $_POST['web_site_name'];
            $name = $_POST['name'];
            $valid_time = $_POST['valid_time'];
            $tac = $_POST['tac'];
            $category = $_POST['category'];
			
            $table = 'rmc_audience_website';
            $condition = "user_id=$uid and name='$web_site_name'"; $item = "id"; $groupby = ""; $orderby = ""; $leftjoin = "";
            $ret = $db->select($table, $condition, $item, $groupby, $orderby, $leftjoin);
            if($ret === false) {
                $error = true;STpl::assign("error", true);
            } else {
                $row = $ret->items[0];
                $web_site_id = $row['id'];
                $table = 'rmc_audience_crowd';
                $item = array("web_site_id"=>$web_site_id, "price"=>$_POST['price']+0.0, "name"=>$name, 'status' => 1, 'valid_time'=>$valid_time, 'create_time'=>date('Y-m-d'), 'is_valid'=>1, 'number'=>0, "priv"=>$_POST['priv']);
                $isreplace = false; $isdelayed = false; $update = array();
                
                $ret = $db->insert($table, $item, $isreplace, $isdelayed, $update);
				#var_dump($ret);
				#var_dump($db);
                if ($ret === false) {
                    $error = true;STpl::assign("error", true);
                } else {
/* 					$table = 'rmc_audience_crowd';
					$condition = ""; $item = "MAX(id) as id"; $groupby = ""; $orderby = ""; $leftjoin = "";
					$ret = $db->selectOne($table, $condition, $item, $groupby, $orderby, $leftjoin); */
					$crowdid = $ret;
					$table = 'rmc_audience_tactics';
                    
                    $category = $_POST['category']; $url = $_POST['includeurl']; $days = $_POST['includedays']; $priv = $_POST['priv'];
					$item = array('days'=>$days, 'crowd_id'=>$crowdid, 'url'=>$url, "category"=>$category);
                    $isreplace = false; $isdelayed = false; $update = array();
                    $ret = $db->insert($table, $item, $isreplace, $isdelayed, $update);
                           #var_dump($ret);
                           #var_dump($db);
                    $category = "0"; $url = $_POST['excludeurl']; $days = $_POST['excludedays'];
					$item = array('days'=>$days, 'crowd_id'=>$crowdid, 'url'=>$url, "category"=>$category);
                    $isreplace = false; $isdelayed = false; $update = array();
                    #$ret = $db->insert($table, $item, $isreplace, $isdelayed, $update);
                    $error = false;
                    if(false) {
                        #$arr = explode ( "\n" , $tac );
                        $arr = array("包含|".$_POST['tac2']);
                        $error = false;
                        foreach($arr as $k=>$v) 
                        {
                            $t = explode ( "|" , $v);
                            if(count($t)!=2)continue;
                            $url = $t[1];
                            $category = $t[0];
                            if($t[0] === '包含')$category = 1;
                            else if ($t[0] === '排除')$category = -1;
                            else $category = 0;
                            $item = array('crowd_id'=>$crowdid, 'url'=>$url, "category"=>$category);
                            $isreplace = false; $isdelayed = false; $update = array();
                            $ret = $db->insert($table, $item, $isreplace, $isdelayed, $update);
                            if($ret !== false){
                                break;
                            } else {
                                $error = true;
                                STpl::assign("error", true);
                                $table = 'rmc_audience_tactics';
                                delete($table,$condition="crowd_id=$crowdid");
                                break;
                            }
                        }
					}
					if($error === false)$this->ShowCrowd(true);
                }
            }
			STpl::assign("error", $error);
			return $this->render("v3/renqun/rq_new.html");
        } else { $error = false;STpl::assign("error", false); }
        $table = 'rmc_audience_website';
        $condition = "user_id=$uid and is_working!=0"; $item = "name"; $groupby = ""; $orderby = ""; $leftjoin = "";
        $ret = $db->select($table, $condition, $item, $groupby, $orderby, $leftjoin);
        if ($ret === false) $websitename = array();
        else $websitename = $ret->items;
        STpl::assign("websitename", $websitename);
		
        return $this->render("v3/renqun/rq_new.html");
        
    }
}
