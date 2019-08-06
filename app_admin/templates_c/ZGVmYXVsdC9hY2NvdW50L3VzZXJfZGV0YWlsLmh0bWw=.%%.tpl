<!DOCTYPE html>
<html>
<head>
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.admin"), ENT_QUOTES); ?>
<!--main-->
<div class="main">
    <div class="side" >
    <div class="leftNav" >
      <ul>
        <li class="nobotbor sel"><a href="/baichuan_advertisement_manage/account.main.edit?nav=6">修改个人信息</a></li>
        </ul>
    </div>
  </div>
	<div class="mcon" >
		<div class="row">
			<!-- start: FORM VALIDATION 1 PANEL -->
			<div class="panel panel-white">
				<div class="panel-heading" style="display:none;">
					<h4 class="panel-title">用户详情</h4>
				</div>
				<div class="panel-body" style="padding-right:100px; padding-top: 0;">
					<form action="/baichuan_advertisement_manage/admin.user.edit.<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->uid, ENT_QUOTES); ?>" method="post" role="form" id="form">
						<div class="row">
							<div class="col-md-10">
								<h5><i class="fa fa-pencil-square"></i> 账户信息</h5>
								<hr style="margin:5px 0;">
								<div class="row">
									<label class="control-label col-md-3">用户ID： </label>
									<div class=" col-md-9"><?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->uid, ENT_QUOTES); ?></div>
								</div>
								<div class="row mt-10">
									<label class="control-label col-md-3">用户名： </label>
									<div class=" col-md-9"><?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->user_name, ENT_QUOTES); ?></div>
								</div>
								<div class="row mt-10">
									<label class="control-label col-md-3">账号类型： </label>
									<div class=" col-md-9"><?php echo htmlspecialchars(Tpl::$_tpl_vars["roleList"][Tpl::$_tpl_vars["user"]->role_id]['name'], ENT_QUOTES); ?></div>
								</div>
								<div class="row mt-10">
									<label class="control-label col-md-3">账号状态： </label>
									<div class=" col-md-9"><?php if(Tpl::$_tpl_vars["user"]->account_status==1){; ?>正常<?php }else{; ?>禁用<?php }; ?></div>
								</div>
								<div class="row mt-10">
									<label class="control-label col-md-3">竞价制余额： </label>
									<div class=" col-md-9"><strong class="ye"><?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["user"]->bid_account,0,00), ENT_QUOTES); ?></strong>元</div>
								</div>
								<div class="row mt-10">
									<label class="control-label col-md-3">合约制余额： </label>
									<div class=" col-md-9"><strong class="ye"><?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["user"]->contract_account,0,00), ENT_QUOTES); ?></strong>元<i class="toogleup fa fa-caret-down" style="margin-left:10px;font-size: 20px;"></i></div>
									<!--<div class=" col-md-9"><strong class="ye"><?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->account, ENT_QUOTES); ?></strong>元</div>-->
								</div>
								<div class="row mt-10 user-detail"  style="display: none;">
									<div class="col-md-10">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listab fs14 font-size-12 table table-bordered  table-striped table-hover">
										<tr>
											<!--<th width="300" style="text-align:center;">合同名称</th>-->
											<th width="110" style="text-align:center;">广告位单价</th>
											<th width="110" style="text-align:center;">单位</th>
											<th width="110" style="text-align:center;">购买量</th>
											<th width="110" style="text-align:center;">已使用量</th>
											<th width="110" style="text-align:center;">剩余量</th>
										</tr>
										<?php foreach(Tpl::$_tpl_vars["unit_list"] as Tpl::$_tpl_vars["key"]=>Tpl::$_tpl_vars["item"]){; ?>
											<tr>
												<td align="center"><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]['price'], ENT_QUOTES); ?> 元</td>
												<td align="center"><?php if(Tpl::$_tpl_vars["item"]['unit']==2){; ?>CPM<?php }else{; ?>CPT<?php }; ?></td>
												<td align="center"><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]['buy_amount'], ENT_QUOTES); ?></td>
												<td align="center"><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]['used_buy_amount'], ENT_QUOTES); ?></td>
												<!--<td align="center"><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]['access_buy_amount'], ENT_QUOTES); ?></td>-->
												<td align="center"><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]['access_budget'], ENT_QUOTES); ?></td>
											</tr>
										<?php }; ?>
									</table>
									</div>
								</div>
							</div>
							
							<div class="col-md-6 hide">
								<h5><i class="fa fa-pencil-square"></i>  结算信息</h5>
								<hr style="margin:5px 0;">
								<div class="row mt-10">
									<label class="control-label col-md-3">结算类型： </label>
									<div class=" col-md-9">
										<?php if(Tpl::$_tpl_vars["user"]->type==0){; ?>实际花费结算<?php }; ?>
										<?php if(Tpl::$_tpl_vars["user"]->type==1){; ?>差价结算方式<?php }; ?>
										<?php if(Tpl::$_tpl_vars["user"]->type==2){; ?>固定CPM方式<?php }; ?>
										<?php if(Tpl::$_tpl_vars["user"]->type==3){; ?>固定CPC方式<?php }; ?>
									</div>
								</div>
								<div class="row mt-10">
									<label class="control-label col-md-3">差价率： </label>
									<div class=" col-md-9"><?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->diffrate, ENT_QUOTES); ?></div>
								</div>
								<div class="row mt-10">
									<label class="control-label col-md-3">技术支持费： </label>
									<div class=" col-md-9"><?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->supportfee, ENT_QUOTES); ?></div>
								</div>
								<div class="row mt-10">
									<label class="control-label col-md-3">CPM结算价格： </label>
									<div class=" col-md-9"><?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->cpm_charge, ENT_QUOTES); ?></div>
								</div>
							</div>
						</div>
						<div class="row mt-30">
							<div class="col-md-10">
								<h5><i class="fa fa-pencil-square"></i> 基本资料</h5>
								<hr style="margin:5px 0;">
								<div class="row mt-10">
									<label class="control-label col-md-3">联系人公司名称： </label>
									<div class=" col-md-9"><?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->company_name, ENT_QUOTES); ?></div>
								</div>
								<div class="row mt-10">
									<label class="control-label col-md-3">联系人姓名： </label>
									<div class=" col-md-9"><?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->host, ENT_QUOTES); ?></div>
								</div>
								<div class="row mt-10">
									<label class="control-label col-md-3">联系电话： </label>
									<div class=" col-md-9"><?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->cell_phone, ENT_QUOTES); ?></div>
								</div>
								<!--<div class="row mt-10">-->
									<!--<label class="control-label col-md-3">邮箱： </label>-->
									<!--<div class=" col-md-9"><?php echo htmlspecialchars(Tpl::$_tpl_vars["email"], ENT_QUOTES); ?></div>-->
								<!--</div>-->
								<div class="row mt-10">
									<label class="control-label col-md-3">联系地址： </label>
									<div class=" col-md-9"><?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->address, ENT_QUOTES); ?></div>
								</div>
								<div class="row mt-10">
									<label class="control-label col-md-3">其他备注： </label>
									<div class=" col-md-9"><?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->colum2, ENT_QUOTES); ?></div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- end: FORM VALIDATION 1 PANEL -->
		</div>
		<?php if(Tpl::$_tpl_vars["config"]['crm']['display']){; ?>
		<div class="row">
			<div class="col-md-8">
				<div class="tabbable">
	                <ul class="nav nav-tabs tab-padding tab-space-3 tab-gray" id="myTab4">
	                    <li class="active">
	                        <a data-toggle="tab" href="#tab-1">可用触点</a>
	                    </li>
	                    <li>
	                        <a data-toggle="tab" href="#tab-2">可用号码库</a>
	                    </li>
	                </ul>
	                <div class="tab-content" style="text-align:center;">
	                    <div id="tab-1" class="tab-pane fade in  active">
	                    	<?php echo htmlspecialchars(tpl_function_part("/crm.chudian.MyList"), ENT_QUOTES); ?>
						</div>
	                    <div id="tab-2" class="tab-pane fade">
	                    	<?php echo htmlspecialchars(tpl_function_part("/crm.number.MyAuthList"), ENT_QUOTES); ?>
	                    </div>
	                </div>
	            </div>
			</div>
		</div>
		<?php }; ?>
		
	</div>
</div>
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
</body>
<script>
	var show=false
	$(function(){
		$(".toogleup").on("click",function(){
			$(this).css("transform",show?"rotate(0deg)":"rotate(180deg)");
			show=!show;
			$(".user-detail").toggle();
		});
	})
</script>
</html>