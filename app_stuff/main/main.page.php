<?php
class main_main{
	public function pageShow($inPath){
		require_once(ROOT."/stuff/id.class.php");
		if(!empty($inPath[3])){
		    if($inPath[3] === 'stuffcache' && !empty($inPath[4])){
		        $id = $inPath[4];
		        $r = stuff_id::decodeid($id);
		        $path = "/data/stuff/".date("Ymd",$r['time'])."/".$id;
		        if(is_file($path)){
		            cache_page::set(60*60*24);
		            if($r['play_status'] != 2){
		                list($width, $height, $type, $attr) = getimagesize($path);
		                header("content-type:".image_type_to_mime_type($type));
		            }else{
		                header("Content-type: application/x-shockwave-flash");
		            }
		            readfile($path);
		        }
		    }else{
		        $id = $inPath[3];
		        $r = stuff_id::decodeid($id);
		        $path = "/data/stuff/".date("Ymd",$r['time'])."/".$id;
		        if(is_file($path)){
		            cache_page::set(60*60*24);
		            if($r['play_status'] != 2){
		                list($width, $height, $type, $attr) = getimagesize($path);
		                header("content-type:".image_type_to_mime_type($type));
		            }else{
		                header("Content-type: application/x-shockwave-flash");
		            }
		            readfile($path);
		        }
		    }
		}
	}

}