<!DOCTYPE html>
<html>
<head>
<title>查看合同详情[<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['contract_name'], ENT_QUOTES); ?>]</title>
<style>
    .scll{
    display:inline-block;
    width:320px;
    font-family:STXihei;
    font-size:16px;
    margin-left:20px;
}
    .hrll{
    border-top:2px solid gray; 
    margin-bottom:10px;
}
    .dvll{
    margin-bottom:10px;
    margin-left:10px;
    margin-right:10px;
}
</style>
</head>
<body>
    <div style="width:800px">
        <h3>• 合同信息</h3>
        <hr class="hrll">
        <div class="dvll">
            <span class="scll">合同类型：<?php if(Tpl::$_tpl_vars["contract"]['contract_type'] =='1'){; ?>竞价制广告合同<?php }elseif( Tpl::$_tpl_vars["contract"]['contract_type'] =='2'){; ?>合约制广告合同<?php }else{; ?>未知<?php }; ?></span>
        </div>
        <div class="dvll">
            <span class="scll">合同名称：<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['contract_name'], ENT_QUOTES); ?></span>
        </div>
        <div class="dvll">
            <span class="scll">合同序号：<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['contract_num'], ENT_QUOTES); ?></span>
        </div>
        <div class="dvll">
            <span class="scll">客户经理所属分公司：<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['company_name'], ENT_QUOTES); ?></span>
        </div>
        <div class="dvll">
            <span class="scll">客户经理姓名：<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['manager_name'], ENT_QUOTES); ?></span>
        </div>
        <div class="dvll">
            <span class="scll">客户经理联系电话：<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['manager_phone_number'], ENT_QUOTES); ?></span>
        </div>
        <div class="dvll">
            <span class="scll">客户公司名称：<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['contact_company_name'], ENT_QUOTES); ?></span>
        </div>
        <div class="dvll">
            <span class="scll">客户名称：<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['contact_person'], ENT_QUOTES); ?></span>
        </div>
        <div class="dvll">
            <span class="scll">客户联系电话：<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['contact_person_phone_number'], ENT_QUOTES); ?></span>
        </div>
        <div class="dvll">
            <span class="scll">客户CA：<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['contact_ca'], ENT_QUOTES); ?></span>
        </div>
        <div class="dvll">
            <span class="scll">折扣率：<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['discount_rate'], ENT_QUOTES); ?>%</span>
        </div>
        <div class="dvll">
            <span class="scll">合同折扣前金额：<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['total_budget'], ENT_QUOTES); ?> 元</span>
        </div>
        <div class="dvll">
            <span class="scll">花费金额：<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['used_budget'], ENT_QUOTES); ?> 元</span>
        </div>
        <div class="dvll">
            <span class="scll">剩余金额：<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['access_budget'], ENT_QUOTES); ?> 元</span>
        </div>

    </div>

    <div style="width:800px">
        <h3>• 广告单价信息</h3>
        <hr class="hrll">
        <?php foreach(Tpl::$_tpl_vars["ContractContent"] as Tpl::$_tpl_vars["Content"]){; ?>
        <div class="dvll">
            <span class="scll">广告单价：<?php echo htmlspecialchars(Tpl::$_tpl_vars["Content"]['price'], ENT_QUOTES); ?> 元</span>
            <span class="scll">购买量：<?php echo htmlspecialchars(Tpl::$_tpl_vars["Content"]['buy_amount'], ENT_QUOTES); ?></span>
            <span class="scll">单位：<?php if(Tpl::$_tpl_vars["Content"]['unit'] ==2){; ?>CPM<?php }else{; ?>CPT<?php }; ?></span>
            <span class="scll">剩余量：<?php echo htmlspecialchars(Tpl::$_tpl_vars["Content"]['access_budget'], ENT_QUOTES); ?></span>
        </div>

        <?php }; ?>
    </div>

    <div style="width:800px">
        <h3>• 审核情况</h3>
        <hr class="hrll">

        <div class="dvll">
            <span class="scll">审核状态：<?php if(Tpl::$_tpl_vars["contract"]['verify_status']==1){; ?>待审核<?php }elseif( Tpl::$_tpl_vars["contract"]['verify_status']==2){; ?>审核通过<?php }elseif( Tpl::$_tpl_vars["contract"]['verify_status']==3){; ?>退回修改<?php }; ?></span>
        </div>
        <!--审核通过的显示-->
        <?php if(Tpl::$_tpl_vars["contract"]['verify_status']==2){; ?>
        <div class="dvll">
            <span class="scll">审核人姓名：<?php echo htmlspecialchars(Tpl::$_tpl_vars["audit_person_info"]->user_name, ENT_QUOTES); ?></span>
        </div>
        <div class="dvll">
            <span class="scll">审核人电话：<?php echo htmlspecialchars(Tpl::$_tpl_vars["audit_person_info"]->cell_phone, ENT_QUOTES); ?></span>
        </div>
        <?php }; ?>

    </div>

    <div style="width:200px;height:38px;line-height:38px;background-color:green;color:white;margin:20px 150px 0px 150px; text-align:center;cursor:pointer" onclick="window.close();" >关闭</div>
</body>
</html>
