<!--top-->
<style>
.i-list a,.i-list a:visited {
	padding-left: 22px;
	width: 100px;
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
		<img src="/baichuan_advertisement_manage/assets_admin/img/{$logo}" alt="广告推广平台" />
	</div>
	<div class="tr">
		<div class="weluser">
			您好,
			<strong>
				{user_api::name()} 
				{*
				<script>
					function login(e) {
						location = "/user.main.login." + $(e).val() + "?back="
								+ escape(location.href);
					}
				</script>
				<select onchange="login(this)">
					{foreach $users as $user}
					<option value="{$user->uid}" {if $user->uid==user_api::id()}selected{/if}>{$user->user_name}</option>
					{/foreach}
				</select>
				*}
			</strong>
			[
			<a href="/baichuan_advertisement_manage/user.main.logout">退出</a>
			]
		</div>
		<div class="trlink">
			<a href="#">
				<img class="fl" src="/baichuan_advertisement_manage/assets_admin/img/i_email.gif" alt="消息" />
				<span class="trlmsg"></span>
			</a>
			<a href="#">
				<img src="/baichuan_advertisement_manage/assets_admin/img/i_help.gif" alt="帮助" align="absmiddle" />
			</a>
		</div>
	</div>
</div>

<!--nav-->
<div class="nav">
	<div class="navd sidelist {if $nav=="ad"}sel{/if}">
		<h3 class="">
			<em class="harrow"></em>
			<a class="ndl" href="/baichuan_advertisement_manage/ad.plan" title="广告管理">广告管理</a>
		</h3>
		<div class="i-list" style="display: none;">
			<a href="/baichuan_advertisement_manage/ad.plan">广告计划</a>
			<a href="/baichuan_advertisement_manage/ad.plan.add">创建广告计划</a>
		</div>
	</div>

	<!--
	{if user_api::haveRole(user_role::ROLE_ADVERTISER) && $config->dc->admin}
	{/if}
	<div class="navd {if $nav=="dc"}sel{/if}">
	<h3>
	<a class="rq" href="/baichuan_advertisement_manage/dc" title="数据中心">数据中心</a>
	</h3>
	</div>
	-->

	{if user_api::haveRole(user_role::ROLE_WEBSITE) && $config->dsp->media}
	<div class="navd sidelist {if $nav=="media"}sel{/if}">
		<h3 class="">
			<em class="harrow"></em>
			<a class="ndl" href="/baichuan_advertisement_manage/media" title="媒体列表">媒体管理</a>
		</h3>
		<div class="i-list" style="display: none;">
			<a href="/baichuan_advertisement_manage/media">媒体管理</a>
			<a href="/baichuan_advertisement_manage/media.website">网站管理</a>
			<a href="/baichuan_advertisement_manage/media.slot">广告位管理</a>
		</div>
	</div>
	{/if}
	
	{if user_api::haveRole(user_role::ROLE_DSP) && $config->dsp->admin}
	<div class="navd {if $nav=="dsp"}sel{/if}">
		<a class="rq" href="/baichuan_advertisement_manage/dsp" title="DSP管理">DSP管理</a>
	</div>
	{/if}
	
	{if user_api::name()=="admin" && $config->dpc->admin}
	<div class="navd {if $nav=="dpc"}sel{/if}">
		<a class="rq" href="/baichuan_advertisement_manage/dpc" title="DPC管理">DPC管理</a>
	</div>
	{/if}

	<!--<div class="navd {if $nav=="audient"}sel{/if}"><a class="rq" href="/baichuan_advertisement_manage/audient" title="人群管理">人群管理</a></div>-->
	
	{if user_api::generalRole()}
	<div class="navd {if $nav=="caiwu"}sel{/if}">
		<a class="cw" href="/baichuan_advertisement_manage/caiwu" title="财务管理">财务管理</a>
	</div>
	{/if}
	
	{if user_api::getCurrentRole() == "adslManager"}
	<div class="navd {if $nav=="caiwu"}sel{/if}">
		<a class="cw" href="/baichuan_advertisement_manage/dpc.main.adsl.beijing_unicom" title="财务管理">ADSL管理</a>
	</div>
	{/if}
	
	<div class="navd {if $nav=="account"}sel{/if}">
		<a class="zh" href="/baichuan_advertisement_manage/account" title="账户管理">账户管理</a>
	</div>

	{if user_api::name()=="admin"}
	<div class="navd sidelist {if $nav=="admin"}sel{/if}">
		<h3 class="">
			<em class="harrow"></em>
			<a class="ndl" href="/baichuan_advertisement_manage/admin.shenhe.plan" title="高级管理">高级管理</a>
		</h3>
		<div class="i-list" style="display: none;">
			<a href="/baichuan_advertisement_manage/admin.shenhe.plan">广告计划审核</a>
			<a href="/baichuan_advertisement_manage/admin.shenhe.stuff">广告素材审核</a>
			<a href="/baichuan_advertisement_manage/admin.user.list">广告主管理</a>
		</div>
	</div>
	{/if} {if user_api::name()!="admin" && user_api::haveRole(user_role::ROLE_Operator)}
	<div class="navd sidelist {if $nav=="admin"}sel{/if}">
		<h3 class="">
			<em class="harrow"></em>
			<a class="ndl" href="#" onclick="return false" title="高级管理">高级管理</a>
		</h3>
		<div class="i-list" style="display: none;">
			<a href="/baichuan_advertisement_manage/admin.shenhe.stuff">广告素材审核</a>
		</div>
	</div>
	{/if}

</div>

