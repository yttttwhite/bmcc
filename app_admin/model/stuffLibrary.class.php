<?php
//用户表：adp_stuff_Library
class model_stuffLibrary extends model_Model{
    public $table = "stuff_library";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
        parent::__construct($this->table);
    }
}