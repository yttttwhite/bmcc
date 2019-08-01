<?php
class media_main extends STpl{
	public function __construct($inPath){
	   if(!user_api::auth("media")){
            $this->success("没有权限",'/user',3);
            exit();
       }
	}
	public function pageEntry($inPath){
		$page=!empty($_REQUEST['page']) ? $_REQUEST['page'] :1 ;
		$cat =!empty($_REQUEST['cat']) ? $_REQUEST['cat'] :"" ;
		$s=!empty($_REQUEST['size']) ? $_REQUEST['size'] :"" ;
		$key=!empty($_REQUEST['key']) ? addslashes($_REQUEST['key']) :"" ;
		$condi=array("size"=>$s,"category"=>$cat);
		if(!empty($key)){
			$condi[]="web_name like '%$key%'";
		}
		//$condi['uid']=user_api::id();
		$r= media_db::listMedia($condi,$page);
		if(!empty($r)){
			//取出所有分类
			$cats=array();
			$type=array();
			$size=array();
			foreach($r->items as $item){
				$k=$item['category'];
				$cats[$k]="";
				$k=$item['size'];
				$size[$k]="";
				$k=$item['type'];
				$type[$k]="";
			}
			$pager = pager_api::page($r,"?page=%p&cat=$cat&size=$s");
			$this->assign("pager",$pager);
		}

		$this->assign("medias",$r);
		$this->assign("size",$size);
		$this->assign("key",$key);
		$this->assign("type",$type);
		$this->assign("cats",$cats);
		return $this->render("v2/meiti/index.html");
	}
	public function pageAdd($inPath){
		$categorys	= media_db::listMediaCategory();
		$locations	= media_db::listMediaLocation();
		$types		= media_db::listMediaType();
		$media=array();
		$media_id=0;
		if(!empty($inPath[3])){
			$media_id = $inPath[3];
			$media = media_db::getMedia($media_id);
			if(empty($media) || $media['uid']!=user_api::id()){
				die("参数错误");
			}
		}
		$fields = array("id","web_name","size","domain_name","category","type","location");
		if(!empty($_POST['web_name'])){//名称是必须的
			if(!empty($media)){//修改
				foreach($media as $k=>$v){
				    if(in_array($k, $fields)){
					   if(isset($_POST[$k]))$media[$k]=$_POST[$k];
				    }
				}
				$r = media_db::updateMedia($media_id,$media);
				if($r){
					$this->assign("result","修改成功");
				}else{
					$this->assign("result","修改失败");
				}
			}else{//新增
				foreach($_POST as $k=>$v){
				    if(in_array($k, $fields)){
				        $media[$k]=$_POST[$k];
				    }
				}
				//$media['uid']=user_api::id();
				$media_id = media_db::addMedia($media);
				if($media_id){
					$media['id']=$media_id;
					$this->assign("result","新增成功");
					$media = media_db::getMedia($media_id);
				}else{
					$this->assign("result","新增失败");
				}
			}
		}
		$this->assign("media_id",$media_id);
		$this->assign("media",$media);
		$this->assign("categorys",$categorys);
		$this->assign("locations",$locations);
		$this->assign("types",$types);
		return $this->render("v2/meiti/mt_new.html");
	}
	public function pageNav($inPath){
		if(!empty($inPath[3])){
			$this->assign("nav",$inPath[3]);
		}
		if(!empty($inPath[4])){
			$this->assign("nav_sub",$inPath[4]);
		}
		return $this->render("v2/meiti/nav.tpl");
	}
}
