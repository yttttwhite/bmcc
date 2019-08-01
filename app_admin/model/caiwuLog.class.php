<?php
//用户表：adp_caiwu_log
class model_caiwuLog extends model_Model{
    public $table = "caiwu_log";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
        parent::__construct($this->table);
    }
    public function getHistoryChargeByUid($uid){
        $condition = array();
        $condition['target_uid'] = $uid;
        $condition['operate_code'] = 1;//recharge
        $data = parent::getData($condition,0,-1);
        $historyCharge = 0;
        foreach($data as $item){
            $historyCharge += $item['operate_num'];
        }
        return $historyCharge;
    }
}
