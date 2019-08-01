<?php
header('Access-Control-Allow-Origin: *');
class api_stuff extends STpl{
	public function __construct($inPath){
		$config = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'version');
	}

	private function reArrayFiles(&$file_post) {
	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);
	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }
	    return $file_ary;
	}

	public function pageUpload(){
	    $access = false;
	    $result = array();
	    $auth = array(
	        'huangjia'=>md5('zhejiangdianxin@huangjia')
	        //'huangjia'=>'zhejiangdianxin@huangjia'
	    );

	    if(isset($_REQUEST['uid']) && isset($_REQUEST['authCode']) && isset($_REQUEST['authKey'])){
	        $userId = $_REQUEST['uid'];
	        if(isset($auth[$_REQUEST['authCode']]) && strtolower($auth[$_REQUEST['authCode']])===strtolower($_REQUEST['authKey'])){
	            $access = true;
	        }else{
	            $result['error'] = "没有权限";
	        }
	    }else{
	        $result['error'] = "缺少参数";
	    }

	    if($access && !empty($_FILES)){
	        $files = self::reArrayFiles($_FILES['stuff']);
	        $a = new thrift_adinfo_main;
	        $d = new thrift_stuffinfo_main;
	        foreach($files as $file){
	            if(!empty($file['error'])){
	                $upload_errors = array(
	                    UPLOAD_ERR_OK          => "No errors.",
	                    UPLOAD_ERR_INI_SIZE    => "Larger than upload_max_filesize.",
	                    UPLOAD_ERR_FORM_SIZE   => "Larger than form MAX_FILE_SIZE.",
	                    UPLOAD_ERR_PARTIAL     => "Partial upload.",
	                    UPLOAD_ERR_NO_FILE     => "No file.",
	                    UPLOAD_ERR_NO_TMP_DIR  => "No temporary directory.",
	                    UPLOAD_ERR_CANT_WRITE  => "写入文件失败，请检查权限或者磁盘是否已经满",
	                    UPLOAD_ERR_EXTENSION   => "File upload stopped by extension.",
	                    UPLOAD_ERR_EMPTY       => "File is empty." // add this to avoid an offset
	                );
	                $er = $file['error'];
	                $result['error']=@$upload_errors[$er];
	                return SJson::encode($result);
	            }else{
	                //对文件大小做限制，图片55K，flash 100K
	                $f_type=strtolower($file['type']);
	                if ($f_type== "image/gif" OR $f_type== "image/png" OR $f_type== "image/jpeg" OR $f_type== "image/gif"){
	                    if(filesize($file['tmp_name'])>300*1024){
	                        $result['error']="图片不能大于300K";
	                        return SJson::encode($result);
	                    }
	                }elseif($f_type=="application/x-shockwave-flash"){
	                    if(filesize($file['tmp_name'])>300*1024){
	                        $result['error']="Flash不能大于300K";
	                        return SJson::encode($result);
	                    }
	                }
	                if(empty($result['error']) && !empty($file['tmp_name'])){
	                    require_once(ROOT."/stuff/id.class.php");
	                    $file_object = new stuff_id;
	                    $file_id = $file_object->upload($file['tmp_name'],$userId,$_REQUEST['play_status']);
	                    if($file_id!==false){
	                        $host  = SConfig::getConfig(ROOT_CONFIG."/js.conf","host");
	                        $result['fileid']=$file_id;
	                        $result['fileurl'] = "https://".$host->stuff."/$file_id";;
	                    }else{
	                        $result['error']="上传文件失败v1";
	                        return SJson::encode($result);
	                    }
	                }else{
	                    $result['error']="上传文件失败v2";
	                    return SJson::encode($result);
	                }
	            }
	        }
	    }
	    if(isset($_REQUEST['response']) && $_REQUEST['response']==='array'){
	        print_r($result);
	    }else{
	        echo json_encode($result);
	    }
	}
}