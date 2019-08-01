<?php 
require 'SensitiveWordFilter.php';

/*
初始化传入词库文件路径，词库文件每个词一个换行符。
如：
敏感1
敏感2

目前只支持UTF-8编码
*/
$filter = new SensitiveWordFilter(__DIR__ . '/dict.txt');

/*
第一个参数传入要过滤的字符串，第二个是匹配的字间距，
比如'枪支'是一个敏感词，想过滤'枪||||支'的时候，
就需要指定一个两个字的间距，可以根据情况设定，
超过指定间距就不会过滤。所有匹配的敏感词会被替换为'*'。
*/
$_POST = array ( 'role_id' => '10000', 'account_provider' => '', 'account_manager' => '', 'user_name' => '见面交易', 'account_status' => '1', 'passwd' => '123456redis', 'passwd_again' => '123456redis', 'host' => '', 'cell_phone' => '', 'address' => '', 'colum2' => '', );
  if(!empty($_POST)){
            $word = $_POST;
            foreach ($word as $value) {
                $re = $filter->filter(trim($value), 5);
               // var_dump($re);
                if($re == false){
                    var_dump($value);
                }
                   //$this->success("您输入的有敏感词请检查后，再创建", "/admin.user.list") ;
                   //exit;
           // }
            }
            
        }
 //var_dump($re);
