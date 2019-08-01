<?php
header('Access-Control-Allow-Origin: *');
class api_sms extends STpl{
	public function __construct($inPath){
	   $this->init();
	}
	private function init(){
	    $appInfo = array(
	        'baichuan_crm'=>"YangLihui@tokyo-hot",
	    );
	    if(isset($_POST['app_key']) && isset($_POST['app_secret']) && isset($appInfo[$_POST['app_key']])){
	        if($appInfo[$_POST['app_key']] !== $_POST['app_secret']){
	            echo $this->setResponse(0, '用户错误');
	            exit();
	        }
	    }else{
	        echo $this->setResponse(0, '无效用户');
	        exit();
	    }
	}
	private static function setResponse($status, $msg, $data=0, $type = "json"){
	    $response = array();
	    $response['status'] = $status;
	    $response['msg'] = $msg;
	    $response['data'] = $data;
	
	    if($type === 'array'){
	        return $response;
	    }else{
	        $response = json_encode($response);
	        return $response;
	    }
	}
	private function checkNumber($number){
	    $preg = '/[^0-9]/';
	    preg_replace($preg, '', $number);
	    if(strlen($number)==11 || strlen($number)==13){
	        return true;
	    }else{
	        return false;
	    }
	}
	private function sendSms($numberList,$message){
	    $a=new thrift_sms_main;
	    $result = $a->send($numberList,$message);
	    return $result;
	}
	public function pageSend(){
	    $copy = 1;
	    /*
	     * 收件人格式
	     * $receiver[id] = number;
	     */
	    /*
	     * status说明
	     * 0:没有联系人； 1：成功； 2：无效号码； 3：接口错误。
	     */
	    $data = array();
	    $numberList = array();
	    $sendIdList = array();
	    
	    if(isset($_POST['receivers']) && isset($_POST['message'])){
	        if($copy){
	            $temp = array();
	            $temp[] = '13336009164';
	            $result = $this->sendSms($temp, $_POST['message']);
	        }
	        
	        if(strlen($_POST['message'])>0 && $_POST['message']<=560){
	            $receivers = json_decode($_POST['receivers'], true);
	            
	            if(is_array($receivers) && count($receivers)>0){
	                foreach ($receivers as $id=>$number){
	                    if( $this->checkNumber($number) ){
	                        $numberList[] = $number;
	                        $sendIdList[] = $id;
	                    }else{
	                        $data[$id] = 2;
	                    };
	                }
	                $message = $_POST['message'];
	                //$message = iconv('utf-8', 'ucs-2', $message);
	                //echo 'msg:'.iconv('ucs-2', 'utf-8', $message)."\r\n";
	                
	                if(1){
	                    $result = $this->sendSms($numberList, $message);
	                }else{
	                    $strLimit = 70;
	                    while (mb_strlen($message,'utf-8') > $strLimit ){
	                        $msg = mb_substr($message, 0, $strLimit, 'utf-8');
	                        $message = mb_substr($message, $strLimit, strlen($message), 'utf-8');
	                        $result = $this->sendSms($numberList, $msg);
	                        //sleep(5);
	                    }
	                    $result = $this->sendSms($numberList, $message);
	                }
	                
	                if($result != 1){
	                    $result = 3;
	                }
	                foreach ($sendIdList as $sendId){
	                    $data[$sendId] = $result;
	                }
	                echo $this->setResponse(1, '处理成功', $data);
	            }else{
	                echo $this->setResponse(0, '收件人格式错误');
	            }
	        }else{
	            echo $this->setResponse(0, '消息为空，或者大于280字符');
	        }
	    }else{
	        echo $this->setResponse(0, '参数不全');
	    }
	}
}