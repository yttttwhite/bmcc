<?php
class model_group extends discuz_database{
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
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