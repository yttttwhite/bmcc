<?php
function tpl_function_tostring($mixed){
	return var_export($mixed,true);
}
function tpl_function_part($path){
	return !empty($path)?SlightPHP::run($path):"";
}
function tpl_function_include($tpl){
	return Tpl::fetch($tpl);
}
function tpl_function_turnpager($total=1,$pagekey='pageNum'){
    $params = $_GET;
    unset($params['PATH_INFO']);
    $page = $params[$pagekey]? $params[$pagekey]:1;
    $params[$pagekey] = 1;
    $query_url = htmlentities(http_build_query($params));
    $outhtml = '<a href="?'.$query_url.'"><em>&lt;</em> 首页</a>';
    // 当前页的前后5页
    $minPage = $page-5; 
    $maxPage = $page+5;
    if($minPage<=1)     $maxPage -= $minPage;
    if($maxPage>=$total)    $minPage -= $maxPage-$total;
    if($minPage<=1)     $minPage = 1;
    if($maxPage>=$total)    $maxPage = $total;

    for ($i=$minPage; $i <= $maxPage; $i++) { 
        $params[$pagekey] = $i;
        $query_url = htmlentities(http_build_query($params));
        if($i==$page)
            $outhtml .= "<a class=\"bg-eee\" href=\"javascript: void(0)\"><b>{$i}</b></a>";
        else
            $outhtml .= "<a href=\"?$query_url\"><b>{$i}</b></a>";
    }

    $params[$pagekey] = $total;
    $query_url = htmlentities(http_build_query($params));
    $outhtml .= '<a href="?'.$query_url.'">末页<em> &gt;</em></a>';
    return $outhtml;
}
function tpl_function_tplvalexport(){
    return var_export(Tpl::$_tpl_vars,true);
}
