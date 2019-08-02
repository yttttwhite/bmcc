<?php

class admin_user extends STpl
{

    public function __construct($inPath)
    {
        /*if (! user_api::auth("system,admin,")) {
            die("权限拒绝");
        }*/
        $info = user_api::info();
        $roleId = $info->role_id;
        if(!in_array($roleId,array(10000,1000,18,17,12))){
              $this->success("没有权限",'/baichuan_advertisement_manage/user',3);
	          exit();
        }
    }

    public function pageLeft($inPath)
    {
        if (! empty($inPath[3])) {
            $this->assign("nav", $inPath[3]);
        }
        if (! empty($inPath[4])) {
            $this->assign("nav_sub", $inPath[4]);
        }
        $role = user_api::getCurrentRole();
        $info = user_api::info();
        if ($info->role_id == 10000) {
            $roleList = user_api::getRoleList();
        } elseif ($info->role_id == 1000) {
            $roleList = user_api::getRoleList();
        } elseif ($info->role_id == 18) {
            $roleList = user_api::getRoleList();
            unset($roleList[10000]);
            unset($roleList[1000]);
            unset($roleList[18]);
        } elseif ($info->role_id == 12) {
            $roleList = user_api::getRoleList();
            unset($roleList[10000]);
            unset($roleList[1000]);
            unset($roleList[18]);
            unset($roleList[12]);
        }
        
        /*
         * if(!user_api::auth("admin")){
         * unset($roleList[10000]);
         * unset($roleList[1000]);
         * }
         */
        unset($roleList[11]);
        unset($roleList[14]);
        unset($roleList[15]);
        unset($roleList[16]);
        unset($roleList[17]);
        $this->assign("roleList", $roleList);
        $this->assign("get", $_GET);
        return $this->render("admin/user_left.html");
    }

    public function pageList($inPath)
    {
        if (isset($_GET['status']) && $_GET['status'] === 1) {
            $status = AccountStatus::NORMAL;
        } else {
            $status = AccountStatus::ALL;
        }
        $this->assign("nav_sub", "list");
        $a = new thrift_aduser_main();
        // 改成所有用户接口
        $admin = 0;
        $info = user_api::info();
        $user_model = new model_userInfo();
        if (user_api::auth("system")) {
            $admin = 1;
            $page = ! empty($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $pageSize = ! empty($_REQUEST['ps']) ? $_REQUEST['ps'] : 1;
            $condition = array();
            /*if ($_GET['status'] != '') {
                $condition['account_status'] = $_GET['status'];
            }
            if ($_GET['account_type'] != '') {
                $condition['account_type'] = intval($_GET['account_type']);
            }*/

            $users = $user_model->getData($condition,0,-1);
            /*
             * $users = $a->getAdUsersByCid(1,$status);
             * //$pager = pager_api::page(pager_api::toData(users),"?page=%p&status=$status");
             * foreach ($users as $temp){
             * $users = array_merge($users, $a->getAdUsersByCid($temp->uid,$status));
             * }
             * $users = array_merge($users, $a->getAdUsersByCid(0,$status));
             */
        } else {
//             $users = $a->getAdUsersByCid(user_api::id(),$status);
            $all_users = $user_model->getData(array(),0,-1);
            $item_1 = array();
            $item_2 = array();
            $role = array("12","13");
            foreach($all_users as $user){   //子运营账户
                  if($info->role_id ==18 && in_array($user['role_id'],$role) && $user['creator_id'] == $info->uid){  //所有客户经理和广告主
                        $item_1[] = $user;
                  }
              }
            $manager_uid_list = array_column($item_1,"uid"); //客户经理uid
            if($info->role_id ==12){ //客户经理
                $manager_uid_list = array($info->uid);
            }
            foreach($all_users as $aduser){
                if(in_array($user['role_id'],$role) && in_array($user['creator_id'],$manager_uid_list)){
                    $item_2[] = $aduser;
                }
            }
//            $users = array_merge($item_1,$item_2);
            $users = $item_2;
        }

        $users = json_encode($users);
        $users = json_decode($users);
        //$users = user_api::listUsersRoles($users);
        //$pager = pager_api::page(pager_api::toData(users), "?page=%p&status=$status");
        $creator[0] = "----";
        // 查看所有用户,客户经理
        $condition = array();
        $condition['creator_id'] = $info->uid;
        //$condition['role_id'] = 12;
        $user_model = new model_userInfo();
        $userTemp = $user_model->getData($condition, 0, - 1);
        if ($userTemp) {
            foreach ($userTemp as $k => $v) {
                $uidManager[] = $v['uid'];
            }
        }
        foreach ($users as $key => $user) {
            if (!empty($_GET['key']) && strlen($_GET['key']) > 0 && stripos($user->user_name, $_GET['key']) === false) {
                unset($users[$key]);
            }
            if (!empty($_GET['account_type']) && ($user->source != $_GET['account_type'])) {
                unset($users[$key]);
            }
            if (!empty($_GET['status']) && strlen($_GET['status']) > 0 && ($user->account_status!= $_GET['status'])) {
                unset($users[$key]);
            }
            if (!empty($_GET['role']) && $user->role_id != $_GET['role']) {
                unset($users[$key]);
            }
            $creator[$user->uid] = $user->user_name;
            if ($user->role_id == 10000) {
                // unset($users[$key]);
            }
        }

        if ($info->role_id == 18) {
            $conditionTemp = array();
            $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为子运营账户的uid
            $marketUser = array();
            $marketkey = array();
            $marketUser = $user_model->getData($conditionTemp, 0, - 1);
            if ($marketUser) {
                foreach ($marketUser as $key => $v) {
                    array_push($marketkey, $v['uid']); // 所属客户经理的用户uid，查看所有广告主
                }
            }
        }
        foreach ($users as $key => $user) {
            // 子运营账户只能管理所属的客户经理和广告主
            if ($info->role_id == 18) {
                // 子运营查看广告主时
                if ($_GET['role'] == 13) {
                    if (! in_array($user->creator_id, $marketkey)) {
                        unset($users[$key]);
                    }
                }
                if ($_GET['role'] == 12) {
                    // 子运营查看客户经理时候
                    if ($info->uid != $user->creator_id) {
                        unset($users[$key]);
                    }
                }
                // 查看所有用户，不选用户角色
                if ($_GET['role'] == null) {
                    if (in_array($user->creator_id, $marketkey)) {
                        $keys[] = $user->uid;
                    }
                    if ($info->uid == $user->creator_id) {
                        $keys_[] = $user->uid;
                    }
                }
            }

            // 客户经理只能管理所属的广告主
            if ($info->role_id == 12) {
                
                if ($info->uid != $user->creator_id) {
                    unset($users[$key]);
                }
            }
        }
        // 子运营账户
        if ($info->role_id == 18) {
            // 处理不选角色时候
            foreach ($keys_ as $v) {
                array_push($keys, $v);
            }
            $keys = array_unique($keys);
            if ($_GET['role'] == null) {
                foreach ($users as $k => $v) {
                    if (! in_array($v->uid, $keys)) {
                        unset($users[$k]);
                    }
                }
            }
        }
        /*
         * $usersTemp = array();
         * $usersTemp['pageNumber'] = $page;
         * $usersTemp['pageSize'] = $pageSize;
         * $usersTemp['totalSize'] = count($users);
         * $usersTemp['data'] = '';
         * $usersTemp = json_encode($usersTemp);
         * $usersTemp = json_decode($usersTemp);
         * $usersTemp->data = $users;
         */
        // 分页操作
        $usersArr = array();
        foreach($users  as $v){
            $usersArr[] = $v;
        }
        $total = count($usersArr);
        if ($_GET['pageNum']) {
            $pageNum = $_GET['pageNum'];
        } else {
            $pageNum = 1;
        }
        $pageSize = 30;
        if ($pageNum * $pageSize - 1 <= $total) {
            $start = ($pageNum - 1) * $pageSize;
            $end = $pageNum * $pageSize - 1;
        } else{
            $start = ($pageNum - 1) * $pageSize;
            $end = $total-1;
        }
        $users = array_slice($usersArr, $start, $pageSize);
        $totalPage = ceil($total/$pageSize);
        $this->assign("totalPage", $totalPage);
        $this->assign("pageNum", $pageNum);
        //$pager = pager_api::page(pager_api::toData($usersTemp),"?page=%p&status=$status&account_type=");
        $url['formAction'] = "/baichuan_advertisement_manage/admin.user.list";
        $this->assign("url", $url);
        $this->assign("pager", $pager);
        $this->assign('total', $total);
        $this->assign("roles", user_api::getRoleList());
        $this->assign("roleList", user_api::getRoleList());
        foreach($users  as $key => $val){
          if($val->uid==$info->uid){
                 $users[$key]->edit = 0;
             } else{
                 $users[$key]->edit = 1;
             }
        }

        // 转换对象
        $users = json_encode($users);
        $users = json_decode($users);
        $this->assign("_users", $users);
        $this->assign("creator", $creator);
        $this->assign("admin", $admin);
        return $this->render("admin/user_ggz.html");
    }

    /**
     *查看用户详情
     */
    public function pageDetail()
    {
        if (isset($_GET['uid'])) {
            $user = user_api::getUserById($_GET['uid']);
            $a = new thrift_aduser_main();
            if ($user->uid > 0) {
                $caiwuModel = new model_caiwuLog();
                $historyCharge = $caiwuModel->getHistoryChargeByUid($user->uid);
                $creator = $a->getAdUserById($user->creator_id);
                if (empty($creator->user_name)) {
                    $creator->user_name = "----";
                }
                $start = date('Y-m-d', $user->reg_time);
                $end = date('Y-m-d', time(NULL));
                $r = dc_api::DayByUid($user->uid, $start, $end);
                foreach ($r->data as $item) {
                    $show += $item->show;
                    $cost += $item->cost;
                }
                $show = $show / 1000;
                if (empty($show)) {
                    $show = 0;
                }
                if (empty($cost)) {
                    $cost = 0;
                }
                $condition = array();
                $condition['uid'] = $user->uid;
                $planModel = new model_planInfo();
                $adModel = new model_adInfo();
                $stuffModel = new model_stuffInfo();
                $userModel = new model_userInfo();
                $u = $userModel->getData($condition, 0, - 1);
                $plan = $planModel->getData($condition, 0, - 1);
                $ad = $adModel->getData($condition, 0, - 1);
                
                $planStat = array(
                    "cnt" => 0,
                    "run" => 0,
                    "0" => 0,
                    "1" => 0,
                    "2" => 0,
                    "3" => 0
                );
                $adStat = array(
                    "cnt" => 0,
                    "run" => 0,
                    "0" => 0,
                    "1" => 0,
                    "2" => 0,
                    "3" => 0
                );
                foreach ($plan as $k => $item) {
                    if ($item[enable] == 4) {
                        unset($plan[$k]);
                        continue;
                    }
                    $planStat[$item[verified_or_not]] ++;
                    if ($item[enable] == 1) {
                        $planStat['run'] ++;
                    }
                }
                foreach ($ad as $k => $item) {
                    if ($item[play_status] == 4) {
                        unset($ad[$k]);
                        continue;
                    }
                    $condition['adid'] = $item['adid'];
                    $stuff = $stuffModel->getData($condition, 0, - 1);
                    $adStat[$stuff[0][verified_or_not]] ++;
                    if ($item[play_status] == 1) {
                        $adStat['run'] ++;
                    }
                }
                $planStat['cnt'] = count($plan);
                $adStat['cnt'] = count($ad);
                $this->assign("historyCharge", $historyCharge);
                $this->assign("lastlogin", $u[0][last_login_time]);
                $this->assign("planStat", $planStat);
                $this->assign("adStat", $adStat);
                $this->assign("show", $show);
                $this->assign("cost", $cost);
                $this->assign("creator", $creator->user_name);
                $this->assign("user", $user);
                $this->assign("roleList", user_api::getRoleList());
                return $this->render("admin/user_detail.html");
            } else {
                $this->success("该用户不存在，或者已经被冻结", "/baichuan_advertisement_manage/admin.user.list");
            }
        } else {
            $this->success("请输入有效用户ID", "/baichuan_advertisement_manage/admin.user.list");
        }
    }

    public function pageAdd($inPath)
    {
//        require __DIR__ .'../../../tools/SensitiveWordFilter.php';
//        $filter = new SensitiveWordFilter(__DIR__ . '../../../tools/dict.txt');
//        if(!empty($_POST)){
//            $word = $_POST;
//            foreach ($word as $value) {
//                $re = $filter->filter(trim($value), 0);
//                if($re == false){
//                    $this->success("您输入的有敏感词请检查后，再创建", "/admin.user.list") ;
//                    exit;
//            }
//            }
//
//        }

        $host = SConfig::getConfig(ROOT_CONFIG."/js.conf","host");
//     if(!empty($_POST) ){
     if($_POST['source'] == 5){

        //新增页面跳转而来
        $response['error'] = 0;
        $response['message'] = "";
        $types = array("image/gif","image/jpg","image/jpeg");
        $ad_type = "";
        if(isset($_FILES['ad-image-file']['tmp_name']) && file_exists($_FILES['ad-image-file']['tmp_name'])){
            $f_type=strtolower($_FILES['ad-image-file']['type']);
            $ad_type = $f_type;
            $maxSize = 400*1024;
            if(!in_array($f_type, $types)){
                $response['error']++;
                if(strlen($f_type)>0){
                    $response['message'] .= "仅支持jpg、gif,jpeg格式图片，识别到的文件类型为：".$f_type;
                }else{
                    $response['message'] .= "文件类型无法识别";
                }
            }else{
                    if(filesize( $_FILES['ad-image-file']['tmp_name'] )>$maxSize){
                        $response['error']++;
                        $response['message'] .= "图片不能大于400K";
                    }
            }

        }else{
                $response['error']++;
                $response['message'] .= "没有收到上传文件，或文件类型不支持";
        }

        if($response['error'] > 0){
            $this->assign("response",$response);
            return $this->render("admin/user_ggz_add.html");
            exit();

        }else{

            $result = $this->saveFile($_FILES['ad-image-file']);
            if(isset($result['error'])){

            }elseif($result['fileid']){
                $imgUrls   = "https://".$host->stuff."/".$result['fileid'];
            }
        }

     }

        $user_model = new model_userInfo();
        $a = new thrift_aduser_main();
        $user = new AdUser();
        $info = user_api::info();
        $user->host = $_POST['host'];
        $user->company_name = $_POST['company_name'];
        $user->cell_phone = $_POST['cell_phone'];
        $user->address = $_POST['address'];
        $user->zip_code = $_POST['zip_code'];
        $user->account_status = $_POST['account_status'];
        $user->source = intval($_POST['source']);
        $user->passwd = md5($_POST['passwd']);
        $user->type = $_POST['type'];
        $user->diffrate = $_POST['diffrate'];
        $user->supportfee = $_POST['supportfee'];
        $user->cpm_charge = $_POST['cpm_charge'];
        $user->cpc_charge = $_POST['cpc_charge'];
        $user->site_name = $_POST['site_name'];
        $user->site_url = $_POST['site_url'];
        $user->type = $_POST['type'];
        $user->name = $_POST['name'];
        $user->number = $_POST['number'];
        $user->valid_date = $_POST['start_date'];
        $user->img_urls = $imgUrls;

        if (strlen($_POST['colum2']) > 100) {
            $user->colum2 = substr($_POST['colum2'], 0, 100);
        } else {
            $user->colum2 = $_POST['colum2'];
        }
        /**
         * $user->creator_id = $_POST['uid];
         */
        // 创建系统管理员/运营/子运营
        $user->creator_id = user_api::id();
        // 创建客户经理
        if ($_POST['role_id'] == 12) {
            $user->creator_id = $_POST['account_provider'];
            if ($info->role_id == 18) { // 子运营创建客户经理
                $user->creator_id = $info->uid;
            }
        }
        // //创建广告主
        if ($_POST['role_id'] == 13 || $info->role_id == 12) {
            $user->creator_id = $_POST['account_manager'];
            if ($info->role_id == 12) { // 子运营创建广告主
                $user->creator_id = $info->uid;
            }
        }
        $user->role_id = $_POST['role_id'];
        if ($info->role_id == 12) {
            $user->role_id = 13;
        }
        $user->up_time = $user->reg_time = time(NULL);
        $error = array();
        $error['count'] = 0;
        $error['msg'] = "";
        
        if (! empty($_POST)) {
            if (isset($_POST['user_name']) && strlen($_POST['user_name']) > 1) {
                $userInfo = user_api::getUserByName($_POST['user_name']);
                if ($userInfo->uid > 0) {
                    $error['count'] ++;
                    $error['msg'] = "用户名'" . $_POST['user_name'] . "'已经存在";
                } else {
                    if (isset($_POST['passwd']) && strlen($_POST['passwd']) >= 6) {
                        if (isset($_POST['passwd_again']) && $_POST['passwd'] == $_POST['passwd_again']) {
                            $user->user_name = $_POST['user_name'];
                            $user->account = 0; // 设置默认余额
                            $roleList = user_api::getRoleList();
                            if (isset($_POST['role_id']) && isset($roleList[$_POST['role_id']])) {
                                $user->role_id = $_POST['role_id'];
                            }
                            $user->colum1 = 0;
                            if (! empty($_POST['roles'])) {
                                foreach ($_POST['roles'] as $role) {
                                    $user->colum1 ^= $role;
                                }
                            }
//                            $uid = $a->addAdUser($user);
                            $user = json_decode(json_encode($user),true);
                            $uid = $user_model->addData($user);
                            //暂时屏蔽哇棒用户同步接口
//                            if ($uid > 0 && $_POST['source'] ==5) {
//                                $userInfo = $user_model->getData(array("uid"=>$uid,"account_status"=>1));
//                                $res = $this->CurlPostUser($userInfo[0]);
//                                $sms2= json_decode($res);
//                                if($sms2->code != 200){
//                                    $deleteUser = $user_model->deleteData(array("uid"=>$uid));
//                                    $errormsg = $sms2->error_hint;
//                                    $url="https://".$host->admin."/admin.user.add"."?nav=5";
//                                    $this->success("提交到第三方媒体平台错误，错误信息为:$errormsg", $url, 3);
//                                    exit();
//                                }else{
//                                    $url="https://".$host->admin."/admin.user.list"."?nav=5";
//                                    $this->success("提交成功", $url, 2);
//                                    exit();
//                                }
//
//                            } else {
//                                $error['count'] ++;
//                                $error['msg'] = "添加失败，内部错误";
//                            }



                        } else {
                            $error['count'] ++;
                            $error['msg'] = "两次输入密码不一致";
                        }
                    } else {
                        $error['count'] ++;
                        $error['msg'] = "密码不能为空,请输入6位及以上密码";
                    }
                }
            } else {
                $error['count'] ++;
                $error['msg'] = "用户名不能为空";
            }
        }
        
        $roleList = user_api::getRoleList();
        if (! user_api::auth("admin")) {
            unset($roleList[10000]);
            unset($roleList[1000]);
        }
        $source = array(
            "0"=>array('id'=>1,"source_name"=>"默认"),
            "1"=>array("id"=>2,"source_name"=>"精准营销平台"),
            "2"=>array("id"=>3,"source_name"=>"直真"),
            "3"=>array("id"=>4,"source_name"=>"外部DSP"),
            "4"=>array("id"=>5,"source_name"=>"哇棒"),
        );

        $condition = array();
        $users = $user_model->getData($condition,0,-1);
        $users_name = array();
        foreach($users as $_user){
            $users_name[] = $_user['user_name'];
        }
        $names = implode(",",$users_name);

        $this->assign("operate", 1); // create account;
        $this->assign("error", $error);
        $this->assign("names", $names);
        $this->assign("sourceInfo", $source);
        $this->assign("user", $user);
        $this->assign("info", $info);
        $this->assign("roleList", $roleList);
        return $this->render("admin/user_ggz_add.html");
    }

    public function pageEdit($inPath)
    {
        if (empty($inPath[3])) {
            return $this->pageAdd($inPath);
        }
        $a = new thrift_aduser_main();
        $user = user_api::getUserById($inPath[3]);
        $userInfo  = user_api::info();
        if($userInfo->role_id!=1000||$userInfo->role_id!=10000){
            if( $user->role_id>$userInfo->role_id){
                $this->assign("error", "低级别权限不能修改高级别权限");
                exit;
            }
        }
        if (! empty($_POST)) {
            $user->host = $_POST['host'];
            $user->company_name = $_POST['company_name'];
            $user->cell_phone = $_POST['cell_phone'];
            $user->address = $_POST['address'];
            $user->zip_code = $_POST['zip_code'];
            $user->email  = $_POST['email'];
            if (!empty($_POST['passwd'])) {
                if ($_POST['passwd'] == $_POST['passwd_again']) {
                    $user->passwd = md5($_POST['passwd']);
                } else {
                    $this->assign("error", "两次输入密码不一致");
                }
            }
            $user->type = $_POST['type'];
            $user->diffrate = $_POST['diffrate'];
            $user->supportfee = $_POST['supportfee'];
            $user->cpm_charge = $_POST['cpm_charge'];
            $user->cpc_charge = $_POST['cpc_charge'];
            $user->account_status = $_POST['account_status'];
            $user->source = $_POST['source']; //用户来源

            if (strlen($_POST['colum2']) > 100) {
                $user->colum2 = substr($_POST['colum2'], 0, 100);
            } else {
                $user->colum2 = $_POST['colum2'];
            }
            $user->up_time = time(NULL);
            $user->colum1 = 0;
            if (! empty($_POST['roles'])) {
                foreach ($_POST['roles'] as $role) {
                    $user->colum1 ^= $role;
                }
            }
            if ($a->updateAdUserInfo($user)) {}
            $user = user_api::getUserByName($user->user_name);
            $this->success("successful", '/baichuan_advertisement_manage/admin.user.list.' . $user->uid);
        }
        $roleList = user_api::getRoleList();
        if (! user_api::auth("system")) {
            unset($roleList[10000]);
            unset($roleList[1000]);
        }
        $userModel = new model_userInfo();
        $condition = array();
        $condition['uid'] = $user->creator_id;
        $u = $userModel->getData($condition, 0, - 1);

        $source = array(
            "0"=>array('id'=>1,"source_name"=>"默认"),
            "1"=>array("id"=>2,"source_name"=>"精准营销平台"),
            "2"=>array("id"=>3,"source_name"=>"直真"),
            "3"=>array("id"=>4,"source_name"=>"外部DSP"),
        );
        $this->assign("sourceInfo", $source);
        $this->assign("creator", $u[0][user_name]);
        $this->assign("operate", 2); // edit account
        $this->assign("user", $user);
        $this->assign("roles", $roleList);
        $this->assign("roleList", $roleList);
        return $this->render("admin/user_ggz_add.html");
    }

    public function pageDelete()
    {
          if (isset($_POST['uid'])) {
            $a = new thrift_aduser_main();
            $user = (array) $a->getAdUserById($_POST['uid']);
            if (user_api::auth("system") || user_api::auth("admin")) {
                $a->delAdUserById($_POST['uid']);
                $this->success("修改成功", "/baichuan_advertisement_manage/admin.user.list");
            } elseif (isset($user['creator_id']) && $user['creator_id'] > 0 && $user['creator_id'] == user_api::id()) {
                $a->delAdUserById($_POST['uid']);
            } else {
                $this->success("您不是该用户创建人，无法禁用", "/baichuan_advertisement_manage/admin.user.list");
            }
        } else {
            $this->success("请输入用户ID", "/baichuan_advertisement_manage/admin.user.list");
        }
    }

    public function pageRefresh()
    {
        if (isset($_POST['uid'])) {
            $a = new thrift_aduser_main();
            $user = $a->getAdUserById($_POST['uid']);
            $user->account_status = 1;
            $user->up_time = time(NULL);
            if (user_api::auth("system") || user_api::auth("admin")) {
                $a->updateAdUserInfo($user);
            } elseif (isset($user->creator_id) && $user->creator_id > 0 && $user->creator_id == user_api::id()) {
                $a->updateAdUserInfo($user);
            } else {
                $this->success("您不是该用户创建人，无法启用", "/baichuan_advertisement_manage/admin.user.list");
            }
        } else {
            $this->success("请输入用户ID", "/baichuan_advertisement_manage/admin.user.list");
        }
    }

    public function pageTopup($inPath)
    {
        $opcode = array(
            1,
            2,
            3
        );
        if (! empty($_POST)) {
            $a = new thrift_aduser_main();
            $user = user_api::getUserById($_POST['uid']);
            $old_account = $user->account;
            if (! in_array($opcode, $_POST['code'])) {
                $this->success("failed to operate finance", "/baichuan_advertisement_manage/admin.user.Topup");
            }
            if ($_POST['code'] == 1 || $_POST['code'] == 2) {
                $user->account += $_POST['topup'];
            } elseif ($_POST['code' == 3]) {
                $user->account -= $_POST['topup'];
            }
            $user->up_time = time(NULL);
            $a->updateAdUserInfo($user);
            admin_log::TopUpLog($user, $old_account);
        }
        $a = new thrift_aduser_main();
        $uid = 0;
        if (! empty($inPath[3])) {
            $uid = $inPath[3];
            $user = $a->getAdUserById($uid);
        }
        $this->assign("user", $user);
        $this->render("admin/user_topup.html");
    }
    
    // 获取子运营账户信息
    public function pageGetMarketList()
    {
        $userModel = new model_userInfo();
        $condition['role_id'] = 18;
        $userInfo = $userModel->getData($condition, 0, - 1);
       // var_dump($userInfo);
        if(is_array($userInfo)&&!empty($userInfo)){
           foreach($userInfo as $k=>$v){
               unset($userInfo[$k]['passwd']);
               
           } 
        }
        echo json_encode($userInfo);
    }
    // 获取客户经理信息
    public function pageGetmanagerListById()
    {
        $userModel = new model_userInfo();
        $condition['role_id'] = 12;
        if (! empty($_GET['uid'])) {
            $condition['creator_id'] = $_GET['uid'];
        }
        $userInfo = $userModel->getData($condition, 0, - 1);
        if(is_array($userInfo)&&!empty($userInfo)){
            foreach($userInfo as $k=>$v){
                unset($userInfo[$k]['passwd']);
                 
            }
        }
        
        echo json_encode($userInfo);
    }
    
    /**
     *获取子运营商下的客户经理
     * @param $inPath
     */
    public function pageGetcarriers($inPath)
    {
        $userType = substr($inPath[3], -1); //用户类型：子运营商，1:客户经理，2:广告主
        $carriers_id = substr($inPath[3], 0, -1); //用户id
        $userInfo = user_api::info();
        if($userType == 1){
            $userRoleId = 12; //查找客户经理
        }
        if($userType == 2){
            $userRoleId = 13; //查找广告主
        }
        $this->userInfoModel = new model_userInfo();
//        $operateRole = $userInfo->role_id;//默认管理员选择子运营商
        if($userRoleId ==12){
            if($carriers_id==0){
                if($userInfo->role_id<1000){
                    $carriers_id = $userInfo->uid;
                }else{
                    $carriers_id = 0;
                }
            }
            $operateRole = 13;
            if($userInfo->role_id == 10000 || $userInfo->role_id == 1000){
                $operateRole = $userInfo->role_id;
            }
        }
        $users = $this->userInfoModel->getSubCarriers($carriers_id,$userRoleId,$operateRole);
        if($userRoleId ==13){
            $condition = array();
            if($carriers_id ==0){
                if($userInfo->role_id ==12){ //客户经理
                   $condition['creator_id'] = $userInfo->uid;
                   $condition['role_id'] = 13;
                   $users = $this->userInfoModel->getData($condition,0,-1);
                }elseif($userInfo->role_id ==18){ //子运营
                    $condition['creator_id'] = $userInfo->uid;
                    $condition['role_id'] = 12;
                    $managerUsers = $this->userInfoModel->getData($condition,0,-1);
                    $uid_list = array_column($managerUsers,"uid");
                    $item = array();
                    if(count($uid_list) > 1){
                        $uid_string = implode(",",$uid_list);
                        $item = " AND creator_id IN ($uid_string) AND role_id =13";
                    }else{
                        $item['role_id'] =13;
                        $item['creator_id'] =$uid_list[0];
                    }
                    $users = $this->userInfoModel->getData($item,0,-1);
                }elseif($userInfo->role_id ==13){
                    $condition['uid'] =$userInfo->uid;
                    $users = $this->userInfoModel->getData($condition,0,-1);
                }else{ //role_id为1000或者10000
                    $condition['role_id'] = 13;
                    $users = $this->userInfoModel->getData($condition,0,-1);
                }
            }else{
                $condition['creator_id'] = $carriers_id;
                $users = $this->userInfoModel->getData($condition,0,-1);
            }

        }

        foreach($users  as $k=>$v){
            unset($users[$k][passwd]);
        }
        if(empty($users)){
            return false;
        }else {
            return  SJson::encode($users);
        }


    }
    //获取广告主账号信息
    public function pageGetAdInfo($inPath){
        $ad_id = $inPath[3];
        $condition = array();
        $condition['uid'] = $ad_id;
        $this->userInfoModel = new model_userInfo();
        $adInfo = $this->userInfoModel->getData($condition,0,-1);
        return SJson::encode($adInfo);
    }

    /**
     * @param $parameter
     * @param int $timeout
     * @param array $aHeader
     * @param int $apiType
     * @return mixed|string
     * @description 提交广告主信息到哇棒平台
     */
    public function CurlPostUser($parameter,$timeout = 40,$aHeader=array(),$apiType=4){
        $curl_post = SConfig::getConfigArray(ROOT_CONFIG."/config.php","wb_curl_post");
        $user_info = (object)$parameter;
        $adx_data = [];
        $data = [];
        if(!empty($parameter)){
            $data['advertiser_id'] = intval($user_info->uid);
            $data['company_name'] = $user_info->company_name;
            $data['site_name'] = $user_info->site_name;
            $data['site_url'] = $user_info->site_url;
            $site = array();
            $site['type'] = intval($user_info->type);
            $site['name'] = $user_info->name;
            $site['number'] = $user_info->number;
            $site['valid_date'] = $user_info->valid_date;
            $site['img_urls'] = array($user_info->img_urls);
            $data['main_licence'] = $site;

        }
        switch ($apiType){
            case 1: //创意新增/修改
                $post_url = $curl_post['post_url']."/creative/add";
                break;
            case 2:  //创意查询
                $post_url = $curl_post['post_url']."/creative/query";
                break;

            case 3:  //创意状态查询
                $post_url = $curl_post['post_url']."/creative/queryAuditState";
                break;
            case 4:  //新增广告主信息
                $post_url = $curl_post['post_url']."/advertiser/su";
                break;
            default:
                $post_url = "";
        }

        $adx_data['auth'] = array(
            "id"=>$curl_post['id'],
            "token"=>$curl_post['token']);
        $adx_data['request'] = array($data);

        $data_json = json_encode($adx_data,JSON_UNESCAPED_SLASHES);

//		var_dump($data_json);

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch,CURLOPT_URL,$post_url);
        if( count($aHeader) >= 1 ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=UTF-8','Content-Length:'.strlen($data_json)));
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data_json);
        $result = curl_exec($ch);
        if($result){
            return $result;
        }else{
            return curl_error($ch);
        }
        curl_close($ch);

    }
    
    
}
  
