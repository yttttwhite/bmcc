<?php
class model_CrmNumberAuth extends discuz_database{
    public $table = "number_auth";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
    }

    public function addData($data, $condition=0){
        if(!is_numeric($condition)&&$condition!=0){
            $exist = $this->getData($condition);
            if(is_array($exist)&&count($exist)>0){
                return -1;
            }
        }
        $id = parent::insert($this->table, $data, true, false);
        return $id;
    }
    public function updateData($data,$condition = 0){
        if(is_numeric($condition) && $condition==0){
            return 0;
        }else{
            $count = parent::update($this->table, $data, $condition);
            return $count;
        }
    }
    public function deleteData($condition = 0){
        if(is_numeric($condition) && $condition==0){
            return 0;
        }else{
            $count = parent::delete($this->table, $condition);
            return $count;
        }
    }
    public function getData($condition=0, $start=0, $limit=0, $order=0, $orderType="ASC"){
        if($condition == 0 || count($condition)==0){
            $condition = " WHERE 1 ";
        }else{
            $condition = parent::implode($condition, "AND");
            $condition = " WHERE $condition ";
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
        $result = parent::fetch_all($sql);
        return($result);
    }
}