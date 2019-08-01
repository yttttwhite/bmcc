<?php
class pager_api{
	static function toData($response){
		$data = new DbData;
		$data->page = $response->pageNumber;
        if (empty($data->page)){
            $data->page = 1;
        }
		if(!empty($response->pageSize)){
		    $data->totalPage = ceil($response->totalSize/$response->pageSize);
		}
		return $data;
	}
	static function page(DbData $result,$url){
		$p ='<!--turnpage start-->';
		$p.='<div class="turnpage">';
		$p.='<a href="'.htmlspecialchars(self::_getUrl(1,$url)).'"><em>&lt;</em> 首页</a>';
		if($result->page>4){
			$p.='<span>...</span>';
		}
		for($i=$result->page-3;$i<$result->page; $i++){
			if($i>0)$p.='<a href="'.htmlspecialchars(self::_getUrl($i,$url)).'"><em>'.$i.'</em></a>';
		}
		$p.='<a href="'.htmlspecialchars(self::_getUrl($result->page,$url)).'"><em><b>'.$result->page.'</b></em></a>';
		for($j=$result->page+1;$j<=$result->totalPage and $j<$result->page+3;$j++){
			$p.='<a href="'.htmlspecialchars(self::_getUrl($j,$url)).'"><em>'.$j.'</em></a>';
		}
		if($result->totalPage>=$result->page+3){
			$p.='<span>...</span>';
		}
		$p.='<a href="'.htmlspecialchars(self::_getUrl($result->totalPage,$url)).'">末页<em> &gt;</em></a>';
		$p.='</div>';
		$p.='<!--turnpage end-->';
		return $p;

	}
	static private function _getUrl($page,$url){
		return str_replace("%p",$page,$url);
	}

}
/*
   <!--turnpage start-->
   <div class="turnpage">
   <a href="#"><em>&lt;</em> 上一页</a>
   <a href="#">1</a>
   <a href="#">2</a>
   <a href="#">3</a>
   <a href="#">4</a>
   <a href="#">5</a>
   <span>...</span>
   <a href="#">65</a>
   <a href="#">下一页 <em>&gt;</em></a>
   </div>
   <!--turnpage end-->
 */
