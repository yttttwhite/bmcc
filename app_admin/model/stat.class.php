<?php
class model_stat{
    public static $conn;
    public static $db;
    public static $collection;
    
    function __construct(){
        $mongo = SConfig::getConfig(ROOT_CONFIG."/mongo.conf","stat_mongo");
        self::$conn = new MongoClient("mongodb://{$mongo->host}:{$mongo->port}");
        self::$db = self::$conn->selectDB($mongo->database);
    }
    
    public function init($mogoName){
        self::$collection = self::$db->selectCollection($mogoName);
    }
    
    public function getCollectionNames(){
        return self::$db->getCollectionNames();
    }
    
    private function updateFlag(){
        $flag = "true";
        $time = time();
        $condition = array('command'=>'dpc_update_flag');
        $data = array();
        $data['command'] = 'dpc_update_flag';
        $data['keyword'] = $flag;
        $data['value'] = "$time";
        $data['uptime'] = $time;
        $count = $this->getCount($condition);
        if($count < 1){
            $result = self::addData($data);
        }else{
            $result = self::$collection->update($condition,$data);
        }
                    
                    
        return $result;
    }
    
    public function getData($condition, $start = 0 , $limit = 50, $order=0){
        if($limit==0){
            if(!is_array($order)){
                $result = self::$collection->find($condition);
            }else{
                $result = self::$collection->find($condition)->sort($order);
            }
        }else{
            if(!is_array($order)){
                $result = self::$collection->find($condition)->skip($start)->limit($limit);
            }else{
                $result = self::$collection->find($condition)->skip($start)->limit($limit)->sort($order);
            }
        }
        
        $result = $this->toArray($result);
        return $result;
    }
    
    public function getCount($condition){
        $result = self::$collection->find($condition)->count();
        return $result;
    }
    
    public function addData($data, $condition=0){
        if(is_array($condition)){
            $result = $this->getData($condition);
            if(count($result)>0){
                return -2;
            }
        }
        $result = self::$collection->insert($data);
        self::updateFlag();
        return $result;
    }
    
    public function deleteData($condition){
        if(is_array($condition) && count($condition)>0){
            $result = self::$collection->remove($condition);
            self::updateFlag();
            return $result;
        }else{
            return -1;
        }
    }
    
    public function toArray($mongoCursor){
        $mongoArray = iterator_to_array($mongoCursor);
        return $mongoArray;
    }

}