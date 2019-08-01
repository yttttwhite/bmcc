<?php
class model_consumer extends discuz_database{
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
    }
    /**
     * 
     * 对consumer的操作
     * 
     */
    public function addConsumer($consumerInfo, $update = false){
        $consumer = array();
        $error = 0;
        if(isset($consumerInfo['name']) && strlen($consumerInfo['name'])<50){
            $consumer['name'] = $consumerInfo['name'];
        }else{
            $error++;
        }
        
        if(isset($consumerInfo['phone']) && strlen($consumerInfo['phone'])<50){
            $consumer['phone'] = $consumerInfo['phone'];
        }
        
        if(isset($consumerInfo['mobile']) && strlen($consumerInfo['mobile'])<50){
            $consumer['mobile'] = $consumerInfo['mobile'];
        }
        
        if(isset($consumerInfo['email']) && strlen($consumerInfo['email'])<50){
            $consumer['email'] = $consumerInfo['email'];
            $consumer['email'] = str_replace("@", "#", $consumer['email']);
        }
        
        if(isset($consumerInfo['state']) && strlen($consumerInfo['state'])<20){
            $consumer['state'] = $consumerInfo['state'];
        }
        
        if(isset($consumerInfo['city']) && strlen($consumerInfo['city'])<20){
            $consumer['city'] = $consumerInfo['city'];
        }
        
        if(isset($consumerInfo['uid'])){
            $consumer['uid'] = $consumerInfo['uid'];
        }
        
        if ($error == 0){
            if($update){
                $condition = array("id" => $consumerInfo['id']);
                parent::update("consumer", $consumer, $condition);
            }else{
                $id = parent::insert("consumer", $consumer,true,false);
            }
            return $id;
        }else{
            return 0;
        }
        
    }
    
    public function deleteConsumerByCid($id){
        $condition = array("id"=>$id);
        parent::delete("consumer", $condition);
    }
    public function deleteConsumersByCids($cidArray){
        if(is_array($cidArray)){
            $idStr = implode(",", $cidArray);
            $table = parent::table("consumer");
            $sql = " DELETE FROM `$table` WHERE `id` in ( $idStr ) ";
            $result = parent::query($sql);
            return $result;
        }else{
            return false;
        }
    }
    
    public function getConsumers($start = 0, $limit = 50, $uid = 0){
        $table = parent::table("consumer");
        $sql = "SELECT * FROM `$table` WHERE `uid` = $uid LIMIT $start , $limit";
        
        $result = parent::fetch_all($sql);
        return $result;
    }
    
    public function getConsumersByUid($uid = -1, $start = 0, $limit = 50){
        $table = parent::table("consumer");
        $sql = "SELECT * FROM `$table` WHERE `uid` = $uid ORDER BY `id` DESC LIMIT $start , $limit ";
        
        $result = parent::fetch_all($sql);
        return $result;
    }
    
    public function getConsumerCountByUid($uid = -1){
        $table = parent::table("consumer");
        $sql = "SELECT COUNT(*) as `num` FROM `$table` WHERE `uid` = $uid ";
        
        $count = parent::fetch_first($sql);
        $amount = $count[num];
        return $amount;
    }
    
    public function getConsumerCountByGid($gid = -1){
        $table = parent::table("group_consumer");
        $sql = "SELECT COUNT(*) as `num` FROM `$table` WHERE `gid` = $gid ";
        
        $count = parent::fetch_first($sql);
        $amount = $count[num];
        return $amount;
    }
    
    public function getConsumerById($id){
        $table = parent::table("consumer");
        $sql = "SELECT * FROM `$table` WHERE `id` = $id ";
        
        $result = parent::fetch_first($sql);
        return $result;
    }
    
    public function getConsumersByIds($cidArray, $start = 0, $limit = 50){
        $idStr = implode(",", $cidArray);
        $table = parent::table("consumer");
        $sql = " SELECT * FROM `$table` WHERE `id` in ( $idStr ) ORDER BY `id` DESC LIMIT $start,$limit ";
        $result = parent::fetch_all($sql);
        return $result;
    }
    
    public function getConsumersByGid($gid, $start = 0, $limit = 50){
        $cidArray = $this->getCidsByGid($gid);
        if (is_array($cidArray) && count($cidArray) >0){
            $consumers = $this->getConsumersByIds($cidArray, $start, $limit);
            return ($consumers);
        }else{
            return array();
        }
    }
    
    /**
     *
     * 对group的操作
     *
     */
    public function addGroup($groupInfo){
        $table = parent::table("group");
        $group = array();
        $infoStatus = false;
        if(isset($groupInfo['name']) && strlen($groupInfo['name'])<50){
            $group['name'] = $groupInfo['name'];
            $infoStatus = true;
        }
        
        if ($infoStatus){
            $id = parent::insert("group", $group,true,false);
            return $id;
        }else{
            return $infoStatus;
        }
    }
    
    public function getGroupsByUid($uid){
        $table = parent::table("group");
        $sql = " SELECT * FROM `$table` WHERE `uid` = $uid ";
        
        $result = parent::fetch_all($sql);
        return $result;
    }
    
    public function getGroupById($gid){
        $table = parent::table("group");
        $sql = " SELECT * FROM `$table` WHERE `id` = $gid ";
        $result = parent::fetch_first($sql);
        return $result;
    }
    
    public function getCidsByGid($gid){
        $table = parent::table("group_consumer");
        $sql = " SELECT * FROM `$table` WHERE `gid` = $gid ";
        $result = parent::fetch_all($sql);
        $cidArray = array();
        if(is_array($result) && count($result)>0){
            foreach ($result as $key => $value){
                $cidArray[] = $value['cid'];
            }
            return $cidArray;
        }else{
            return $cidArray;
        }
    }
    
    public function updateCountByGid($gid){
        $table = parent::table("group_consumer");
        $sql = " SELECT COUNT(*) AS `num` FROM `$table` WHERE `gid` = $gid ";
        $count = parent::fetch_first($sql);
        $amount = $count[num];
        
        $group =array();
        $group['count'] = $amount;
        parent::update("group", $group, " `id` = $gid ");
    }
    
    public function addConsumerToGroup($cid, $gid){
        $couple = array();
        $couple['cid'] = $cid;
        $couple['gid'] = $gid;
        $couple['gid_cid'] = $gid."_".$cid;
        
        $id = parent::insert("group_consumer", $couple, true, true);
        return $id;
    }
    
    public function countUser($uid = 0){
        if ($uid != 0){
            $where = " WHERE `uid` = $uid ";
        }else{
            $where = " WHERE 1 ";
        }
        
        $sql = " SELECT COUNT(*) AS `count` FROM `crm_consumer` $where ";
        $count = parent::fetch_first($sql);
        if(isset($count['count'])){
            return $count['count'];
        }else{
            return 0;
        }
    }
    
}