<?php
class model_ReportHostWhite extends discuz_database{
    public $table = "HostWhite";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
        $this->table = 'HostWhite';
    }
    
    public function getDataBySql($condition=0, $start="", $limit="", $order="", $orderType="ASC", $sql=""){
        $where = "WHERE 1 ";
        if(is_array($condition) && count($condition)>0)
        {
            $condition = parent::implode($condition,"AND");
            $where .= " AND $condition ";
        }

        if(strlen($sql)>0)
        {
            $where .= " AND ".$sql;
        }

        if(strlen($start)>0 && strlen($limit)>0 && is_numeric($start) && is_numeric($limit)){
            $limit = parent::limit($start,$limit);
        }else{
            $limit = "";
        }

        if(strlen($order)>0)
        {
            if($orderType == 1 || strtolower($orderType) === 'desc')
            {
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
        $sql = "SELECT Complaint_HostWhite.ID,Complaint_HostWhite.HostWhite,Complaint_HostWhite.PushDate,Complaint_HostWhite.Toppv,Adpv FROM `$table` $where $order $limit ";
        $result = parent::fetch_all($sql);
        return($result);
    }
}

?>