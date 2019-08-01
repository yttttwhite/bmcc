<?php
class model_Mongo{
    public static $conn;
    public static $db;
    public static $collection;
    
    function __construct(){
        $mongo = SConfig::getConfig(ROOT_CONFIG."/mongo.conf","dpc_mongo");
        self::$conn = new MongoClient("mongodb://{$mongo->host}:{$mongo->port}");
        self::$db = self::$conn->selectDB($mongo->database);
    }
    
    public function init($mogoName){
        self::$collection = self::$db->selectCollection($mogoName);
    }
    
    public function getCollectionNames(){
        return self::$db->getCollectionNames();
    }
    
    private function updateFlag(){
        $flag = "true";
        $time = time();
        $condition = array('command'=>'dpc_update_flag');
        $data = array();
        $data['command'] = 'dpc_update_flag';
        $data['keyword'] = $flag;
        $data['value'] = "$time";
        $data['uptime'] = $time;
        $count = $this->getCount($condition);
        if($count < 1){
            $result = self::addData($data);
        }else{
            $result = self::$collection->update($condition,$data);
        }
                    
                    
        return $result;
    }
    
    public function getData($condition, $start = 0 , $limit = 50, $order=0){
        if($limit==0){
            if(!is_array($order)){
                $result = self::$collection->find($condition);
            }else{
                $result = self::$collection->find($condition)->sort($order);
            }
        }else{
            if(!is_array($order)){
                $result = self::$collection->find($condition)->skip($start)->limit($limit);
            }else{
                $result = self::$collection->find($condition)->skip($start)->limit($limit)->sort($order);
            }
        }
        
        $result = $this->toArray($result);
        return $result;
    }
    
    public function getCount($condition){
        $result = self::$collection->find($condition)->count();
        return $result;
    }
    
    public function addData($data, $condition=0){
        if(is_array($condition)){
            $result = $this->getData($condition);
            if(count($result)>0){
                return -2;
            }
        }
       //$data = self::useRemoveXSS($data);
        $result = self::$collection->insert($data);
        self::updateFlag();
        return $result;
    }
    
    public function deleteData($condition){
        if(is_array($condition) && count($condition)>0){
            $result = self::$collection->remove($condition);
            self::updateFlag();
            return $result;
        }else{
            return -1;
        }
    }
    
    public function toArray($mongoCursor){
        $mongoArray = iterator_to_array($mongoCursor);
        return $mongoArray;
    }
    //防止xss攻击
    public static function removeXSS($val) {
        // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
        // this prevents some character re-spacing such as <java\0script>
        // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
        $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
        // straight replacements, the user should never need these since they're normal characters
        // this prevents like <IMG SRC=@avascript:alert('XSS')>
        $search = 'abcdefghijklmnopqrstuvwxyz';
        $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $search .= '1234567890!@#$%^&*()';
        $search .= '~`";:?+/={}[]-_|\'\\';
        for ($i = 0; $i < strlen($search); $i++) {
            // ;? matches the ;, which is optional
            // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
    
            // @ @ search for the hex values
            $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
            // @ @ 0{0,7} matches '0' zero to seven times
            $val = preg_replace('/(�{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
        }
    
        // now the only remaining whitespace attacks are \t, \n, and \r
        $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
        $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $ra = array_merge($ra1, $ra2);
    
        $found = true; // keep replacing as long as the previous round replaced something
        while ($found == true) {
            $val_before = $val;
            for ($i = 0; $i < sizeof($ra); $i++) {
                $pattern = '/';
                for ($j = 0; $j < strlen($ra[$i]); $j++) {
                    if ($j > 0) {
                        $pattern .= '(';
                        $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                        $pattern .= '|';
                        $pattern .= '|(�{0,8}([9|10|13]);)';
                        $pattern .= ')*';
                    }
                    $pattern .= $ra[$i][$j];
                }
                $pattern .= '/i';
                $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
                $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
                if ($val_before == $val) {
                    // no replacements were made, so exit the loop
                    $found = false;
                }
            }
        }
        return $val;
    }
    
    //防注入
    public static function abacaAddslashes($var) {
        if (! get_magic_quotes_gpc ()) {
            if (is_array ( $var )) {
                foreach ( $var as $key => $val ) {
                    $var [$key] = abacaAddslashes ( $val );
                }
            } else {
                $var = addslashes ( $var );
            }
        }
        return $var;
    }
    //防止xss攻击
    public static  function useRemoveXSS($data){
        if(is_array($data)&&empty($data)){
            foreach($data as $k=>$v){
                $data[$k] = self::removeXSS($v);
            }
        }else{
            throw new \Exception("插入了不合法的数据");
        }
        return $data;
    }
    }
}