<?php
class crm_consumer extends STpl{
    private $crm, $tag;
    private $perPage,$uid;
    public function __construct($inPath){
        $this->crm = new model_consumer();
        $this->tag = new model_interest();
        $this->perPage = 20;
        
        
        $this->uid = user_api::id();
        if($this->uid == 0){
            exit("尚未登录");
        }
    }
    
    private function customRedirect($redirect){
        if(!isset($redirect['url'])){
            $redirect['url'] = "/baichuan_advertisement_manage/crm.consumer.list";
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
    
    public function pageEntry(){
        exit();
        for($i = 0; $i<1000; $i++){
            $name = $this->createName();
            $mobile = rand(13500000000, 13599999999);
            
            $consumerInfo = array(
                "name" => $name,
                "mobile" => $mobile
            );
            $consumerInfo['uid'] = $this->uid;
            $consumerInfo['uid'] = rand(2, 10);
            $id = $this->crm->addConsumer($consumerInfo);
        }
    }
    
    public function pageList($inPath) {
        if( isset($inPath[3]) && is_numeric($inPath[3]) ){
            $page = $inPath[3];
        }else{
            $page = 1;
        }
        $page = $page < 1?1:$page;
        $pageInfo = array();
        $pageInfo['url'] = "/baichuan_advertisement_manage/crm.consumer.list.";
        $pageInfo['current'] = $page;
        $amount = $this->crm->getConsumerCountByUid($this->uid);
        $pageInfo['count'] = ceil($amount/$this->perPage);
        
        $start = ($page-1)*$this->perPage;
        $result = $this->crm->getConsumersByUid($this->uid,$start,$this->perPage);
        if(is_array($result)){
            $this->assign("pageInfo",$pageInfo);
            $this->assign("consumers",$result);
            return $this->render("/crm/consumerList.html");
        }
    }
    
    public function pageDetail($inPath){
        if( isset($inPath[3]) && is_numeric($inPath[3]) ){
            $consumerId = $inPath[3];
            $result = $this->crm->getConsumerById($consumerId);
            if (count($result)!=0 && $result['uid']==$this->uid){
                if(isset($result['mobile'])){
                    $userTags = $this->tag->getTagsByUid($result['mobile']);
                    if($userTags !== false){
                        $rootTag = array();
                        for ($i = 1; $i <5; $i++ ){
                            $rootTag[$i]=0;
                        }
                        
                        $outputUser = array();
                        $pid = 0;
                        foreach ($userTags as $tag){
                            $rid = $tag['rid'];
                            if(isset($rootTag[$rid])){
                                $rootTag[$rid] = 1;
                                
                                if($pid == $tag['pid']){
                                    $outputUser[$rid][$pid]['tagStr'] .= "<br>".$tag['tname'];
                                    
                                    $outputUser[$rid][$tag['pid']]['count'] .= "<br>".$tag['count'];
                                    $outputUser[$rid][$tag['pid']]['weight'] .= "<br>".$tag['weight'];
                                    $outputUser[$rid][$tag['pid']]['weight_sum'] .= "<br>".$tag['weight_sum'];
                                }else{
                                    $pid = $tag['pid'];
                                    $outputUser[$rid][$tag['pid']]['pname'] = $tag['pname'];
                                    $outputUser[$rid][$tag['pid']]['tagStr'] .= $tag['tname'];
                                    
                                    $outputUser[$rid][$tag['pid']]['count'] = $tag['count'];
                                    $outputUser[$rid][$tag['pid']]['weight'] = $tag['weight'];
                                    $outputUser[$rid][$tag['pid']]['weight_sum'] = $tag['weight_sum'];
                                }
                            }
                        }
                        
                        $tag = $this->tag->getTag();
                        $this->assign("tag", $tag);
                        $this->assign("rootTag", $rootTag);
                        $this->assign("userTags", $userTags);
                        $this->assign("outputUser", $outputUser);
                    }
                }
                
                $this->assign("consumer", $result);
                return $this->render("/crm/consumerDetail2.html");
            }
        }else{
            
        }
    }
    
    public function pageOperation($inPath){
        if(isset($inPath[3]) && strlen($inPath[3])>0){
            switch ($inPath[3]) {
                case "delete":
                    $cid = 0;
                    if(isset($inPath[4]) && is_numeric($inPath[4])){
                        $cid = $inPath[4];
                    }elseif(isset($_REQUEST['cid']) && is_numeric($_REQUEST['cid'])){
                        $cid = $_REQUEST['cid'];
                    }else{
                        if(isset($_POST['consumerIds'])){
                            $consumerIds = $_POST['consumerIds'];
                            if(is_array($consumerIds)){
                                $this->crm->deleteConsumersByCids($consumerIds);
                                
                                $redirect = array();
                                $redirect['url'] = $_SERVER['HTTP_REFERER'];
                                $redirect['msg'] = "删除成功，准备跳转";
                                $this->customRedirect($redirect);
                            }
                        }
                    }
                    
                    if($cid != 0){
                        $this->crm->deleteConsumerByCid($cid);
                        return "删除成功";
                    }
                break;
                
                default:
                echo "hello";
                break;
            }
        }
    }
    
    public function pageGroup($inPath){
        $error = 0;
        if( isset($inPath[3]) && is_numeric($inPath[3]) ){
            $groupId = $inPath[3];
            
            if( isset($inPath[4]) && is_numeric($inPath[4]) ){
                $page = $inPath[4];
            }else{
                $page = 1;
            }
            $start = ($page-1)*$this->perPage;
            $group = $this->crm->getGroupById($groupId);
            if($group['uid'] == $this->uid){
                $consumers = $this->crm->getConsumersByGid($groupId,$start,$this->perPage);
                $pageInfo = array();
                $pageInfo['url'] = "crm.consumer.group.$groupId.";
                $pageInfo['current'] = $page;
                $amount = $this->crm->getConsumerCountByGid($groupId);
                $pageInfo['count'] = ceil($amount/$this->perPage);
                $this->assign("pageInfo",$pageInfo);
                $this->assign("consumers",$consumers);
                return $this->render("/crm/consumerList.html");
            }else{$error++;}
        }else{$error++;}
        
        if($error > 0){
            $redirect = array();
            $redirect['url'] = "/baichuan_advertisement_manage/crm.consumer.list";
            $redirect['time'] = 3;
            $redirect['msg'] = "您没有浏览该分组的权限！";
            
            $this->customRedirect($redirect);
        }
    }
    
    public function pageGroups(){
        $groups = $this->crm->getGroupsByUid($this->uid);
        $this->assign("groups", $groups);
        return $this->render("/crm/consumerGroups.html");
        print_r($groups);
    }
    
    public function pageAddGroup(){
        if(isset($_POST['groupName']) && strlen($_POST['groupName'])>0){
            $group = array();
            $group['name'] = $_POST['groupName'];
            $group['uid'] = $this->uid;
            
            $id = $this->crm->addGroup($group);
            if(is_numeric($id) && $id>0){
                $msg = "添加成功!";
            }else{
                $msg = "添加失败!";
            }
            
            $redirect = array();
            $redirect['url'] = $_SERVER['HTTP_REFERER'];
            $redirect['time'] = 3;
            $redirect['msg'] = $msg;
            $this->customRedirect($redirect);
        }
    }
    
    public function pageUpdateGroupCount($inPath){
        $error = 0;
        if( isset($inPath[3]) && is_numeric($inPath[3]) ){
            $groupId = $inPath[3];
            $this->crm->updateCountByGid($groupId);
        }
        
        $redirect['url'] = "/baichuan_advertisement_manage/crm.consumer";
        $this->customRedirect($redirect);
    }
    
    public function pageAddConsumerToGroup(){
        if(isset($_POST['groupRadio']) && is_numeric($_POST['groupRadio']) && isset($_POST['cids'])){
            $gid = $_POST['groupRadio'];
            $group = $this->crm->getGroupById($gid);
            if($group['uid'] == $this->uid){
                $cids = explode("#", $_POST['cids']);
                $cidArray = array();
                foreach ($cids as $cid){
                    if(is_numeric($cid)){
                        $cidArray[] = $cid;
                    }
                }
                
                $consumers = $this->crm->getConsumersByIds($cidArray,0,count($cidArray));
                $success = 0;
                foreach ($consumers as $consumer){
                    if($consumer['uid'] == $this->uid){
                        $id = $this->crm->addConsumerToGroup($consumer['id'], $gid);
                        if($id > 0){
                            $success++;
                        }
                    }
                }
                $this->crm->updateCountByGid($gid);
                $redirect['msg'] = $success."/".count($cidArray)."条添加成功";
                $this->customRedirect($redirect);
            }
        }elseif(isset($_POST['consumerIds']) && count($_POST['consumerIds'])>0){
            $cidArray = $_POST['consumerIds'];
            $consumers = array();
            $consumers['cids'] = implode($cidArray, "#");
            $consumers['count'] = count($cidArray);
            
            $groups = $this->crm->getGroupsByUid($this->uid);
            $this->assign("groups", $groups);
            $this->assign("consumers", $consumers);
            return $this->render("/crm/addConsumerToGroup.html");
        }
    }
    
    public function pageIframeAddConsumer($inPath){
        $cid = 0;
        if(isset($inPath[3]) && is_numeric($inPath[3])){
            $cid = $inPath[3];
        }
        if($cid != 0){
            $consumer = $this->crm->getConsumerById($cid);
        }else{
            $consumer = array();
        }
        
        $groups = $this->crm->getGroupsByUid($this->uid);
        $this->assign("consumer", $consumer);
        $this->assign("groups", $groups);
        return $this->render("/crm/iframeAddConsumer.html");
    }
    
    public function pageAddConsumer($inPath){
        $error = 0;
        $consumer = array();
        
        if(isset($_POST['name'])){
            $consumer['name'] = $_POST['name'];
        }else{
            $error++;
        }
        if(isset($_POST['mobile'])){
            $consumer['mobile'] = $_POST['mobile'];
        }
        if(isset($_POST['phone'])){
            $consumer['phone'] = $_POST['phone'];
        }
        if(isset($_POST['email'])){
            $consumer['email'] = $_POST['email'];
        }
        if(isset($_POST['state'])){
            $consumer['state'] = $_POST['state'];
        }
        if(isset($_POST['city'])){
            $consumer['city'] = $_POST['city'];
        }
        
        if($error == 0 && isset($_POST['cid']) && is_numeric($_POST['cid'])){
            $consumer['id'] = $_POST['cid'];
            $existConsumer = $this->crm->getConsumerById($consumer['id']);
            if(isset($existConsumer['uid']) == $this->uid){
                $consumer['uid'] = $this->uid;
                $id = $this->crm->addConsumer($consumer,true);
            }
        }elseif($error == 0){
            $consumer['uid'] = $this->uid;
            $id = $this->crm->addConsumer($consumer);
            if(isset($_POST['groupRadio'])){
                $gid = $_POST['groupRadio'];
                $group = $this->crm->getGroupById($gid);
                if ($group['uid'] == $this->uid){
                    $this->crm->addConsumerToGroup($id, $gid);
                    $this->crm->updateCountByGid($gid);
                }
            }
        }
        echo "<script language=JavaScript>parent.location.reload();</script>";
    }
    
    private function createName(){
        $xingArray = array('艾','爱','安','敖','巴','白','百里','柏','班','包','薄','鲍','暴','贝','贲','毕','边','卞','别','邴','伯','卜','步','蔡','苍','曹','岑','曾','查','柴','昌','常','晁','巢','车','陈','成','程','池','充','仇','储','褚','淳于','从','崔','笪','戴','单','单于','澹台','党','邓','狄','刁','丁','东','东方','东郭','东门','董','都','钭','窦','督','堵','杜','端木','段','段干','鄂','佴','樊','范','方','房','费','丰','封','酆','冯','凤','伏','扶','符','傅','富','盖','甘','干','高','郜','戈','葛','庚','耿','弓','公','公良','公孙','公西','公羊','公冶','宫','龚','巩','贡','勾','缑','古','谷','谷粱','顾','关','管','广','归','桂','郭','国','哈','海','韩','杭','郝','何','和','贺','赫连','衡','弘','红','洪','侯','后','後','呼延','胡','扈','花','华','滑','怀','桓','宦','皇甫','黄','惠','霍','姬','嵇','吉','汲','籍','计','纪','季','蓟','暨','冀','家','夹谷','郏','贾','简','江','姜','蒋','焦','解','金','晋楚','靳','经','荆','井','景','居','鞠','堪','阚','康','亢','柯','空','孔','寇','蒯','匡','况','夔','赖','蓝','郎','劳','乐','乐正','雷','冷','黎','李','厉','利','郦','连','廉','梁丘','粱','廖','林','蔺','凌','令狐','刘','柳','龙','隆','娄','卢','鲁','陆','逯','禄','路','栾','罗','骆','闾丘','吕','麻','马','满','毛','茅','梅','蒙','孟','糜','米','宓','苗','闵','明','缪','莫','墨','牟','牧','慕','慕容','穆','那','南宫','南门','能','倪','年','乜','聂','宁','牛','钮','农','欧阳','殴','潘','庞','逄','裴','彭','蓬','皮','平','蒲','濮','濮阳','浦','戚','漆雕','亓官','齐','祁','钱','强','乔','谯','钦','秦','琴','邱','秋','裘','屈','麴','璩','瞿','权','全','阙','冉','壤驷','饶','任','戎','荣','容','融','茹','汝','阮','芮','桑','沙','山','商','赏','上官','尚','韶','邵','佘','厍','申','申屠','莘','沈','慎','盛','师','施','石','时','史','寿','殳','舒','束','帅','双','水','司','司空','司寇','司马','司徒','松','宋','苏','孙','索','邰','太叔','谈','谭','汤','唐','陶','滕','田','通','佟','童','涂','屠','拓拔','万','万俟','汪','王','危','微生','韦','隗','卫','尉迟','蔚','魏','温','文','闻','闻人','翁','沃','乌','邬','巫','巫马','毋','吴','伍','武','西门','郗','奚','习','席','舄','夏','夏侯','鲜于','咸','相','向','项','萧','谢','辛','邢','幸','熊','宿','须','胥','徐','许','轩辕','宣','薛','荀','鄢','闫法','严','阎','颜','晏','燕','羊','羊舌','阳','杨','仰','养','姚','叶','伊','易','羿','益','阴','殷','尹','印','应','雍','尤','游','有','於','于','余','鱼','俞','虞','宇文','禹','郁','喻','欎','元','袁','岳','越','云','宰','宰父','昝','臧','翟','詹','张','章','长孙','仉','赵','甄','郑','支','终','钟','钟离','仲','仲孙','周','朱','诸','诸葛','竺','祝','颛孙','庄','卓','子车','訾','宗','宗政','邹','祖','左','左丘');
        $str = "在一次朋友聚会上认识一女朋友我们两个人聊到厨艺她告诉我自己很喜欢吃鲈鱼但是不会做我告诉她做鲈鱼一点都不难最简单的做法就是清蒸了我分享了自己清蒸鲈鱼的做法她听了一半忽然说我是西北人从小吃鱼少也不会做我笑着说那可以学呀她回应到我学不会而且我是西北人嘛天生缺少做鱼的细胞在后来的聊天中我发现这个女生有很多类似我是西北人我学不会做鱼的信念她和你抱怨男朋友不带她出门旅行你说很多女生会独自旅行";
        $xing = $xingArray[rand(0, count($xingArray))];
        $wordArray = array();
        for($i = 0; $i<floor(strlen($str)); $i+=3){
            $wordArray[] = substr($str, $i, 3);
        }
        $ming = "";
        $len = rand(0, 1);
        for($k = 0; $k<=$len; $k++){
            $ming.= $wordArray[rand(0, count($wordArray))];
        }
        return $xing.$ming;
    }
}