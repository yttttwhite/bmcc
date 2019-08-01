<?php
class dc_db{
    public static function InitDB($dbname="adp") {
        $db = new SDb();
		$db->useConfig($dbname);
        return $db;
    }
	/**
	 * 获取用户
	 * */
	public static function listUsers($condi,$Page=1,$Limit=-1){
		foreach($condi as $k=>$v){
		if(empty($v))unset($condi[$k]);
		}
		$table=array("adp_user_info");
		$db = self::InitDB();
		$db->setPage($Page);
		$db->setLimit($Limit);
		return $db->select($table,$condi);
	}
	public static function listPlans($condi,$Page=1,$Limit=-1){
		foreach($condi as $k=>$v){
		if(empty($v))unset($condi[$k]);
		}
		$table=array("adp_plan_info");
		$db = self::InitDB();
		$db->setPage($Page);
		$db->setLimit($Limit);
		return $db->select($table,$condi);
	}
	public static function listGroups($condi,$Page=1,$Limit=-1){
		foreach($condi as $k=>$v){
		if(empty($v))unset($condi[$k]);
		}
		$table=array("adp_group_info");
		$db = self::InitDB();
		$db->setPage($Page);
		$db->setLimit($Limit);
		return $db->select($table,$condi);
	}
	public static function listAds($condi,$Page=1,$Limit=-1){
		foreach($condi as $k=>$v){
		if(empty($v))unset($condi[$k]);
		}
		$condi[]="adp_ad_info.adid=adp_stuff_info.adid";
		$table=array("adp_ad_info","adp_stuff_info");
		$db = self::InitDB();
		$db->setPage($Page);
		$db->setLimit($Limit);
		return $db->select($table,$condi);
	}
}

