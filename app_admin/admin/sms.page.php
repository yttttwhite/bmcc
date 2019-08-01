<?php
//短信管理
class admin_sms extends STpl
{
    //短信内容管理列表
    public function pageConList($inPath)
    {
        return $this->render("admin/smsManagement_ConList.html");
    }
    //短信内容管理新建
    public function pageConNew($inPath)
    {
        return $this->render("admin/smsManagement_ConNew.html");
    }
    //短信内容管理编辑
    public function pageConEdit($inPath)
    {
        return $this->render("admin/smsManagement_ConEdit.html");
    }
    //短信投放管理列表
    public function pageDelList($inPath)
    {
        return $this->render("admin/smsManagement_DelList.html");
    }
    //短信投放管理新建
    public function pageDelNew($inPath)
    {
        return $this->render("admin/smsManagement_DelNew.html");
    }
    //短信投放管理编辑
    public function pageDelEdit($inPath)
    {
        return $this->render("admin/smsManagement_DelEdit.html");
    }

}
?>