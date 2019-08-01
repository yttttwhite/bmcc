<?php
function listFile($dir, $listdir = false, $start = 0, $end = 100000) {
    $error = 0;
    if (is_dir ( $dir )) {
        $fileList = array ();
        $dirHandle = opendir ( $dir );
        if (( bool ) $dirHandle) {
            $i = 1;
            while ( ($file = readdir ( $dirHandle ))!==false ) {
                if ($file != "." && $file != "..") {
                    if(  strpos ( $file, "." ) || $listdir ){
                        if ($i >= $start && $i <= $end) {
                            $fileList [] = $file;
                        }
                        $i ++;
                    }
                }
            }
            closedir ( $dirHandle );
            return $fileList;
        } else {
            $error = "open failed!";
        }
    } else {
        $error = $dir . "is not a Directory or I do'not have authority";
    }
    if ($error) {
        return false;
    }
}

$dir = 'bg-random/';
$files = listFile($dir);
if(isset($_GET['debug'])){
    print_r($files);
    $date = date("Ymd",time());
    echo $date;
    exit();
}
if(is_array($files)){
    $date = date("Ymd",time());
    if(in_array($date.".jpg", $files)){
        $image = $date.".jpg";
    }elseif(in_array('main.jpg', $files)){
        $image = "main.jpg";
    }else{
        $key = array_rand($files);
        $image = $files[$key];
    }
    
    $expiretime = 60;
    
    list($width, $height, $type, $attr) = getimagesize($image);
    header( 'Access-Control-Allow-Origin:*' );
    header("content-type:".image_type_to_mime_type($type));
    header("Pragma:private");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()) . " GMT");
    header("Expires: " . gmdate("D, d M Y H:i:s", time()+$expiretime) . " GMT");
    header("Cache-Control: max-age=" . "$expiretime");
    readfile("bg-random/".$image);
    
    //$imgUrl = 'https://cdn.yanglihui.cn/image/bg-random/'.$image;
    //header('Location:'.$imgUrl);
}else{
    echo "";
}