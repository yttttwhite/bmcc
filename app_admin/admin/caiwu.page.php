<?php

class admin_caiwu extends STpl
{

    public $mongoModel, $mogoName;

    public function __construct($inPath)
    {
        /*if (! user_api::auth("system")) {
            die("权限拒绝");
        }*/
        $info = user_api::info();
        if(($info->role_id=1000)|| ($info->role_id=10000)){
           
        } else{
           die("权限拒绝");
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
        
        $roleList = user_api::getRoleList();
        if (! user_api::auth("system")) {
            unset($roleList[10000]);
            unset($roleList[1000]);
        }
        $this->assign("roleList", $roleList);
        $this->assign("get", $_GET);
        return $this->render("admin/caiwu_left.html");
    }

    /**
     * 账户列表
     *
     * @param unknown $inPath            
     */
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
            $condition = array();
            $info = user_api::info();
//            if ($_GET['status'] != '') {
//                $condition['account_status'] = $_GET['status'];
//            }
//
//             if ($_GET['role_id'] != '') {
//              $condition['role_id'] = $_GET['role_id'];
//              }

            $users = $user_model->getData($condition, 0, - 1);

        } else {}
        // $userInfo = $this->object_array($userinfo);
        foreach ($users as $key => $val) {
            $createinfo = user_api::getUserByID($val['creator_id']);
            if ($createinfo) {
                $users[$key]['createname'] = $createinfo->user_name;
            } else {
                $users[$key]['createname'] = "异常";
            }
            $users[$key]['show'] = 0;
            $users[$key]['cost'] = 0;
            switch ($val['role_id']) {
                case "10000":
                    $users[$key]['role_name'] = "系统管理员";
                    break;
                case "1000":
                    $users[$key]['role_name'] = "运营账户";
                    break;
                case "18":
                    $users[$key]['role_name'] = "子运营账户";
                    break;
                case "12":
                    $users[$key]['role_name'] = "客户经理";
                    break;
                case "13":
                    $users[$key]['role_name'] = "广告主";
                    break;
                default:
                    $users[$key]['role_name'] = "不存在的角色";
            }
        }
        $operate_role = $info->role_id;
//        if (isset($_GET['role_id'])) {
//            $role_id = $_GET['role_id'];
//        } else {
//            if ($operate_role == 10000 || $operate_role == 1000) {
//                $role_id = 0;
//            }
//            // 子运营
//            if ($operate_role == 18) {
//                $role_id = 12;
//            }
//            // 客户经理
//            if ($operate_role == 12) {
//                $role_id = 13;
//            }
//        }

         if ($_GET['role_id'] != '') {
             $condition['role_id'] = $_GET['role_id'];
         }

        if ($_GET['options'] == "指定"||$_GET['options'] == "所属") {
            $options = $_GET['options'];
        }
        if (! isset($_GET['options']) || $_GET['options'] == "全部") {
            $options = "所属";
        }

        // 筛选所属用户
        $selectKey = $this->getRuleUid($user_model, $operate_role, $role_id, $options);

        foreach ($users as $k => $v) {
            $users[$k]['allsavemoney'] = 0; // 初始化累计充值
            if (! in_array($v['uid'], $selectKey)) {
                unset($users[$k]);
            }
        }

        // 用户类型筛选，归属筛选
        /*
         * if ($info->role_id == 18) {
         * $conditionTemp = array();
         * $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为子运营账户的uid
         * $marketkey = array();
         * if ($_GET['status'] == "全部") {}
         * if ($_GET['status'] == "指定") {}
         * $marketUser = $user_model->getData($conditionTemp, 0, - 1);
         * if ($marketUser) {
         * foreach ($marketUser as $key => $v) {
         * array_push($marketkey, $v['uid']); // 所属客户经理的用户uid，查看所有广告主
         * }
         * }
         * }
         * // 用户类型筛选，归属筛选
         * // 管理员账户和运营账户
         * if (($info->role_id == 1000) || ($info->role_id == 10000)) {
         * $conditionTemp = array();
         * $conditionTemp['creator_id'] = $info->uid; // 当前登陆的用户为管理员或者运营账户
         * $marketUser = array();
         * $marketkey = array(); // 管理的 用户的uid
         * $marketUser = $user_model->getData($conditionTemp, 0, - 1);
         * if ($marketUser) {
         * foreach ($marketUser as $key => $v) {
         * array_push($marketkey, $v['uid']);
         * }
         * }
         * }
         * // 客户经理
         * if (($info->role_id == 12)) {
         * $conditionTemp = array();
         * $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为子运营账户的uid
         * $marketUser = array();
         * $marketkey = array(); // 管理的 用户的uid
         * $marketUser = $user_model->getData($conditionTemp, 0, - 1);
         * if ($marketUser) {
         * foreach ($marketUser as $key => $v) {
         * array_push($marketkey, $v['uid']);
         * }
         * }
         * }
         */
        // 计算累计充值
        $financeModel = new model_caiwuLog();
        $chargeLog = $financeModel->getData(array(), 0, - 1);
        $allSaveMoney = array();
        if ($chargeLog) {
            foreach ($chargeLog as $k => $v) {
                if ($v['operate_code'] == 1 || $v['operate_code'] == 2 || $v['operate_code'] ==4) {
                    if (isset($allSaveMoney[$v['target_uid']])) {
                        $allSaveMoney[$v['target_uid']] = (float) $allSaveMoney[$v['target_uid']] + (float) $v['operate_num'];
                    } else {
                        $allSaveMoney[$v['target_uid']] = (float) $v['operate_num'];
                    }
                }
            }
        }
        // 更新累计充值
        foreach ($users as $k1 => $v1) {
            foreach ($allSaveMoney as $k2 => $v2) {
                if ($v1['uid'] == $k2) {
                    $users[$k1]['allsavemoney'] = $v2;
                }
            }
        }
        // 获取统计
        $userStat = $this->PagegetStatByUid($condition = array());
        // 更新用户的花费和展示量
        if ($users && $userStat) {
            foreach ($users as $k => $v) {
                foreach ($userStat as $k2 => $v2) {
                    if ($v['uid'] == $k2) {
                        $users[$k]['show'] = $v2['show'];
                        $users[$k]['cost'] = $v2['cost'];
                    }
                }
            }
        }
         $users2 = $users;

    foreach($users as $key => $user) {
             foreach ($users2 as $u) {
                 if ($user['uid'] == $u['creator_id']) {
                     $users[$key]['lower_level_user'][] = $u;
                 }
             }
         }
    if ($_GET['role_id'] != '') {
         foreach($users as $val){
             if($val['role_id'] == $_GET['role_id']){
                 $searchUsers[] = $val;
             }
         }
        $users = $searchUsers;
     }
     if($_GET['status'] != ''){
         foreach($users as $value){
             if($value['account_status'] == $_GET['status']){
                 $accout_status_users[] = $value;
             }
         }
         $users = $accout_status_users;
     }
         // 根据key筛选用户
         foreach ($users as $key => $user) {
             if (isset($_GET['key']) && strlen($_GET['key']) > 0 && stripos($user['user_name'], $_GET['key']) === false) {
                 unset($users[$key]);
             }
         }


        // 分页处理
        $total = count($users);
        if ($_GET['pageNum']) {
            $pageNum = $_GET['pageNum'];
        } else {
            $pageNum = 1;
        }
        $pageSize = 30;
        if ($pageNum * $pageSize - 1 <= $total) {
            $start = ($pageNum - 1) * $pageSize;
            $end = $pageNum * $pageSize - 1;
        } else {
            $start = ($pageNum - 1) * $pageSize;
            $end = $total - 1;
        }
        $users = array_slice($users, $start, $pageSize);
        $totalPage = ceil($total / $pageSize);
        
        // $users = user_api::listUesersRoles($users);
        /*
         * $creator[0] = "----";
         * $caiwu = array();
         * foreach ($users as $key=>$user){
         * if(isset($_GET['key']) && strlen($_GET['key'])>0 && stripos($user->user_name, $_GET['key']) === false){
         * unset($users[$key]);
         * }
         * if(isset($_GET['role']) && $user->role_id != $_GET['role']){
         * unset($users[$key]);
         * }
         * $caiwu[$user->uid][show] = 0;
         * $caiwu[$user->uid][cost] = 0;
         *
         * $creator[$user->uid] = $user->user_name;
         * if($user->role_id == 10000){
         * //unset($users[$key]);
         * }
         * }
         */
        /*
         * foreach($users as $user){
         * $r =dc_api::DayByUid($user->uid,date('Y-m-d',$user->reg_time),date('Y-m-d',time(NULL)));
         * foreach($r->data as $item){
         * $caiwu[$user->uid][show] += $item->show;
         * $caiwu[$user->uid][cost] += $item->cost;
         * }
         * }
         */
        // 转换成对象

        $users = json_encode($users);
        $users = json_decode($users);
        $url['formAction'] = "/admin.user.list";
        $this->assign("totalPage", $totalPage);
        $this->assign("pageNum", $pageNum);
        $this->assign('total', $total);
        $this->assign("caiwu", $users);
        $this->assign("url", $url);
        $this->assign("roles", user_api::getRoleList());
        $this->assign("roleList", user_api::getRoleList());
        // $this->assign("_users",$users);
        $this->assign("creator", $creator);
        $this->assign("admin", $admin);
        $this->assign("info", $info);
        return $this->render("admin/caiwu_ggz.html");
    }
    //查询下级用户信息
    public function pageSearchLowerUser(){
        $data = $_POST['data_list'];
        $uid = $data['uid']; //当前用户uid
        $role_id = $data['role_id'];  //当前用户角色
        $user_model = new model_userInfo();
        $condition = array();
        $condition['creator_id'] = $uid;
        if($role_id ==10000 || $role_id == 1000){  //管理员或者运营人员
            $condition['role_id'] =18;
        }elseif($role_id ==18 ){ //子运营商
            $condition['role_id'] =12;
        }elseif($role_id == 12){  //客户经理
            $condition['role_id'] =13;
        }

        $users = $user_model->getData($condition, 0, - 1);


//        var_dump($_POST);die(erert);

    }

    /**
     * 流水
     */
    public function pageStream()
    {
        $condition = array();
        $caiwuModel = new model_caiwuLog();
        if (! empty($_GET)) {
              if (isset($_GET['uid'])) {
              $condition['target_uid'] = $_GET['uid'];
              }
             
            if (! empty($_GET['source'])) {
                $condition['source'] = $_GET['source'];
            }
            if (! empty($_GET['operate_code'])) {
                $condition['operate_code'] = $_GET['operate_code'];
            }
            $data = $caiwuModel->getData($condition, 0, - 1,"id",1);
            $a = new thrift_aduser_main();
            foreach ($data as $key => $item) {
                $user = $a->getAdUserById($item[operator_id]);
                $data[$key][operator_name] = $user->user_name;
                $user = $a->getAdUserById($item[target_uid]);
                $data[$key][target_name] = $user->user_name;
                if ($item['operate_code'] == 1) {
                    $data[$key]['op_type'] = "充值";
                    $data[$key]['in_money'] = $item['operate_num'];
                    $data[$key]['out_money'] = 0;
                }
                if ($item['operate_code'] == 2) {
                    $data[$key]['op_type'] = "补差";
                    $data[$key]['in_money'] = $item['operate_num'];
                    $data[$key]['out_money'] = 0;
                }
                if ($item['operate_code'] == 3) {
                    $data[$key]['op_type'] = "冲正";
                    $data[$key]['in_money'] = 0;
                    $data[$key]['out_money'] = $item['operate_num'];
                }
                if ($item['operate_code'] == 4) {
                    $data[$key]['op_type'] = "合同充值";
                    $data[$key]['in_money'] = $item['operate_num'];
                    $data[$key]['out_money'] = 0;
                }

            }
            foreach ($data as $k => $v) {
                if ($_GET['select_type'] == 'target_name') {
                    if (isset($_GET['key']) && strlen($_GET['key']) > 0 && stripos($v['target_name'], $_GET['key']) === false) {
                        unset($data[$k]);
                    }
                }
                if ($_GET['select_type'] == 'business_id') {
                    if (isset($_GET['key']) && strlen($_GET['key']) > 0 && stripos($v['business_id'], $_GET['key']) === false) {
                        unset($data[$k]);
                    }
                }
                if ($_GET['select_type'] == 'contract_id') {
                    if (isset($_GET['key']) && strlen($_GET['key']) > 0 && stripos($v['contract_id'], $_GET['key']) === false) {
                        unset($data[$k]);
                    }
                }
                if ($_GET['operator_name'] == 'target_name') {
                    if (isset($_GET['key']) && strlen($_GET['key']) > 0 && stripos($v['target_name'], $_GET['key']) === false) {
                        unset($data[$k]);
                    }
                }
            }
            /*
             * if($d){
             *
             * }
             */
            // 分页处理
            $total = count($data);
            if ($_GET['pageNum']) {
                $pageNum = $_GET['pageNum'];
            } else {
                $pageNum = 1;
            }
            $pageSize = 30;
            if ($pageNum * $pageSize - 1 <= $total) {
                $start = ($pageNum - 1) * $pageSize;
                $end = $pageNum * $pageSize - 1;
            } else {
                $start = ($pageNum - 1) * $pageSize;
                $end = $total - 1;
            }
             $users = array_slice($users, $start, $pageSize);
            $totalPage = ceil($total / $pageSize);
            $this->assign("data", $data);
            $this->assign("totalPage", $totalPage);
            $this->assign("pageNum", $pageNum);
            $this->assign('total', $total);
            return $this->render("admin/caiwu_stream.html");
        } else {
            $this->success("请输入有效用户ID", "/baichuan_advertisement_manage/admin.caiwu.list");
        }
    }

    public function pageDetail()
    {
        $condition = array();
        $caiwuModel = new model_caiwuLog();
        if (isset($_GET['uid'])) {
            $condition['target_uid'] = $_GET['uid'];
            $data = $caiwuModel->getData($condition, 0, - 1);
            $a = new thrift_aduser_main();
            foreach ($data as $key => $item) {
                $user = $a->getAdUserById($item[operator_id]);
                $data[$key][operator_name] = $user->user_name;
                $user = $a->getAdUserById($item[target_uid]);
                $data[$key][target_name] = $user->user_name;
            }
            $user = $a->getAdUserById($_GET['uid']);
            $roleList = user_api::getRoleList();
            $this->assign("roleList", $roleList);
            $this->assign("user", $user);
            $this->assign("data", $data[0]);
            return $this->render("admin/caiwu_detail.html");
        } else {
            $this->success("请输入有效用户ID", "/baichuan_advertisement_manage/admin.caiwu.list");
        }
    }

    public function pageAdd($inPath)
    {
        require __DIR__ .'../../../tools/SensitiveWordFilter.php';
        $filter = new SensitiveWordFilter(__DIR__ . '../../../tools/dict.txt');
        $word = $_POST;
        if(!empty($_POST)){
            $word = $_POST;
            foreach ($word as $value) {
                $re = $filter->filter(trim($value), 0);
                if($re == false){
                    $this->success("您输入的有敏感词请检查后，再创建", "/baichuan_advertisement_manage/admin.caiwu.list") ;
                    exit;
                }
            }
        
        }
        
        $a = new thrift_aduser_main();
        $user = $a->getAdUserById($inPath[3]);
        $roleList = user_api::getRoleList();
        $contract_file = "";
        if (! empty($_FILES['contract']['tmp_name'][0])) {
            $files = self::reArrayFiles($_FILES['contract']);
            foreach ($files as $file) {
                if (! empty($file['error'])) {
                    $upload_errors = array(
                        UPLOAD_ERR_OK => "No errors.",
                        UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
                        UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.",
                        UPLOAD_ERR_PARTIAL => "Partial upload.",
                        UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
                        UPLOAD_ERR_CANT_WRITE => "写入文件失败，请检查权限或者磁盘是否已经满",
                        UPLOAD_ERR_EXTENSION => "File upload stopped by extension.",
                        UPLOAD_ERR_EMPTY => "File is empty."
                    ); // add this to avoid an offset
                    
                    $er = $file['error'];
                    $result['error'] = @$upload_errors[$er];
                    return SJson::encode($result);
                } else {
                    $f_type = strtolower($file['type']);
                    if ($f_type == "image/gif" or $f_type == "image/png" or $f_type == "image/jpeg" or $f_type == "image/gif") {
                        if (filesize($file['tmp_name']) > 300 * 1024) {
                            $result['error'] = "图片不能大于300K";
                            return SJson::encode($result);
                        }
                    }
                    if (empty($result['error']) && ! empty($file['tmp_name'])) {
                        require_once (ROOT . "/stuff/id.class.php");
                        $file_object = new stuff_id();
                        $file_id = $file_object->upload($file['tmp_name'], user_api::getUserID(), $_REQUEST['play_status']);
                        if ($file_id !== false) {
                            $result['fileid'] = $file_id;
                        } else {
                            $result['error'] = "上传文件失败v1";
                            return SJson::encode($result);
                        }
                    } else {
                        $result['error'] = "上传文件失败v2";
                        return SJson::encode($result);
                    }
                }
                if (! empty($file_id)) {
                    $host = SConfig::getConfig(ROOT_CONFIG . "/js.conf", "host");
                    $c = "https://" . $host->stuff . "/$file_id";
                    $contract_file .= $c . ",";
                }
            }
        }
        
        if (! empty($_POST)) {
            $data = array();
            if (empty($_POST['operate_num']) || empty($_POST['operate_code']) || empty($_POST['contract_id'])) {
                header("location:/baichuan_advertisement_manage/admin.caiwu.list");
                return;
            }
            $a = new thrift_aduser_main();
            $user = $a->getAdUserById($inPath[3]);
            $data['operator_id'] = user_api::id();
            $data['op_time'] = time(NULL);
            $data['target_uid'] = $inPath[3];
            $data['operate_code'] = $_POST['operate_code'];
            $data['operate_num'] = $_POST['operate_num'];
            $data['business_id'] = $_POST['business_id'];
            $data['contract_id'] = $_POST['contract_id'];
            $data['source'] = 1;
            $data['note'] = $_POST['note'];
            $data['contract_file'] = $contract_file;
            $data['history_money'] = $user->account;
            if ($_POST['operate_code'] == 1 || $_POST['operate_code'] == 2) {
                $data['flow_money'] = $user->account + $_POST['operate_num'];
                $user->account += $_POST['operate_num'];
            } elseif ($_POST['operate_code'] == 3) {
                $data['flow_money'] = $user->account - $_POST['operate_num'];
                $user->account -= $_POST['operate_num'];
            }
            $reUpdate = $a->updateAdUserInfo($user);
            $caiwuModel = new model_caiwuLog();
            $reAdd = $caiwuModel->addData($data);
            header("location:/baichuan_advertisement_manage/admin.caiwu.list");
            // return;
            // return $this->render("admin/caiwu_ggz.html");
        }
        
        $this->assign("roleList", $roleList);
        $this->assign("user", $user);
        return $this->render("admin/caiwu_add.html");
    }

    public function pageEdit($inPath)
    {
        if (empty($inPath[3])) {
            return $this->pageAdd($inPath);
        }
        $a = new thrift_aduser_main();
        $user = user_api::getUserById($inPath[3]);
        if (! empty($_POST)) {
            $user->host = $_POST['host'];
            $user->cell_phone = $_POST['cell_phone'];
            $user->address = $_POST['address'];
            $user->zip_code = $_POST['zip_code'];
            if (isset($_POST['passwd'])) {
                if ($_POST['passwd'] == $_POST['passwd_agin']) {
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
            $this->assign("error", "修改成功！");
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
        $this->assign("creator", $u[0][user_name]);
        $this->assign("operate", 2); // edit account
        $this->assign("user", $user);
        $this->assign("roles", $roleList);
        $this->assign("roleList", $roleList);
        return $this->render("admin/user_ggz_add.html");
    }

    public function pageDelete()
    {
        if (isset($_GET['uid'])) {
            $a = new thrift_aduser_main();
            $user = (array) $a->getAdUserById($_GET['uid']);
            if (user_api::auth("system") || user_api::auth("admin")) {
                $a->delAdUserById($_GET['uid']);
            } elseif (isset($user['creator_id']) && $user['creator_id'] > 0 && $user['creator_id'] == user_api::id()) {
                $a->delAdUserById($_GET['uid']);
            } else {
                $this->success("您不是该用户创建人，无法禁用", "/baichuan_advertisement_manage/admin.user.list");
            }
        } else {
            $this->success("请输入用户ID", "/baichuan_advertisement_manage/admin.user.list");
        }
    }

    public function pageRefresh()
    {
        if (isset($_GET['uid'])) {
            $a = new thrift_aduser_main();
            $user = $a->getAdUserById($_GET['uid']);
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

    private function reArrayFiles(&$file_post)
    {
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
        
        for ($i = 0; $i < $file_count; $i ++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        
        return $file_ary;
    }
    
    // 对象转化成数组
    public function object2array(&$object)
    {
        $object = json_decode(json_encode($object), true);
        return $object;
    }

    /**
     * 获取当前用户的累计展示量和花费。
     */
    public function PagegetStatByUid($condition = array())
    {
        // error_reporting(E_ALL);
        // ini_set( 'display_errors', 'On' );
        $this->mogoName = "SourceDetail";
        $this->mongoModel = new model_stat();
        $this->mongoModel->init($this->mogoName);
        $condition = array();
        $list = $this->mongoModel->getData($condition, 0, 0);
        if ($list) {
            $list = $this->groupBy($list, 'USERID');
        } else {
            $list = array();
        }
        return $list;
    }

    /**
     * 查询结果按照uid,planid,groupid,day,hour分组
     */
    private function groupBy($re, $group)
    {
        if (! empty($re)) {
            $n = 0;
            // mongodb查询出来的数据，把key转化成0，1，2......
            foreach ($re as $k => $v) {
                $re[$n] = $v;
                unset($re[$k]);
                $n ++;
            }
            $total = count($re);
            // 初始化
            $reTemp[$re[0][$group]]['show'] = 0;
            $reTemp[$re[0][$group]]['click'] = 0;
            $reTemp[$re[0][$group]]['cost'] = 0;
            foreach ($re as $key => $val) {
                if (isset($reTemp[$re[$key][$group]])) {
                    $reTemp[$re[$key][$group]]['show'] += $re[$key]["show"];
                    $reTemp[$re[$key][$group]]['click'] += $re[$key]["click"];
                    $reTemp[$re[$key][$group]]['cost'] += $re[$key]["cost"];
                } else {
                    $reTemp[$re[$key][$group]]['show'] = $re[$key]["show"];
                    $reTemp[$re[$key][$group]]['click'] = $re[$key]["click"];
                    $reTemp[$re[$key][$group]]['cost'] = $re[$key]["cost"];
                }
            }
        }
        
        return $reTemp;
    }

    /**
     * 获取权限内的各级用户的uid
     */
    public function getRuleUid($user_model, $operate_role, $role_id, $options)
    {
        $info = user_api::info();
        // 用户类型筛选，归属筛选
        if ($operate_role == 18) { // 子运营账户
            if ($options == "所属") {
                $conditionTemp = array();
                // 1.先查询所属客户经理账号
                $conditionTemp['role_id'] = 12;
                $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为子运营账户的uid
                $marketkey = array();
                $marketUser = $user_model->getData($conditionTemp, 0, - 1);
                if ($marketUser) {
                    foreach ($marketUser as $key => $v) {
                        array_push($marketkey, $v['uid']); // 所属客户经理的用户uid，查看所有广告主
                    }
                }
                foreach ($marketkey as $k => $uid) {
                    // 2.查询所属广告主的账号
                    $conditionTemp = array();
                    $conditionTemp['role_id'] = 13;
                    $conditionTemp['creator_id'] = $uid;
                    $advertiseKey = array();
                    $advertiseUser = $user_model->getData($conditionTemp, 0, - 1);
                    if ($advertiseUser) {
                        foreach ($advertiseUser as $key => $v) {
                            array_push($advertiseKey, $v['uid']);
                        }
                    }
                }
                $selectedKey = array_unique(array_merge($marketkey, $advertiseKey));
            }
            if ($options == "指定") {
                if ($role_id == 12) {
                    $conditionTemp = array();
                    // 1.先查询所属客户经理账号
                    $conditionTemp['role_id'] = 12;
                    $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为子运营账户的uid
                    $marketkey = array();
                    $marketUser = $user_model->getData($conditionTemp, 0, - 1);
                    if ($marketUser) {
                        foreach ($marketUser as $key => $v) {
                            array_push($marketkey, $v['uid']); // 所属客户经理的用户uid，查看所有广告主
                        }
                    }
                    $selectedKey = $marketkey;
                }
                if ($role_id == 13) {
                    $conditionTemp = array();
                    // 1.先查询所属客户经理账号
                    $conditionTemp['role_id'] = 12;
                    $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为子运营账户的uid
                    $marketkey = array();
                    $marketUser = $user_model->getData($conditionTemp, 0, - 1);
                    if ($marketUser) {
                        foreach ($marketUser as $key => $v) {
                            array_push($marketkey, $v['uid']); // 所属客户经理的用户uid，查看所有广告主
                        }
                    }
                    foreach ($marketkey as $k => $uid) {
                        // 2.查询所属广告主的账号
                        $conditionTemp = array();
                        $conditionTemp['role_id'] = 13;
                        $conditionTemp['creator_id'] = $uid; // 当前登录用户为子运营账户的uid
                        $advertiseKey = array();
                        $advertiseUser = $user_model->getData($conditionTemp, 0, - 1);
                        if ($advertiseUser) {
                            foreach ($advertiseUser as $key => $v) {
                                array_push($advertiseKey, $v['uid']);
                            }
                        }
                    }
                    $selectedKey = $advertiseKey;
                }
            }
        }
        if (($operate_role == 1000) || ($operate_role == 10000)) {
            if ($options == "所属") {
                $conditionTemp = array();
                // 1.先查询子运营商账号
                $conditionTemp['role_id'] = 18;
                $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为子运营账户的uid
                $operatorkey = array();
                $operatorUser = $user_model->getData($conditionTemp, 0, - 1);
                if ($operatorUser) {
                    foreach ($operatorUser as $key => $v) {
                        array_push($operatorkey, $v['uid']); // 子运营账户的uid
                    }
                }
                // 2.查询客户经理的账号
                foreach ($operatorkey as $k => $uid) {
                    $conditionTemp = array();
                    $conditionTemp['role_id'] = 12;
                    $conditionTemp['creator_id'] = $uid;
                    $marketKey = array();
                    $marketUser = $user_model->getData($conditionTemp, 0, - 1);
                    if ($marketUser) {
                        foreach ($marketUser as $key => $v) {
                            array_push($marketKey, $v['uid']);
                        }
                    }
                }
                // 3.查询广告主的账号
                foreach ($marketKey as $k => $uid) {
                    // 2.查询所属广告主的账号
                    $conditionTemp = array();
                    $conditionTemp['role_id'] = 13;
                    $conditionTemp['creator_id'] = $uid;
                    $advertiseKey = array();
                    $advertiseUser = $user_model->getData($conditionTemp, 0, - 1);
                    if ($advertiseUser) {
                        foreach ($advertiseUser as $key => $v) {
                            array_push($advertiseKey, $v['uid']);
                        }
                    }
                }
                    $conditionTemp = array();
                    $allKey = array();
                    $allUser = $user_model->getData($conditionTemp, 0, - 1);
                    if ($allUser) {
                        foreach ($allUser as $key => $v) {
                            array_push($allKey, $v['uid']);
                        }
                    }
                if (empty($operatorkey)) {
                    $operatorkey = array();
                }
                if (empty($marketKey)) {
                    $marketKey = array();
                }
                if (empty($advertiseKey)) {
                    $advertiseKey = array();
                }
                if(empty($allKey)){
                    $allKey = array();
                }
                // 所属，选择子运营商情况
                if ($role_id == 18) {
                    
                    $selectedKey = array_unique(array_merge($operatorkey, $marketKey, $advertiseKey));
                }
                // 所属，选择客户经理情况
                if ($role_id == 12) {
                    $selectedKey = array_unique(array_merge($marketKey, $advertiseKey));
                }
                // 所属，选择广告主情况
                if ($role_id == 13) {
                    $selectedKey = array_unique($advertiseKey);
                }
                if($role_id == 0){
                    $selectedKey = array_unique($allKey);
                }
            }
            if ($options == "指定") {
                if ($role_id == 18) {
                    $conditionTemp = array();
                    // 1.先查询子运营商账号
                    $conditionTemp['role_id'] = 18;
                    $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为子运营账户的uid
                    $operatorkey = array();
                    $operatorUser = $user_model->getData($conditionTemp, 0, - 1);
                    if ($operatorUser) {
                        foreach ($operatorUser as $key => $v) {
                            array_push($operatorkey, $v['uid']); // 子运营账户的uid
                        }
                    }
                    $selectedKey = $operatorkey;
                }
                if ($role_id == 12) {
                    $conditionTemp = array();
                    // 1.先查询子运营商账号
                    $conditionTemp['role_id'] = 18;
                    $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为子运营账户的uid
                    $operatorkey = array();
                    $operatorUser = $user_model->getData($conditionTemp, 0, - 1);
                    if ($operatorUser) {
                        foreach ($operatorUser as $key => $v) {
                            array_push($operatorkey, $v['uid']); // 子运营账户的uid
                        }
                    }
                    // 2.查询客户经理的账号
                    foreach ($operatorkey as $k => $uid) {
                        // 2.查询所属广告主的账号
                        $conditionTemp = array();
                        $conditionTemp['role_id'] = 12;
                        $conditionTemp['creator_id'] = $uid;
                        $marketKey = array();
                        $marketUser = $user_model->getData($conditionTemp, 0, - 1);
                        if ($marketUser) {
                            foreach ($marketUser as $key => $v) {
                                array_push($marketKey, $v['uid']);
                            }
                        }
                    }
                    $selectedKey = $marketKey;
                }
                if ($role_id == 13) {
                    $conditionTemp = array();
                    // 1.先查询子运营商账号
                    $conditionTemp['role_id'] = 18;
                    $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为运营账户或者管理员账户的uid
                    $operatorkey = array();
                    $operatorUser = $user_model->getData($conditionTemp, 0, - 1);
                    if ($operatorUser) {
                        foreach ($operatorUser as $key => $v) {
                            array_push($operatorkey, $v['uid']); // 子运营账户的uid
                        }
                    }
                    // 2.查询客户经理的账号
                    foreach ($operatorkey as $k => $uid) {
                        // 2.查询所属广告主的账号
                        $conditionTemp = array();
                        $conditionTemp['role_id'] = 12;
                        $conditionTemp['creator_id'] = $uid;
                        $marketKey = array();
                        $marketUser = $user_model->getData($conditionTemp, 0, - 1);
                        if ($marketUser) {
                            foreach ($marketUser as $key => $v) {
                                array_push($marketKey, $v['uid']);
                            }
                        }
                    }
                    // 3.查询广告主的账号
                    foreach ($marketkey as $k => $uid) {
                        // 2.查询所属广告主的账号
                        $conditionTemp = array();
                        $conditionTemp['role_id'] = 13;
                        $conditionTemp['creator_id'] = $uid;
                        $advertiseKey = array();
                        $advertiseUser = $user_model->getData($conditionTemp, 0, - 1);
                        if ($advertiseUser) {
                            foreach ($advertiseUser as $key => $v) {
                                array_push($advertiseKey, $v['uid']);
                            }
                        }
                    }
                    $selectedKey = $advertiseKey;
                }
            }
        }
        if ($operate_role == 12) {
            // 客户经理
            if ($options == "全部") {
                $conditionTemp = array();
                // 1.先查询所属客户经理账号
                $conditionTemp['role_id'] = 13;
                $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为客户经理账户
                $advertisekey = array();
                $advertiseUser = $user_model->getData($conditionTemp, 0, - 1);
                if ($advertiseUser) {
                    foreach ($advertiseUser as $key => $v) {
                        array_push($advertisekey, $v['uid']); // 所属客户经理的用户uid，查看所有广告主
                    }
                }
                
                $selectedKey = $advertiseKey;
            }
            if ($options == "指定") {
                $conditionTemp = array();
                // 1.先查询广告主账号
                $conditionTemp['role_id'] = 13;
                $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为客户经理的uid
                $advertisekey = array();
                $advertiseUser = $user_model->getData($conditionTemp, 0, - 1);
                if ($advertiseUser) {
                    foreach ($advertiseUser as $key => $v) {
                        array_push($advertisekey, $v['uid']); // 所属客户经理的用户uid，查看所有广告主
                    }
                }
                
                $selectedKey = $advertiseKey;
            }
        }
        
        return $selectedKey;
    }

    /**
     * 用户帐单
     */
    public function pageUserBill()
    {
        $userBillModel = new model_userbilling();
        $username = $_GET['username'];
        $start_date = $_GET['dateStart'];
        $end_date = $_GET['dateEnd'];
        if (empty($start_date) || empty($end_date)) {
            $start_date = date('Y-m-d', time()-6*24*60*60);   //一周内
            $end_date = date('Y-m-d', time());
        }
        $timeStart = strtotime($start_date.' 00:00:00');
        $timeEnd = strtotime($end_date.' 23:59:59');
        $condition = array();
        $billData = $userBillModel->getData($condition, 0, - 1,"ctime",1);
        $billCount = $userBillModel->getCount();
        $user_model = new model_userInfo();
        $condition = array();
        $users = $user_model->getData($condition, 0, - 1);
        if (! empty($billData) && ! empty(users)) {
            foreach ($billData as $k1 => $v1) {
                foreach ($users as $k2 => $v2) {
                    if ($v1['uid'] == $v2['uid']) {
                        switch ($v2['role_id']) {
                            case 10000:
                                $billData[$k1]['role'] = "管理员";
                                $billData[$k1]['role_id'] = 10000;
                                break;
                            case 1000:
                                $billData[$k1]['role'] = "运营";
                                $billData[$k1]['role_id'] = 1000;
                                break;
                            case 18:
                                $billData[$k1]['role'] = "子运营";
                                $billData[$k1]['role_id'] = 18;
                                break;
                            case 12:
                                $billData[$k1]['role'] = "客户经理";
                                $billData[$k1]['role_id'] = 12;
                                break;
                            case 13:
                                $billData[$k1]['role'] = "广告主";
                                $billData[$k1]['role_id'] = 13;
                                break;
                            default:
                                echo $billData[$k1]['role'] = "不存在";
                                $billData[$k1]['role_id'] = 0;
                        }
                    }
                }
            }
        }
        
        // 根据key筛选用户
        foreach ($billData as $key => $user) {
            if (isset($_GET['username']) && strlen($_GET['username']) > 0 && stripos($user['user_name'], $_GET['username']) === false) {
                unset($billData[$key]);
            }
        }
        // 根据时间筛选数据

            foreach ($billData as $k3=>$v3){
//                if(date('Ymd',strtotime($v3['ctime']))<date('Ymd',strtotime($_GET['statrtdate']))){
                if(($v3['ctime']<$timeStart)){
                    unset($billData[$k3]);
                }
            }
        // 根据时间筛选数据
            foreach ($billData as $k4=>$v4){
//                if(date('Ymd',strtotime($v4['ctime']))>date('Ymd',strtotime($_GET['enddate']))){
                if(($v4['ctime']>$timeEnd)){
                    unset($billData[$k4]);
                }
            }
        $total = count($billData);
        //分页
        if ($_GET['pageNum']) {
            $pageNum = $_GET['pageNum'];
        } else {
            $pageNum = 1;
        }
        $pageSize = 30;
        if ($pageNum * $pageSize - 1 <= $total) {
            $start = ($pageNum - 1) * $pageSize;
            $end = $pageNum * $pageSize - 1;
        } else {
            $start = ($pageNum - 1) * $pageSize;
            $end = $total - 1;
        }
        $billData = array_slice($billData, $start, $pageSize);
        $totalPage = ceil($total / $pageSize);
        $this->assign('dateStart', $start_date);
        $this->assign('dateEnd', $end_date);
        $this->assign("totalPage", $totalPage);
        $this->assign("pageNum", $pageNum);
        $this->assign("billData", $billData);
        $this->assign("total", $total);
        return $this->render("admin/caiwu_user_bill.html");
    }

    /**
     * 广告计划账单
     */
    public function pagePlanBill()
    {
        $planBillModel = new model_planbilling();
        $username = $_GET['username'];
        $planname = $_GET['planname'];
//        $startdate = $_GET['startdate'];
//        $enddate = $_GET['enddate'];
        $start_date = $_GET['dateStart'];
        $end_date = $_GET['dateEnd'];
        if (empty($start_date) || empty($end_date)) {
            $start_date = date('Y-m-d', time()-6*24*60*60);   //一周内
            $end_date = date('Y-m-d', time());
        }
        $timeStart = strtotime($start_date.' 00:00:00');
        $timeEnd = strtotime($end_date.' 23:59:59');

        $uid = $_GET['uid'];
        $condition = array();
        if(isset($uid) && $uid>0){
            $condition['uid'] = $uid;
        }
        $billData = $planBillModel->getData($condition, 0, - 1,"ctime",1);
        $billCount = count($billData);
        $user_model = new model_userInfo();
        $users  = $user_model->getData();
        foreach ($billData as $k=>$v){
            foreach ($users as $k1=>$v1){
                if($v['uid']==$v1['uid']){
                    $billData[$k]['role_id'] = $v1['role_id'];
                }
            }
            
        }
        $condition = array();
        $users = $user_model->getData($condition, 0, - 1);
        if (! empty($billData) && ! empty($users)) {}
        // 根据key筛选用户
        foreach ($billData as $key => $user) {
            if($user['billing_type']==2){
                $billData[$key]['billing_type'] ="cpm";
            }
            if($user['billing_type']==4){
                 $billData[$key]['billing_type'] ="cpt";
            }
            if (isset($_GET['username']) && strlen($_GET['username']) > 0 && stripos($user['user_name'], $_GET['username']) === false) {
                unset($billData[$key]);
            }
            if (isset($_GET['planname']) && strlen($_GET['planname']) > 0 && stripos($user['plan_name'], $_GET['planname']) === false) {
                unset($billData[$key]);
            }

        }
        // 根据时间筛选数据
        foreach ($billData as $k3=>$v3){
//                if(date('Ymd',strtotime($v3['ctime']))<date('Ymd',strtotime($_GET['statrtdate']))){
            if(($v3['ctime']<$timeStart)){
                unset($billData[$k3]);
            }
        }
        // 根据时间筛选数据
        foreach ($billData as $k4=>$v4){
//                if(date('Ymd',strtotime($v4['ctime']))>date('Ymd',strtotime($_GET['enddate']))){
            if(($v4['ctime']>$timeEnd)){
                unset($billData[$k4]);
            }
        }

        $total = count($billData);
        //分页
        if ($_GET['pageNum']) {
            $pageNum = $_GET['pageNum'];
        } else {
            $pageNum = 1;
        }
        $pageSize = 50;
        if ($pageNum * $pageSize - 1 <= $total) {
            $start = ($pageNum - 1) * $pageSize;
            $end = $pageNum * $pageSize - 1;
        } else {
            $start = ($pageNum - 1) * $pageSize;
            $end = $total - 1;
        }
        $billData = array_slice($billData, $start, $pageSize);
        //提供url给查看报表的跳转
        foreach($billData as $k=>$v){
             if($v['role_id'] ==13){
                 $url = "account_type=13&account_provider=0&account_manager=0&uid=".$v['uid']."&plan_id=".$v['plan_id'];
             }
             if($v['role_id']==18){
                 $url = "account_type=18&account_provider=".$v['uid']."&account_manager=0&uid=0&plan_id=".$v['plan_id'];
             }
             if($v['role_id']==12){
                 $url = "account_type=12&account_provider=0&account_manager=".$v['uid']."&uid=0&plan_id=".$v['plan_id'];
             }
              if($v['role_id']==1000){
                  $url = "account_type=1000&account_provider=0&account_manager=0&uid=".$v['uid']."&plan_id=".$v['plan_id'];
             }
             if($v['role_id']==10000){
                 $url = "account_type=10000&account_provider=0&account_manager=0&uid=".$v['uid']."&plan_id=".$v['plan_id'];
             }
             $billData[$k]['url'] = $url;
        }
        $totalPage = ceil($total / $pageSize);
        $this->assign('dateStart', $start_date);
        $this->assign('dateEnd', $end_date);
        $this->assign("totalPage", $totalPage);
        $this->assign("pageNum", $pageNum);
        $this->assign("billData", $billData);
        $this->assign('total',$total);
        return $this->render("admin/caiwu_plan_bill.html");
    }
}


