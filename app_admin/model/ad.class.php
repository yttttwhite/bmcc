<?php
class model_ad{
    public static function InitDB() {
        $db = new SDb();
		$db->useConfig("adp");
        return $db;
    }
	public static function getStuffByAid($aid){
		$table=array("adp_ad_info","adp_stuff_info");
		$condi=array("adp_ad_info.adid"=>$aid,"adp_ad_info.adid=adp_stuff_info.adid");
		$db = self::InitDB();
		return self::InitDB()->selectOne($table,$condi);
	}

}

