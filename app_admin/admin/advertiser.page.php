<?php

class admin_advertiser extends STpl
{

    public $userInfoModel, $planInfoModel, $adInfoModel, $stuffInfoModel;

    public function __construct($inPath)
    {
        if (! user_api::auth("admin")) {
            die("权限拒绝");
        }
        $this->init();
    }

    public function init()
    {
        $this->userInfoModel = new model_userInfo();
        $this->planInfoModel = new model_planInfo();
        $this->adInfoModel = new model_adInfo();
        $this->stuffInfoModel = new model_stuffInfo();
    }

    public function pageSearch()
    {
        $condition = array();
        $result = array();
        if (isset($_GET['key'])) {
            if (isset($_GET['keyType']) && $_GET['keyType'] === 'stuff') {
                $condition['stuff_id'] = $_GET['key'];
                $list = $this->stuffInfoModel->getData($condition, 0, 30);
                if (is_array($list[0])) {
                    $result['stuff'] = $list[0];
                    $condition = array();
                    $condition['adid'] = $list[0]['adid'];
                    $list = $this->adInfoModel->getData($condition, 0, 30);
                    if (is_array($list[0])) {
                        $result['ad'] = $list[0];
                    }
                }
            } else {
                $condition['adid'] = $_GET['key'];
                $list = $this->adInfoModel->getData($condition, 0, 30);
                if (is_array($list[0])) {
                    $result['ad'] = $list[0];
                }
            }
        }
        $this->assign('result', $result);
        return $this->render("admin/ad_search.html");
    }

    public function pageList()
    {
        $condition = array();
        $like = array();
        if (isset($_GET['key'])) {
            if (isset($_GET['keyType']) && $_GET['keyType'] === 'company') {
                $like['host'] = "%" . $_GET['key'] . "%";
            } else {
                $like['user_name'] = "%" . $_GET['key'] . "%";
            }
        }
        if (isset($_GET['role']) && $_GET['role'] >0) {
            $condition['role_id'] = $_GET['role'];
        }
        if (count($like) > 0) {
            $list = $this->userInfoModel->getDataLike($condition, $like, 0, - 1);
        } else {
            $list = $this->userInfoModel->getData($condition, 0, - 1);
        }
        foreach ($list as $k => $v) {
            $uids[] = $v['uid'];
        }
        $uids = array_unique($uids);
        $adStat = $this->planInfoModel->getStat();
        $adList = array();
        $summary = array();
        $summary['total'] = 0;
        $summary['verify_1'] = 0;
        $summary['verify_2'] = 0;
        $summary['verify_3'] = 0;
        $summary['enable_1'] = 0;
        $summary['enable_2'] = 0;
        $summary['enable_3'] = 0;
        $summary['enable_4'] = 0;
        $summary['enable_5'] = 0;
        $summary['enable_6'] = 0;
        foreach ($adStat as $temp) {
            if (in_array($temp['uid'], $uids)) {
                if (! isset($adList[$temp['uid']])) {
                    $adList[$temp['uid']]['total'] = 0;
                    $adList[$temp['uid']]['verify_1'] = 0;
                    $adList[$temp['uid']]['verify_2'] = 0;
                    $adList[$temp['uid']]['verify_3'] = 0;
                    $adList[$temp['uid']]['enable_1'] = 0;
                    $adList[$temp['uid']]['enable_2'] = 0;
                    $adList[$temp['uid']]['enable_3'] = 0;
                    $adList[$temp['uid']]['enable_4'] = 0;
                    $adList[$temp['uid']]['enable_5'] = 0;
                    $adList[$temp['uid']]['enable_6'] = 0;
                }
                $verifyIndex = 'verify_' . $temp['verified_or_not'];
                $enableIndex = 'enable_' . $temp['enable'];
                
                $adList[$temp['uid']]['total'] += $temp['count'];
                $adList[$temp['uid']]['total_cpt'] += $temp['total_cpt']*$temp['count'];
                $adList[$temp['uid']][$verifyIndex] += $temp['count'];
                $adList[$temp['uid']][$enableIndex] += $temp['count'];
                
                $summary['total'] += $temp['count'];
                $summary['total_cpt'] += $temp['total_cpt']*$temp['count'];
                $summary[$verifyIndex] += $temp['count'];
                $summary[$enableIndex] += $temp['count'];
            }
        }
        if (isset($_GET['planStatus'])) {
            foreach ($list as $index => $value) {
                if (! isset($adList[$value['uid']]) || $adList[$value['uid']]['enable_' . $_GET['planStatus']] == 0) {
                    unset($list[$index]);
                }
            }
        }
        if (isset($_GET['planVerify'])) {
            foreach ($list as $index => $value) {
                if (! isset($adList[$value['uid']]) || $adList[$value['uid']]['verify_' . $_GET['planVerify']] == 0) {
                    unset($list[$index]);
                }
            }
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
        $roles = $roleList;
        foreach ($adList as $k=>$v){
            $tempUids[] = $k;
        }
        foreach ($list  as $k2=>$v2){
            if(!in_array($v2['uid'],$tempUids)){
                $adList[$v2['uid']]['total'] = 0;
                $adList[$v2['uid']]['verify_1'] = 0;
                $adList[$v2['uid']]['verify_2'] = 0;
                $adList[$v2['uid']]['verify_3'] = 0;
                $adList[$v2['uid']]['enable_1'] = 0;
                $adList[$v2['uid']]['enable_2'] = 0;
                $adList[$v2['uid']]['enable_3'] = 0;
                $adList[$v2['uid']]['enable_4'] = 0;
                $adList[$v2['uid']]['enable_5'] = 0;
                $adList[$v2['uid']]['enable_6'] = 0;
                $adList[$v2['uid']]['verify_0'] = 0;
            }
        }
        $planBillModel = new model_planbilling();
        $billData = $planBillModel->getData(array(), 0, - 1,"ctime",1);

        foreach($list as $key=>$value){
            foreach($billData as $bill){
                if($value['uid'] ==$bill['uid']){
                    $value['cpm_show_num'] = $bill['page_show_num'];
                }else{
                    $value['cpm_show_num'] = 0;
                }
            }
           $all_list[] = $value;
        }
        $list = $all_list;
        foreach($list as $cpm){
            $sum[] = $cpm['cpm_show_num'];
        }
        $sum_cpm = array_sum($sum);
        $currentUser = user_api::info();
        $this->assign("currentUser", $currentUser);
        $this->assign("roles", $roles);
        $this->assign("roleList", $roleList);
        $this->assign("list", $list);
        $this->assign("sum_cpm", $sum_cpm);
        $this->assign("GET",$_GET);
        $this->assign("adList", $adList);
        $this->assign("summary", $summary);
        return $this->render("admin/advertiser_list.html");
    }
}