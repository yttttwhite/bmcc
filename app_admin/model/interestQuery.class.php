<?php
class model_interestQuery extends discuz_database{
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
    }
    
    public function addInterestQuery($data){
        $table = 'interest_query';
        $id = parent::insert($table, $data, true);
        return $id;
    }
    
    public function getQueryListByUid($uid = 0){
        if($uid == 0){
            $uid = user_api::id();
        }
        $table = parent::table('interest_query');
        $sql = " SELECT * FROM `$table` WHERE `uid`=$uid ORDER BY `id` DESC ";
        $result = parent::fetch_all($sql);
        return $result;
    }
    public function getQueryDetailById($id = 0){
        if($id != 0){
            $table = parent::table('interest_query');
            $sql = " SELECT * FROM `$table` WHERE `id`=$id ORDER BY `id` DESC ";
            $result = parent::fetch_all($sql);
            return $result;
        }
    }
}