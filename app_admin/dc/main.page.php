<?php

class dc_main extends STpl
{

    private $week_note = array();

    public function __construct($inPath)
    {
        if (! user_api::auth("dc")) {
            $this->success("没有权限", '/user', 3);
            exit();
        }
    }

    public function pageEntry($inPath)
    {
        header("location:/baichuan_advertisement_manage/dc.main.ad");
    }

    /**
     * 
     * 广告维度统计
     */
    public function pageAd($inPath)
    {
        $start = empty($_REQUEST['start']) ? date("Ymd", time() - 30 * 24 * 3600) : date("Ymd", strtotime($_REQUEST['start']));
        $end = empty($_REQUEST['end']) ? date("Ymd", time()) : date("Ymd", strtotime($_REQUEST['end']));
        $status = 0;
        $uid = 0;
        $plan_id = 0;
        $group_id = 0;
        $type = empty($_REQUEST['type']) ? "all" : $_REQUEST['type'];
        $_users = array();
        $_plans = array();
        $_groups = array();
        $patchName = "";
        $patchId = 0;
        $info = user_api::info();
        //1120 end
        if(isset($_REQUEST['uid']) && ($_REQUEST['uid'] !=0)){
            $uid = $_REQUEST['uid'];
        }else{
            if(isset($_REQUEST['account_provider']) && ($_REQUEST['account_provider'] !=0)){
//                $uid = $_REQUEST['account_provider'];
                $uid = 0;
            }
            if(isset($_REQUEST['account_manager']) && ($_REQUEST['account_manager'] !=0)){
//                $uid = $_REQUEST['account_manager'];
                $uid = 0;
            }
        }
        if($info->role_id ==13){  //广告主
            $uid = $info->uid;
        }

        // 获取用户的广告计划
        $_plans = dc_db::listPlans(array(
            "bind_id" => $uid
        ));
        if (! empty($_REQUEST['plan_id'])) {
            $plan_id = $_REQUEST['plan_id'];
            // 获取用户的广告计划
            $_groups = dc_db::listGroups(array(
                "plan_id" => $plan_id
            ));
        } else {
            $_REQUEST['group_id'] = 0;
        }
        
         if (! empty($_REQUEST['group_id'])) {
            $group_id = $_REQUEST['group_id'];
            // 获取用户的广告计划
            $_ads = dc_db::listAds(array(
                "group_id" => $group_id
            ));
        } else {
            $_REQUEST['group_id'] = 0;
        }
        if (! empty($_REQUEST['status'])) {
            $status = $_REQUEST['status'];
        }
        if (! empty($group_id)) {
            // 获取对应广告组的
            if ($type == "all") {
                $r = dc_api::AdReportByGroupId($group_id, $start, $end);
                $patchName = "ad";
                $patchId = $group_id;
            } elseif ($type == "day") {
                $r = dc_api::DayByGid($group_id, $start, $end);
                $patchName = "day";
            } elseif ($type == "hour") {
                $r = dc_api::HourByGid($group_id, $start, $end);
                $patchName = "hour";
            } elseif ($type == "area") {
                $r = dc_api::AreaByGid($group_id, $start, $end);
                $patchName = "area";
            } elseif ($type == "source") {
                $r = dc_api::SourceByGid($group_id, $start, $end);
            } elseif ($type == "media") {
                $r = dc_api::HostByGid($group_id, $start, $end);
            } elseif ($type == "ta") {
                $r = dc_api::AdspaceByGid($group_id, $start, $end);
                $patchName = "ta";
            } elseif ($type == "week") {
                $r = dc_api::DayByGid($group_id, $start, $end);
                $patchName = "week";
            }
        } elseif (! empty($plan_id)) {
            // 获取对应广告计划的
            if ($type == "all") {
                $r = dc_api::GroupReportByPlanId($plan_id, $start, $end);
                $patchName = "group";
                $patchId = $plan_id;
            } elseif ($type == "day") {
                $r = dc_api::DayByPid($plan_id, $start, $end);
                $patchName = "day";
            } elseif ($type == "hour") {
                $r = dc_api::HourByPid($plan_id, $start, $end);
                $patchName = "hour";
            } elseif ($type == "area") {
                $r = dc_api::AreaByPid($plan_id, $start, $end);
                $patchName = "area";
            } elseif ($type == "source") {
                $r = dc_api::SourceByPid($plan_id, $start, $end);
            } elseif ($type == "media") {
                $r = dc_api::HostByPid($plan_id, $start, $end);
            } elseif ($type == "ta") {
                $r = dc_api::AdspaceByPid($plan_id, $start, $end);
                $patchName = "ta";
            } elseif ($type == "week") {
                $r = dc_api::DayByPid($plan_id, $start, $end);
                $patchName = "week";
            }
        } else {
            // 获取对应用户下的所有广告计划数据
            if ($type == "all") {
                if (!empty($uid)) {
                   $r = dc_api::PlanReportByUid($uid, $start, $end);
                   $patchName = "plan";
                   //$patchId = $uid;
                } else {
                    $r = dc_api::CostsByUidV2($uid = 0, $start, $end);
                    $patchName = "user";
                }
            } elseif ($type == "day") {
                $r = dc_api::DayByUid($uid, $start, $end);
                $patchName = "day";
            } elseif ($type == "hour") {
                $r = dc_api::HourByUid($uid, $start, $end);
                $patchName = "hour";
            } elseif ($type == "area") {
                $r = dc_api::AreaByUid($uid, $start, $end);
                $patchName = "area";
            } elseif ($type == "source") {
                $r = dc_api::SourceByUid($uid, $start, $end);
            } elseif ($type == "media") {
                 $r = dc_api::AdspaceByUid($uid, $start, $end);
                 $patchName = "media";
            } elseif ($type == "ta") {
                $r = dc_api::AdspaceByUid($uid, $start, $end);
                $patchName = "ta";
            } elseif ($type == "week") {
                $r = dc_api::DayByUid($uid, $start, $end);
                $r = $this->day2week($r, $start);
                $patchName = "week";
            }
        }
        $condition = array();
        $this->userInfoModel = new model_userInfo();
        if($info->role_id == 1000 || $info->role_id == 10000){  //系统管理员
            if(isset($_REQUEST['account_type']) && $_REQUEST['account_type'] >0){
                if($_REQUEST['account_type'] ==18){ //子运营
                    if($_REQUEST['account_provider'] >0 && $_REQUEST['account_manager'] ==0){
                        $condition['creator_id'] = $_REQUEST['account_provider'];
                        $condition['role_id'] = 12;
                        $managerUsers = $this->userInfoModel->getData($condition,0,-1);
                        $uid_list = array_column($managerUsers,"uid");
                    }elseif($_REQUEST['account_provider']>0 && $_REQUEST['account_manager']>0){
                        $uid_list = array($_REQUEST['account_manager']); //查找客户经理
                    }
                    $item = array();
                    if(count($uid_list) > 1){
                        $uid_string = implode(",",$uid_list);
                        $item = " AND creator_id IN ($uid_string) AND role_id =13";
                    }else{
                        $item['role_id'] =13;
                        $item['creator_id'] =$uid_list[0];
                    }
                    $adUsers = $this->userInfoModel->getData($item,0,-1);

                }elseif($_REQUEST['account_type'] ==12){  //客户经理
                    if($_REQUEST['account_manager'] ==0){
                        $condition['role_id'] = 12;
                        $managerUsers = $this->userInfoModel->getData($condition,0,-1);
                        $uid_list = array_column($managerUsers,"uid");
                    }elseif($_REQUEST['account_manager']>0){
                        $uid_list = array($_REQUEST['account_manager']); //查找客户经理
                    }
                    $item = array();
                    if(count($uid_list) > 1){
                        $uid_string = implode(",",$uid_list);
                        $item = " AND creator_id IN ($uid_string) AND role_id =13";
                    }else{
                        $item['role_id'] =13;
                        $item['creator_id'] =$uid_list[0];
                    }
                    $adUsers = $this->userInfoModel->getData($item,0,-1);

                }elseif($_REQUEST['account_type'] ==13){ //广告商
                    if($_REQUEST['uid'] >0){
                        $condition['uid'] = $_REQUEST['uid'];
                    }
                    $adUsers = $this->userInfoModel->getData($condition,0,-1);
                }

            }else{
                $condition['role_id'] =13;
                $adUsers = $this->userInfoModel->getData($condition,0,-1);
            }

        }elseif($info->role_id ==18){  //子运营商
            if($_REQUEST['account_type'] ==12 && $_REQUEST['account_manager'] >0){ //客户经理
                    $condition['creator_id'] = $_REQUEST['account_manager'];
                    $condition['role_id'] = 13;
                    $adUsers = $this->userInfoModel->getData($condition,0,-1);
            }elseif($_REQUEST['account_type'] ==13 && $_REQUEST['uid'] >0){
                $condition['uid'] = $_REQUEST['uid'];
                $condition['role_id'] = 13;
                $adUsers = $this->userInfoModel->getData($condition,0,-1);
            }else{
                $condition['creator_id'] = $info->uid;
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
                $adUsers = $this->userInfoModel->getData($item,0,-1);
            }
        }elseif($info->role_id ==12){ //客户经理
            if($_REQUEST['account_type'] ==13 && $_REQUEST['uid']>0){
                $condition['uid'] = $_REQUEST['uid'];
            }else{
                $condition['creator_id'] = $info->uid;
                $condition['role_id'] = 13;
            }
            $adUsers = $this->userInfoModel->getData($condition,0,-1);
        }else{ //广告主
            $condition['uid'] = $info->uid;
            $adUsers = $this->userInfoModel->getData($condition,0,-1);
        }
        $uid_list = array_column($adUsers,"uid");
        $uid_data = $r->data;
        foreach($uid_data as $data){
            if(in_array($data->uid,$uid_list)){
                $result_data[] = $data;
            }
        }

        $r->totalSize = count($result_data);
        $r->currentSize = count($result_data);
        $r->totalPage = intval(ceil(count($result_data)/20));
        $r->pageNumber = 1;
        $r->data = $result_data;
        $r1 = new reportResult();
        $r = $this->patchName($r, $patchName, $patchId);
        $sort_order = 0;
        if (empty($_REQUEST['index_id'])) {
            $index_id = "pv";
        } else {
            $index_id = $_REQUEST['index_id'];
        }
        if (empty($_REQUEST['sort_id'])) {
            $sort_id = "pv";
        } else {
            $sort_id = $_REQUEST['sort_id'];
        }
        foreach ($r->data as $k => $v) {
            /*$r->data[$k]->pc = 10;
            $r->data[$k]->uv = 10;
            $r->data[$k]->uc = 10;
            $r->data[$k]->ipv = 10;
            $r->data[$k]->ipc = 10;*/
            $r->data[$k]->name = $r->data[$k]->name;
            $tmp = (array) $v;
            $id[] = $tmp[$sort_id];
        }
        if ($_REQUEST['sort_order'] == 1) {
            $sort_order = 1;
        }
        if($type!="week" && $type!="day"){
            array_multisort($id, SORT_DESC, $r->data);
        }
        //array_multisort($id, SORT_DESC, $r->data);
        $adminFlag = false;
        if (user_api::auth("admin") || $info->role_id == "1000") {
            $_users = dc_db::listUsers(array());
            $adminFlag = true;
        } else {
            $_users = dc_db::listUsers(array(
                "uid" => user_api::id()
            ));
        }
        $data = array();
        $isPie = false;
        switch ($type) {
            case "all":
            case "day":
            case "hour":
            case "week":
                $data_json = $this->data2bar($r);
                break;
            case "ta":
                $data_json = $this->data2bar($r, 0, 1);
                break;
            case "area":
                $data_json = $this->dataArea2pie($r, 10, $_REQUEST['index_id']);
                $isPie = true;
                break;
            case "source":
                $data_json = $this->data2pie($r);
                $isPie = true;
                break;
            case "media":
                $data_json = $this->data2pie($r, 10);
                $isPie = true;
                break;
        }
        if ($_REQUEST['sort_order'] == 1) {
            array_multisort($id, SORT_ASC, $r->data);
        }
        if (empty($_REQUEST['uid']) && $info->role_id == "1000") {
            $uid = "";
        }
        if (empty($_REQUEST['sort_id'])) {
            $sort_id = "pv";
        } else {
            $sort_id = $_REQUEST['sort_id'];
        }
        if(empty($_REQUEST['ad_id'])){
            $ad_id = 0;
        }else{
            $ad_id = $_REQUEST['ad_id'];
        }

        $this->assign("month", $_REQUEST[month] ? $_REQUEST[month] : 0);
        $this->assign("week", $_REQUEST[week] ? $_REQUEST[week] : 0);
        $this->assign("sort_id", $sort_id);
        $this->assign("sort_order", $sort_order);
        $this->assign("index_id", $index_id);
        $this->assign("isPie", $isPie);
        $this->assign("r", $r);
        $this->assign("data_json", $data_json); // $this->data2bar($data));
        $this->assign("start", $start);
        $this->assign("end", $end);
        $this->assign("type", $type);
        $this->assign("uid", $uid);
        $this->assign("plan_id", $plan_id);
        $this->assign("ad_id", $ad_id);
        $this->assign("group_id", $group_id);
        $this->assign("patchName", $patchName);
        $this->assign("_users", @$_users->items);
        $this->assign("_plans", @$_plans->items);
        $this->assign("_groups", @$_groups->items);
        $this->assign("_ads", @$_ads->items);
        $this->assign("adminFlag", $adminFlag);
        $info = user_api::info();
        $this->assign('info', $info);
        $role_id = isset($_GET['role_id']) ? $_GET['role_id'] : 0;
        $uid = isset($_GET['uid']) ? $_GET['uid'] : 0;
        if ($info->role_id == 1000 || $info->role_id == 10000) {
            $account_provider = $this->selectOpUser();
            $this->assign('account_provider', $account_provider);
            $account_manager = $this->selectMangerUser($info->uid);
            $this->assign('account_manager', $account_manager);
            $account_advertiser = $this->selectAdvertiseUser($uid);
            $this->assign('account_advertiser', $account_advertiser);
        }
        // 子运营商
        if ($info->role_id == 18) {
            $account_manager = $this->selectMangerUser($info->uid);
            $this->assign('account_manager', $account_manager);
            $account_advertiser = $this->selectAdvertiseUser($uid);
            $this->assign('account_advertiser', $account_advertiser);
        }
        
        // 客户经理
        if ($info->role_id == 12) {
            $account_advertiser = $this->selectAdvertiseUser($uid);
            $this->assign('account_advertiser', $account_advertiser);
        }
        if ($info->role_id == 13) {
            $this->assign('account_advertiser', $info);
        }
        $this->assign("select_role_id", $role_id);
        $this->assign("select_uid", $uid);
        $this->assign("_GET", $_GET);
        return $this->render("v2/dc/dcUser.html");
    }

    public function pageMedia($inPath)
    {
        $start = empty($_REQUEST['start']) ? date("Y-m-d", time() - 30 * 24 * 3600) : date("Y-m-d", strtotime($_REQUEST['start']));
        $end = empty($_REQUEST['end']) ? date("Y-m-d", time()) : date("Y-m-d", strtotime($_REQUEST['end']));
        $status = 0;
        $uid = 0;
        $type = empty($_REQUEST['type']) ? "all" : $_REQUEST['type'];
        $position_id = $_GET['position_identification'];//广告位id
        $channel_id  = $_GET['channel_id'];//频道id

        $source_id = $_GET['source_id'];//
        $_users = array();
        $_plans = array();
        $_groups = array();
        $patchName = "";
        $patchId = 0;
        $info = user_api::info();
//        if (! user_api::auth('admin')) {
//            $uid = user_api::id();
//            if ($info->role_id == "1000") {
//                $uid = 0;
//            }
//        }
        
        if (! empty($_REQUEST['uid'])) {
            if (user_api::auth("admin") || $info->role_id == "1000") {
                $uid = $_REQUEST['uid'];
            } else {
                $uid = user_api::id();
            }
        }else{
            $uid = 0;
        }
        // 获取用户的广告计划
        $_plans = dc_db::listPlans(array(
            "uid" => $uid
        ));
        if (! empty($_REQUEST['plan_id'])) {
            $plan_id = $_REQUEST['plan_id'];
            // 获取用户的广告计划
            $_groups = dc_db::listGroups(array(
                "plan_id" => $plan_id
            ));
        } else {
            $_REQUEST['group_id'] = 0;
        }
        
        if (! empty($_REQUEST['group_id'])) {
            $group_id = $_REQUEST['group_id'];
            // 获取用户的广告计划
            $_ads = dc_db::listAds(array(
                "group_id" => $group_id
            ));
        } else {
            $_REQUEST['group_id'] = 0;
        }
        
        if (! empty($_REQUEST['status'])) {
            $status = $_REQUEST['status'];
        }
        // 选择了广告位的情况
        if (! empty($position_id)) {
            $adspace = $position_id;
            // 获取对应广告组的
            if ($type == "all") {
                $r = dc_api::AdspaceByPosid($adspace, $start, $end);
                 $patchName = "plan";
                //$patchId = $group_id;
            } elseif ($type == "day") {
                //$r = dc_api::AdspaceByPosid($adspace, $start, $end);
                $r = dc_api::DayByMediaid($adspace, $start, $end);
                $patchName = "day";
            } elseif ($type == "account") {
                $r = dc_api::AdspaceByPosid($adspace, $start, $end);
                $patchName = "ta";
            } elseif ($type == "week") {
                $r = dc_api::DayByAdspace($adspace, $start, $end);
                $r = $this->day2week($r, $start);
                $patchName = "week";
            } elseif ($type == "plan") {
                $r = dc_api::AdspaceByPosid($adspace, $start, $end);
               // $r = dc_api::AdspaceByPid($plan_id, $start, $end);
                //$patchName = "ta";
                $patchName = "plan";
            } elseif ($type == "stuff") {
                $r = dc_api::PosByAdid($adspace, $start, $end);
                $patchName = "stuff";
            }
        }elseif (!empty($channel_id)) {  // 选择了频道的情况
            $channel_id = (int)$channel_id;
            // 获取对应广告组的
             if ($type == "all") {
                $r = dc_api::AdspaceByChannelid($channel_id, $start, $end);
               // var_dump($r);
                $patchName = "position";
               // $patchId = $group_id;
            } elseif ($type == "day") {
                //$r = dc_api::AdspaceByChannelid($channel_id, $start, $end);
                $r = dc_api::DayByMediaid($channel_id, $start, $end);
                $patchName = "day";
            } elseif ($type == "account") {
                $r = dc_api::AdspaceByChannelid($channel_id, $start, $end);
                $patchName = "ta";
            } elseif ($type == "week") {
                $r = dc_api::DayByChannelid($channel_id, $start, $end);
                $r = $this->day2week($r, $start);
                $patchName = "week";
            } elseif ($type == "plan") {
                $r = dc_api::AdspaceByChannelid($channel_id, $start, $end);
                //var_dump($r);
                $patchName = "plan";
            } elseif ($type == "stuff") {
                $r = dc_api::ChannelByAdid($channel_id, $start, $end);
                $patchName = "stuff";
            }
        }elseif (! empty($source_id)) {  // 选择了媒体的情况
            $source_id = (int)$source_id;
            // 获取对应广告组的
            if ($type == "all") {
                $r = dc_api::AdspaceByMediaid($source_id, $start, $end);
               // var_dump($r);
                 $patchName = "channel";
               // $patchId = $group_id;
            } elseif ($type == "day") {
                //$r = dc_api::AdspaceByMediaid($source_id, $start, $end);
                $r = dc_api::DayByMediaid($source_id, $start, $end);
                $patchName = "day";
            } elseif ($type == "account") {
                /*$r = dc_api::AdspaceByMediaid($source_id, $start, $end);
                $patchName = "ta";*/
                $r = dc_api::AdspaceByUid($uid = 0, $start, $end);
                $patchName = "user";
            } elseif ($type == "week") {
                $r = dc_api::DayByMediaid($source_id, $start, $end);
                $r = $this->day2week($r, $start);
                $patchName = "week";
            } elseif ($type == "plan") {
                $r = dc_api::AdspaceByMediaid($source_id, $start, $end);
                $patchName = "plan";
            } elseif ($type == "stuff") {
                //$r = dc_api::AdspaceByMediaid($source_id, $start, $end);
                $r = dc_api::MediaByAdid($source_id, $start, $end);
                $patchName = "stuff";
            }
        }else { // 没有选择广告位的情况
            // 获取对应用户下的所有广告计划数据
            if ($type == "all") {
                if (! empty($uid)) {
                    $r = dc_api::PlanReportByUid($uid, $start, $end);
                    $patchName = "plan";
                    $patchId = $uid;
                } else {
                    $r = dc_api::CostsByUidV2($uid = 0, $start, $end);
                    $patchName = "user";
                }
            } elseif ($type == "day") {
                $r = dc_api::AdspaceByPosid($adspace, $start, $end);
                $patchName = "day";
                if (!empty($uid)) {
                    $r = dc_api::PlanReportByUid($uid, $start, $end);
                    $patchName = "plan";
                    //$patchId = $uid;
                } else {
                   // $r = dc_api::CostsByUidV2($uid = 0, $start, $end);
                    $r = dc_api::DayByUid($uid, $start, $end);
                    $patchName = "day";
                }
                
            } elseif ($type == "hour") {
                $r = dc_api::AdspaceByPosid($adspace, $start, $end);
                $patchName = "hour";
            } elseif ($type == "ta") {
                $r = dc_api::AdspaceByPosid($adspace, $start, $end);
                $patchName = "ta";
            } elseif ($type == "week") {
                $r = dc_api::DayByUid($uid, $start, $end);
                $r = $this->day2week($r, $start);
                $patchName = "week";
            } elseif ($type == "account") {
                 $r = dc_api::CostsByUidV2($uid = 0, $start, $end);
                 $patchName = "user";
            } elseif ($type == "plan") {
               $r = dc_api::PlanReportByUid($uid, $start, $end);
               $patchName = "plan";
            } elseif ($type == "stuff") {
                $r = dc_api::AdSpaceByAdid(0, $start, $end);
                if($_GET['debug']){
                 var_dump($r);
                 }
                $patchName = "stuff";
            }
        }
        $condition = array();
        $this->userInfoModel = new model_userInfo();
        if($info->role_id == 1000 || $info->role_id == 10000){  //系统管理员
            if(isset($_REQUEST['account_type']) && $_REQUEST['account_type'] >0){
                if($_REQUEST['account_type'] ==18){ //子运营
                    if($_REQUEST['account_provider'] >0 && $_REQUEST['account_manager'] ==0){
                        $condition['creator_id'] = $_REQUEST['account_provider'];
                        $condition['role_id'] = 12;
                        $managerUsers = $this->userInfoModel->getData($condition,0,-1);
                        $uid_list = array_column($managerUsers,"uid");
                    }elseif($_REQUEST['account_provider']>0 && $_REQUEST['account_manager']>0){
                        $uid_list = array($_REQUEST['account_manager']); //查找客户经理
                    }
                    $item = array();
                    if(count($uid_list) > 1){
                        $uid_string = implode(",",$uid_list);
                        $item = " AND creator_id IN ($uid_string) AND role_id =13";
                    }else{
                        $item['role_id'] =13;
                        $item['creator_id'] =$uid_list[0];
                    }
                    $adUsers = $this->userInfoModel->getData($item,0,-1);

                }elseif($_REQUEST['account_type'] ==12){  //客户经理
                    if($_REQUEST['account_manager'] ==0){
                        $condition['role_id'] = 12;
                        $managerUsers = $this->userInfoModel->getData($condition,0,-1);
                        $uid_list = array_column($managerUsers,"uid");
                    }elseif($_REQUEST['account_manager']>0){
                        $uid_list = array($_REQUEST['account_manager']); //查找客户经理
                    }
                    $item = array();
                    if(count($uid_list) > 1){
                        $uid_string = implode(",",$uid_list);
                        $item = " AND creator_id IN ($uid_string) AND role_id =13";
                    }else{
                        $item['role_id'] =13;
                        $item['creator_id'] =$uid_list[0];
                    }
                    $adUsers = $this->userInfoModel->getData($item,0,-1);

                }elseif($_REQUEST['account_type'] ==13){ //广告商
                    if($_REQUEST['uid'] >0){
                        $condition['uid'] = $_REQUEST['uid'];
                    }
                    $adUsers = $this->userInfoModel->getData($condition,0,-1);
                }

            }else{
                $condition['role_id'] =13;
                $adUsers = $this->userInfoModel->getData($condition,0,-1);
            }

        }elseif($info->role_id ==18){  //子运营商
            if($_REQUEST['account_type'] ==12 && $_REQUEST['account_manager'] >0){ //客户经理
                $condition['creator_id'] = $_REQUEST['account_manager'];
                $condition['role_id'] = 13;
                $adUsers = $this->userInfoModel->getData($condition,0,-1);
            }elseif($_REQUEST['account_type'] ==13 && $_REQUEST['uid'] >0){
                $condition['uid'] = $_REQUEST['uid'];
                $condition['role_id'] = 13;
                $adUsers = $this->userInfoModel->getData($condition,0,-1);
            }else{
                $condition['creator_id'] = $info->uid;
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
                $adUsers = $this->userInfoModel->getData($item,0,-1);
            }
        }elseif($info->role_id ==12){ //客户经理
            if($_REQUEST['account_type'] ==13 && $_REQUEST['uid']>0){
                $condition['uid'] = $_REQUEST['uid'];
            }else{
                $condition['creator_id'] = $info->uid;
                $condition['role_id'] = 13;
            }
            $adUsers = $this->userInfoModel->getData($condition,0,-1);
        }else{ //广告主
            $condition['uid'] = $info->uid;
            $adUsers = $this->userInfoModel->getData($condition,0,-1);
        }

        $uid_list = array_column($adUsers,"uid");
        $uid_data = $r->data;
        foreach($uid_data as $data){
            if(in_array($data->uid,$uid_list)){
                $result_data[] = $data;
            }
        }
        $r->totalSize = count($result_data);
        $r->currentSize = count($result_data);
        $r->totalPage = intval(ceil(count($result_data)/20));
        $r->pageNumber = 1;
        $r->data = $result_data;

        $r1 = new reportResult();
        $r = $this->patchName($r, $patchName, $patchId);
        $sort_order = 0;
        if (empty($_REQUEST['index_id'])) {
            $index_id = "pv";
        } else {
            $index_id = $_REQUEST['index_id'];
        }
        if (empty($_REQUEST['sort_id'])) {
            $sort_id = "pv";
        } else {
            $sort_id = $_REQUEST['sort_id'];
        }
        foreach ($r->data as $k => $v) {
            /*$r->data[$k]->pc = 10;
            $r->data[$k]->uv = 10;
            $r->data[$k]->uc = 10;
            $r->data[$k]->ipv = 10;
            $r->data[$k]->ipc = 10;*/
            $r->data[$k]->name = $r->data[$k]->name;
            $tmp = (array) $v;
            $id[] = $tmp[$sort_id];
        }
        if ($_REQUEST['sort_order'] == 1) {
            $sort_order = 1;
        }
        if($type!="week" && $type!="day"){
            array_multisort($id, SORT_DESC, $r->data);
        }
        $adminFlag = false;
//        if (user_api::auth("admin") || $info->role_id == "1000") {
        if (user_api::auth("admin") || in_array($info->role_id,array("1000","18"))) {
            $_users = dc_db::listUsers(array());
            $adminFlag = true;
        } else {
            $_users = dc_db::listUsers(array(
                "uid" => user_api::id()
            ));
            $adminFlag = true;
        }
        $data = array();
        $isPie = false;
        switch ($type) {
            case "all":
            case "day":
            case "hour":
            case "week":
                $data_json = $this->data2bar($r);
                break;
            case "ta":
                $data_json = $this->data2bar($r, 0, 1);
                break;
            case "area":
                $data_json = $this->dataArea2pie($r, 10, $_REQUEST['index_id']);
                $isPie = true;
                break;
            case "account":
                $data_json = $this->data2pie($r);
                $isPie = true;
                break;
            case "plan":
                $data_json = $this->data2pie($r);
                $isPie = true;
                break;
            case "stuff":
                $data_json = $this->data2pie($r);
                $isPie = true;
                break;
            case "media":
                $data_json = $this->data2pie($r, 10);
                $isPie = true;
                break;
        }
        if ($_REQUEST['sort_order'] == 1) {
            array_multisort($id, SORT_ASC, $r->data);
        }
        if (empty($_REQUEST['uid']) && $info->role_id == "1000") {
            $uid = "";
        }
        if (empty($_REQUEST['sort_id'])) {
            $sort_id = "pv";
        } else {
            $sort_id = $_REQUEST['sort_id'];
        }
        //$ms = media_db::listMedia($condi,$page);
        $mediaModel = new model_rmcbjMedia();
        $ms = $mediaModel->getData();
        $this->assign("month", $_REQUEST[month] ? $_REQUEST[month] : 0);
        $this->assign("week", $_REQUEST[week] ? $_REQUEST[week] : 0);
        $this->assign("sortf_id", $sort_id);
        $this->assign("sort_order", $sort_order);
        $this->assign("index_id", $index_id);
        $this->assign("isPie", $isPie);
        $this->assign("r", $r);
        $this->assign("data_json", $data_json); // $this->data2bar($data));
        $this->assign("start", $start);
        $this->assign("end", $end);
        $this->assign("type", $type);
        $this->assign("uid", $uid);
        $this->assign("plan_id", $plan_id);
        $this->assign("group_id", $group_id);
        $this->assign("patchName", $patchName);
        $this->assign("_users", @$_users->items);
        $this->assign("_plans", @$_plans->items);
        $this->assign("_groups", @$_groups->items);
        $this->assign("_ads", @$_ads->items);
        $this->assign("adminFlag", $adminFlag);
        $this->assign("ms", $ms);
        $info = user_api::info();
        /**
         * 前端切换url方式时候缺少加入,position_identification的拼接，前端代码很乱，一时没看懂，在后端快速解决回传上次选中的广告位;
         */
//        if($_GET['position_identification']){
//            $_SESSION['position_identification']=$_GET['position_identification'];
//        }
        $this->assign('info', $info);
        $role_id = isset($_GET['role_id']) ? $_GET['role_id'] : 0;
        $uid = isset($_GET['uid']) ? $_GET['uid'] : 0;
        $this->assign('selectUser', $selectUser);
        $this->assign("select_role_id", $role_id);
        $this->assign("select_uid", $uid);
        //回传给页面用于选中广告位
//        $_GET['position_identification']= $_SESSION['position_identification'];
        $_GET['position_identification']= $position_id;
        $this->assign("_GET", $_GET);
        return $this->render("v2/dc/dcMedia.html");
    }

    private function patchName($r, $name, $id = 0)
    {
        if ($name == "user") {
            $_users = dc_db::listUsers(array());
            foreach ($r->data as &$data) {
                foreach ($_users->items as $item) {
                    if ($data->id == $item['uid']) {
                        $data->name = $item['user_name'];
                        break;
                    }
                }
            }
        } elseif ($name == "plan") {
            $plans = dc_db::listPlans(array(
                "uid" => $id
            ));
            foreach ($r->data as &$data) {
                foreach ($plans->items as $item) {
                    if ($data->id == $item['plan_id']) {
                        $data->name = $item['plan_name'];
                        break;
                    }
                }
            }
        } elseif ($name == "group") {
            $groups = dc_db::listGroups(array(
                "plan_id" => $id
            ));
            foreach ($r->data as &$data) {
                foreach ($groups->items as $item) {
                    if ($data->id == $item['group_id']) {
                        $data->name = $item['group_name'];
                        break;
                    }
                }
            }
        } elseif ($name == "ad") {
            $ads = dc_db::listAds(array(
                "group_id" => $id
            ));
            foreach ($r->data as &$data) {
                foreach ($ads->items as $item) {
                    if ($data->id == $item['adid']) {
                        $data->name = $item['adname'];
                        break;
                    }
                }
            }
        } elseif ($name == "day") {
            $ads = dc_db::listAds(array(
                "group_id" => $id
            ));
            foreach ($r->data as &$data) {
                $data->id = date("Y-m-d", strtotime($data->id));
                $data->name = date("Y-m-d", strtotime($data->id));
            }
        } elseif ($name == "week") {
            $ads = dc_db::listAds(array(
                "group_id" => $id
            ));
            foreach ($r->data as &$data) {
                // $data->id=date("Y-m-d",strtotime($data->id));
                $data->name = $this->week_note[$data->id];
            }
        } elseif ($name == "hour") {
            $ads = dc_db::listAds(array(
                "group_id" => $id
            ));
            foreach ($r->data as &$data) {
                $data->id = str_pad($data->id, 2, "0", STR_PAD_LEFT) . ":00";
                $data->name = str_pad($data->id, 2, "0", STR_PAD_LEFT) . ":00";
            }
        } elseif ($name == "area") {
            $areas = rmc_db::listOriArea();
            foreach ($r->data as $key => &$data) {
                foreach ($areas->items as $item) {
                    if ($data->id == $item['id']) {
                        $data->name = $item['area_name'];
                        break;
                    }
                }
                if (empty($data->name) || $data->name == "默认地域") {
                    $r->data[10000]->name = "其他";
                    $r->data[10000]->id = "其他";
                    $r->data[10000]->push += $data->push;
                    $r->data[10000]->show += $data->show;
                    $r->data[10000]->pv += $data->pv;
                    $r->data[10000]->pc += $data->pc;
                    $r->data[10000]->uv += $data->uv;
                    $r->data[10000]->uc += $data->uc;
                    $r->data[10000]->ipv += $data->ipv;
                    $r->data[10000]->ipc += $data->ipc;
                    $r->data[10000]->click += $data->click;
                    $r->data[10000]->cost += $data->cost;
                    $r->data[10000]->bid += $data->bid;
                    $r->data[10000]->bidres += $data->bidres;
                    unset($r->data[$key]);
                }
            }
        } elseif ($name == "ta") {
//            $config = SConfig::getConfigArray(ROOT_CONFIG . "/config.php", 'ta');
            $position_thrift = new thrift_admedia_main;
            $positions= $position_thrift->getAllPo();
            $result = array();
            foreach($positions as $key=>$value){
                $result[$value->position_identification][] = $value;
            }
            foreach ($r->data as $key => &$data) {
//                if (strstr($data->id, "mm") || strstr($data->id, "ads")) {
//                    unset($r->data[$key]);
//                    continue;
//                }
//                $ta = $config[$data->id];
//                $data->name = $ta[pos] . "[" . $ta[style] . "]";
//                $data->id = $data->name;
                $ta = $result[$data->adspace][0];
                $data->name = $ta->position_name;
                $data->id = $data->name;
            }
        } elseif($name=="stuff"){
            //查询广告素材信息
            $adInfo = new model_adInfo();
            $ads  = $adInfo->getData();
            $userModel = new model_userInfo();
            $users = $userModel->getData();
            $planModel = new model_planInfo();
            $plans = $planModel->getData();
            $position_thrift = new thrift_admedia_main;
            $positions= $position_thrift->getAllPo();
            $channels = $position_thrift->getAllChannel();
            $medias =  $position_thrift->getAllMedia();
            //找出媒体名称，素材名称
            foreach ($r->data as &$data) {
                foreach ($ads as $ad) {
                    if ($data->id == $ad['adid']) {
                        $data->name = $ad['adname'];
                        $data->id = $ad['adname'];
                        $data->media_name = $ad['media_name'];
                        $data->plan_id = $ad['plan_id'];
                        break;
                    }
                }
            }
            //找出广告主id
            foreach ($r->data as &$data) {
                foreach ($plans as $plan) {
                    if ($data->plan_id == $plan['plan_id']) {
                        $data->bind_id = $plan['bind_id'];
                        if($plan['billing_type']==2){
                             $data->billing_type = "cpm";
                        } else{
                            $data->billing_type = "cpt";
                        }
                        break;
                    }
                }
            }
            //找出广告拥有者名字
            foreach ($r->data as &$data) {
                foreach ($users as $user) {
                    if ($data->bind_id == $user['uid']) {
                        $data->user_name = $user['user_name'];
                        break;
                    }
                }
            }
            //找出广告位名字
            foreach ($r->data as &$data) {
                foreach ($positions as $position) {
                    if ($data->adspace == $position->position_identification) {
                        $data->position_name = $position->position_name;
                        $data->price = "cpm价格：".$position->cpm.";"."cpt价格:".$position->cpt;
                        $data->channel_id = $position->channel_id;
                        break;
                    }
                }
            }
            //找出频道名字
            foreach ($r->data as &$data) {
                foreach ($channels as $channel) {
                    if ($data->channel_id == $channel->channel_id) {
                        $data->channel_name = $channel->channel_name;
                        $data->media_id = $channel->media_id;
                        break;
                    }
                }
            }
            //找出媒体名字
            foreach ($r->data as &$data) {
                foreach ($medias as $media) {
                    if ($data->media_id == $media->id) {
                        $data->media_name = $media->media_name;
                        break;
                    }
                }
            }
            
        }elseif($name=="media"){
            //查询媒体信息
            $media_thrift = new thrift_admedia_main;
            $medias= $media_thrift->getAllMedia();//所有媒体详细信息
            foreach ($r->data as &$data) {
                foreach ($medias as $media) {
                    if ($data->id == $media->id) {
                        $data->name = $media->media_name;
                        $data->id = $media->id;
                        break;
                    }
                }
            }
        }elseif($name=="channel"){
            //查询媒体信息
            $media_thrift = new thrift_admedia_main;
            $medias= $media_thrift->getAllChannel();//所有媒体详细信息
            foreach ($r->data as &$data) {
                foreach ($medias as $media) {
                    if ($data->id == $media->channel_id) {
                        $data->name = $media->channel_name;
                        $data->id = $media->channel_id;
                        break;
                    }
                }
            }
        } elseif($name=="position"){
            $media_thrift = new thrift_admedia_main;
            $medias= $media_thrift->getAllPo();
          //  var_dump($medias);
             foreach ($r->data as &$data) {
                foreach ($medias as $media) {
                    if ($data->id == $media->position_identification) {
                        $data->name = $media->position_name;
                        $data->id = $media->position_identification;
                        break;
                    }
                }
            }
        }
        
        else {
            foreach ($r->data as &$data) {
                $data->name = $data->id;
            }
        }
        return $r;
    }

    private function data2bar($r, $count = 0, $flag = 0)
    {
        $data = array();
        $ct = 0;
        $data_json = array();
        if (! empty($r->data)) {
            foreach ($r->data as $item) {
                if ($count > 0 && $ct ++ >= $count)
                    break;
                foreach ($item as $k => $v) {
                    if ($k == "show" && is_numeric($v)) {
                        $v = $v / 1000;
                    }
                    if ($k == "pv" && is_numeric($v)) {
                        $v = $v / 1000;
                    }
                    if ($k == "uv" && is_numeric($v)) {
                        $v = $v / 1000;
                    }
                    if ($k == "ipv" && is_numeric($v)) {
                        $v = $v / 1000;
                    }
                    if (is_numeric($v)) {
                        $data[$k][] = floatval($v);
                    } else {
                        $data[$k][] = $v;
                    }
                }
            }
        }
        if ($flag) {
            $data['name'] = $data['id'];
        }
        foreach ($data as $k => $v) {
            $data_json[$k] = SJson::encode($v);
        }
        return $data_json;
    }

    private function data2pie($r, $count = 0)
    {
        $data = array();
        $data_json = array();
        $data_json['title'] = array();
        $data_json['data'] = array();
        $ct = 0;
        if (! empty($r->data)) {
            foreach ($r->data as $item) {
                if ($count > 0 && $ct ++ >= $count)
                    break;
                $data_json['title'][] = '"' . $item->id . '"';
                foreach ($item as $k => $v) {
                    if ($k == "show" && is_numeric($v)) {
//                        $id = $item->id;
                        $id = $item->name;
                        $data_json['data'][] = "{value:" . $v . ", name:'" . $id . "'}";
                    }
                }
            }
            $data_json['data'] = implode(",", $data_json['data']);
            $data_json['title'] = implode(",", $data_json['title']);
        }
        return $data_json;
    }

    private function dataArea2pie($r, $count = 0, $key = "pv")
    {
        $data = array();
        $data_json = array();
        $data_json['title'] = array();
        $data_json['data'] = array();
        $ct = 0;
        if (! empty($r->data)) {
            foreach ($r->data as $item) {
                if ($count > 0 && $ct ++ >= $count)
                    break;
                    // $name = rmc_db::GetAreaNameById($item->id);
                $name = $item->name;
                $data_json['title'][] = '"' . $name . '"';
                foreach ($item as $k => $v) {
                    if ($k == $key && is_numeric($v)) {
                        $id = $item->id;
                        $data_json['data'][] = "{value:" . $v . ", name:'" . $name . "'}";
                    }
                }
            }
            $data_json['data'] = implode(",", $data_json['data']);
            $data_json['title'] = implode(",", $data_json['title']);
        }
        return $data_json;
    }

    private function data2map($data)
    {}

    private function day2week($r, $start, $end)
    {
        // split the time [$start,$end] by week
        $arr = $this->get_time_arr($start, $end, "week");
        $cnt = count($arr);
        foreach ($arr as $key => $a) {
            $this->week_note[$key] = "第" . ($key + 1) . "周[" . date('m-d', $a[0]) . "," . date('m-d', $a[1]) . "]";
        }
        $r1 = new reportResult();
        for ($i = 0; $i < $cnt; $i ++) {
            $res = new Response();
            $res->id = $i;
            $res->push = 0;
            $res->show = 0;
            $res->click = 0;
            $res->cost = 0;
            $res->bid = 0;
            $res->bidres = 0;
            $res->pv = 0;
            $res->pc = 0;
            $res->uv = 0;
            $res->uc = 0;
            $res->ipv = 0;
            $res->ipc = 0;
            $res->uid = 0;
            $r1->data[] = $res;
        }
        foreach ($r->data as $item) {
            $curStart = strtotime($item->id);
            foreach ($arr as $key => $a) {
                if ($curStart >= $a[0] && $curStart <= $a[1]) {
                    $r1->data[$key]->push += $item->push;
                    $r1->data[$key]->show += $item->show;
                    $r1->data[$key]->click += $item->click;
                    $r1->data[$key]->cost += $item->cost;
                    $r1->data[$key]->bid += $item->bid;
                    $r1->data[$key]->bidres += $item->bidres;
                    $r1->data[$key]->pv += $item->pv;
                    $r1->data[$key]->pc += $item->pc;
                    $r1->data[$key]->uv += $item->uv;
                    $r1->data[$key]->uc += $item->uc;
                    $r1->data[$key]->ipv += $item->ipv;
                    $r1->data[$key]->ipc += $item->ipc;
                    $r1->data[$key]->uid = $item->uid;
                    break;
                }
            }
        }
        return $r1;
    }

    private function get_time_arr($s, $e, $m_or_w)
    {
        $arr = array();
        $start = strtotime($s . " 00:00:00");
        $end = strtotime($e . " 23:59:59");
        if ($m_or_w == 'week') {
            $s_w = date('w', $start);
            $f_w = 8 - $s_w;
        } else {
            $allday = date('t', $start);
            $today = date('d', $start);
            $f_w = $allday - $today + 1;
        }
        if ($f_w) {
            $f_end = $start + 86400 * $f_w - 1;
        } else {
            $f_end = $start + 86400 - 1;
        }
        $new_end = $f_end;
        if ($end < $new_end) {
            $arr[] = array(
                $start,
                $end
            );
            return $arr;
        }
        while ($end > $new_end) {
            $arr[] = array(
                $start,
                $new_end
            );
            $start = $new_end + 1;
            if ($m_or_w == 'week') {
                $day = 7;
            } else {
                $day = date('t', $new_end + 10);
            }
            $new_end = $new_end + $day * 86400;
        }
        if ($m_or_w == 'week') {
            $fullday = 7;
        } else {
            $fullday = date('t', $new_end);
        }
        $arr[] = array(
            $new_end - $fullday * 86400 + 1,
            $end
        );
        return $arr;
    }

    /**
     * *
     * 用于广告报表子运营商账户筛选
     */
    public function selectOpUser()
    {
        $admin = 0;
        $users = array();
        if (true) {
            $admin = 1;
            $user_model = new model_userInfo();
            $condition = array();
            $condition['role_id'] = 18;
            $info = user_api::info();
            $users = $user_model->getData($condition, 0, - 1);
        } else {
            // $users = $a->getAdUsersByCid(user_api::id(),$status);
        }
        $users = json_encode($users);
        $users = json_decode($users);
        return $users;
    }

    /**
     * *
     * 客户经理筛选
     */
     public function selectMangerUser($uid)
    {
        $users = array();
        if (true) {
            $user_model = new model_userInfo();
            $condition = array();
            $info = user_api::info();
            if (! empty($uid)) {
                $condition['creator_id'] = $uid;
            } else {
                return array();
            }
            $condition['creator_id'] = $uid;
            $condition['role_id'] = 12;
            $users = $user_model->getData($condition, 0, - 1);
        } else {
            // $users = $a->getAdUsersByCid(user_api::id(),$status);
        }
        $users = json_encode($users);
        $users = json_decode($users);
        return $users;
    }

    /**
     * 广告主的筛选
     */
    public function selectAdvertiseUser($uid)
    {
        $users = array();
        if (true) {
            $user_model = new model_userInfo();
            $condition = array();
            $info = user_api::info();
            if (! empty($uid)) {
                $condition['creator_id'] = $uid;
            } else {
                return array();
            }
            $condition['creator_id'] = $uid;
            $condition['role_id'] = 13;
            $users = $user_model->getData($condition, 0, - 1);
        } else {
            // $users = $a->getAdUsersByCid(user_api::id(),$status);
        }
        $users = json_encode($users);
        $users = json_decode($users);
        return $users;
    }

    /**
     * *
     * 根据账户筛选获取第一级用户的数据
     */
    public function getUserByType()
    {
        $info = user_api::info();
        $condition = array();
        
        if (isset($_GET['role_id']) && isset($_GET['role_id']) > 0) {
            $condition["role_id"] = $_GET['role_id'];
        }
        if ($info) {
            $condition['creator_id'] = $info->uid;
        } else {
            return false;
        }
        $user_model = new model_userInfo();
        $users = $user_model->getData($condition, 0, - 1);
        if ($users) {}
    }
    // 对象转化成数组
    private function object2array(&$object)
    {
        $object = json_decode(json_encode($object), true);
        return $object;
    }

    /**
     * 根据uid获取plan
     */
    public function pageGetPlan()
    {
        $plans = array();
        if (isset($_GET['uid']) && $_GET['uid'] > 0) {
            $condition = array();
            $condition['bind_id'] = $_GET['uid'];
            $model_planInfo = new model_planInfo();
            $plans = $model_planInfo->getData($condition, 0, - 1);
             
        } else {
            $condition = array();
            $model_planInfo = new model_planInfo();
            $plans = $model_planInfo->getData($condition, 0, - 1);
        }
        echo json_encode($plans);
    }

    /**
     * 查询所有广告主
     */
    public function pageGetAdevertiser()
    {
        $userModel = new model_userInfo();
        $condition = array();
        $condition['role_id'] = 13;
        $userInfo = $userModel->getData($condition, 0, - 1);
        if (is_array($userInfo) && ! empty($userInfo)) {
            foreach ($userInfo as $k => $v) {
                unset($userInfo[$k]['passwd']);
            }
        }
        echo json_encode($userInfo);
    }
    /**
     * 导出满足北京客户的报表
     */
    public  function  getExcel()
    {
        
    }
}
