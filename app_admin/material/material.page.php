<?php

class material_material extends STpl
{
//素材管理列表 start
public function pageList($inPath)
{
    return $this->render("material/material_List.html");
}
//素材管理列表 end
//素材新建 start
    public function pageNew($inPath)
    {
        return $this->render("material/material_New.html");
    }
//素材新建 end
//素材编辑start
    public function pageEdit($inPath)
    {
        return $this->render("material/material_Edit.html");
    }
//素材编辑end
//素材管理审核通过 start
    public function pageAudited($inPath)
    {
        return $this->render("material/material_Audited.html");
    }
//素材管理审核通过 end
//素材管理审核未通过 start
    public function pageUnaudit($inPath)
    {
        return $this->render("material/material_Unaudit.html");
    }
//素材管理审核未通过 end
}