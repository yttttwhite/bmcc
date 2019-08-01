<?php
class model_CrmCreativeInfo extends discuz_database{
    public $table = "creative_info";
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
        $table = parent::table($this->table);
        $sql = "SELECT * FROM `$table` $condition $order $limit ";
        $result = parent::fetch_all($sql);
        return($result);
    }
}