<?php
class audient_db{
    public static function InitDB() {
        $db = new SDb();
		$db->useConfig("rmc");
        return $db;
    }
	/**
	 * 获取受众人群
	 * */
	public static function listCrowd($uid,$website=0){
		$condi=array();
		$condi['user_id']=$uid;
		$condi[]="rmc_audience_website.id=rmc_audience_crowd.web_site_id";
		if(!empty($website)){$condi['web_site_id']=$website;}
		$table=array("rmc_audience_website","rmc_audience_crowd");
		//$db = self::InitDB();
		return self::InitDB()->select($table,$condi);
	}
	public static function listCrowdDefault(){
		$condi=array();
		$table=array("rmc_mp_media_default");
		//$db = self::InitDB();
		$data = self::InitDB()->select($table,$condi);
		foreach($data->items as $item){
            if($item['level'] > 2)
                continue;
			$id = $item['id'];
			if($item['parent_id']==0){
				$result[$id]['data']=$item;
			}else{
				$id = $item['parent_id'];
				$result[$id]['child'][]=$item;
			}
		}
		return ($result);
	}

	public static function GetCrowdPositionById($id){
        $condi=array();
        $condi['id'] = $id;
        $table=array("rmc_mp_media_position");        //$db = self::InitDB();
        $data = self::InitDB()->select($table,$condi);
        return ($data->items[0][name]);                                                                                              
    }

    public static function GetCrowdById($id){
        $condi=array();
        $condi['id'] = $id;
        $table=array("rmc_mp_media_default");        //$db = self::InitDB();
        $data = self::InitDB()->select($table,$condi);
        return ($data->items[0]);
    }

    public static function listCrowdPosition(){                                                                                      
        $condi=array();
        $table=array("rmc_mp_media_position");
        //$db = self::InitDB();
        $data = self::InitDB()->select($table,$condi);
        foreach($data->items as $item){
            if($item['level'] > 2)
                continue;
            $id = $item['id'];
            if($item['parent_id']==0){
                $result[$id]['data']=$item;
            }else{
                $id = $item['parent_id'];
                $result[$id]['child'][]=$item;
            }
        }
        return ($result);
    }

    /**
     * 获取人群定向新表
     *
     **/
    public static function listCrowdNew($page=1,$limit=-1,$hostname=""){
//        define("DEBUG",true);
        $db = self::InitDB();
        $db->setPage($page);
        $db->setLimit($limit);
        $keys = $db->execute("select * from cate_dict");
        $condi=array("cate_dict.cateid=host_cate.cateid");
        $table=array("cate_dict","host_cate");
        $res=new stdClass();
        $res=$db->select($table,$condi);
        $cate_host= array();
        foreach($keys as $key){
            foreach($res->items as $host){
                if($key['cateid'] == $host['cateid']){
                    $cate_host[$key['catename']][] = $host;
                }
            }
        }
        return $cate_host;
    }

    public static function get_user_tags() {
        $db = self::InitDB();
        $ret = $db->select("rmc_user_tag", array());
//var_dump($ret);
        return $ret;
    }
}
