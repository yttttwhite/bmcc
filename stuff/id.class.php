<?php
if(!function_exists("hex2bin")){
	function hex2bin($hexstr){ 
		$n = strlen($hexstr); 
		$sbin="";   
		$i=0; 
		while($i<$n) 
		{       
			$a =substr($hexstr,$i,2);           
			$c = pack("H*",$a); 
			if ($i==0){$sbin=$c;} 
			else {$sbin.=$c;} 
			$i+=2; 
		} 
		return $sbin; 
	} 
}
class stuff_id{
	/**
	 * 上传文件，返回文件ID
	 */
	public static function encodeID($uid,$play_status){
		$time=time();
		$rand=rand(1,10000000);
		$r = @bin2hex(@pack("LLLL",$time,$uid,$play_status,$rand));
		return $r;
	}
	public static function decodeID($r){
		if(strlen($r)<=4)return false;
		$r = @unpack("Ltime/Luid/Lplay_status/Lrand",@hex2bin($r));
		return $r;
	}
	public static function upload($file,$uid,$play_status){
		$id = self::encodeID($uid,$play_status);
		$r  = self::decodeID($id);

		$path = "/data/stuff/".date("Ymd",$r['time']);
		@mkdir($path,0777,true);
		$filename = $path."/".$id;
		if(copy($file,$filename)){;
			//return $id;
			return 'stuff/'.date('Ymd',$r['time']).'/'.$id;
		}else{
			return false;
		}
	}
}
