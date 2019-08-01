<?php
class dpc_dpc{
    public static $conn;
    public static $db;
    public static $collection;
    
    function __construct(){
        $mongo = SConfig::getConfig(ROOT_CONFIG."/mongo.conf","dpc_mongo");
        self::$conn=new Mongo("mongodb://{$mongo->host}:{$mongo->port}");
        self::$db= self::$conn->selectDB($mongo->database);
    
    }
    
    private function updateFlag($collection,$flag = "true"){
        $time = time();
        $r = self::$collection->update(
                    array('command'=>'dpc_update_flag'),
                    array('command' => 'dpc_update_flag','keyword' => $flag,"value"=>"$time",'uptime' => $time)
                    );
        return $r;
    }

    public function getHostGroupByGid($dbName = 0, $gid = 0, $limit = 50){
        if($gid === 0 || $dbName === 0){
            return 0;
        }else{
            $condition = array();
            $condition['command'] = 'website_group';
            
            if($gid !== "all"){
                $condition['group_id'] = (string)$gid;
            }
    
            self::$collection = self::$db->selectCollection($dbName);
            if($limit == 0){
                $result = self::$collection->find($condition);
            }else{
                $sort = array("group_id"=>1);
                $result = self::$collection->find($condition)->limit($limit)->sort($sort);
            }
            foreach ($result as $item){
                $arrayResult[$item['group_id']] = $item;
            }
            return $arrayResult;
        }
    }
    
    public function addHostGroup($dbName = 0, $groupInfo = 0){
        if(is_array($groupInfo) && isset($groupInfo['group_id']) && $dbName !== 0){
            $groupInfo['command'] = 'website_group';
            $groupInfo['status'] = 'start';
            $groupInfo['uptime'] = time();
            $groupInfo['user'] = user_api::name();
            $groupInfo['group_id'] = (string)$groupInfo['group_id'];
            if(isset($groupInfo['max_push_times']) && is_numeric($groupInfo['max_push_times'])){
                if($groupInfo['max_push_times']<0){
                    $groupInfo['max_push_times'] = (string)0;
                }elseif($groupInfo['max_push_times'] > 255){
                    $groupInfo['max_push_times'] = (string)255;
                }else{
                    $groupInfo['max_push_times'] = (string)$groupInfo['max_push_times'];
                }
            }else{
                $groupInfo['max_push_times'] = (string)0;
            }
            
            self::$collection = self::$db->selectCollection($dbName);
            $result = self::$collection->insert($groupInfo);
            $this->updateFlag(self::$collection);
            return $result;
        }else{
            return 0;
        }
    }
    
    public function updateHostGroup($dbName = 0, $condition ,$groupInfo = 0){
        self::$collection = self::$db->selectCollection($dbName);
        if(is_array($condition) && isset($condition['group_id'])){
            $condition['group_id'] = (string)$condition['group_id'];
            $groupInfo['group_id'] = $condition['group_id'];
            
            if(isset($groupInfo['max_push_times']) && is_numeric($groupInfo['max_push_times'])){
                if($groupInfo['max_push_times']<0){
                    $groupInfo['max_push_times'] = (string)0;
                }elseif($groupInfo['max_push_times'] > 255){
                    $groupInfo['max_push_times'] = (string)255;
                }else{
                    $groupInfo['max_push_times'] = (string)$groupInfo['max_push_times'];
                }
            }else{
                $groupInfo['max_push_times'] = (string)0;
            }
            
            if(isset($groupInfo['status']) && $groupInfo['status'] === "stop"){
                $groupInfo['status'] = 'stop';
            }else{
                $groupInfo['status'] = 'start';
            }
            
            $groupInfo['command'] = 'website_group';
            $condition['command'] = 'website_group';
            self::$collection->update($condition, $groupInfo);
            $this->updateFlag(self::$collection);
        }
    }
    
    public function changeHostGroupStatusByGid($dbName=0, $gid=0, $status = 0){
        self::$collection = self::$db->selectCollection($dbName);
        if($gid === 0 || $dbName === 0){
            return 0;
        }
        
        if($status !== "stop"){
            $status = "start";
        }
        
        $hostGroupArray = $this->getHostByGid($dbName,$gid);
        $hostGroup = $hostGroupArray[$gid];
        $hostGroup['status'] = $status;
        $condition['group_id'] = $gid;
        
        $this->updateHostGroup($dbName,$condition,$hostGroup);
    }
    
    public function deleteHostGroupByGid($dbName = 0, $gid = 0){
        self::$collection = self::$db->selectCollection($dbName);
        if($gid === 0 || $dbName === 0){
            return 0;
        }else{
            $condition = array();
            $condition['command'] = 'website_group';
            if($gid !== "all"){
                $condition['group_id'] = (string)$gid;
                $result = self::$collection->remove($condition);
            }else{
                for($tmp = 2; $tmp < 40; $tmp++){
                    $condition['group_id'] = (string)$tmp;
                    $result = self::$collection->remove($condition);
                }
            }
            $this->updateFlag(self::$collection);
            return $result;
        }
    }

    public function getHostByGid($dbName = 0, $gid = 0, $skip = 0 , $limit = 50){
        if($gid === 0 || $dbName === 0){
            return 0;
        }else{
            $condition = array();
            $condition['command'] = 'js_ad_group';
            $condition['group_id'] = (string)$gid;
            
            self::$collection = self::$db->selectCollection($dbName);
            if($limit == 0){
                $result = self::$collection->find($condition);
            }else{
                $sort = array("uptime"=>-1);
                $result = self::$collection->find($condition)->skip($skip)->limit($limit)->sort($sort);
            }
            foreach ($result as $item){
                $arrayResult[] = $item;
            }
            return $arrayResult;
        }
    }
    
    public function getCountByGid($dbName = 0, $gid = 0){
        if($gid === 0 || $dbName === 0){
            return 0;
        }else{
            $condition = array();
            $condition['command'] = 'js_ad_group';
            $condition['group_id'] = (string)$gid;
        
            self::$collection = self::$db->selectCollection($dbName);
            $result = self::$collection->find($condition)->count();
            return $result;
        }
    }
    
    public function addHost($dbName = 0, $hostInfo = 0){
        if(is_array($hostInfo) && isset($hostInfo['group_id']) && $dbName !== 0){
            $hostInfo['group_id'] = (string)$hostInfo['group_id'];
            $hostInfo['command'] = 'js_ad_group';
            $hostInfo['uptime'] = time();
            $hostInfo['user'] = user_api::name();
        
            self::$collection = self::$db->selectCollection($dbName);
            $result = self::$collection->insert($hostInfo);
            $this->updateFlag(self::$collection);
            return $result;
        }else{
            return 0;
        }
    }
    
    public function updateHost($dbName = 0, $hostInfo = 0){
        if(is_array($hostInfo) && isset($hostInfo['group_id']) && $dbName !== 0){
            $hostInfo['group_id'] = (string)$hostInfo['group_id'];
            $hostInfo['command'] = 'js_ad_group';
            $hostInfo['uptime'] = time();
            $hostInfo['user'] = user_api::name();
        
            $condition = array('url'=>$hostInfo['url']);
            
            self::$collection = self::$db->selectCollection($dbName);
            $result = self::$collection->update($condition,$hostInfo);
            $this->updateFlag(self::$collection);
            return $result;
        }else{
            return 0;
        }
    }
    
    public function deleteHost($dbName = 0, $url = 0, $type = "url"){
        if($url === 0 || $dbName === 0){
            return 0;
        }else{
            $condition = array();
            $condition['command'] = 'js_ad_group';
            if($url !== "all"){
                if($type === "url_sha1"){
                    $condition['url_sha1'] = $url;
                }else{
                    $condition['url'] = $url;
                }
            }
            self::$collection = self::$db->selectCollection($dbName);
            $result = self::$collection->remove($condition);
            $this->updateFlag(self::$collection);
            return $result;
        }
    }
    
    public function deleteHostByGid($dbName = 0, $gid = 0){
        if($gid < 2 || $dbName === 0){
            return 0;
        }else{
            $condition = array();
            $condition['command'] = 'js_ad_group';
            $condition['group_id'] = $gid;
            self::$collection = self::$db->selectCollection($dbName);
            $result = self::$collection->remove($condition);
            $this->updateFlag(self::$collection);
            return $result;
        }
    }
    
    public function getHost($dbName = 0, $url, $type = "url"){
        $arrayResult = array();
        $condition = array();
        $condition['command'] = 'js_ad_group';
        
        if($type === "url_sha1"){
            $condition['url_sha1'] = $url;
        }else{
            $condition['url'] = $url;
        }
        
        self::$collection = self::$db->selectCollection($dbName);
        $result = self::$collection->find($condition);
        
        foreach ($result as $item){
            $arrayResult[] = $item;
        }
        return ($arrayResult);
    }
}