<?php
//生成敏感词词典
require_once 'simpledict.php';
SimpleDict::make("dict.txt", "blackword.txt");
$dict = new SimpleDict("blackword.txt");
$result = $dict->search("台");
var_dump($result);

/* $result 的格式：
 array(
 'word1' => array('value' => 'value1', 'count' => 'count1'),
 ...
 )*/
?>