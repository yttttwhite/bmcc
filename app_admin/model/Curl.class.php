<?php
class model_Curl{
    public static function curl($url, $data = "", $config = array())
    {
        $CH = curl_init();
        
        // 设置CURL参数
        $curlOption = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => array(
                'Accept-Language: zh-cn',
                'Connection: Keep-Alive',
                'Cache-Control: no-cache'
            ),
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.79 Safari/537.1",
            CURLOPT_MAXREDIRS => 99,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,
            //HTTPS
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        );
        
        //应用配置
        if(isset($config['followLocation'])){
            $curlOption[CURLOPT_FOLLOWLOCATION] = $config['followLocation'];
        }else{
            $curlOption[CURLOPT_REFERER] = true;
        }
        if (isset($config['reffer'])) {
            $curlOption[CURLOPT_REFERER] = $config['reffer'];
        }
        if (isset($config['cookie'])) {
            $curlOption [CURLOPT_COOKIEJAR] = $config['cookie'];
            $curlOption [CURLOPT_COOKIEFILE] = $config['cookie'];
        }
        
        //应用数据
        if(is_array($data)){
            $curlOption[CURLOPT_POST] = count($data);
            $curlOption[CURLOPT_POSTFIELDS] = $data;
        }elseif(strlen($data) > 0){
            $curlOption[CURLOPT_POST] = count($data);
            $curlOption[CURLOPT_POSTFIELDS] = $data;
        }
        curl_setopt_array($CH, $curlOption);
    
        
        $response = curl_exec($CH);
        $header = curl_getinfo($CH);
        if (curl_errno($CH)) {
            $currentTime = date("Y-m-d H:i:s", time());
            $errorMsg = $currentTime . "\r\tCURL 请求出错：\r\t" . $url;
            $errorMsg .= "\r\n";
            $errorMsg .= curl_error($CH);
            $error = array();
            $error['code'] = 0;
            $error['msg'] = $errorMsg;
            return $error;
        }
        curl_close($CH);
        if ($curlOption[CURLOPT_FOLLOWLOCATION] === false) {
            return $header;
        } else {
            return $response;
        }
    }
}