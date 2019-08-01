<?php
class crm_word extends STpl{
    public $forbiddenWordModel;
    public function __construct($inPath){
        user_api::getUserByName(user_api::name());
        if(user_api::id()==0){
            header("location:/baichuan_advertisement_manage/user");
        }else{
        }
        $this->init();
    }
    public function init(){
        $this->forbiddenWordModel = new model_CrmForbiddenWord();
    }
    public function pageEntry(){
        $this->pageList();
    }
    
    //号码库管理
    public function pageLeft(){
        return $this->render("number/left.html");
    }
    public function pageList(){
        $condition = array();
        if(isset($_GET['key']) && strlen($_GET['key'])>0){
            $condition['word'] = urldecode($_GET['key']);
        }
        $wordList = $this->forbiddenWordModel->getData($condition);
        $this->assign("list",$wordList);
        $this->assign("get",$_GET);
        return $this->render("crm/word_list.html");
    }
    public function pageAddIframe(){
        $url['formAction'] = "/crm.word.save";
        $this->assign('url',$url);
        $this->assign('get',$_GET);
        return $this->render("/crm/word_add_iframe.html");
    }
    public function pageSave(){
        if(isset($_POST['wordStr']) && strlen($_POST['wordStr'])>0){
            $wordStr = $_POST['wordStr'];
    
            $wordStr = str_ireplace(array("\r\n","\r","+","-"," ","\t",",","，","&",":","：",";","；","(",")","（","）"), "\n", $wordStr);
            $wordList = explode("\n", $wordStr);
            $addResult = array();
    
            foreach ($wordList as $word){
                if(strlen($word)>0){
                    $condition = array();
                    $data =array();
    
                    $data['word'] = $word;
                    $data['creator_id'] = user_api::id();
                    $data['creator_name'] = user_api::name();
                    $data['ctime'] = time();
    
                    $condition['word'] = $word;
    
                    $result = $this->forbiddenWordModel->addData($data,$condition);
                    if($result < 0){
                        $addResult['exist'][] = $data['word'];
                    }else{
                        $addResult['success'][] = $data['word'];
                    }
                }
            }
            $this->assign('addResult',$addResult);
            return $this->render("/crm/word_add_result.html");
        }else{
            $this->parentReload("参数错误，即将刷新");
        }
    }
    
    public function pageImportIframe(){
        $url['formAction'] = "/crm.word.import";
        $this->assign('url',$url);
        $this->assign('get',$_GET);
        return $this->render("/crm/word_import_iframe.html");
    }
    public function pageImport(){
        if (in_array($_FILES["wordList"]["type"], array("text/plain")) && ($_FILES["file"]["size"] < 200000)){
            if ($_FILES["wordList"]["error"] > 0){
                echo "Error: " . $_FILES["wordList"]["error"] . "<br />";
                $this->parentReload("请检查文件","/",3);
            }else{
                $file = $_FILES["wordList"]["tmp_name"];
                $wordStr = file_get_contents($file);
                $wordStr = str_ireplace(array("\r\n","\r","+","-"," ","\t",",","，","&",":","：",";","；","(",")","（","）"), "\n", $wordStr);
                $wordList = explode("\n", $wordStr);
                
                $addResult = array();
                foreach ($wordList as $word){
                    if(strlen($word)>0){
                        $condition = array();
                        $data =array();
                
                        $data['word'] = $word;
                        $data['creator_id'] = user_api::id();
                        $data['creator_name'] = user_api::name();
                        $data['ctime'] = time();
                
                        $condition['word'] = $word;
                
                        $result = $this->forbiddenWordModel->addData($data,$condition);
                        if($result < 0){
                            $addResult['exist'][] = $data['word'];
                        }else{
                            $addResult['success'][] = $data['word'];
                        }
                    }
                }
                $this->assign('addResult',$addResult);
                return $this->render("/crm/word_add_result.html");
            }
        }else{
            $this->parentReload("参数错误，即将刷新");
        }
    }
    public function pageUpdateIframe(){
        if(isset($_GET['id'])){
            $url['formAction'] = "/crm.word.updateSave";
            $this->assign('url',$url);
            $this->assign('get',$_GET);
            return $this->render("/crm/word_update_iframe.html");
        }else{
            $this->parentReload("参数错误，即将刷新");
        }
    }
    public function pageUpdateSave(){
        if(isset($_POST['id']) && isset($_POST['word'])){
            $condition = array();
            $condition['id'] = $_POST['id'];
            $date = array();
            $data['word'] = $_POST['word'];
            $this->forbiddenWordModel->updateData($data,$condition);
            $this->parentReload("修改成功");
        }else{
            $this->parentReload("参数错误，即将刷新");
        }
    }
    
    public function pageDelete(){
        if(isset($_GET['id']) && strlen($_GET['id'])>0){
            $condition = array();
            $condition['id'] = $_GET['id'];
    
            $count = $this->forbiddenWordModel->deleteData($condition);
            if($count>0){
                echo "删除成功";
            }else{
                echo "删除失败";
            }
        }else{
            echo "删除失败";
        }
    }
    
    public function pageCheck(){
        if(isset($_POST['str'])){
            $str = urldecode($_POST['str']);;
        }elseif(isset($_GET['str'])){
            $str = urldecode($_GET['str']);
        }
        
        $wordList = $this->forbiddenWordModel->getData();
        $forbidden = array();
        foreach ($wordList as $word){
            if(stripos($str, $word['word'])!==false){
                $forbidden[] = $word['word'];
            }
        }
        $response = array();
        $response['count'] = count($forbidden);
        $response['words'] = implode("、", $forbidden);
        echo json_encode($response);
    }
    
    public function check($str){
        $wordList = $this->forbiddenWordModel->getData();
        $forbidden = array();
        foreach ($wordList as $word){
            if(stripos($str, $word['word'])!==false){
                $forbidden[] = $word['word'];
            }
        }
        if(count($forbidden)>0){
            return false;
        }else{
            return true;
        }
    }
}
