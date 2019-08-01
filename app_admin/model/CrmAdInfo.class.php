<?php
class model_CrmAdInfo extends discuz_database{
    public $table = "ad_info";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
    }

    public function addData($data)
    {
        $id = parent::insert($this->table, $data, true, false);
        return $id;
    }
    public function getData($condition=0, $start=0, $limit=0, $order=0, $orderType="ASC")
    {
        if($condition !== 0){
            $condition = parent::implode($condition, "AND");
            $condition = " WHERE $condition ";
        }else{
            $condition = " WHERE 1 ";
        }
        if($limit !== 0){
            $limit = parent::limit($start,$limit);
        }else{
            $limit = "";
        }
        
        if($order !== 0){
            $order = parent::order($order,$orderType);
            $order = " ORDER BY $order ";
        }else{
            $order = "";
        }
        $table = parent::table($this->table);
        $sql = "SELECT * FROM `$table` $condition $order $limit ";
        echo $sql;
        $result = parent::fetch_all($sql);
        return($result);
    }
    public function getAdInfo($condition=0, $start=0, $limit=0, $order=0, $orderType="ASC")
    {
        $table = parent::table($this->table);
        $creativeTable = parent::table("creative_info");
        $join = " LEFT JOIN `$creativeTable` ON `$table`.`creative_id` = `$creativeTable`.`creative_id` ";
        
        if($condition !== 0){
            $condition = parent::implode($condition, "AND");
            $condition = " WHERE $condition ";
        }else{
            $condition = " WHERE = 1 ";
        }
        if($limit !== 0){
            $limit = parent::limit($start,$limit);
        }else{
            $limit = "";
        }
        
        if($order !== 0){
            $order = parent::order($order,$orderType);
            $order = " ORDER BY $order ";
        }else{
            $order = "";
        }
        
        $sql = "SELECT * FROM `$table` $join $condition $order $limit ";
        $result = parent::fetch_all($sql);
        return($result);
    }
    public function deleteData($condition = 0){
        if(is_numeric($condition) && $condition==0){
            return 0;
        }else{
            $count = parent::delete($this->table, $condition);
            return $count;
        }
    }
    
    public function updateData($data,$condition = 0){
        if(is_numeric($condition) && $condition==0){
            return 0;
        }else{
            $count = parent::update($this->table, $data, $condition);
            return $count;
        }
    }
}