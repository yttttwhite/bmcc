<?php
require_once(ROOT_APP . "/media/db.class.php");
class ad_group extends STpl
{
    public $mongoModel, $mongoName, $planInfoModel;
    public function __construct($inPath)
    {
        $this->planInfoModel = new model_planInfo();
        if (user_api::id() == 0) {
            header("location:/baichuan_advertisement_manage/user");
        }
        $config = SConfig::getConfigArray(ROOT_CONFIG . "/config.php", 'version');
        $host = SConfig::getConfig(ROOT_CONFIG . "/js.conf", 'host');
        $ta = SConfig::getConfigArray(ROOT_CONFIG . "/config.php", 'ta');
        $this->assign("ta", $ta);
        $this->assign("config", $config);
        $this->assign("host", $host);
        $this->assign("_GET", $_GET);

        $stuffType = array(
            1 => "图片",
            2 => "Flash",
            3 => "Flash·动态",
            4 => "文本",
            5 => "文字链",
            6 => "视频",
            7 => "IFrame",
            8 => "JS",
            9 => "HTML",
        );
        $viewType = array(
            1 => '嵌入式',
            2 => '浮窗',
            4 => '背投',
            8 => '重定向[禁用]',
            16 => '重定向[DPC]',
            32 => '通栏',
            64 => '无线APP',
            128 => '无线浮标',
            256 => '插页',
            512 => '对联',
        );
        $position = array(
            0 => "默认",
            1 => "正上方",
            2 => "右上角",
            3 => "右侧居中",
            4 => "右下角",
            5 => "正下方",
            6 => "左下角",
            7 => "左侧居中",
            8 => "左上角"
        );

        if (user_api::auth("adReadonly")) {
            $groupReadonly = " disabled='disabledz'  readonly='readonly' ";
            $this->assign("groupReadonly", $groupReadonly);
        } else {
            $this->assign("groupReadonly", "");
        }

        $this->assign("viewType", $viewType);
        $this->assign("position", $position);
        $this->assign("stuffType", $stuffType);
    }
    public function pageEntry($inPath)
    {
        return $this->render("v2/ad/adGroup.html");
    }
    public function pageShow($inPath)
    {
        if (!empty($inPath[3])) {
            $group_id = $inPath[3];
            $a = new thrift_adgroup_main;
            $group = $a->findAdGroupById($group_id);

            $a = new thrift_adplan_main;
            $plan = $a->getAdPlanByPid($group->plan_id);
            if ($plan->uid != user_api::id()) {
                die("NO ALLOWED");
            }
            $this->assign("plan_id", $group->plan_id);
            $this->assign("group_id", $group_id);
        }
        return $this->render("v2/ad/adGroup.html");
    }
    public function pageList($inPath)
    {
        if (!empty($inPath[3])) {
            $plan_id = $inPath[3];
            $a = new thrift_adplan_main;
            $plan = $a->getAdPlanByPid($plan_id);
            /**
             *通过广告id查找广告位置信息
             */
            $condition = array();
            $condition['plan_id'] = $plan_id;
            $media_extra = $this->planInfoModel->getData($condition);
            $postionId = $media_extra[0]['ad_pos_id']; //广告位id
            $m = new thrift_admedia_main;
            $adpostion = $m->getPoById($postionId);

            if ($plan->uid != user_api::id() && !user_api::auth("admin") && !user_api::auth("adReadonly")) {
                die("NO ALLOWED");
            }
            $this->assign("adpostion", $adpostion);
            $this->assign("plan", $plan);
        }
        $this->assign("plan_id", $plan_id);
        if (!empty($inPath[4])) {
            $group_id = $inPath[4];
            $b = new thrift_adgroup_main;
            $group = $b->findAdGroupById($group_id);
            $this->assign("group", $group);
            $this->assign("sp_list", @explode(",", $group->sp_list));
        }
        $start = "00000000";
        $end = "99999999";
        $ads = ad_api::listAdsReport($group_id, $start, $end);

        if (empty($ads)) {
            $ads = ad_api::listads($group_id);
        }
        $status = array(
            0 => "已保存未提交",
            1 => "待审核",
            2 => "已通过",
            3 => "被拒绝",
        );
        $this->assign("ads", $ads);
        $this->assign("status", $status);
        $this->assign("group_id", $group_id);
        return $this->render("v2/ad/scList.html");
    }
    public function pageStatus($inPath)
    {
        if (!empty($_POST['group_ids'])) {
            //$a = new thrift_adgroup_main;
            $a = new thrift_status_main;
            if ($inPath[3] == "start") {
                foreach ($_POST['group_ids'] as $group_id) {

                    $x = new thrift_adgroup_main;
                    $group = $x->findAdGroupById($group_id);
                    $y = new thrift_adplan_main;
                    $plan = $y->getAdPlanByPid($group->plan_id);
                    if ($plan->uid != user_api::id() && !user_api::auth("admin")) {
                        die("NO ALLOWED");
                    }
                    if ($group->enabled != 4) {
                        $a->updateAdGroupStatus($group_id, PlanStatus::RUNNING);
                    }
                }
            } elseif ($inPath[3] == "stop") {
                foreach ($_POST['group_ids'] as $group_id) {
                    $x = new thrift_adgroup_main;
                    $group = $x->findAdGroupById($group_id);
                    $y = new thrift_adplan_main;
                    $plan = $y->getAdPlanByPid($group->plan_id);
                    if ($plan->uid != user_api::id() && !user_api::auth("admin")) {
                        die("NO ALLOWED");
                    }
                    if ($group->enabled != 4) {
                        $a->updateAdGroupStatus($group_id, PlanStatus::STOPPED);
                    }
                }
            } elseif ($inPath[3] == "del") {
                foreach ($_POST['group_ids'] as $group_id) {
                    $x = new thrift_adgroup_main;
                    $group = $x->findAdGroupById($group_id);
                    $y = new thrift_adplan_main;
                    $plan = $y->getAdPlanByPid($group->plan_id);

                    $config = SConfig::getConfigArray(ROOT_CONFIG . "/config.php", 'config');
                    if ($config['delete'] == 1 && !user_api::auth('admin')) {
                        die("0");
                    }

                    if ($plan->uid != user_api::id() && !user_api::auth("admin")) {
                        die("NO ALLOWED");
                    }
                    $a->updateAdGroupStatus($group_id, PlanStatus::DELETED);
                }
            }
        }
        return true;
    }
    public function pageAdd($inPath)
    {
        require __DIR__ . '../../../tools/SensitiveWordFilter.php';
        $filter = new SensitiveWordFilter(__DIR__ . '../../../tools/dict.txt');
        $word = $_POST;
        if (!empty($_POST)) {
            $word = $_POST;
            foreach ($word as $value) {
                $re = $filter->filter(trim($value), 0);
                if ($re == false) {
                    $this->success("您输入的有敏感词请检查后，再创建", "/baichuan_advertisement_manage/ad.plan");
                    exit;
                }
            }
        }

        if (user_api::auth("adGroupEdit")) {
            $this->assign("groupReadonly", "");
        }
        $domainRules = array();
        if (is_array($_POST['domain_group']) && count($_POST['domain_group']) > 0) {
            //将手动填写的host读入数组
            $includeHostStr = $_POST['_include_host'];
            $includeHostStr = str_ireplace(array("\r\n", "<br>", "</br>", ",", " "), "\n", $includeHostStr);
            $domainRules = explode("\n", $includeHostStr);
            //将选中的域名分组读入数组
            $this->initMongo();
            $domainGroupIds = $_POST['domain_group'];
            foreach ($domainGroupIds as $domainGroupId) {
                $condition = array(
                    'table' => 'domain_rule',
                    'group_id' => $domainGroupId,
                );
                $list = $this->mongoModel->getData($condition, 0, 0);
                if (is_array($list) && count($list) > 0) {
                    foreach ($list as $item) {
                        $domainRules[] = $item['rule'];
                    }
                }
            }
            $domainRules = array_filter($domainRules);
            $domainRules = array_unique($domainRules);
            $_POST['_include_host'] = implode(',', $domainRules);
        }
        if (isset($_POST['_include_host'])) {
            //过滤非法域名
            //$topTLD = array("*.com","*.cn","*.net","*.org","*.co","*.gov","*.edu","*.biz","*.info","*.name");
            $topTLD = array("*", "*/*", "*.*", "*.com", "*.cn", "*.net", "*.org", "*.co", "*.gov", "*.edu", "*.biz", "*.info", "*.name", "*.com.cn", "*.net.cn", "*.org.cn",);
            $tempStr = str_ireplace(array("\r\n", "<br>", "</br>", ",", " "), "\n", $_POST['_include_host']);
            $tempArray = explode("\n", $tempStr);
            if (count($tempArray) > 3) {
                foreach ($tempArray as $tempIndex => $tempRule) {
                    if (in_array($tempRule, $topTLD)) {
                        unset($tempArray[$tempIndex]);
                    }
                }
                $_POST['_include_host'] = implode(',', $tempArray);
            }
        }

        $a = new thrift_adplan_main;
        $b = new thrift_adgroup_main;
        if (empty($inPath[3])) {
            header("location:/baichuan_advertisement_manage/ad.plan.add");
            return;
        }
        $plan_id = $inPath[3];
        $x = new thrift_adplan_main;
        $plan = $x->getAdPlanByPid($plan_id);
        $props = array();
        if (!empty($_POST)) {
            if ($plan->uid != user_api::id() && !user_api::auth("admin") && !user_api::auth("adGroupEdit")) {
                die("NO ALLOWED");
            }
            $error = "";
            if (!empty($inPath[4])) {
                $group = $b->findAdGroupById($inPath[4]);
            } else {
                $group = new AdGroup;
                //{{{ ugly code
                $plan = $a->getAdPlanByPid($plan_id);
                $group->time_interval = $plan->time_interval;
                $group->day_num = $plan->day_num;
                $group->show_num = $plan->show_num;
                $group->start_date = $plan->start_date;
                $group->end_date = $plan->end_date;
                //}}}
            }
            //{{{处理媒体定向(编码与写库)
            ad_api::group_host_encode($group, $_POST);
            //}}}
            ad_api::group_useragent_encode($group, $_POST); //终端信息(编码与写库)
            //出价
            $group->bid_price = $plan->setting_price;
            $group->base_props = array();
            $group->residence_locations = array();
            $group->work_locations = array();
            //            if(isset($_POST['职业'])){
            //                foreach($_POST['职业'] as $item){
            //                    $group->base_props[] = $item;
            //                }
            //            }
            //            if(isset($_POST['工作地'])){
            //                foreach($_POST['工作地'] as $item){
            //                    $group->residence_locations[] = $item;
            //                }
            //            }
            //            if(isset($_POST['居住地'])){
            //                foreach($_POST['居住地'] as $item){
            //                    $group->work_locations[] = $item;
            //                }
            //            }
            $group->usertags = array();
            if (isset($_POST['user_tag_type']) && !(empty($_REQUEST['usertag_1']) && empty($_REQUEST['usertag_2']))) {

                $group->colum2 = $_POST['user_tag_type'];
                if ($_POST['user_tag_type'] == 1 && is_array($_REQUEST['usertag_1'])) {
                    foreach ($_REQUEST['usertag_1'] as $usertag) {
                        $group->usertags[] = $usertag;
                    }
                } elseif ($_POST['user_tag_type'] == 2) {
                    foreach ($_REQUEST['usertag_2'] as $usertag) {
                        $group->usertags[] = $usertag;
                    }
                }
                unset($_POST['user_tag_type']);
            }
            $usertags_type = isset($_POST['usertags_type']) ? $_POST['usertags_type'] : 1;
            // 手动输入标签
            if (!empty($_POST['usertag_manual'])) {
                if ($usertags_type == 2) {
                    $usertag_manual = $_POST['usertag_manual'];
                    $usertag_manual = str_ireplace(array("\r\n", "<br>", "</br>", ",", " "), "\n", $usertag_manual);
                    $group->usertags = explode("\n", $usertag_manual);
                }
            }
            foreach ($group as $k => $v) {
                if (isset($_POST[$k])) {
                    $group->$k = $_POST[$k];
                }
            }
            if ($plan->platform == 1) {
                $group->mobile = 2; //北京移动需要设定为2
            }
            //处理北京地区选择
            //            if($plan->platform == 1 && empty($_POST['area_value']) ){
            //不知道为什么要限定platform为1，toolbar媒体频道，但还会有为2的新TA媒体平台
            if (empty($_POST['area_value'])) {
                $group->area_value = implode(",", $_POST['bj_area']);
            }
            //处理 sp_list
            if ($group->sp_list) {
                $group->sp_list = implode(",", $group->sp_list);
            }
            if (!empty($group->bid_price) && $group->bid_price < 0.1) {
                if (!user_api::auth("admin")) {
                    $group->bid_price = 0.1;
                }
            }
            if (empty($group->name)) {
                $error = "分组名不能为空";
            }
            if (empty($error)) {
                $group->uid = $plan->uid;
                $policys = array();
                $policys_old = array(); //利用原来的policys变量，尽量利用原有代码,修改该人群定向策略
                $policys_str = "";
                if (!empty($_REQUEST['crow'])) {
                    foreach ($_REQUEST['crow'] as $crowd_id) {
                        $policy = new AdGroupPolicy;
                        $policy->herd_id = $crowd_id; //rdp.adp_herd_policy.herd_id = rmc.rmc_audience_crowd.id的值
                        $policys[] = $policy;
                    }
                } elseif (!empty($_POST['media_value'])) {
                    $group->colum1 = 1;
                    $policys_str = $_POST['media_value'];
                    $policys_old = explode(":", trim($policys_str, ":"));
                    if (!empty($policys_old)) {
                        foreach ($policys_old as $crowd_id) {
                            $policy = new AdGroupPolicy;
                            $policy->herd_id = $crowd_id; //rdp.adp_herd_policy.herd_id = rmc.rmc_audience_crowd.id的值
                            $policys[] = $policy;
                        }
                    }
                }
                $group->usertype = $_REQUEST['usertype'];
                $group->policys = $policys;
                $group->exchanges = @implode(",", $_POST['exchanges']);
                if (!empty($inPath[4])) { //修改
                    //修改
                    $group->mtime = time();
                    $group->bid_price = $plan->setting_price;
                    $r = $b->updateAdGroup($group);
                    $group_id = $group->group_id;

                    //edit by 方正 2019.8.9,编辑时也可以新增广告和素材
                    $stufflibraryModel = new model_stuffLibrary();
                    if (!empty($_REQUEST['adid']) && !empty($group_id)) {
                        $stuff_id_list = implode(',', $_REQUEST['adid']);
                        $sql = "SELECT * FROM `adp_stuff_library` WHERE stuff_id IN ($stuff_id_list)";
                        $result = $stufflibraryModel->fetch_all($sql);
                        if (!empty($result)) {
                            $adInfo = [];
                            foreach ($result as $key => $val) {
                                $adInfo['media_name'] = $val['media_name'];
                                $adInfo['adname'] = $val['name'];
                                $adInfo['uid'] = user_api::id();
                                $adInfo['group_id'] = $group_id;
                                $adInfo['plan_id'] = $plan_id;
                                $adInfo['adType'] = $_REQUEST['view_type'][$val['stuff_id']];
                                $adInfo['colum1'] = $_REQUEST['view_position'][$val['stuff_id']];;
                                $adInfo['width'] = $val['width'];
                                $adInfo['height'] = $val['height'];
                                $adInfo['show_js'] = $val['show_js'];
                                $adInfo['click_js'] = $val['click_js'];
                                if (user_api::auth("admin")) {
                                    $adInfo['play_status'] = 1;
                                    $adInfo['verified_or_not'] = 2;
                                } else {
                                    $adInfo['play_status'] = 3;
                                    $adInfo['verified_or_not'] = 1;
                                }
                                $adInfo['media_type'] = 1; //0:固网，1：移动互联网
                                $adInfo['ctime'] = $adInfo['mtime'] = time();

                                $adInfoModel     = new model_adInfo();
                                $adid = $adInfoModel->addData($adInfo);

                                unset($val['adType']);
                                unset($val['valid_startTime']);
                                unset($val['valid_endTime']);
                                unset($val['tel_number']);
                                unset($val['industry_id']);
                                unset($val['show_js']);
                                unset($val['click_js']);
                                
                                $val['adid'] = $adid;
                                $val['ctime'] = $data['mtime'] = time();
                                $val['uid'] = user_api::id();

                                $stuffInfoModel  = new model_stuffInfo();
                                $id = $stuffInfoModel->addData($val);
                                
                                //edit by 方正, 由于数据库将adid修改为主键，所以update操作取消
                                // $data['ctime'] = $data['mtime'] = time();
                                // $data['uid'] = user_api::id();
                                // $data['adid'] = $adid;
                                // $update_id = $stuffInfoModel->updateData($data, array("stuff_id" => $val['stuff_id']));
                            }
                        }
                    }

                    if (empty($group_id)) {
                        $error = "建立失败";
                        $this->assign("group", $group);
                    } else {
                        $db = new SDb();
                        $db->useConfig("adp");
                        $sql = "UPDATE `adp_group_info` SET `usertags_type`={$usertags_type} WHERE `group_id`={$group_id}";
                        $res = $db->execute($sql);
                        header("location:/baichuan_advertisement_manage/ad.group.list.$plan_id.$group_id");
                    }
                } else {
                    //增加
                    $group->bid_price = $plan->setting_price;
                    $group->mtime = $group->ctime = time();
                    $group_id = $b->addAdGroup($group);
                    $stufflibraryModel = new model_stuffLibrary();
                    if (!empty($_REQUEST['adid']) && !empty($group_id)) {
                        $stuff_id_list = implode(',', $_REQUEST['adid']);
                        $sql = "SELECT * FROM `adp_stuff_library` WHERE stuff_id IN ($stuff_id_list)";
                        $result = $stufflibraryModel->fetch_all($sql);
                        if (!empty($result)) {
                            $adInfo = [];
                            foreach ($result as $key => $val) {
                                $adInfo['media_name'] = $val['media_name'];
                                $adInfo['adname'] = $val['name'];
                                $adInfo['uid'] = user_api::id();
                                $adInfo['group_id'] = $group_id;
                                $adInfo['plan_id'] = $plan_id;
                                $adInfo['adType'] = $_REQUEST['view_type'][$val['stuff_id']];
                                $adInfo['colum1'] = $_REQUEST['view_position'][$val['stuff_id']];;
                                $adInfo['width'] = $val['width'];
                                $adInfo['height'] = $val['height'];
                                $adInfo['show_js'] = $val['show_js'];
                                $adInfo['click_js'] = $val['click_js'];
                                if (user_api::auth("admin")) {
                                    $adInfo['play_status'] = 1;
                                    $adInfo['verified_or_not'] = 2;
                                } else {
                                    $adInfo['play_status'] = 3;
                                    $adInfo['verified_or_not'] = 1;
                                }
                                $adInfo['media_type'] = 1; //0:固网，1：移动互联网
                                $adInfo['ctime'] = $adInfo['mtime'] = time();

                                $adInfoModel     = new model_adInfo();
                                $adid = $adInfoModel->addData($adInfo);

                                unset($val['adType']);
                                unset($val['valid_startTime']);
                                unset($val['valid_endTime']);
                                unset($val['tel_number']);
                                unset($val['industry_id']);
                                unset($val['show_js']);
                                unset($val['click_js']);
                                
                                $val['adid'] = $adid;
                                $val['ctime'] = $data['mtime'] = time();
                                $val['uid'] = user_api::id();

                                $stuffInfoModel  = new model_stuffInfo();
                                $id = $stuffInfoModel->addData($val);
                                
                                //edit by 方正, 由于数据库将adid修改为主键，所以update操作取消
                                // $data['ctime'] = $data['mtime'] = time();
                                // $data['uid'] = user_api::id();
                                // $data['adid'] = $adid;
                                // $update_id = $stuffInfoModel->updateData($data, array("stuff_id" => $val['stuff_id']));
                            }
                        }
                    }

                    if (empty($group_id)) {
                        $error = "建立失败";
                        $this->assign("group", $group);
                    } else {
                        $db = new SDb();
                        $db->useConfig("adp");
                        $sql = "UPDATE `adp_group_info` SET `usertags_type`={$usertags_type} WHERE `group_id`={$group_id}";
                        $res = $db->execute($sql);
                        header("location:/baichuan_advertisement_manage/ad.stuff.add.$plan_id.$group_id");
                    }
                }
                //更新审核状态
                if (!user_api::auth("admin")) {
                    $operator = user_api::name();
                    $x->updateVerifiedStatus($plan_id, 1, $operator);
                }
            }
        } elseif (!empty($inPath[4])) {
            if ($plan->uid != user_api::id() && !user_api::auth("admin") && !user_api::auth("adReadonly")) {
                die("NO ALLOWED");
            }
            $group_id = $inPath[4];
            $group = $b->findAdGroupById($inPath[4]);
        } elseif (!empty($_GET['loaded_id'])) {
            if ($plan->uid != user_api::id() && !user_api::auth("admin")) {
                die("NO ALLOWED");
            }
            $group = $b->findAdGroupById($_GET['loaded_id']);
            unset($group->group_id);
            $this->assign("loaded_id", $_GET['loaded_id']);
        } else {
            if ($plan->uid != user_api::id() && !user_api::auth("admin")) {
                die("NO ALLOWED");
            }
            $group = new AdGroup;
        }

        if (!is_array($group->usertags)) {
            $group->usertags = array();
        }
        $this->assign("group", $group);
        //处理媒体定向(反编码)
        ad_api::group_host_decode($group);
        ad_api::group_useragent_decode($group); //终端信息

        /*获取受众*/
        $c = new audient_db;
        $crowds = $c->listCrowd(user_api::id());
        $crowds_default = $c->listCrowdDefault();
        $crowds_position = $c->listCrowdPosition();
        // 获取所有的用户数据
        $user_tags = $c->get_user_tags();
        /*地区*/
        $area_region = rmc_db::listAreaByRegion();
        /*一二线城市*/
        //$area_area = ad_api::getArea_ByArea();
        $area_level = rmc_db::listAreaByLevel();
        /*
        $medias_include = media_db::listMediaDistinct(array(),1,-1);
        $medias_exclute = clone $medias_include; 
        //{{{把已经选择的放到上面
        foreach($medias_include->items as $k=>$item){
            if(in_array($item['id'],$group->_include_media_id)){
                array_unshift($medias_include->items,array_splice($medias_include->items,$k,1));
            }
        }
        foreach($medias_exclute->items as $k=>$item){
            if(in_array($item['id'],$group->_exclude_media_id)){
                array_unshift($medias_exclute->items,array_splice($medias_exclute->items,$k,1));
            }
        }
        */

        //}}}
        $https_refer = preg_split("/[\/]/", $_SERVER["HTTP_REFERER"]);
        $host = $https_refer[2];
        if ($host == "112.124.28.142:94") {
            $this->assign("cj_flag", 1);
        }
        if (!empty($group->base_props)) {
            $PropsString .= "[职业]：";
        }
        foreach ($group->base_props as $item) {
            $props[] = $item;
            $PropsString .= " " . $c->GetCrowdPositionById($item);
        }
        if (!empty($group->residence_locations)) {
            $PropsString .= "<br>[工作地]：";
        }
        foreach ($group->residence_locations as $item) {
            $props[] = $item;
            $PropsString .= " " . $c->GetCrowdPositionById($item);
        }
        if (!empty($group->work_locations)) {
            $PropsString .= "<br>[居住地]：";
        }
        foreach ($group->work_locations as $item) {
            $props[] = $item;
            $PropsString .= " " . $c->GetCrowdPositionById($item);
        }
        if (empty($PropsString)) {
            $PropsString = "您当前还未选择人群属性！";
        } else {
            $PropsString = "您已经选择如下人群属性<br>" . $PropsString;
        }
        if (empty($group->usertags)) {
            $CrowdsString = "您当前还未选择人群!";
        } else {
            $tmpString = array(99000000 => "站点", 1000000 => "电商", 2000000 => "汽车", 3000000 => "APP", 4000000 => "游戏");
            $i = 0;
            foreach ($group->usertags as $id) {
                $item = $c->GetCrowdById($id);
                $i++;
                $CrowdsString .= " " . $item[name];
                if ($i % 10 == 0) {
                    $CrowdsString .= "<br>";
                }
            }
            $CrowdsString = "您已经选择如下人群:<br>" . $CrowdsString;
        }
        $CrowdsString = '';

        $user = user_api::info(); //获取当前用户信息；
        $roleId = $user->role_id; //当前用户角色id 10000：系统管理员，1000：运营商 18：子运营商，12：客户经理，13：广告主

        if (!empty($inPath[4])) {
            $adInfoModel     = new model_adInfo();
            $stuffInfoModel     = new model_stuffInfo();
            // $adInfos = $adInfoModel->getData(array("plan_id" => $plan_id, "group_id" => $group_id));
            //edit by 方正 2019.8.9 去除删除的广告
            $query_sql_adinfo = "SELECT * FROM `adp_ad_info` WHERE plan_id = ($plan_id) and group_id = ($group_id) and play_status != 4";
            $adInfos = $adInfoModel->fetch_all($query_sql_adinfo);
            if (count($adInfos) > 0) {
                $adid_list = implode(',', array_column($adInfos, "adid"));
                $query_sql = "SELECT * FROM `adp_stuff_info` WHERE adid IN ($adid_list) and enabled != 4";
                $stu_result = $stuffInfoModel->fetch_all($query_sql);
            }
            if (!empty($stu_result)) {
                $this->assign("stuff_list", $stu_result);
                $this->assign("ad_list", $adInfos);
            }
        }

        $tag_default = require __DIR__ . '/tags.class.php';
        $crowds_default = [];
        foreach ($tag_default as $value) {
            $crowds_default = array_merge($crowds_default, array_values($value));
        }
        // 解析标签的第一级code
        $usertags_code = [];
        foreach ($group->usertags as $key => $value) {
            $codes = explode(':', $value);
            if (!empty($codes[0])) {
                $usertags_code[] = $codes[0];
            }
        }
        $db = new SDb();
        $db->useConfig("adp");
        $sql = "SELECT * FROM`adp_group_info`WHERE `group_id`={$group->group_id}";
        $res = $db->execute($sql);

        $usertags_type = empty($res[0]['usertags_type']) ? 1 : $res[0]['usertags_type'];
        $this->assign("roleId", $roleId);
        $this->assign("PropsString", $PropsString);
        $this->assign("CrowdsString", $CrowdsString);
        $this->assign("area_level", $area_level);
        $this->assign("area_region", $area_region);
        $this->assign("crowds", $crowds);
        $this->assign("crowds_default", $crowds_default);
        $this->assign("usertags_code", $usertags_code);
        $this->assign("usertags_type", $usertags_type);
        $this->assign("crowds_position", $crowds_position);
        $this->assign("props", $props);
        $this->assign("user_tags", $user_tags);
        $this->assign("plan_id", $plan_id);
        $this->assign("plan", $plan);
        $this->assign("sp_list", @explode(",", $group->sp_list));
        $this->assign("include_useragent", @explode(",", $group->include_useragent));
        $this->assign("group_id", $group_id);
        $exchanges = explode(",", $group->exchanges);
        $this->assign("exchanges", array_filter($exchanges));
        //$this->assign("medias_exclute",$medias_exclute);
        //$this->assign("medias_include",$medias_include);
        $groups = ad_api::listGroups($plan_id);
        $this->assign("groups", $groups);

        $sp = ad_sp::$items;

        $userName = user_api::name();
        if (stripos($userName, '4g') !== false) {
            $showSpId = array('350');
            foreach ($sp as $spId => $spName) {
                if (!in_array($spId, $showSpId)) {
                    unset($sp[$spId]);
                }
            }
        }
        $condition = array();
        $condition['plan_id'] = $inPath[3];
        $media_extra = $this->planInfoModel->getData($condition);
        $this->assign("backstaff", $_GET['back']);
        $this->assign("media_extra", $media_extra[0]);
        $this->assign("sp", $sp);
        $domainGroups = array();
        $this->assign('domainGroups', $domainGroups);
        return $this->render("v2/ad/step_2.html");
    }
    public function pageSet($inPath)
    {
        return $this->render("v2/ad/adGroup_set.html");
    }

    private function getDomainGroup()
    {
        $this->initMongo();
        $condition = array();
        $condition['table'] = "domain_group";
        $list = $this->mongoModel->getData($condition);
        return $list;
    }

    private function initMongo()
    {
        $config = SConfig::getConfigArray(ROOT_CONFIG . "/config.php", 'mongo');
        $this->mongoModel = new model_Mongo();
        $this->mongoName = $config['domain'];
        $this->mongoModel->init($this->mongoName);
    }
}
