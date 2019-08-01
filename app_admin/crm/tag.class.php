<?php
class crm_tag{
    public $uid;
    public function __construct(){
        $this->uid = user_api::id();
        if($this->uid == 0){
            exit("尚未登录");
        }
    }
    
    public function getTag(){
        $table = discuzDB::table('tag_2');
        $sql = " SELECT * FROM $table ";
        $result = discuzDB::fetch_all($sql);
        $tagArray = array();
        foreach ($result as $tagInfo){
            $tagArray[$tagInfo['tid']] = $tagInfo;
        }
        foreach ($tagArray as $key=>$tag){
            if ($tag['pid'] > 900){
                $tag['rid'] = $tagArray[$tag['pid']]['pid'];
                $tag['rname'] = $tagArray[$tag['pid']]['pname'];
            }else{
                $tag['rid'] = $tag['pid'];
                $tag['rname'] = $tag['pname'];
            }
            $tagArray[$key] = $tag;
        }
        return ($tagArray);
    }
    
    public function getTag_old(){
        $table = discuzDB::table('tag_2');
        $sql = " SELECT * FROM $table ";
        $result = discuzDB::fetch_all($sql);
        $tagArray = array();
        foreach ($result as $tagInfo){
            $tagArray[$tagInfo['tid']] = $tagInfo;
        }
        foreach ($tagArray as $key=>$tag){
            $tag['pname'] = $tagArray[$tag['pid']]['name'];
            if ($tag['pid'] > 100){
                $tag['rid'] = $tagArray[$tag['pid']]['pid'];
                $tag['rname'] = $tagArray[$tag['rid']]['name'];
            }else{
                $tag['rid'] = $tag['pid'];
                $tag['rname'] = $tagArray[$tag['rid']]['name'];
            }
            $tagArray[$key] = $tag;
        }
        return ($tagArray);
    }
    
    public function getTagsByUid($uid, $type = 0){
        $tag = $this->getTag();
        
        $table = discuzDB::table('user_tag');
        if($type !== 0){
            $sql = " SELECT *, SUM(`weight`) as `weight_sum`, COUNT(*) as `count` FROM $table WHERE `uid` = '$uid' AND `uid_type` = '$type' GROUP BY `tid` ORDER BY `weight_sum` DESC  ";
        }else{
            $sql = " SELECT *, SUM(`weight`) as `weight_sum`, COUNT(*) as `count` FROM $table WHERE `uid` = '$uid' GROUP BY `tid` ORDER BY `weight_sum` DESC ";
        }
        $result = discuzDB::fetch_all($sql);
        if (is_array($result) && count($result)>0){
            foreach ($result as $key => $value){
                $result[$key]['pid'] = $tag[$value['tid']]['pid'];
                $result[$key]['tname'] = $tag[$value['tid']]['tname'];
                $result[$key]['pname'] = $tag[$value['tid']]['pname'];
                $result[$key]['rid'] = $tag[$value['tid']]['rid'];
                $result[$key]['rname'] = $tag[$value['tid']]['rname'];
            
                $rid[$key] = $result[$key]['rid'];
                $pid[$key] = $result[$key]['pid'];
                $tid[$key] = $result[$key]['tid'];
            }
            array_multisort($rid,$pid,$tid,$result);
            return ($result);
        }else{
            return false;
        }
    }
    
    public function addUserTag($userTag){
        discuzDB::insert('user_tag', $userTag);
    }
    
    public function getUsersByTag($tag,$uid = 0){
        $userTable = discuzDB::table('consumer');
        $userTagTable = discuzDB::table('user_tag');
        
        $select  = " SELECT `$userTable`.`uid` , `$userTable`.`mobile` , `$userTable`.`mobile` , `$userTagTable`.`uid` AS 'key' , `$userTagTable`.`tid`";
        $from    = " FROM `crm_consumer` INNER JOIN `$userTagTable` ON `$userTable`.`mobile` = `$userTagTable`.`uid` ";
        $where   = " WHERE `$userTable`.`uid` = $uid ";
        if(is_array($tag)){
            foreach ($tag as $tagId){
                $where   .= " AND `$userTagTable`.`tid` = '$tagId' ";
            }
        }else{
            $where   .= " AND `$userTagTable`.`tid` = '$tag' ";
        }
        
        $limit = " LIMIT 0 , 30 ";
        
        $sql = $select.$from.$where.$limit;
        
        $result = discuzDB::fetch_all($sql);
        return $result;
    }
    
    public function getTagsStat($uid){
        $userTable = discuzDB::table('consumer');
        $userTagTable = discuzDB::table('user_tag');
        
        $sql = "SELECT `tid`, count( * ) AS `count`  FROM `$userTagTable` GROUP BY `tid`  ORDER BY `count` DESC  LIMIT 20  ";
        $sql = "SELECT `$userTagTable`.`tid`, count( * ) AS `count`  FROM `$userTagTable` GROUP BY `tid`  ORDER BY `count` DESC  LIMIT 20  ";
        
        $select     = " SELECT `$userTagTable`.`tid`, count( * ) AS `count` ";
        $from       = " FROM `$userTable` INNER JOIN `$userTagTable` ON `$userTable`.`mobile` = `$userTagTable`.`uid` ";
        $where      = " WHERE `$userTable`.`uid` = '$uid' ";
        $sql        = $select.$from.$where."  GROUP BY `tid`  ORDER BY `count` DESC  LIMIT 20 ";
        echo $sql;
        $result = discuzDB::fetch_all($sql);
        return $result;
    }
    
    public function getTagReport($uid = 0,$rid = 0,$order = 'count',$limit = 50){
        if($rid == 1){
            $group = "pid";
            $order = " ORDER BY `pid` ASC ";
        }else{
            $group = "tid";
            $order = " ORDER BY `$order` DESC ";
        }
        
        if($uid != 0){
            $where = " WHERE `crm_consumer`.`uid` = '$uid' ";
        }else{
            $where = " WHERE 1 ";
        }
        if($rid != 0){
            $ridStart = ($rid)*1000;
            $ridEnd = ($rid+1)*1000;
            $where .= " AND `crm_user_tag`.`pid` > $ridStart AND `crm_user_tag`.`pid` < $ridEnd ";
        }
        
        $select = " SELECT `crm_user_tag`.`tid`,SUM(`weight`) AS `weight_sum`, count(  DISTINCT `crm_user_tag`.`uid`  ) AS `count` ";
        $from = " FROM `crm_consumer` INNER JOIN `crm_user_tag` ON `crm_consumer`.`mobile` = `crm_user_tag`.`uid` ";
        
        $sql = $select.$from.$where." GROUP BY `crm_user_tag`.`$group` ".$order." LIMIT 0,$limit ";
        $result = discuzDB::fetch_all($sql);
        return ($result);
    }
    
    public function getTagWeightSumByUid($uid = 0,$rid = 0){
        if($uid != 0){
            $where = " WHERE `crm_consumer`.`uid` = '$uid' ";
        }else{
            $where = " WHERE 1 ";
        }
        if($rid != 0){
            $ridStart = ($rid)*1000;
            $ridEnd = ($rid+1)*1000;
            $where .= " AND `crm_user_tag`.`pid` > $ridStart AND `crm_user_tag`.`pid` < $ridEnd ";
        }
        
        $sql = "
        SELECT SUM(`weight`) AS `weight_sum`
        FROM `crm_consumer` INNER JOIN `crm_user_tag` ON `crm_consumer`.`mobile` = `crm_user_tag`.`uid`
        ".$where;
        $result = discuzDB::fetch_all($sql);
        if(isset($result[0]['weight_sum'])){
            $weightSum = $result[0]['weight_sum'];
        }else{
            $weightSum = 1;
        }
        return $weightSum;
    }
    
    public function countUserByTag($uid = 0, $tid = 0, $mode = "and"){
        if($uid != 0){
            $where = " WHERE `crm_consumer`.`uid` = $uid ";
            $from = " FROM `crm_consumer` INNER JOIN `crm_user_tag` ON `crm_consumer`.`mobile` = `crm_user_tag`.`uid` ";
        }else{
            $where = " WHERE 1 ";
            $from = " FROM `crm_user_tag` ";
        }
        
        $tid = array(20160005,20280008);
        
        if($tid != 0 && is_numeric($tid)){
            $where .= " AND `crm_user_tag`.`tid` = $tid ";
        }elseif($tid != 0 && is_array($tid)){
            if($mode === "or"){
                $tid = implode(",", $tid);
                $where .= " AND `crm_user_tag`.`tid` in ( $tid ) ";
            }else{
                foreach ($tid as $id){
                    $where .= " AND `crm_user_tag`.`tid` = $id ";
                }
            }
        }
        
        $select = " SELECT `crm_user_tag`.`tid` , COUNT( DISTINCT `crm_user_tag`.`uid` ) AS `count` ";
        $group = " GROUP BY `crm_user_tag`.`tid` ";
        $order = " ORDER BY `count` DESC ";
        $sql = $select.$from.$where.$group.$order;
        echo $sql;
        $result = discuzDB::fetch_all($sql);
        if(is_array($result) && count($result)>0){
            foreach ($result as $count){
                $tagCount[$count['tid']] = $count['count'];
            }
        }
        print_r($result);
        return $tagCount;
    }
    
}