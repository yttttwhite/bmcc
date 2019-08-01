<?php

$html = <<<EOF
<!DOCTYPE html> <html> <head> <meta charset="utf-8"> <meta https-equiv="X-UA-Compatible" content="IE=edge, chrome=1"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <style type="text/css"> body {text-align: center; } body, button, input, select, textarea {font: 14px/1.5 'Microsoft Yahei',\5FAE\8F6F\96C5\9ED1,SimSun,\5b8b\4f53,tahoma,arial,verdana; } body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, p, blockquote, th, td, hr, article, aside, details, figcaption, figure, footer, header, menu, nav, section {margin: 0; padding: 0; } input, select, textarea {font-size: 100%; } html {color: #000; background: #fff; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; } .medium, .text-medium {font-size: 14px; } p {margin-bottom: 5px; line-height: 200%; } p {padding: 0; word-break: break-all; word-wrap: break-word; } .search-submit {color: #fff; border: 1px solid #0e90d2; background: #0e90d2; -moz-border-radius: 0; -webkit-border-radius: 0; border-radius: 0; color: #fff; font-size: 16px; font-weight: normal; text-decoration: none; cursor: pointer; font-family: "Microsoft Yahei",arial,tahoma,sans-serif,\5B8B\4F53; line-height: 100%; vertical-align: middle; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; -o-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; height: 34px; padding: 0; margin: 0; width: 80px; } </style> </head> <body> <div id="jbjs"> <form id="form1" name="form1" method="post" action=""> <p class="p medium">请输入要进行解码的号码（一行一个）：</p> <textarea name="src" id="src" cols="80" rows="6" style="width:99%;height:120px;margin-bottom: 10px;"></textarea> <p class="p tcenter"> <input onclick="doDecode();" type="button" value="解码" name="decode" class="search-submit"> <input type="reset" value="清空" name="coderemot" class="search-submit"> </p> <p class="p medium">解码结果：</p> <textarea name="dest" id="dest" cols="80" rows="6" style="width:99%;height:120px;"></textarea> </form> </div> <script type="text/javascript"> var src = document.getElementById('src'); var dest = document.getElementById('dest'); function doDecode(){var s = src.value; if(typeof s == 'string'&& s.trim() != "" ){remoteDecode(s, function(data){dest.value = data; console.log(data); }); }else{return; } } function remoteDecode(data, cb){var xhr; if(window.XMLHttpRequest){xhr=new XMLHttpRequest(); if(xhr.overrideMimeType){xhr.overrideMimeType("text/xml"); }; }else if(window.ActiveXObject){var activeName=["MSXML2.XMLHTTP","Microsoft.XMLHTTP"]; for(var i=0;i<activeName.length;i++){try{xhr=new ActiveXObject(activeName[i]); break; }catch(e){} } }; if (! xhr){ return alert('浏览器不支持 XMLHttpRequest');} xhr.open('post', '#', true); xhr.onerr = function(err){alert('解码出错！');}; xhr.onload = function(data){if( xhr.status == 200 ){var responseText=xhr.responseText; return cb? cb(responseText): ''; } }; xhr.send( data ); } </script> </body> </html>
EOF;
if($_SERVER['REQUEST_METHOD']=='GET'){
    echo $html;exit;
}elseif ($_SERVER['REQUEST_METHOD']=='POST') {
    if(true){
        $MAX_LINE = 10000 * 10;
        $fp = fopen("php://input", "r");
        while (!feof($fp)) {
            if(!$MAX_LINE--) break;
            $value = trim(fgets($fp));
            if($value=="") continue;
            $res[] = decode($value);
        }
        echo join($res, "\n");
    }
}



/**
 * 加密手机号码算法
 *
 * @param string $md5           
 * @return string
 */
function decode($md5) {
    $md5 = strtoupper ( md5( 'bj86' . $md5 ) );
    $code = array (
            1 => "A",
            3 => "8",
            7 => "E",
            8 => "0",
            13 => "D",
            19 => "1",
            23 => "B",
            30 => "9" 
    );
    $res = "";
    $len = strlen ( $md5 );
    for($i = 0; $i < $len; $i ++) {
        $res .= $md5 [$i];
        if (array_key_exists ( $i, $code ))
            $res .= $code [$i];
    }
    return $res;
}
