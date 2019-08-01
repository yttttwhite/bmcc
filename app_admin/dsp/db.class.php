<?php
/**
  status 0：可用 1：暂停 2：停止
  qps 0：不启用 -1：不限制 >0 设置好
  */
class dsp_db{
    public static function InitDB($dbname="dsp") {
        $db = new SDb();
		$db->useConfig($dbname);
        return $db;
    }
	public static function updateDSP($id,$DSP=array()){
		$table=array("dsp_info");
		$condi=array("dsp_id"=>$id);
		$db = self::InitDB();
		return $db->update($table,$condi,$DSP);
	}
	public static function addDSP($DSP=array()){
		$table=array("dsp_info");
		$db = self::InitDB();
		return $db->insert($table,$DSP);
	}
	public static function getDSP($id){
		$table=array("dsp_info");
		$condi=array("dsp_id"=>$id);
		$db = self::InitDB();
		$db->setPage($Page);
		$db->setLimit($Limit);
		return $db->selectOne($table,$condi);
	}
	public static function listDSP($uid=0,$page=1,$pageSize=-1){
		$table=array("dsp_info");
		if(!empty($uid)){
			$condi=array("uid"=>$uid);
		}else{
			$condi=array();
		}
		$db = self::InitDB();
		$db->setPage($Page);
		$db->setLimit($pageSize);
		return $db->select($table,$condi);
	}
	public static function updateDspCache($dsp_id){
		$ssp_main = new thrift_dsp_main;//主要用来加载自动的类
		$DSPInfo= new DSPInfo;
		$dsp= self::getDSP($dsp_id);
		if(!empty($dsp)){
			foreach($DSPInfo as $k=>$v){
				if(isset($dsp[$k]))$DSPInfo->$k=$dsp[$k];
			}
			$DSPInfo->token=$dsp['dsp_token'];
		}
		$table=array("dsp_info_cache");
		$db = self::InitDB();
		$Cache=array(
				"dsp_id"=>$dsp_id,
				"dsp_data"=>Thrift\Serializer\TBinarySerializer::serialize($DSPInfo),
				"_inserttime"=>date("Y-m-d H:i:s")
		);
		
		return $db->insert($table,$Cache,true);
	}
}
