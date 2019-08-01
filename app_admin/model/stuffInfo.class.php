<?php
//用户表：adp_stuff_info
class model_stuffInfo extends model_Model{
    public $table = "stuff_info";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
        parent::__construct($this->table);
    }
}