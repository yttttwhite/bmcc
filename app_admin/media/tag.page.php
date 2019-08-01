<?php

class media_tag extends STpl
{

    public function __construct($inPath)
    {
        /*
         * $exclude_arr = array("getwebsites","getpositions","getprice");
         * if(!user_api::auth("media")&& !in_array($inPath[2],$exclude_arr)){
         * $this->success("没有权限",'/user',3);
         * exit();
         * }
         */
    }

    /**
     * 广告位标签列表
     * 
     * @param unknown $inPath            
     */
    public function pageEntry($inPath)
    {
        $tagModel = new model_poTag();
        $data = $tagModel->getData();
        if ($data) {
            $tagList = $data;
        } else {
            $tagList = array();
        }
        //过滤数据
        foreach ($tagList as $key => $v) {
            if (isset($_GET['name']) && strlen($_GET['name']) > 0 && stripos(trim($v['tag_name']),trim($_GET['name'])) === false) {
                unset($tagList[$key]);
            }
        }
        // 分页处理
        $total = count($tagList);
        if ($_GET['pageNum']) {
            $pageNum = $_GET['pageNum'];
        } else {
            $pageNum = 1;
        }
        $pageSize = 30;
        if ($pageNum * $pageSize - 1 <= $total) {
            $start = ($pageNum - 1) * $pageSize;
            $end = $pageNum * $pageSize - 1;
        } else {
            $start = ($pageNum - 1) * $pageSize;
            $end = $total - 1;
        }
        $tagList = array_slice($tagList, $start, $pageSize);
        $totalPage = ceil($total / $pageSize);
        $this->assign("totalPage", $totalPage);
        $this->assign("pageNum", $pageNum);
        $this->assign("tagList", $tagList);
        return $this->render("v2/meiti/tag.html");
    }

    public function pageGet($inPath)
    {
        $slot_id = $inPath[3];
        $slot = media_db::getSlotCache($slot_id);
    }

    /**
     *
     * 广告位标签添加
     * 
     * @param unknown $inPath            
     * @return boolean
     */
    public function pageAdd($inPath)
    {
        $info = user_api::info();
        $data = array();
        $tag_id = 0;
        $tagModel = new model_poTag();
        if (! empty($inPath[3])) {
            $tag_id = $inPath[3];
            $condition = array();
            $condition['id'] = $tag_id;
            $tags = $tagModel->getData($condition, 0, - 1);
        }
	    if(isset($_POST['tag_name']))
        {
            if (! empty($tags)) { // 修改数据
                if (isset($_POST['tag_name'])) {
                    $data['tag_name'] = $_POST['tag_name'];
                } else {
                    return false;
                }
                /*if (isset($_POST['tag_ident'])) {
                    $data['tag_ident'] = $_POST['tag_ident'];
                } else {
                    return false;
                }*/
                $data['tag_ident'] = $_POST['tag_name'];
               /* if (isset($_POST['using_nums'])) {
                    $data['using_nums'] = $_POST['using_nums'];
                } else {
                    return false;
                }*/
                $data['using_nums'] = 0;
                if (isset($_POST['cpm_price'])) {
                    $data['cpm_price'] = $_POST['cpm_price'];
                } 
                if (isset($_POST['cpc_price'])) {
                    $data['cpc_price'] = $_POST['cpc_price'];
                } 
                if (isset($_POST['cpt_price'])) {
                    $data['cpt_price'] = $_POST['cpt_price'];
                } 
                $data['uid'] = $info->uid;
                $data['user_name'] = $info->user_name;
                $data['utime'] = time();
                $tas_up = $tagModel->updateData($data, $condition);
                /*****广告位标签变化时候，更改广告位的价格*****/
                $positionModel = new model_sspPosition();
                $conditionPo = array();
                $conditionPo['tag_identification'] = $_POST['tag_name'];
                $dataPo = array();
                $dataPo['cpm'] = $_POST['cpm_price'];
                $dataPo['cpc'] = $_POST['cpc_price'];
                $dataPo['cpt'] = $_POST['cpt_price'];
                $reUpdate = $positionModel->updateData($dataPo, $conditionPo);
                if(!$reUpdate){
                   // return false;
                }
                /***结束*************************/
                if ($tags_up >= 0) {
                    $this->assign("result", "修改成功");
                } else {
                    $this->assign("result", "修改失败");
                }
            } else {
                //添加数据
                if (isset($_POST['tag_name'])) {
                    $data['tag_name'] = $_POST['tag_name'];
                } else {
                    return false;
                }
                /*if (isset($_POST['tag_ident'])) {
                    $data['tag_ident'] = $_POST['tag_ident'];
                } else {
                    return false;
                }
                if (isset($_POST['using_nums'])) {
                    $data['using_nums'] = $_POST['using_nums'];
                } else {
                    return false;
                }*/
                $data['tag_ident'] = $_POST['tag_name'];
                $data['using_nums'] = 0;
                if (isset($_POST['cpm_price'])) {
                    $data['cpm_price'] = $_POST['cpm_price'];
                } 
                if (isset($_POST['cpc_price'])) {
                    $data['cpc_price'] = $_POST['cpc_price'];
                } 
                if (isset($_POST['cpt_price'])) {
                    $data['cpt_price'] = $_POST['cpt_price'];
                } 
                $data['uid'] = $info->uid;
                $data['user_name'] = $info->user_name;
                $data['ctime'] = time();
                $data['utime'] = time();
                $re = $tagModel->addData($data);
                if (!re) {
                    $this->assign("result", "添加失败");
                } else {
                    
                    $this->assign("result", "添加成功");
                }
            }
        }
        //编辑返回数据
        foreach($tags  as $k=>$v){
              $tags = $v;
        }
        //编辑数据返回
        if($re||$tas_up){
            $tags = $data;
        }
        $this->assign("tagsView", $tags);
        return $this->render("v2/meiti/tag_new.html");
    }


    public function pageNav($inPath)
    {
        if (! empty($inPath[3])) {
            $this->assign("nav", $inPath[3]);
        }
        if (! empty($inPath[4])) {
            $this->assign("nav_sub", $inPath[4]);
        }
        return $this->render("v2/meiti/nav.tpl");
    }
}
