<?php
// header('Content-Type:text/html; charset=utf-8');
class admin_contract extends STpl
{

    public function __construct($inPath)
    {
        $info = user_api::info();
        $roleId = $info->role_id;
        /*
         * if(!in_array($roleId,array(10000,1000,18,17,12))){
         * $this->success("没有权限",'/user',3);
         * exit();
         * }
         */
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
        $ownuser = array_unique($this->getOwnuser());
        $contractModel = new model_contractInfo();
        $condition = array();
        $like = array();
        $condition['is_delete'] = 1;
        if (! empty($_GET['contract_num'])) {
            $like['contract_num'] = "%".trim($_GET['contract_num'])."%";
        }
        if (! empty($_GET['contact_company_name'])) {
            $like['contact_company_name'] = "%".trim($_GET['contact_company_name'])."%";
        }
        if (! empty($_GET['company_name'])) {
            $like['company_name'] = "%".trim($_GET['company_name'])."%";
        }
        $contractInfo = $contractModel->getDataLike($condition,$like, 0, - 1,"contract_id","desc");
        foreach ($contractInfo as $k => $v) {
            if (!in_array($v['create_uid'], $ownuser)) {
                unset($contractInfo[$k]);
            }
        }
        // 分页操作
        $total = count($contractInfo);
        if ($_GET['pageNum']) {
            $pageNum = $_GET['pageNum'];
        } else {
            $pageNum = 1;
        }
        $pageSize = 15;
        if ($pageNum * $pageSize - 1 <= $total) {
            $start = ($pageNum - 1) * $pageSize;
            $end = $pageNum * $pageSize - 1;
        } else {
            $start = ($pageNum - 1) * $pageSize;
            $end = $total - 1;
        }
        $contractInfo = array_slice($contractInfo, $start, $pageSize);
        $totalPage = ceil($total / $pageSize);
        $this->assign("totalPage", $totalPage);
        $this->assign("pageNum", $pageNum);
        $url['formAction'] = "/admin.contract.list";
        $this->assign("url", $url);
        $pager = pager_api::page(pager_api::toData($contractInfo),"?pageNum=%p");
        $this->assign("pager",$pager);
        $this->assign('total', $total);
        //$this->assign("roles", user_api::getRoleList());
        // $this->assign("roleList", user_api::getRoleList());
        $this->assign("contractInfo", $contractInfo);
        return $this->render("admin/contractManagement_list.html");
    }
    // 合同管理 新建 start
    public function pageNew($inPath)
    {
        require __DIR__ . '../../../tools/SensitiveWordFilter.php';
        $filter = new SensitiveWordFilter(__DIR__ . '../../../tools/dict.txt');
        $info = user_api::info();
        $manager_info = user_api::getUserByID($info->creator_id);
        if (! empty($_POST)) {
            $word = $_POST;
            foreach ($word as $value) {
                $re = $filter->filter(trim($value), 0);
                if ($re == false) {
                    $this->success("您输入的有敏感词请检查后，再创建", "/admin.contract.list");
                    exit();
                }
            }
            $contract_name = $_POST['contract_name'];
            $contact_company_name = $_POST['contact_company_name'];
            $contact_person_phone_number = $_POST['contact_person_phone_number'];
            $contract_type = $_POST['contract_type'];
            $manager_name = $_POST['manager_name'];
            $manager_phone_number = $_POST['manager_phone_number'];
            $company_name = $_POST['company_name'];
            $contact_person = $_POST['contact_person'];
            $contact_ca = $_POST['contact_ca'];
            $discount_rate = $_POST['discount_rate'];
            $unit = $_POST['unit'];
            $contract_remark = $_POST['contract_remark'];
            $discount_rate = $_POST['discount_rate'];
            $total_budget = $_POST['total_budget'];
            $price = $_POST['price'];
            $buy_amount = $_POST['buy_amount'];
            $discount_after = ($total_budget * $discount_rate) / 100;
            $access_budget = $total_budget;
            $data = array(
                "contract_name" => $contract_name,
                "contact_company_name" => $contact_company_name,
                "contact_person_phone_number" => $contact_person_phone_number,
                "manager_name" => $manager_name,
                "manager_phone_number" => $manager_phone_number,
                "company_name" => $company_name,
                "contact_person" => $contact_person,
                "discount_rate" => $discount_rate,
                "discount_after" => $discount_after,

                // "price"=>$price,
                // "unit"=>$unit,
                "total_budget" => $total_budget,
                "create_uid" => $info->uid,
                "contract_type" => $contract_type,
                "access_budget" => $access_budget,
                "contact_ca" => $contact_ca
            );
            $contractModel = new model_contractInfo();
            $contract_id = $contractModel->addData($data);
            if ($contract_id > 0) {
                // 合同类型+客户ID+年月日+顺序号”的方式。
                if ($contract_type == 1) {
                    $contract_num = "R" . $info->uid . date("YmdHis", time()) . $contract_id;
                } else {
                    $contract_num = "P" . $info->uid . date("YmdHis", time()) . $contract_id;
                }
                $condition['contract_id'] = $contract_id;
                $data = array();
                $data['contract_num'] = $contract_num;
                $re = $contractModel->updateData($data, $condition);
                if ($contract_type == 2) {
                    $unitModel = new model_contractUnit();
                    $data = array();
                    foreach ($price as $k => $v) {
                        $data[] = array(
                            'price' => $v
                        );
                    }
                    foreach ($data as $k1 => $v1) {
                        $data[$k1]['unit'] = $unit[$k1];
                        $data[$k1]['buy_amount'] = $buy_amount[$k1];
//                        $data[$k1]['contract_id'] = $contract_id;
                        $data[$k1]['access_buy_amount'] = $buy_amount[$k1];
                        $data[$k1]['access_budget'] = $buy_amount[$k1];
                        $data[$k1]['uid'] = $info->uid;
                        $data[$k1]['create_time'] = time();
                    }
                    $unit_json = array();
                    $json = array();
                    foreach($data as $unit){
                        unset($unit['access_buy_amount']);
                        unset($unit['uid']);
                        unset($unit['create_time']);
                        $unit_json[] = $unit;
                    }
                    $json['unit'] = json_encode($unit_json);
                    $update_unit_json = $contractModel->updateData($json, array("contract_id"=>$contract_id));

                }

                header("location:/baichuan_advertisement_manage/admin.contract.list");
            }
        }

        $this->assign("operate", 1);
        $this->assign("error", $error);
        $this->assign("user", $user);
        $this->assign("info", $info);
        $this->assign("manager_info", $manager_info);
        $this->assign("roleList", $roleList);
        return $this->render("admin/contractManagement_new.html");
    }

    /**
     * 合同编辑
     *
     * @param unknown $inPath
     */
    public function pageEditor($inPath)
    {
        if (! empty($_POST)) {
            $word = $_POST;
            /*
             * foreach ($word as $value) {
             * $re = $filter->filter(trim($value), 0);
             * if($re == false){
             * $this->success("您输入的有敏感词请检查后，再创建", "/admin.user.list") ;
             * exit;
             * }
             * }
             */
            $info = user_api::info();
            $contract_id = $_POST['contract_id'];
            $data = array();
            if (! empty($_POST['contract_name'])) {
                $data['contract_name'] = $_POST['contract_name'];
            }
            if (! empty($_POST['contact_company_name'])) {
                $data['contact_company_name'] = $_POST['contact_company_name'];
            }
            if (! empty($_POST['contact_person_phone_number'])) {
                $data['contact_person_phone_number'] = $_POST['contact_person_phone_number'];
            }
            if (! empty($_POST['manager_phone_number'])) {
                $data['manager_phone_number'] = $_POST['manager_phone_number'];
            }

            if (! empty($_POST['contact_ca'])) {
                $data['contact_ca'] = $_POST['contact_ca'];
            }
            if (! empty($_POST['contact_person'])) {
                $data['contact_person'] = $_POST['contact_person'];
            }
            if (! empty($_POST['manager_name'])) {
                $data['manager_name'] = $_POST['manager_name'];
            }

            if (! empty($_POST['discount_rate'])) {
                $data['discount_rate'] = $_POST['discount_rate'];
            }
            if (! empty($_POST['total_budget'])) {
                $data['total_budget'] = $_POST['total_budget'];
            }
            if (! empty($_POST['discount_after'])) {
                $data['discount_after'] = $_POST['discount_after'];
            }
            if (! empty($_POST['access_budget'])) {
                $data['access_budget'] = $_POST['access_budget'];
            }
            // $contract_num = uniqid($_SERVER['REMOTE_ADDR'].'_'.$_SERVER['REMOTE_PORT'].'_'.getmypid().'_'.mt_rand().'_', true);
            $contractModel = new model_contractInfo();
            $condition['contract_id'] = $_POST['contract_id'];
            $re = $contractModel->updateData($data, $condition);
            if ($_POST['contract_type'] == 2) {
                $price = $_POST['price'];
                $unit = $_POST['unit'];
                $unit_id = $_POST['unit_id'];
                $buy_amount = $_POST['buy_amount'];
                $unitModel = new model_contractUnit();
                $data = array();
                foreach ($price as $k => $v) {
                    $data[] = array(
                        'price' => $v
                    );
                }
                foreach ($data as $k1 => $v1) {
                    $data[$k1]['unit'] = $unit[$k1];
                    $data[$k1]['unit_id'] = $unit_id[$k1];
                    $data[$k1]['buy_amount'] = $buy_amount[$k1];
                    $data[$k1]['contract_id'] = $contract_id;
                    $data[$k1]['access_buy_amount'] = $buy_amount[$k1];
                    $data[$k1]['access_budget'] = $buy_amount[$k1];
                    $data[$k1]['create_time'] = time();
                }
                $unit_json = array();
                $json = array();
                foreach($data as $unit){
                    unset($unit['uid']);
                    unset($unit['contract_id']);
                    unset($unit['access_buy_amount']);
                    unset($unit['create_time']);
                    $unit_json[] = $unit;
                }
                $json['unit'] = json_encode($unit_json);
                $update_unit_json = $contractModel->updateData($json, array("contract_id"=>$contract_id));

                foreach ($data as $k2 => $v2) {
                    // unit不是空就去更新合同的单价
                    if (!empty($unit_id[$k2])) {
                        $conditionUnit = array();
                        $dataUnit = array();
                        $conditionUnit['unit_id']=$unit_id[$k2];
                        $dataUnit['unit_id'] = $unit_id[$k2];
                        $dataUnit['unit'] = $unit[$k2];
                        $dataUnit['buy_amount'] = $buy_amount[$k2];
                        $dataUnit['access_buy_amount'] = $buy_amount[$k2];
                        $dataUnit['access_budget'] = $buy_amount[$k2];
                        $dataUnit['price'] = $price[$k2];
                        $re = $unitModel->updateData($dataUnit, $conditionUnit);
                    } else { // 编辑时候添加单价
                        $v2['access_budget'] = $v2['access_buy_amount'];
                        $re = $unitModel->addData($v2);
                    }
                }
            }
            $this->success("successful", '/admin.contract.list.');
        }
        $condition = array();
        $contractModel = new model_contractInfo();
        $condition['contract_id'] = $inPath[3];
        $contract_info = $contractModel->getData($condition, 0, - 1);
        $contract = $contract_info[0];
//        $unitModel = new model_contractUnit();
//        $unit = $unitModel->getData($condition, 0, - 1);
        $unit = json_decode($contract['unit'],true);
        $this->assign("contractinfo", $contract);
        $this->assign("unitlist", $unit);
        return $this->render("admin/contractManagement_editor.html");
    }

    /**
     * 合同审核通过列表，合同审核拒绝列表，合同待审核列表只需要通过一个方法，传参数进去即可，type，1是待审核，2是通过，3是拒绝
     *
     * @param unknown $inPath
     */
    public function pageAudited($inPath)
    {
        $info = user_api::info();
        $roleId = $info->role_id;
        if ($roleId == 13) {
            $this->success("没有权限", '/user', 3);
            exit();
        }
        if (empty($_GET['type'])) {
            $_GET['type'] = 1;
        }
        $condition['verify_status'] = $_GET['type'];
        $condition['is_delete'] = 1;
        $contractModel = new model_contractInfo();
        $contractInfo = $contractModel->getData($condition, 0, - 1,"contract_id","desc");
        $ownuser = array_unique($this->getOwnuser());
        foreach ($contractInfo as $k => $v) {
            if (!in_array($v['create_uid'], $ownuser)) {
                unset($contractInfo[$k]);
            }
        }
        // 分页操作
        $total = count($contractInfo);
        if ($_GET['pageNum']) {
            $pageNum = $_GET['pageNum'];
        } else {
            $pageNum = 1;
        }
        $pageSize = 10;
        if ($pageNum * $pageSize - 1 <= $total) {
            $start = ($pageNum - 1) * $pageSize;
            $end = $pageNum * $pageSize - 1;
        } else {
            $start = ($pageNum - 1) * $pageSize;
            $end = $total - 1;
        }
        $contractList = array_slice($contractInfo, $start, $pageSize);
        foreach ($contractList as $key => $val) {
            if (intval($val['verify_status']) == 1) {
                $contractList[$key]['verify_status'] = "待审核";
            }
            if ($val['verify_status'] == 2) {
                $contractList[$key]['verify_status'] = "通过";
            }
            if ($val['verify_status'] == 3) {
                $contractList[$key]['verify_status'] = "退回修改";
            }
        }
        $totalPage = ceil($total / $pageSize);
        $this->assign("totalPage", $totalPage);
        $this->assign("pageNum", $pageNum);
        // $pager = pager_api::page(pager_api::toData($usersTemp),"?page=%p&status=$status&account_type=");
        $url['formAction'] = "/admin.contract.list";
        $this->assign("url", $url);
        $this->assign("pager", $pager);
        $this->assign('total', $total);
        // $this->assign("roles", user_api::getRoleList());
        // $this->assign("roleList", user_api::getRoleList());
        $this->assign("contractInfo", $contractList);
        return $this->render("admin/contractManagement_audited.html");
    }

    /**
     * 调整审核状态,用ajax方式，传参数type 2是通过，3是拒绝
     */
    public function pageContractSet()
    {
        $data = array();
        $condition = array();
        $type = $_REQUEST['type'];
        $currentUser = user_api::info();
        // 合同id
        $contract_id = $_REQUEST['contract_id'];
        $condition['contract_id'] = $contract_id;
        $data['audit_person_uid'] = $currentUser->uid;  //审核者uid
        $data['verify_status'] = $type;
        $contractModel = new model_contractInfo();
        $re = $contractModel->updateData($data, $condition);
        if($re >0 && $type ==2){  //审核通过后折扣前合同金额自动充值到账户余额
            $updateUnitInfo  = $this->updateUnitInfo($contract_id);

            $contractInfo = $contractModel->getData(array("contract_id"=>$contract_id));
            $contract_budget = $contractInfo[0]['total_budget'];
            $aduser = new thrift_aduser_main();
            $user = user_api::getUserById($contractInfo[0]['create_uid']);
            $history_account = $user->account;
            $user->account = $history_account + $contract_budget;
            $aduser->updateAdUserInfo($user);

            //往adp_caiwu_log表中写数据
            $amount = array();
            $amount['operator_id'] = $contractInfo[0]['create_uid'];
            $amount['op_time'] = time();
            $amount['target_uid'] = $contractInfo[0]['create_uid'];
            $amount['operate_code'] = 4; //合同充值
            $amount['operate_num'] = $contract_budget;
            $amount['contract_id'] = $contract_id;
            $amount['source'] = 1;
            $amount['history_money'] = $history_account;
            $amount['flow_money'] = $user->account;
            $caiwuModel = new model_caiwuLog();
            $reAdd = $caiwuModel->addData($amount);
        }
        if(isset($_GET['currentStatus']) && $_GET['currentStatus'] >0){
            $currentStatus = $_GET['currentStatus'];
        }
        if($type!=1 && $type !=2 && $type!=3){
            return false;
        }
        //start
        //初始化审核日志
        $log = new admin_contractlogapi;
        //初始化系统消息类
        $message = new message_api;
        $operator = user_api::name();
        $operate_uid = user_api::id();

        if($currentStatus ==1 && $type ==2){  //由待审核转为通过
            $operate_num = 112;
        }elseif($currentStatus ==1 && $type ==3){ //由待审核转为未通过
            $operate_num = 113;
        }elseif($currentStatus ==2 && $type ==3){
            $operate_num = 123;  //由已通过状态转为未通过
        }elseif($currentStatus ==3 && $type ==2){
            $operate_num = 132;  //由未通过状态转为已通过
        }else{
            $operate_num = 100;
        }
        //批量处理
        foreach($_REQUEST['data_list'] as $uid => $plan_list){
            $msgText = $this->generateMsgText($operate_num, $plan_list); //生成文本信息
            $log->addLog($operate_uid, $uid, $operate_num, $plan_list, $msgText['body']);//日志生成
        }
//        return true;
        //end
        $flag = ($re >0)?"审核成功":"审核失败";
        return json_encode($flag);

    }

    /**
     * 删除合同
     */
    public function pageDel()
    {
        $contract_id = $_REQUEST['contract_id'];
        // 合同id
        $condition['contract_id'] = $contract_id;
        $data['is_delete'] = 0;
        $contractModel = new model_contractInfo();
        $re = $contractModel->updateData($data, $condition);
        return true;
    }

    /**
     * 获取合同内容
     */
    public function pageGet()
    {
        $contract_id = $_REQUEST['contract_id'];
        $condition['contract_id'] = $contract_id;
        // $condition['is_delete'] = 0;
        $unitModel = new model_contractUnit();
        $contractModel = new model_contractInfo();
        $re = $contractModel->getData($condition, 0, - 1,"contract_id","desc");
        $unit = $unitModel->getData(array(
            "contract_id" => $contract_id
        ), 0, - 1);
        foreach ($unit as $key => $val) {
            if ($val['unit'] == 2) {
                $unit[$key]['unit'] = "cpm";
            } else {
                $unit[$key]['unit'] = "cpt";
            }
        }
        if ($re) {
            $re[0]['unit'] = $unit;
        }
        echo SJson::encode($re);
    }

    /**
     * 获取单价信息
     */
    public function pageGetUnit()
    {
        $unit_id = $_POST['unit_id'];
        $unitModel = new model_contractUnit();
        $condition['unit_id'] = $unit_id;
        $re = $unitModel->getData($condition, 0, - 1,"unit_id","desc");
        /*
         * foreach($re as $k=>$v){
         * if($v['unit']==1){
         * $re[$k]['unit'] = "cpm";
         * }
         * if($v['unit']==2){
         * $re[$k]['unit'] = "cpt";
         * }
         * }
         */

        echo SJson::encode($re);
    }

    /**
     * *
     * 获取当前用户的管理用户列表
     */
    private function getOwnuser()
    {
        $info = user_api::info();
        $user_model = new model_userInfo();
        if ($info->role_id == 13) {
            //广告主只能查看自己
            $uids[] = $info->uid;
            return $uids;
        }
        if ($info->role_id == 10000||$info->role_id==1000) {
            //1，管理员首先可以查看自己
            $uids[] = $info->uid;
            $condition1 = array();
            //2查看自己创建的的子运营的账号
            $condition1['creator_id'] = $info->uid;
            $condition1['role_id'] = 18;
            $userOp = $user_model->getData($condition1, 0, - 1);
            if ($userOp) {
                foreach ($userOp as $v2) {
                    array_push($uids, $v2['uid']);
                    //3.查看自己创建的客户经理的账号
                    $condition2['creator_id'] = $v2['uid'];
                    $condition2['role_id'] = 12;
                    $userManager1 = $user_model->getData($condition2, 0, - 1);
                    if ($userManager1) {
                        foreach ($userManager1 as $v3) {
                            array_push($uids, $v3['uid']);
                            //3.查看自己创建的广告主的账号
                            $condition3['creator_id'] = $v3['uid'];
                            $condition3['role_id'] = 13;
                            $userAdvertise1 = $user_model->getData($condition3, 0, - 1);
                            if ($userAdvertise1 ) {
                                foreach ($userAdvertise1  as $v4) {
                                    array_push($uids, $v4['uid']);
                                }
                            }
                        }
                    }

                }
            }
            //3.查看自己创建的客户经理的账号
            $condition4['creator_id'] = $info->uid;
            $condition4['role_id'] = 12;
            $userManager2 = $user_model->getData($condition4, 0, - 1);
            if ($userManager2) {
                foreach ($userManager2 as $v5) {
                    array_push($uids, $v5['uid']);
                    //3.查看自己创建的广告主的账号
                    $condition5['creator_id'] = $v5['uid'];
                    $condition5['role_id'] = 13;
                    $userAdvertise2 = $user_model->getData($condition5, 0, - 1);
                    if ($userAdvertise2 ) {
                        foreach ($userAdvertise2  as $v6) {
                            array_push($uids, $v6['uid']);
                        }
                    }
                }
            }
            //3.查看自己创建的广告主的账号
            $condition['creator_id'] = $info->uid;
            $condition['role_id'] = 13;
            $userAdvertise = $user_model->getData($condition, 0, - 1);
            if ($userAdvertise ) {
                foreach ($userAdvertise  as $v) {
                    array_push($uids, $v);
                }
            }
            return $uids;
        }
        //子运营商角色
        if ($info->role_id == 18) {
            // 1，子运营商首先可以查看自己
            $uids[] = $info->uid;
            $condition = array();
            //2.查看自己创建的客户经理的账号
            $condition['creator_id'] = $info->uid;
            $condition['role_id'] = 12;
            $userManager = $user_model->getData($condition, 0, - 1);
            if ($userManager) {
                foreach ($userManager as $v) {
                    array_push($uids, $v['uid']);
                    //3.查看自己创建的广告主的账号
                    $condition['creator_id'] = $v['uid'];
                    $condition['role_id'] = 13;
                    $userAdvertise = $user_model->getData($condition, 0, - 1);
                    if ($userAdvertise ) {
                        foreach ($userAdvertise  as $v) {
                            array_push($uids, $v['uid']);
                        }
                    }

                }
            }
            //3.查看自己创建的广告主的账号
            $condition2['creator_id'] = $info->uid;
            $condition2['role_id'] = 13;
            $userAdvertise2 = $user_model->getData($condition2, 0, - 1);
            if ($userAdvertise2 ) {
                foreach ($userAdvertise2  as $v2) {
                    array_push($uids, $v2['uid']);
                }
            }
            return $uids;
        }
        //客户经理角色
        if ($info->role_id == 12) {
            // 1，客户经理首先可以查看自己
            $uids[] = $info->uid;
            $condition = array();
            //3.查看自己创建的广告主的账号
            $condition['creator_id'] = $info->uid;
            $condition['role_id'] = 13;
            $userAdvertise = $user_model->getData($condition, 0, - 1);
            if ($userAdvertise ) {
                foreach ($userAdvertise  as $v) {
                    array_push($uids, $v['uid']);
                }
            }
            return  $uids;
        }

    }

    /**
     * @param $inPath
     * @description 查看合同详情
     */
    public function pageDetail($inPath){
        $contract_id = $_GET['contract_id'];
//        $ContractContent = $this->getContractContent($contract_id);

        if(isset($contract_id) && $contract_id >0){
            $condition['contract_id'] = $contract_id;
            $contractModel = new model_contractInfo();
            $contractInfo= $contractModel->getData($condition, 0, - 1);
            $audit_person_info = user_api::getUserByID($contractInfo[0]['audit_person_uid']);
            $this->assign("audit_person_info",$audit_person_info);
            $this->assign("contract",$contractInfo[0]);
        }
        $ContractContent = json_decode($contractInfo[0]['unit'],true);
        $this->assign("ContractContent",$ContractContent);
        return $this->render("admin/contractManagement_detail.html");

    }

    /**
     * 获取合同内容
     */
    public  function  getContractContent($contractId){
        $contract_id = $contractId;
        $condition['contract_id'] = $contract_id;
        //$condition['is_delete'] = 0;
        $unitModel = new model_contractUnit();
        $contractModel = new model_contractInfo();
        $re = $contractModel->getData($condition,0,-1,"contract_id","desc");
        $unit = $unitModel->getData(array("contract_id"=>$contract_id),0,-1);
        foreach($unit as $key=>$val){
            if($val['unit']==2){
                $unit[$key]['unit'] = "cpm";
            } else{
                $unit[$key]['unit'] = "cpt";
            }

        }
        if($re){
            $re[0]['unit'] = $unit;
        }
//        echo  SJson::encode($re);
        return $re;
    }

    /**
     *合同审核日志
     */
    public function pageAuditedLog($inPath){
        $start = $_GET['start'];
        $end = $_GET['end'];
        $uid = $_GET['uid'];
        $code = $_GET['code'];
        $condition = array();
        if (empty($start) || empty($end)) {
            $start = date('Y-m-d', time() - 6*24*60*60);   //一周内
            $end = date('Y-m-d', time());
        }

        $condition[] = "time >= " . strtotime($start);
        $condition[] =  "time <= " . (strtotime($end) + 24*60*60 - 1);

        if (!empty($uid)) {
            $condition['target_uid'] = $uid;
        }

        if (!empty($code)) {
            $condition['operate_num'] = $code;
        }

        $page = $_GET['pageNum']>0? $_GET['pageNum']: 1;
        $limit = $_GET['limit']>0? $_GET['limit']: 20;

        $db = new SDb();
        $db->useConfig('adp');
        $db->setPage($page);
        $db->setLimit($limit);
        $result = $db->select('adp_contract_audited_log',$condition);
        $list  = array_reverse($result->items);

        $user_list = array();
        $plan_list = array();
        $stuff_list = array();
        foreach ($list as $item ) {
            $user_list[] = $item['operate_uid'];
            $user_list[] = $item['target_uid'];
            $op_num = substr($item['operate_num'], 0, 1);
            if ( $op_num == 1) {
                $arr = explode(',', $item['object_id']);
                $plan_list = array_merge($plan_list, $arr);
            } else if($op_num == 2) {
                $arr = explode(',', $item['object_id']);
                $stuff_list = array_merge($stuff_list, $arr);
            }
        }
        $user_list = array_unique($user_list);
        $plan_list = array_unique($plan_list);
        $stuff_list = array_unique($stuff_list);

        $user_list = api_common::getUserNameByList($user_list);
        $plan_list = api_common::getPlanNameByList($plan_list);
        $stuff_list = api_common::getStuffNameByList($stuff_list);

        foreach ($list as &$item) {
            $item['operate_uid'] = $item['operate_uid'] .':'.$user_list[$item['operate_uid']];
            $item['target_uid'] = $item['target_uid'] .':'.$user_list[$item['target_uid']];

            $op_num = substr($item['operate_num'], 0, 1);
            if ( $op_num == 1) {
                $arr = explode(',', $item['object_id']);
                $item['object_id'] = '';
                foreach ($arr as $pid) {
                    $name = isset($plan_list[$pid]) ? $plan_list[$pid]: '未知';
                    $item['object_id'] .= $pid. ':' . $name.', ';
                }
            } else if($op_num == 2) {
                $arr = explode(',', $item['object_id']);
                $item['object_id'] = '';
                foreach ($arr as $sid) {
                    $name = isset($stuff_list[$sid]) ? $stuff_list[$sid]: '未知';
                    $item['object_id'] .= $sid. ':' . $name.', ';
                }
            }
        }

        $this->assign('start', $start);
        $this->assign('end', $end);
        $this->assign('uid', $uid);
        $this->assign('code', $code);
        $this->assign('user_list', $user_list);
        $this->assign('plan_list', $plan_list);
        $this->assign('stuff_list', $stuff_list);
        $this->assign('list', $list);
        $this->assign('page', $result->page);
        $this->assign('totalPage', $result->totalPage);
        $this->assign('limit', $result->limit);
        $this->assign('totalSize', $result->totalSize);
        return $this->render("v2/admin/contractManagement_audited_log.html");
    }


    //生成消息文本
    private function generateMsgText($operate_num, $object_list) {
        if ($operate_num < 100)
            return;
        $subject = '合同审核结果';
        $num = count($object_list);
        $body = '有 '.$num.' 个';

        //十位数，原先的状态
        $code = substr($operate_num, 1, 1);
        if ( $code == '1') {
            $body .= '等待审核的';
        } else if ($code == '2') {
            $body .= '原先已审核通过的';
        } else if ($code == '3') {
            $body .= '原先已被拒绝的';
        }

        //百位数，操作对象的类型
        $code = substr($operate_num, 0, 1);
        if ( $code == '1') {
            $body .= '合同,';
        } else if ($code == '2') {
            $body .= '素材,';
        }

        //个位数，被操作之后的状态
        $code = substr($operate_num, 2, 1);
        if ( $code == '1') {
            $body .= '已经被置为等待审核的状态。';
        } else if ($code == '2') {
            $body .= '已经被置为审核通过。';
        } else if ($code == '3') {
            $body .= '已经被拒绝。';
        }

        $body .=  '被审核的内容如下：';
        foreach ($object_list as $obj) {
            $body .= $obj. ' ';
        }
        $msgText = array();
        $msgText['subject'] = $subject;
        $msgText['body'] = $body;
        return $msgText;
    }

    /**
     * @param $contract_id
     * @author hyman
     * @date 2018-01-18
     * @description 合约制合同审核通过时更新adp_contract_unit表
     */
    private function updateUnitInfo($contract_id){
        $contractModel = new model_contractInfo();
        $unitModel = new model_contractUnit();
        $contract = $contractModel->getData(array("contract_id"=>$contract_id));
        $contractUnitInfo = $contract[0]["unit"];
        $arr_contractUnit = json_decode($contractUnitInfo);
        $data = array();
        if(count($arr_contractUnit) >0){
            foreach($arr_contractUnit as $val){
                $unit_info["price"] = $val->price;
                $unit_info["uid"] = $contract[0]["create_uid"];
                $unit_info["unit"] = $val->unit;
                $unit_info["buy_amount"] = $val->buy_amount;
                $unit_info["access_budget"] = $val->access_budget;
                $data[] = $unit_info;
            }
        }
        foreach ($data as $k2 => $v2) {
            $item = array();
            $item['price'] = $v2['price'];  //单价
            $item['uid'] = $v2['uid'];  //用户uid
            $item['unit'] = $v2['unit'];  //计费类别2为CPM，4为CPT
            $unit_one = $unitModel->getData($item);
            if(count($unit_one)>0){ //若存在某个类型的单价数据则更新之前的数据，若不存在则新增
                $update_unit = array();
                $update_unit['buy_amount'] = $unit_one[0]['buy_amount']+$v2['buy_amount'];
//                $update_unit['access_buy_amount'] = $unit_one[0]['access_buy_amount']+$v2['access_buy_amount'];
                $update_unit['access_buy_amount'] = $unit_one[0]['access_buy_amount']+$v2['access_budget'];
                $update_unit['access_budget'] = $unit_one[0]['access_budget']+$v2['access_budget'];
                $update_unit['update_time'] = time();
                $re = $unitModel->updateData($update_unit,$item);
            }else{
//                $v2['access_budget'] = $v2['access_buy_amount'];
                $v2['access_buy_amount'] = $v2['access_budget'];
                $v2['create_time'] = time();
                $v2['update_time'] = time();
                $re = $unitModel->addData($v2);
            }
        }
            return $re;
    }

}