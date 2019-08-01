<!--top-->
<style>
.i-list a,.i-list a:visited {
	padding-left: 22px;
	width: 150px;
	height: 36px;
	line-height: 30px;
}
</style>
<script>
	$(document).ready(function() {
		//二级导航的
		$('.sidelist').mousemove(function() {
			$(this).find('.i-list').show();
			$(this).find('h3').addClass('help_hover');
		});
		$('.sidelist').mouseleave(function() {
			$(this).find('.i-list').hide();
			$(this).find('h3').removeClass('help_hover');
		});

	});

</script>
<div class="top">
	<div class="tlogo">
		<a href="/baichuan_advertisement_manage/">
			<img src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["logo"], ENT_QUOTES); ?>" alt="广告推广平台" style="height:50px;"/>
		</a>
	</div>
	<div class="tr">
		<?php if(user_api::auth('admin')){; ?>
		<span style="float:left;margin-right:20px;">待审核计划<a href="/baichuan_advertisement_manage/admin.shenhe.plan"> <?php echo htmlspecialchars(Tpl::$_tpl_vars["checkplan"], ENT_QUOTES); ?></a></span>
		<span style="float:left;margin-right:20px;">待审核素材<a href="/baichuan_advertisement_manage/admin.shenhe.stuff"> <?php echo htmlspecialchars(Tpl::$_tpl_vars["checkstuff"], ENT_QUOTES); ?></a></span>
		<?php }; ?>
		<div class="weluser">
			您好,
			<strong>
				<?php echo htmlspecialchars(user_api::name(), ENT_QUOTES); ?> 
				<?php /*
				<script>
					function login(e) {
						location = "/user.main.login." + $(e).val() + "?back="
								+ escape(location.href);
					}
				</script>
				<select onchange="login(this)">
					<?php foreach(Tpl::$_tpl_vars["users"] as Tpl::$_tpl_vars["user"]){; ?>
					<option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->uid, ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["user"]->uid==user_api::id()){; ?>selected<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->user_name, ENT_QUOTES); ?></option>
					<?php }; ?>
				</select>
				*/?>
			</strong>
			[
			<a href="/baichuan_advertisement_manage/user.main.logout">退出</a>
			]
		</div>
		<div class="trlink">
			<a href="/baichuan_advertisement_manage/message.main.entry">
				<i class="fa fa-envelope">(<span style="color:red;font-weight:600;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["msgCount"], ENT_QUOTES); ?></span>)</i>
			</a>
			<!--<a href="#">
				<i class="fa fa-question-circle"></i>
			</a>-->
		</div>
	</div>
</div>

<!--nav-->
<div class="nav">
	<?php if( user_api::auth("adReadonly") ){; ?>
	<div class="navd <?php if(Tpl::$_tpl_vars["nav"]=="ad"){; ?>sel<?php }; ?>">
		<a class="rq" href="/baichuan_advertisement_manage/ad.plan" title="广告浏览">广告浏览</a>
	</div>
	<?php }; ?>
	
 <?php if(user_api::auth(["system","admin","createContract"],"or")){; ?>
	<!--<div class="navd sidelist <?php if(Tpl::$_tpl_vars["nav"]=="ad"){; ?>sel<?php }; ?>">-->
	<div class="navd sidelist" <?php if(Tpl::$_tpl_vars["nav"]==1){; ?> style="background-color: #188f7f;"<?php }elseif( Tpl::$_tpl_vars["ad"] =="ad"){; ?> style="background-color: #188f7f;" <?php }; ?>>
		<h3 class="">
			<em class="harrow"></em>
			<a class="ndl" href="/baichuan_advertisement_manage/ad.plan?nav=1" title="广告管理">广告管理</a>
		</h3>
		<div class="i-list" style="display: none;">
			<a href="/baichuan_advertisement_manage/ad.plan?nav=1">广告计划</a>
			<a href="/baichuan_advertisement_manage/ad.plan.add?nav=1">创建广告计划</a>
			<?php if( user_api::auth("admin")){; ?>
			<a href="/baichuan_advertisement_manage/admin.advertiser.search?nav=1">广告搜索</a>
			<?php }; ?>
            <?php if( user_api::auth("admin")){; ?>
            <!-- <a href="/baichuan_advertisement_manage/admin.system.tag">自定义标签管理</a> -->
            <?php }; ?>
		</div>
	</div>
	<?php }; ?>

	<!--<div class="navd sidelist <?php if(Tpl::$_tpl_vars["nav"]=="media"){; ?>sel<?php }; ?>">-->
	<?php if(user_api::auth(["system","admin"],"or")){; ?>
	<div class="navd sidelist" <?php if(Tpl::$_tpl_vars["nav"]==2){; ?> style="background-color: #188f7f;" <?php }; ?>>
		<h3 class="">
			<em class="harrow"></em>
			<a class="ndl" <?php if(user_api::auth("media") && Tpl::$_tpl_vars["config"]['dsp']['media']){; ?> href="/baichuan_advertisement_manage/media?nav=2" <?php }else{; ?> href="/baichuan_advertisement_manage/media.schedule?nav=2" <?php }; ?> title="媒体列表">媒体管理</a>
		</h3>
		<div class="i-list" style="display: none;">
	<?php if(user_api::auth("media") && Tpl::$_tpl_vars["config"]['dsp']['media']){; ?>
            <a href="/baichuan_advertisement_manage/media?nav=2">媒体来源</a>
            <a href="/baichuan_advertisement_manage/media.channel?nav=2">频道专题</a>
            <a href="/baichuan_advertisement_manage/media.tag?nav=2">广告位分类</a>
            <a href="/baichuan_advertisement_manage/media.position?nav=2">广告位置</a>
	<?php }; ?>
            <a href="/baichuan_advertisement_manage/media.schedule?nav=2">广告位排期</a>
            <!--<a href="/baichuan_advertisement_manage/material.material.List">素材管理</a>-->
            <!--<a href="/baichuan_advertisement_manage/material.material.Audited">素材审核</a>-->
			<!--MaterialManagement素材管理-->
        </div>
	</div>
	<?php }; ?>
	
	<?php if(user_api::auth("dsp") && Tpl::$_tpl_vars["config"]['dsp']['manage']){; ?>
	<div class="navd hide <?php if(Tpl::$_tpl_vars["nav"]=="dsp"){; ?>sel<?php }; ?>">
		<a class="rq" href="/baichuan_advertisement_manage/dsp" title="DSP管理">DSP管理</a>
	</div>
	<?php }; ?>
	
	<?php if( user_api::auth("dpcRule") && Tpl::$_tpl_vars["config"]['dpc']['manage']){; ?>
	<div class="navd hide <?php if(Tpl::$_tpl_vars["nav"]=="dpc"){; ?>sel<?php }; ?>">
		<a class="rq" href="/baichuan_advertisement_manage/dpc.manage.ist" title="DPC管理">DPC管理</a>
	</div>
	<?php }; ?>
	
	<?php if( user_api::auth("dpc") && Tpl::$_tpl_vars["config"]['dpc']['manage']){; ?>
	<div class="navd hide sidelist <?php if(Tpl::$_tpl_vars["nav"]=="dpc"){; ?>sel<?php }; ?>">
		<h3 class="">
			<em class="harrow"></em>
			<a class="ndl" href="/baichuan_advertisement_manage/dpc" title="DPC管理">DPC管理</a>
		</h3>
		<div class="i-list" style="display: none;">
			<a href="/baichuan_advertisement_manage/dpc">DPC管理</a>
			<a href="/baichuan_advertisement_manage/dpc.manage.list">DPC管理[新版]</a>
			<a href="/baichuan_advertisement_manage/admin.complain.list">投诉账号推送记录查询</a>
			<a href="/baichuan_advertisement_manage/admin.complain.miitlist">工信部投诉预警</a>
			<a href="/baichuan_advertisement_manage/admin.push.list">推送方每日推送量统计</a>
		</div>
	</div>
	<?php }; ?>

	<?php if( user_api::auth("audient") && Tpl::$_tpl_vars["config"]['dsp']['people'] ){; ?>
	<div style="display: none;" class="navd <?php if(Tpl::$_tpl_vars["nav"]=="audient"){; ?>sel<?php }; ?>">
		<a class="rq" href="/baichuan_advertisement_manage/audient" title="人群管理">人群管理</a>
	</div>
	<?php }; ?>
	
	<?php if( user_api::auth("stat") && Tpl::$_tpl_vars["config"]['report']['stat']){; ?>
	<div class="navd hide <?php if(Tpl::$_tpl_vars["nav"]=="report"){; ?>sel<?php }; ?>">
		<a class="zh" href="/baichuan_advertisement_manage/report.stat.host" title="运维报表">运维报表</a>
	</div>
	<?php }; ?>
	
	<?php if( in_array(Tpl::$_tpl_vars["currentUser"]->role_id,[10000,1000,18,17,12,13]) ){; ?>
	<div class="navd sidelist" <?php if(Tpl::$_tpl_vars["nav"]==3){; ?>style="background-color: #188f7f;" <?php }; ?>>
		<!--<h3>-->
		<!--&lt;!&ndash;<a class="rq" href="/baichuan_advertisement_manage/dc?nav=3" title="广告报表">广告报表</a>&ndash;&gt;-->
		<!--<a class="rq" href="/baichuan_advertisement_manage/dc.main.ad?nav=3&menu_left=1" title="广告报表">广告报表</a>-->
			<!--<?php if(user_api::auth(["system","admin"],"or")){; ?>-->
			<!--<a href="/baichuan_advertisement_manage/admin.advertiser.list?nav=5">投放概况</a>-->
			<!--<?php }; ?>-->
		<!--</h3>-->
	<!--</div>-->

<h3 class="">
	<em class="harrow"></em>
	<a class="rq" href="/baichuan_advertisement_manage/dc.main.ad?nav=3&menu_left=1" title="广告报表">广告报表</a>
</h3>
<div class="i-list" style="display: none;">
	<?php if(user_api::auth(["system","admin"],"or")){; ?>
	<a href="/baichuan_advertisement_manage/admin.advertiser.list?nav=3">投放概况</a>
	<?php }; ?>
	<a class="rq" href="/baichuan_advertisement_manage/dc.main.ad?nav=3&menu_left=1" title="报表展示">报表展示</a>
</div>
</div>
	<?php }; ?>

	
	<?php if(user_api::auth("shenhe")){; ?>
	<!--<div class="navd sidelist <?php if(Tpl::$_tpl_vars["nav4"]=="shenhe"){; ?>sel<?php }; ?>">-->
	<div class="navd sidelist" <?php if(Tpl::$_tpl_vars["nav"]==4){; ?> style="background-color: #188f7f;" <?php }; ?>>
		<h3 class="">
			<em class="harrow"></em>
			<a class="ndl" href="/baichuan_advertisement_manage/admin.shenhe.plan?nav=4" title="广告审核">广告审核</a>
		</h3>
		<div class="i-list" style="display: none;">
			<a href="/baichuan_advertisement_manage/admin.shenhe.plan?nav=4">广告计划审核</a>
			<!--<a href="/baichuan_advertisement_manage/admin.shenhe.stuff?nav=4">广告素材审核</a>-->
			<a href="/baichuan_advertisement_manage/admin.shenhelog.entry?nav=4">广告审核日志</a>
			
			<?php if( user_api::auth("shenhe") && Tpl::$_tpl_vars["config"]['crm']['display']){; ?>
			<a href="/baichuan_advertisement_manage/crm.shenhe.list?complete=1">触点广告审核</a>
			<a href="#" onclick="layerConfirmGet('/crm.shenhe.CheckBlack','确定手动审核黑白名单？')">手动审核</a>
			<?php }; ?>
		</div>
	</div>
	<?php }; ?>
	<?php echo htmlspecialchars(Tpl::$_tpl_vars["nav4"], ENT_QUOTES); ?>

	<?php if(user_api::auth(["system","admin"],"or") or in_array(Tpl::$_tpl_vars["currentUser"]->role_id,[10000,1000,18,17,12])){; ?>
	<!--<div class="navd sidelist <?php if(Tpl::$_tpl_vars["nav4"]=="user"){; ?>sel<?php }; ?>">-->
	<div class="navd sidelist" <?php if(Tpl::$_tpl_vars["nav"]==5){; ?> style="background-color: #188f7f;" <?php }; ?>>
		<h3 class="">
			<em class="harrow"></em>
			<a class="ndl" href="/baichuan_advertisement_manage/admin.user.list?admin=<?php echo htmlspecialchars(Tpl::$_tpl_vars["admin"], ENT_QUOTES); ?>&nav=5" title="高级管理">高级管理</a>
		</h3>
		<div class="i-list" style="display: none;">
            <a href="/baichuan_advertisement_manage/admin.user.list?admin=<?php echo htmlspecialchars(Tpl::$_tpl_vars["admin"], ENT_QUOTES); ?>&nav=5">账户管理</a>
            <?php if(user_api::auth(["system","admin"],"or") or in_array(Tpl::$_tpl_vars["currentUser"]->role_id,[10000,1000])){; ?>
            <a href="/baichuan_advertisement_manage/admin.caiwu.list?admin=<?php echo htmlspecialchars(Tpl::$_tpl_vars["admin"], ENT_QUOTES); ?>&menu=1&nav=5">财务管理</a>
            <?php }; ?>
           <?php if( user_api::auth("admin") && Tpl::$_tpl_vars["config"]['crm']['display']){; ?>
                   <a href="/baichuan_advertisement_manage/crm.word">敏感词维护</a>
                   <a href="/baichuan_advertisement_manage/crm.number.grouplist">号码库管理</a>
           <?php }; ?>
           <?php if(user_api::auth("admin") ){; ?>
            <a href="/baichuan_advertisement_manage/admin.log.list?nav=5">系统日志</a>
            <?php }; ?>

		</div>
	</div>
	<?php }; ?>	

	<?php if( user_api::auth("crm") && Tpl::$_tpl_vars["config"]['crm']['display'] && 0){; ?>
	<!--<div class="navd sidelist <?php if(Tpl::$_tpl_vars["nav"]=="audient"){; ?>sel<?php }; ?>">-->
	<div class="navd sidelist" <?php if(Tpl::$_tpl_vars["nav"]=="audient"){; ?> style="background-color: #188f7f;" <?php }; ?>>
		<h3 class="">
			<em class="harrow"></em>
			<a class="ndl" href="/baichuan_advertisement_manage/crm.consumer.list" title="CRM">CRM+</a>
		</h3>
		<div class="i-list" style="display: none;">
			<a href="/baichuan_advertisement_manage/bigdata">大数据</a>
			<a href="/baichuan_advertisement_manage/bigdata.main.queryList">查询记录</a>
			<a href="/baichuan_advertisement_manage/crm.consumer.list">客户管理</a>
			<a href="/baichuan_advertisement_manage/crm.main.TagStat">客户分析</a>
		</div>
	</div>
	<?php }; ?>
	
	<!--<div class="navd sidelist <?php if(Tpl::$_tpl_vars["nav"]==="account"){; ?>sel<?php }elseif((Tpl::$_tpl_vars["nav"]==="caiwu")){; ?>sel<?php }; ?>">-->
	<div class="navd sidelist" <?php if(Tpl::$_tpl_vars["nav"]==6){; ?> style="background-color: #188f7f;"<?php }; ?>>
		<h3 class="">
			<a class="ndl" href="/baichuan_advertisement_manage/account.main.detail?nav=6" title="个人中心">个人中心</a>
		</h3>
	</div>

	<?php if(user_api::auth(["system","admin"],"or")){; ?>
	<div class="navd" style="display: none;">
		<h3>
		<a class="rq" href="https://www.4mp.cn" title="互动营销" target="_blank">互动营销</a>
		</h3>
	</div>
	<?php }; ?>
<!--合同管理导航   Start-->

<!--<div class="navd sidelist <?php if(Tpl::$_tpl_vars["nav8"]=="shenhe"){; ?>sel<?php }; ?>">-->
<div class="navd sidelist" <?php if(Tpl::$_tpl_vars["nav"]==7){; ?> style="background-color: #188f7f;" <?php }; ?>>

<h3 class="">
	<em class="harrow"></em>
	 <a class="ndl" href="/baichuan_advertisement_manage/admin.contract.list?nav=7" title="合同管理">合同管理</a>
</h3>
<div class="i-list" style="display: none;">
	<a href="/baichuan_advertisement_manage/admin.contract.list?nav=7">合同列表</a>
	<?php if(user_api::auth(["shenhe","shenheContract"],"or")){; ?>
	<a href="/baichuan_advertisement_manage/admin.contract.audited?type=1&nav=7">合同审核</a>
	<?php }; ?>
	<?php if(user_api::auth("shenhe")){; ?>
	<a href="/baichuan_advertisement_manage/admin.contract.AuditedLog?nav=7">合同审核日志</a>
	<?php }; ?>
	<!--<a href="/baichuan_advertisement_manage/admin.contract.new">合同新建</a>-->
	<!--<a href="/baichuan_advertisement_manage/admin.contract.editor">合同编辑</a>-->
</div>
</div>


<!--素材库管理导航   Start-->

<div class="navd sidelist" <?php if(Tpl::$_tpl_vars["nav"]==8){; ?> style="background-color: #188f7f;" <?php }; ?>>

<h3 class="">
  <em class="harrow"></em>
   <a class="ndl" href="/baichuan_advertisement_manage/ad.stufflibrary.List?nav=8" title="素材库">素材库</a>
</h3>
<div class="i-list" style="display: none;">
  <a href="/baichuan_advertisement_manage/ad.stufflibrary.List?nav=8">素材列表</a>
  <?php if(user_api::auth(["shenhe","shenheContract"],"or")){; ?>
  <a href="/baichuan_advertisement_manage/ad.stufflibrary.AuditedList?type=1&nav=8">素材审核</a>
  <?php }; ?>
</div>
</div>
<!--合同管理导航   End-->

<!--外呼管理 start-->
<!--<?php if(user_api::auth("shenhe")){; ?>
<div class="navd sidelist <?php if(Tpl::$_tpl_vars["nav8"]=="shenhe"){; ?>sel<?php }; ?>">
<h3 class="">
	<em class="harrow"></em>
	<a class="ndl" href="/baichuan_advertisement_manage/admin" title="DPC管理">外呼管理</a>
</h3>
<div class="i-list" style="display: none;">
	<a href="/baichuan_advertisement_manage/admin.outbound.content">内容管理列表</a>
	<a href="/baichuan_advertisement_manage/admin.outbound.ConNew">内容管理新建</a>
	<a href="/baichuan_advertisement_manage/admin.outbound.ConEdit">内容管理编辑</a>
	<a href="/baichuan_advertisement_manage/admin.outbound.DelList">投放管理列表</a>
	<a href="/baichuan_advertisement_manage/admin.outbound.DelNew">内容管理新建</a>
	<a href="/baichuan_advertisement_manage/admin.outbound.DelEdit">内容管理编辑</a>
</div>
</div>
<?php }; ?>-->
<!--外呼管理 end-->

<!--短信管理start-->
<!--<?php if(user_api::auth("shenhe")){; ?>
<div class="navd sidelist <?php if(Tpl::$_tpl_vars["nav8"]=="shenhe"){; ?>sel<?php }; ?>">
<h3 class="">
	<em class="harrow"></em>
	<a class="ndl" href="/baichuan_advertisement_manage/admin" title="DPC管理">短信管理</a>
</h3>
<div class="i-list" style="display: none;">
	<a href="/baichuan_advertisement_manage/admin.sms.ConList">内容管理</a>
	<a href="/baichuan_advertisement_manage/admin.sms.ConNew">内容管理新建</a>
	<a href="/baichuan_advertisement_manage/admin.sms.ConEdit">内容管理编辑</a>
	<a href="/baichuan_advertisement_manage/admin.sms.DelList">投放管理</a>
	<a href="/baichuan_advertisement_manage/admin.sms.DelNew">内容管理新建</a>
	<a href="/baichuan_advertisement_manage/admin.sms.DelEdit">内容管理编辑</a>
</div>
</div>
<?php }; ?>-->
<!--短信管理end-->


</div>

<script>
	//导航栏下拉条定位标识
	$(".i-list").find("a").hover( function(event){
		$(this).css("color", "red");
	}, function(event){
		$(this).css("color", "white");
	} );
</script>

