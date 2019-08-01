<?php
//外呼管理
class admin_outbound extends STpl
{
    //内容管理列表
    public function pageContent($inPath)
    {
        return $this->render("admin/outboundManagement_content.html");
    }
//内容管理新建
    public function pageConNew($inPath)
    {
        return $this->render("admin/outboundManagement_ConNew.html");
    }
    //内容管理编辑
    public function pageConEdit($inPath)
    {
        return $this->render("admin/outboundManagement_ConEdit.html");
    }

    //投放管理列表
    public function pageDelList($inPath)
    {
        return $this->render("admin/outboundManagement_DelList.html");
    }
    //投放管理新建
    public function pageDelNew($inPath)
    {
        return $this->render("admin/outboundManagement_DelNew.html");
    }
    //投放管理编辑
    public function pageDelEdit($inPath)
    {
        return $this->render("admin/outboundManagement_DelEdit.html");
    }
}
?>