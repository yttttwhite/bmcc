<?php
class dpc_main extends STpl{
    public static $conn;
    public static $db;
    public static $collection;
    public $dpcModel;

    function __construct(){
        if(!user_api::auth("dpc")){
            $this->success("没有权限",'/user',3);
            exit();
        }
        
        $mongo = SConfig::getConfig(ROOT_CONFIG."/mongo.conf","dpc_mongo");
        self::$conn=new Mongo("mongodb://{$mongo->host}:{$mongo->port}");
        self::$db= self::$conn->selectDB($mongo->database);
        
        $this->dpcModel = new dpc_dpc();

    }
    
    private function dpcRedirect($redirect){
        if(!isset($redirect['url'])){
            $redirect['url'] = "/dpc.main.host";
        }
        if(!isset($redirect['msg'])){
            $redirect['msg'] = "正在准备跳转……";
        }
        if(!isset($redirect['time'])){
            $redirect['time'] = 3;
        }
        $this->assign("redirect", $redirect);
        return $this->render("/redirect.html");
    }

    function pageEntry($inPath){
        $this->pageList($inPath);
    }
    function pageList($inPath){
        $collection_names = self::$db->getCollectionNames();
        $this->assign("collection_names",$collection_names);
        return $this->render("v2/dpc/command_list.html");
    }
    public function getAreaName($collection,$command_name,$type){
        self::$collection = self::$db->selectCollection($collection);
        $area_names= self::$collection->find(array('command'=>$command_name,'type'=>$type));
        return $area_names;
    }
    public function getHostBlack($collection,$command_name){
        self::$collection = self::$db->selectCollection($collection);
        $host_black= self::$collection->find(array('command'=>$command_name));
        return $host_black;
    }
    public function getHostWhite($collection,$command_name){
        self::$collection = self::$db->selectCollection($collection);
        $host_white= self::$collection->find(array('command'=>$command_name));
        return $host_white;
    }
    public function getAdslList($collection,$value = "",$keyword=""){
        self::$collection = self::$db->selectCollection($collection);
        if(strlen($value)==0 && strlen($keyword)>0){
            $adslList= self::$collection->find(array('command'=>"adsl_config",'keyword'=>$keyword));
        }else{
            $adslList= self::$collection->find(array('command'=>"adsl_config",'value'=>"$value"));
        }
        return $adslList;
    }
    
    
    //ajax返回模板
    public function pageTemplate($inPath){
        $collection = !empty($inPath[3]) ? $inPath[3] : "";
        self::$collection = self::$db->selectCollection($collection);
        $command_name = !empty($inPath[4]) ? $inPath[4] : "";
        switch ($command_name){
            case "area_name":
                $values1 = $this->getAreaName($collection,'area_name','1');
                $values2 = $this->getAreaName($collection,'area_name','0');
                $this->assign("values1",$values1);
                $this->assign("values2",$values2);
                $tab1_name = "blacklist";
                $tab2_name = "whitelist";
                break;
            case "host_cfg":
                $values1 = $this->getHostBlack($collection,'host_black');
                $values2 = $this->getHostWhite($collection,'host_white');
                $this->assign("values1",$values1);
                $this->assign("values2",$values2);
                $tab1_name = "host_black";
                $tab2_name = "host_white";
                break;
            case "url_cfg":
                $values1 = $this->getHostBlack($collection,'url_black');
                $values2 = $this->getHostWhite($collection,'url_white');
                $this->assign("values1",$values1);
                $this->assign("values2",$values2);
                $tab1_name = "url_black";
                $tab2_name = "url_white";
                break;
            case "keyword":
                $tab1_name = "keyword_black";
                $tab2_name = "keyword_white";
                break;
            case "keywork_cate":
                $tab1_name = "keywork_cate";
                break;
            case "web_union":
                $tab1_name = "keyword";
                break;
            case "area_push_interval":
                $ad_max_success_push_obj = self::$collection->find(array('command'=>'ad_max_success_push_times'));
                $ad_max_fail_push_obj = self::$collection->find(array('command'=>'ad_max_fail_push_times'));
                $ad_max_success_push_arr= $this->obj2arr($ad_max_success_push_obj);
                $ad_max_fail_push_arr= $this->obj2arr($ad_max_fail_push_obj);
                $this->assign("ad_max_success_push_arr",$ad_max_success_push_arr);
                $this->assign("ad_max_fail_push_arr",$ad_max_fail_push_arr);
                $this->assign("command_name",$command_name);
                $this->assign("collection",$collection);
                return $this->render("v2/dpc/area_push_interval.tpl");
                break;
            case "redirect":
                $tab1_name = "host_redirect";
                $tab2_name = "redirect_server";
                $tab3_name = "url_redirect";
                $this->assign("tab3_name",$tab3_name);
                break;
            case "time_range":
                $tab1_name = "time_range";
                break;
            case "area_time_range":
                $tab1_name = "area_time_range";
                break;
            case "adsl_black":
                $blackList = $this->getAdslList($collection, 1);
                $whiteList = $this->getAdslList($collection, 2);
                $this->assign("values1", $blackList);
                $this->assign("values2", $whiteList);
                $tab1_name = "adsl_black";
                $tab2_name = "adsl_white";
                break;
            default:
                $tab1_name = $command_name;
        }
        $this->assign("tab1_name",$tab1_name);
        $this->assign("tab2_name",$tab2_name);
        $this->assign("command_name",$command_name);
        $this->assign("collection",$collection);
        return $this->render("/dpc/form.tpl");

    }
    //mongo object 2 array
    function obj2arr($obj){
        if(!empty($obj)){
            $arr = array();
            foreach($obj as $k=>$v){
                $arr[] = $v;
            }
            return $arr;
        }else{
            return false;
        }


    }
    //delete host_black or host_white
    function delHostBF($command_name="host_black",$host=""){
        $opt=array(
                'command' => $command_name
                );
        self::$collection->remove($opt);
    }
    //add host_black or host_white
    function addHostBF($host,$command_name="host_black"){
        $document = array(
                'command' => $command_name,
                'keyword' => trim($host),
                'uptime' => time(),
                ); 
        self::$collection->insert($document);

    }
    //add adsl_black or adsl_white
    function addAdsl($adsl,$command_name="adsl_black"){
        if($command_name == "adsl_white"){
            $value = 2;
        }else{
            $value = 1;
        }
        $document = array(
                'command' => "adsl_config",
                'value' => "$value",
                'keyword' => trim($adsl),
                'author' => user_api::name(),
                'uptime' => time()
                ); 
        return self::$collection->insert($document);

    }
    //delete adsl_black or adsl_white
    function delAdsl($command_name="adsl_white",$keyword=""){
        if($command_name === "adsl_white"){
            $value = 2;
        }else{
            $value = 1;
        }
        if(strlen($keyword)>0){
            $opt=array(
                'command' => "adsl_config",
                'value' => "$value",
                'keyword' => $keyword
            );
        }else{
            $opt=array(
                'command' => "adsl_config",
                'value' => "$value",
            );
        }
        self::$collection->remove($opt);
    }
    function addAreaName($post){
        $document = array(
                'command' => $post['command_name'],
                'type' => $post['type'],
                'value' => $post['value'],
                'uptime' => time(),
                );
        self::$collection->insert($document);

    }
    function findMaxTimes($collection,$ad_type){
        self::$collection = self::$db->selectCollection($collection);
        $res_arr = array();
        if($ad_type == 1){
            $res_arr['ad_max_success_push_obj'] = self::$collection->find(array('command'=>'ad_max_success_push_times'));
            $res_arr['ad_max_fail_push_obj'] = self::$collection->find(array('command'=>'ad_max_fail_push_times'));

        }else{
            $res_arr['redirect_max_success_push_obj'] = self::$collection->find(array('command'=>'redirect_max_success_push_times'));
            $res_arr['redirect_max_fail_push_obj'] = self::$collection->find(array('command'=>'redirect_max_fail_push_times'));
        }
        return $res_arr;
    }
    function updateFlag($collection,$flag = "true"){
        $time = time();
        $r = self::$collection->update(array('command'=>'dpc_update_flag'),array(
                    'command' => 'dpc_update_flag',
                    'keyword' => $flag,
                    "value"=>"$time",
                    'uptime' => $time
                    ));
        return $r;
    }
    function pageAdd($inPath){
        if(!empty($inPath[3])){//修改
            self::$collection = self::$db->selectCollection($inPath[3]);
            if(!empty($_POST)){
                switch ($_POST['command_name']){
                    case 'area_push_interval':
                        //写ad
                        $res_s = array();
                        $res_f = array();
                        if($_POST['ad_type']==1){
                            $res_arr = $this->findMaxTimes($inPath[3],$_POST["ad_type"]);
                            // $ad_max_success_push_obj = self::$collection->find(array('command'=>'ad_max_success_push_times'));
                            // $ad_max_fail_push_obj = self::$collection->find(array('command'=>'ad_max_fail_push_times'));
                            $res_s = $this->obj2arr($res_arr["ad_max_success_push_obj"]);
                            $res_f = $this->obj2arr($res_arr["ad_max_fail_push_obj"]);
                            $document = $this->setupAreaPushInterval($_POST);
                            if(empty($res_s)){
                                self::$collection->insert($document["ad_max_success_push_times"]);
                                $this->updateFlag(self::$collection);
                            }else{
                                self::$collection->update(array('command'=>'ad_max_success_push_times'),$document["ad_max_success_push_times"]);
                                $this->updateFlag(self::$collection);
                            }
                            if(empty($res_f)){
                                self::$collection->insert($document["ad_max_fail_push_times"]);
                                $this->updateFlag(self::$collection);
                            }else{
                                self::$collection->update(array('command'=>'ad_max_fail_push_times'),$document["ad_max_fail_push_times"]);
                                $this->updateFlag(self::$collection);
                            }
                        }else{
                            //写redirect
                            $res_arr = $this->findMaxTimes($inPath[3],$_POST["ad_type"]);
                            //$redirect_max_success_push_obj = self::$collection->find(array('command'=>'redirect_max_success_push_times'));
                            //$redirect_max_fail_push_obj = self::$collection->find(array('command'=>'redirect_max_fail_push_times'));
                            $res_s = $this->obj2arr($res_arr["redirect_max_success_push_obj"]);
                            $res_f = $this->obj2arr($res_arr["redirect_max_fail_push_obj"]);
                            $document = $this->setupAreaPushInterval($_POST);
                            if(empty($res_s)){
                                self::$collection->insert($document["redirect_max_success_push_times"]);
                                $this->updateFlag(self::$collection);
                            }else{
                                self::$collection->update(array('command'=>'redirect_max_success_push_times'),$document["redirect_max_success_push_times"]);
                                $this->updateFlag(self::$collection);
                            }
                            if(empty($res_f)){
                                self::$collection->insert($document["redirect_max_fail_push_times"]);
                                $this->updateFlag(self::$collection);
                            }else{
                                self::$collection->update(array('command'=>'redirect_max_fail_push_times'),$document["redirect_max_fail_push_times"]);
                                $this->updateFlag(self::$collection);
                            }

                        }
                        break;
                    case 'host_cfg':
                        $host_black = $_POST['host_black'];
                        $host_black_arr = array_filter(preg_split("/[\s,]+/",$host_black));
                        $this->delHostBF('host_black');
                        foreach($host_black_arr as $host){
                            $this->addHostBF($host,'host_black');
                        }
                        $this->updateFlag(self::$collection);
                        $host_white= $_POST['host_white'];
                        $host_white_arr = array_filter(preg_split("/[\s,]+/",$host_white));
                        $this->delHostBF('host_white');
                        foreach($host_white_arr as $host){
                            $this->addHostBF($host,'host_white');
                        }
                        $this->updateFlag(self::$collection);
                        break;
                    case 'url_cfg':
                        $url_black = $_POST['url_black'];
                        $url_black_arr = array_filter(preg_split("/[\s,]+/",$url_black));
                        $this->delHostBF('url_black');
                        foreach($url_black_arr as $url){
                            $this->addHostBF($url,'url_black');
                        }
                        $this->updateFlag(self::$collection);
                        $url_white= $_POST['url_white'];
                        $url_white_arr = array_filter(preg_split("/[\s,]+/",$url_white));
                        $this->delHostBF('url_white');
                        foreach($url_white_arr as $url){
                            $this->addHostBF($url,'url_white');
                        }
                        $this->updateFlag(self::$collection);
                        break;
                    case "adsl_black":
                        $datas = array("adsl_black", "adsl_white");
                        foreach ($datas as $data) {
                            $adsl = $_POST[$data];
                            $arr = array_filter(preg_split("/[\s,]+/", $adsl));
                            $this->delAdsl($data);
                            foreach($arr as $adsl){
                                $this->addAdsl($adsl, $data);
                            }
                        }
                        $this->updateFlag(self::$collection);
                        break;
                    default:
                        echo "error";
                        break;
                }
            }
        }else{  //增加
            if(!empty($_POST)){

            }
        }
        $this->assign("collection",$inPath[3]);
        $this->render("v2/dpc/command_add.html");

    }
    function pageGetAreaPushInterval($inPath){
        $collection = $_GET['collection'];
        $command_name= $_GET['command_name'];
        $ad_type= $_GET['ad_type'];
        $res_arr = $this->findMaxTimes($collection,$ad_type);
        $data_arr = array();
        foreach($res_arr as $k=>$v){
            $data_arr[]=$this->obj2arr($v);
        }
        return json_encode($data_arr);

    }
    function setupAreaPushInterval($post){
        $document = array();
        $ad_type = $post["ad_type"];
        if($ad_type==1){
            $document["ad_max_success_push_times"] = array(
                    'command' => 'ad_max_success_push_times',
                    'keyword' => $post['success_maxtimes'],
                    'value' => $post['succeed_interval'],
                    'uptime' => time(),
                    );
            $document["ad_max_fail_push_times" ] = array(
                    'command' => 'ad_max_fail_push_times',
                    'keyword' => $post['fail_maxtimes'],
                    'value' => $post['fail_interval'],
                    'uptime' => time(),
                    );
        }else{
            $document["redirect_max_success_push_times" ] = array(
                    'command' => 'redirect_max_success_push_times',
                    'keyword' => $post['success_maxtimes'],
                    'value' => $post['succeed_interval'],
                    'uptime' => time(),
                    );
            $document["redirect_max_fail_push_times" ] = array(
                    'command' => 'redirect_max_fail_push_times',
                    'keyword' => $post['fail_maxtimes'],
                    'value' => $post['fail_interval'],
                    'uptime' => time(),
                    );
        }
        return $document;
    }
    
    public function pageHost($inPath){
        if(!empty($inPath[3])){
            $collection = $inPath[3];
            self::$collection = self::$db->selectCollection($inPath[3]);
            
            if(!empty($inPath[4])){
                $option = $inPath[4];
                
                if($option === "add"){
                    $groupList = $this->dpcModel->getHostGroupByGid($collection,"all");
                    unset($groupList['1']);
                    unset($groupList['0']);
                    foreach ($groupList as $groupTemp){
                        $groupIdArray[] = $groupTemp['group_id'];
                    }
                    
                    if(isset($_GET['gid']) && is_numeric($_GET['gid']) && in_array($_GET['gid'], $groupIdArray)){
                        $gid = $_GET['gid'];
                    }else{
                        $gid = '1';
                    }
                    
                    $this->assign("gid",$gid);
                    $this->assign("groupList",$groupList);
                    $this->assign("collection",$collection);
                    return $this->render("/dpc/iframe_add_host.html");
                }elseif($option === "edit"){
                    $groupList = $this->dpcModel->getHostGroupByGid($collection,"all");
                    unset($groupList['1']);
                    unset($groupList['0']);
                    foreach ($groupList as $groupTemp){
                        $groupIdArray[] = $groupTemp['group_id'];
                    }
                    
                    if(!isset($_POST['url']) && !isset($_GET['url'])){
                        $url = array();
                        $urlStr = "";
                        echo "没有收到任何HOST，请检查表单。<br><a href='".$_SERVER['HTTP_REFERER']."'>返回</a>";
                        exit();
                    }
                    
                    if(isset($_POST['url'])){
                        $url = $_POST['url'];
                        
                        if(is_array($_POST['url'])){
                            $urlStr = implode("<br>", $_POST['url']);
                        }else{
                            $urlStr = $url;
                        }
                        $this->assign("referer",$_SERVER['HTTP_REFERER']);
                    }elseif(isset($_GET['url'])){
                        $url = $_GET['url'];
                        $urlStr = urldecode($url);
                        $url = array($url);
                    }
                    
                    $this->assign("urlStr",$urlStr);
                    $this->assign("url",$url);
                    $this->assign("gid",$gid);
                    $this->assign("groupList",$groupList);
                    $this->assign("collection",$collection);
                    return $this->render("/dpc/iframe_edit_host.html");
                }elseif($option === "save"){
                    if(isset($_POST['url']) && isset($_POST['groupRadio'])){
                        $urlStr = $_POST['url'];
                        $groupId = $_POST['groupRadio'];
                        
                        $groupList = $this->dpcModel->getHostGroupByGid($collection,"all");
                        foreach ($groupList as $groupTemp){
                            $groupIdArray[] = $groupTemp['group_id'];
                        }
                        
                        if($groupId == 0 || $groupId == 1){
                            exit("不可以向该分组添加内容");
                        }elseif(is_numeric($groupId) && in_array($groupId, $groupIdArray)){
                            $urlStr = str_replace(array("https://","https://"), "", $urlStr);
                            $urlStr = str_replace(array("\r\n","\r","<br>"), "\n", $urlStr);
                            $urlArray = explode("\n", $urlStr);
                            $urlArray = array_filter($urlArray);
                            
                            $insertStatus = array();
                            foreach ($urlArray as $url){
                                $url_sha1 = sha1($url);
                                $item = $this->dpcModel->getHost($collection,$url);
                                $exist = count($item);
                                if($exist > 0){
                                    $existDetail = array();
                                    $existDetail['url'] = $url;
                                    $existDetail['group_id'] = $item[0]['group_id'];
                                    $existDetail['user'] = $item[0]['user'];
                                    $existDetail['uptime'] = date('Y-m-d H:i:s',$item[0]['uptime']);
                                    
                                    $insertStatus['exist'][] = $existDetail;
                                    
                                    if(isset($_POST['saveType']) && $_POST['saveType']==="edit"){
                                        $hostInfo = array();
                                        $hostInfo['url'] = $url;
                                        $hostInfo['url_sha1'] = $url_sha1;
                                        $hostInfo['group_id'] = (string)$groupId;
                                        
                                        $this->dpcModel->updateHost($collection,$hostInfo);
                                    }
                                    
                                }else{
                                    $insertStatus['ok'][] = $url;
                                    $hostInfo = array();
                                    $hostInfo['url'] = $url;
                                    $hostInfo['url_sha1'] = $url_sha1;
                                    $hostInfo['group_id'] = (string)$groupId;
                                    $this->dpcModel->addHost($collection,$hostInfo);
                                }
                            }
                            if(is_array($insertStatus['ok'])){
                                $this->assign('insertStatus',$insertStatus);
                            }
                            if(is_array($insertStatus['exist'])){
                                
                                if(isset($_POST['saveType']) && $_POST['saveType']==="edit"){
                                    $title = "以下内容重复，已经更新。";
                                }else{
                                    $title = "以下内容重复，未执行操作。";
                                }
                                
                                if(isset($_POST['referer'])){
                                    $referer = $_POST['referer'];
                                }else{
                                    $referer = 0;
                                }
                                
                                $this->assign('title',$title);
                                $this->assign('referer',$referer);
                                $this->assign('insertStatus',$insertStatus);
                                return $this->render("/dpc/iframe_add_host_result.html");
                                exit();
                            }
                        }else{
                            exit("请选择分组");
                        }
                    }
                }elseif($option === "delete"){
                    if(isset($_GET['url_sha1'])){
                        $this->dpcModel->deleteHost($collection,$_GET['url_sha1'],"url_sha1");
                    }elseif(isset($_GET['url'])){
                        $url = urldecode($_GET['url']);
                        $this->dpcModel->deleteHost($collection,$url);
                    }
                }
                echo "<script language=JavaScript>parent.location.reload();</script>";
                
            }else {
                if(isset($_GET['gid']) && is_numeric($_GET['gid'])){
                    $gid = $_GET['gid'];
                    $groupList = $this->dpcModel->getHostGroupByGid($collection,"all");
                    foreach ($groupList as $key => $temp){
                        $groupListNew[$temp['group_id']] = $temp;
                    }
                
                    $groupInfo = $groupListNew[$gid];
                    if(!isset($groupInfo['max_push_times'])){$groupInfo['max_push_times'] = "未设置";}
                    
                    $amount = $this->dpcModel->getCountByGid($collection,$gid);
                    
                    $perpage = 50;
                    $page = array();
                    $page['current'] = $_GET['page'];
                    $page['amount'] = $amount/$perpage;
                    $page['perpage'] = $perpage;
                    
                    if(isset($_GET['page']) && is_numeric($_GET['page'])){
                        if($_GET['page']<1){
                            $skip = 0;
                        }else{
                            $skip = ($_GET['page']-1) * $perpage;
                        }
                    }else{
                        $skip = 0;
                    }
                    
                    $hostList = $this->dpcModel->getHostByGid($collection,$gid,$skip,$perpage);
                
                    if(!is_array($hostList)){
                        $hostList = array();
                    }
                
                    $this->assign("page",$page);
                    $this->assign("groupList",$groupList);
                    $this->assign("groupInfo",$groupInfo);
                    $this->assign("hostList",$hostList);
                    $this->assign("collection",$collection);
                    return $this->render("/dpc/host_list.html");
                }else{
                    $groupList = $this->dpcModel->getHostGroupByGid($collection,"all");
                    if(!is_array($groupList)){$groupList = array();}
                    $this->assign("groupList",$groupList);
                    $this->assign("collection",$collection);
                    return $this->render("/dpc/host_group_list.html");
                }
                return $this->render("/dpc/host_list.html");
            }
        }else{
            $mongoList = self::$db->getCollectionNames();
            $this->assign("mongoList",$mongoList);
            return $this->render("/dpc/mongo_list.html");
        }
    }
    
    
    public function pageHostLeft($inPath){
        if(!empty($inPath[3])){
            $collection = $inPath[3];
            self::$collection = self::$db->selectCollection($inPath[3]);
            $groupList = $this->dpcModel->getHostGroupByGid($collection,"all");
            $this->assign("collection",$collection);
            $this->assign("groupList",$groupList);
            return $this->render("/dpc/host_group_list_left.html");
        }else{
            $collection_names = self::$db->getCollectionNames();
            $this->assign("collection_names",$collection_names);
            return $this->render("/dpc/mongo_list_left.html");
        }
    }
    
    public function pageHostGroup($inPath){
        if(!empty($inPath[3])){
            $collection = $inPath[3];
            self::$collection = self::$db->selectCollection($inPath[3]);
            
            if(!empty($inPath[4])){
                $option = $inPath[4];
                
                if($option === "add"){
                    $groupList = $this->dpcModel->getHostGroupByGid($collection,"all");
                    $countGroup = count($groupList);
                    if($countGroup >= 50){
                        exit("分组已经达到上限，您可以修改其他分组。");
                    }else{
                        $this->assign("collection",$collection);
                        return $this->render("/dpc/iframe_add_group.html");
                    }
                }elseif($option === "edit"){
                    if(isset($_GET['gid'])){
                        $hostGroup = $this->dpcModel->getHostGroupByGid($collection,$_GET['gid']);
                        if(is_array($hostGroup)){
                            $this->assign("collection",$collection);
                            $this->assign("hostGroup",$hostGroup[$_GET['gid']]);
                            return $this->render("/dpc/iframe_add_group.html");
                        }
                    }
                }elseif($option === "save"){
                    $collection_names = self::$db->getCollectionNames();
                    
                    if( isset($_POST['collection']) && in_array($_POST['collection'], $collection_names) && $collection === $_POST['collection']) {
                    }else{
                        exit("所选数据库有误！");
                    }
                    $groupInfo = array();
                    if( isset($_POST['times']) && is_numeric($_POST['times']) ){
                        $groupInfo['max_push_times'] = $_POST['times'];
                    }else{
                        $groupInfo['max_push_times'] = 0;
                    }
                    
                    if(isset($_POST['bidder']) && $_POST['bidder']==1){
                        $groupInfo['bidder_url'] = $_POST['bidder_url'];
                        $groupInfo['traffic_ratio'] = $_POST['traffic_ratio'];
                    }
                    
                    
                    if(  isset($_POST['group_name']) ){
                        $groupInfo['group_name'] = strip_tags($_POST['group_name']);
                        if(strlen($groupInfo['group_name']) > 50){
                            $groupInfo['group_name'] = substr($groupInfo['group_name'], 0,50);
                        }
                        
                        if(strlen($groupInfo['group_name'])<2){
                            $groupInfo['group_name'] = "新建分组";
                        }
                    }else{
                        $groupInfo['group_name'] = "新建分组";
                    }
                    
                    //获取当前分组的ID情况
                    $groupList = $this->dpcModel->getHostGroupByGid($collection,"all");
                    if(!is_array($groupList)){$groupList = array();}
                    $countGroup = count($groupList);
                    $groupIdArray = array();
                    foreach ($groupList as $groupTemp){
                        $groupIdArray[] = $groupTemp['group_id'];
                    }
                    //编辑或者新增
                    if(isset($_POST['group_id']) && is_numeric($_POST['group_id'])){
                        $groupId = $_POST['group_id'];
                        if(in_array($groupId, $groupIdArray)){
                            if($groupId == 0){
                                $groupInfo['group_name'] = "白名单";
                            }elseif($groupId == 1){
                                $groupInfo['group_name'] = "默认分组";
                            }
                            $condition = array('group_id'=>"$groupId");
                            $this->dpcModel->updateHostGroup($collection, $condition, $groupInfo);
                        }else{
                            exit("无该分组或者没有修改改组权限。");
                        }
                    }else{
                        if($countGroup >= 50){
                            exit("分组已经达到上限，您可以修改其他分组。");
                        }
                        $groupId = 0;
                        for ($i = 2; $i<32; $i++){
                            if( !in_array($i, $groupIdArray) ){
                                $groupId = $i;
                                break;
                            }
                        }
                        
                        if($groupId == 0 || $groupId >31){
                            exit("分组已经达到上限，您可以修改其他分组。");
                        }else{
                            $groupInfo['group_id'] = $groupId;
                            $this->dpcModel->addHostGroup($collection, $groupInfo);
                        }
                    }
                    echo "<script language=JavaScript>parent.location.reload();</script>";
                }elseif($option === "delete"){
                    if(isset($_GET['gid'])){
                        $groupId = $_GET['gid'];
                        //获取当前分组的ID情况
                        $groupList = $this->dpcModel->getHostGroupByGid($collection,"all");
                        $groupIdArray = array();
                        foreach ($groupList as $groupTemp){
                            $groupIdArray[] = $groupTemp['group_id'];
                        }
                        
                        if($groupId != 0 && $groupId != 1 && in_array($groupId, $groupIdArray)){
                            $groupId = "$groupId";
                            $this->dpcModel->deleteHostGroupByGid($collection,$groupId);
                            $this->dpcModel->deleteHostByGid($collection,$groupId);
                        }else{
                            exit("无法删除，可能原因：<br>1.没有这个分组；<br>2.该分组是系统分组，无法删除。");
                        }
                    }
                }
            }
            
        }
    }
    
    public function pageHostDeleteAll($inPath){
        exit();
        $collection = $inPath[3];
        $this->dpcModel->deleteHostGroupByGid($collection,"all");
        $this->dpcModel->deleteHostByUrl($collection,"all");
    }
}
