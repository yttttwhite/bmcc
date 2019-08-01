<?php 
class admin_log{
    static public function TopUpLog($user,$old_account){
        $data=array();
        $data['time']       =date("Y-m-d H:i:s");
        $data['ip']         =SUtil::getIP();
        $data['uid']        =$user->uid;
        $data['username']   =$user->user_name;
        $data['old_account']   =$old_account;
        $data['new_account']   =$user->account;
        $pre_path="/data/logs/topup/";
        if(!is_dir($pre_path)) @mkdir($pre_path,0777,true);
        $path="/data/logs/topup/".date("Ymd");
        @mkdir($path,0777,true);
        $file=$path."/"."topup_".date("YmdH").".log";
        file_put_contents($file,implode("\x02",$data)."\r\n",FILE_APPEND|LOCK_EX );
    }
}
