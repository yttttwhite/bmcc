<?php
class model_lib{
    public static function getDomain($url){
        $topTLD = array("com","net","org","co","gov","edu","biz","info","name");
        $host = self::getHost($url);
        if($host !== false){
            if( filter_var($host,FILTER_VALIDATE_IP)){
                //如果域名时IP，不处理
                return $host;
            }else{
                $domain = explode(".", $host);
                $temp = $domain[count($domain)-2];
                if(in_array($temp, $topTLD)){
                    $mainDomain = $domain[count($domain)-3].".".$domain[count($domain)-2].".".$domain[count($domain)-1];
                }else{
                    $mainDomain = $domain[count($domain)-2].".".$domain[count($domain)-1];
                }
                return $mainDomain;
            }
        }else{
            return false;
        }
    }
    public static function getHost($url){
        if(stripos($url, '://') === false){
            $url = 'https://'.$url;
        }
        $urlInfo = parse_url($url);
        if(isset($urlInfo['host']) && strlen($urlInfo['host'])>0){
            $host = $urlInfo['host'];
            return $host;
        }else {
            return false;
        }
    }
}