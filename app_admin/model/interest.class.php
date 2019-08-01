<?php
class model_interest extends discuz_database{
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
    }
    
    //通过pid获取标签
    public function getTagsByPid($pid, $assoc = false){
        $table = discuzDB::table('interest');
        if($pid === "all"){
            $sql = " SELECT `back_inte_id` as `tid`,`parent_id` as `pid`, `name` as `tname`, `level` FROM $table ORDER BY `back_inte_id`  ";
        }else{
            $sql = " SELECT `back_inte_id` as `tid`,`parent_id` as `pid`, `name` as `tname`, `level` FROM $table WHERE `parent_id`='$pid' ORDER BY `back_inte_id` ";
        }
        $result = discuzDB::fetch_all($sql);
        
        if ($assoc){
            $tag = array();
            foreach ($result as $temp){
                $tag[$temp['tid']] = $temp;
            }
        }else{
            $tag = $result;
        }
        return($tag);
    }
    
    //获取某一级别标签
    public function getTagsByLevel($level = 1, $assoc = false){
        $table = discuzDB::table('interest');
        if($level === "all"){
            $sql = " SELECT `back_inte_id` as `tid`,`parent_id` as `pid`, `name` as `tname`, `level` FROM $table ORDER BY `pid`  ";
        }else{
            $sql = " SELECT `back_inte_id` as `tid`,`parent_id` as `pid`, `name` as `tname`, `level` FROM $table WHERE `level`='$level' ORDER BY `pid` ";
        }
        $result = discuzDB::fetch_all($sql);
    
        if ($assoc){
            $tag = array();
            foreach ($result as $temp){
                $tag[$temp['tid']] = $temp;
            }
        }else{
            $tag = $result;
        }
        return($tag);
    }
}