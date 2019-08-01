<?php
class model_Model extends discuz_database{
    public $table;
    public function __construct($table){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
        $this->table = $table;
    }
    
    public function addData($data, $condition=0){
        if(is_array($condition) && count($condition)>0){
            $count = $this->getCount($condition);
            if($count>0){
                return -1;
            }
        }
        $id = parent::insert($this->table, $data, true, false);
        return $id;
    }
    public function updateData($data,$condition = 0){
        if(is_array($condition) && count($condition)>0){
            $count = parent::update($this->table, $data, $condition);
            return $count;
        }else{
            return 0;
        }
    }
    public function deleteData($condition = 0){
        if(is_array($condition) && count($condition)>0){
            $count = parent::delete($this->table, $condition);
            return $count;
        }else{
            return 0;
        }
    }
    public function getData($condition=0, $start='', $limit='', $order='', $orderType="ASC"){
        $where = " WHERE 1 ";
        if($condition==0 || empty($condition)){
            unset($where);
            unset($condition);
        }
        if(is_array($condition) && count($condition)>0){
            $condition = parent::implode($condition, "AND");
            $where .= " AND $condition ";
        }else{
            $where .= $condition;
        }
        if(strlen($start)>0 && strlen($limit)>0 && is_numeric($start) && is_numeric($limit)){
            $limit = parent::limit($start,$limit);
        }else{
            $limit = "";
        }
        
        if(strlen($order)>0){
            if($orderType == 1 || strtolower($orderType) === 'desc'){
                $orderType = 'DESC';
            }else{
                $orderType = 'ASC';
            }
            $order = parent::order($order,$orderType);
            $order = " ORDER BY $order ";
        }else{
            $order = "";
        }
        
        $table = parent::table($this->table);
        $sql = "SELECT * FROM `$table` $where $order $limit ";
        $result = parent::fetch_all($sql);
        return($result);
    }
    
    public function getCount($condition='',$like=''){
        $where = " WHERE 1 ";
        if(is_array($condition) && count($condition)>0){
            $condition = parent::implode($condition, "AND");
            $where .= " AND $condition ";
        }
        
        if(is_array($like) && count($like)>0){
            $likeArray = array();
            foreach ($like as $key=>$value){
                $likeStr = parent::field($key, $value,'like');
                $likeArray[] = $likeStr;
            }
            $like = implode(' AND ', $likeArray);
            $where .= $like;
        }
        
        $table = parent::table($this->table);
        $sql = "SELECT COUNT(*) AS `count` FROM `$table` $where ";
        $result = parent::fetch_all($sql);
        $count = $result[0]['count'];
        return ($count);
    }
    
    public function getDataLike($condition=0,$like='', $start='', $limit='', $order='', $orderType="ASC"){
        $where = " WHERE 1 ";
        if(is_array($condition) && count($condition)>0){
            $condition = parent::implode($condition, "AND");
            $where .= " AND $condition ";
        }
    
        if(is_array($like) && count($like)>0){
            $likeArray = array();
            foreach ($like as $key=>$value){
                $likeStr = parent::field($key, $value,'like');
                $likeArray[] = $likeStr;
            }
            $like = implode(' AND ', $likeArray);
            $where .= " AND $like ";
        }
    
        if(strlen($start)>0 && strlen($limit)>0 && is_numeric($start) && is_numeric($limit)){
            $limit = parent::limit($start,$limit);
        }else{
            $limit = "";
        }
    
        if(strlen($order)>0){
            if($orderType == 1 || strtolower($orderType) === 'desc'){
                $orderType = 'DESC';
            }else{
                $orderType = 'ASC';
            }
            $order = parent::order($order,$orderType);
            $order = " ORDER BY $order ";
        }else{
            $order = "";
        }
    
        $table = parent::table($this->table);
        $sql = "SELECT * FROM `$table` $where $order $limit ";
        //echo  $sql;
        $result = parent::fetch_all($sql);
        return($result);
    }

    /**
    *通过当前用户ID查找子运营商,客户经理，广告主账号
     *
     */
    public function getSubCarriers($userId,$userRoleId,$operateRole){
        if($operateRole==1000 || $operateRole==10000){
            if($userId >0){
                $where = " WHERE account_status=1 AND creator_id=$userId AND role_id= $userRoleId";
            }else{
                $where = " WHERE account_status=1 AND role_id=$userRoleId";
            }
        }elseif($operateRole <1000 && $userId >0){
            $where = " WHERE account_status=1 AND creator_id=$userId AND role_id= $userRoleId";
        }else{
            $where = " WHERE account_status=1 AND role_id= $userRoleId";
        }
      
         $table = parent::table($this->table);
        $sql = "SELECT * FROM `$table` $where";
        $result = parent::fetch_all($sql);
        return($result);
    }

}
