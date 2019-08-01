<?php
header('Access-Control-Allow-Origin: *');
class api_mongo extends STpl{
    public $mongoModel;
	public function __construct($inPath){
		$config = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'version');
	}
	public function pageDecode(){
	    $str = $_GET['str'];
	    $type = $_GET['type'];
	    switch ($type) {
	        case 'base64':
	           echo "base64:";
	           echo base64_decode($str);
	        break;
	        
	        case 'dene':
	           echo "dene:";
	           echo $this->decodeDene($str, "monkey");
	        break;
	        
	        default:
	        echo "input error";
	        break;
	    }
	}
	public function pageUpdateUserConfig(){
	    if(isset($_POST['web_id']) && isset($_POST['showtime'])){
	        $showTime = $_POST['showtime'];
	        $netId = $_POST['web_id'];
	        
	        $netId = $this->decodeDene($netId, "monkey");
	        
	        if($showTime == 1){
	            $this->addToBlack($netId);
	        }elseif(is_numeric($showTime) && $showTime>1){
	            $this->deleteFromWhite($netId);
	        }
	    }
	}
	private function initMongo($mongoName){
	    $this->mongoModel = new model_Mongo();
	    $this->mongoModel->init($mongoName);
	}
	
	private function deleteFromWhite($netId){
	    $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'mongo');
	    $dpcMongo = $config['dpc'];
	    $this->initMongo($dpcMongo);
	    
	    $condition = array();
	    $condition['command'] = 'adsl_config';
	    $condition['keyword'] = $netId;
	    $condition['value'] = "2";
	    echo $this->mongoModel->deleteData($condition);
	    $data = array();
	    $data = $condition;
	    $data['value'] = '3';
	    $data['uptime'] = time();
	    $data['author'] = "system";
	    echo $this->mongoModel->addData($data);
	}
	private function addToBlack($netId){
	    $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'mongo');
	    $dpcMongo = $config['dpc'];
	    $this->initMongo($dpcMongo);
	    
	    $data = array();
	    $data['command'] = "adsl_config";
	    $data['value'] = "1";
	    $data['keyword'] = $netId;
	    $condition = $data;
	    
	    $data['uptime'] = time();
	    $data['author'] = "system";
	    
	    echo $this->mongoModel->addData($data,$condition);
	}
	
	//s1= decodeDene("nbda10003899", "monkey")
	private function decodeDene($data, $key){
	    $out = "";
	    $data= base64_decode($data);
	    while (strlen($key) < strlen($data)){
	        $key .= $key;
	    }
	    for($i = 0; $i<strlen($data); $i++){
	        $out .= chr(ord($data[$i]) ^ ord($key[$i]));
	    }
	    return $out;
	}
}