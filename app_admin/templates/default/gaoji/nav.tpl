<script type="text/javascript">
$(document).ready(function(){
		$(".accordion h3[current=active]").addClass("active");
		$(".accordion .snav:not([current=active])").hide();

		$(".accordion h3").click(function(){
			$(this).next(".snav").slideToggle("fast")
			.siblings(".snav").slideUp("fast");
			$(this).toggleClass("active");
			$(this).siblings("h3").removeClass("active");
			});
		$(".checkall").change(function(){
			var ck=$(this).prop("checked");
			$(this).parents("table").find("input:checkbox").prop("checked",ck);
			});

		});
</script>

<div class="accordion" style="margin-top:0;">
	<h2>系统管理</h2>
	<h3 class="bort " {if $nav=="plan"}current="active"{/if}>广告计划审核</h3>
	<div class="snav" style="display:block;" {if $nav=="plan"}current="active"{/if}>
		<ul>
			<li {if $nav_sub==1}class="sel"{/if}><a href="/baichuan_advertisement_manage/admin.shenhe.plan?type=1"><b>待审核</b></a></li>
			<li {if $nav_sub==3}class="sel"{/if}><a href="/baichuan_advertisement_manage/admin.shenhe.plan?type=3">末通过</a></li>
			<li {if $nav_sub==2}class="sel"{/if}><a href="/baichuan_advertisement_manage/admin.shenhe.plan?type=2">已通过</a></li>
		</ul>
	</div>

	<h3 class="bort " {if $nav=="stuff"}current="active"{/if}>广告素材审核</h3>
	<div class="snav" style="display:block;" {if $nav=="stuff"}current="active"{/if}>
		<ul>
			<li {if $nav_sub==1}class="sel"{/if}><a href="/baichuan_advertisement_manage/admin.shenhe.stuff?type=1"><b>待审核</b></a></li>
			<li {if $nav_sub==3}class="sel"{/if}><a href="/baichuan_advertisement_manage/admin.shenhe.stuff?type=3">末通过</a></li>
			<li {if $nav_sub==2}class="sel"{/if}><a href="/baichuan_advertisement_manage/admin.shenhe.stuff?type=2">已通过</a></li>
		</ul>
	</div>

	{if(user_api::auth("admin"))}
		<h3 class="bort " {if $nav=="user"}current="active"{/if} onclick="location='/baichuan_advertisement_manage/admin.user.list'">广告主管理</a></h3>
		<div class="snav" style="display:block;" {if $nav=="user"}current="active"{/if}>
			<ul>
				<li {if $nav_sub=="list"}class="sel"{/if}><a href="/baichuan_advertisement_manage/admin.user.list">广告主列表</a></li>
				<li {if $nav_sub=="add"}class="sel"{/if}><a href="/baichuan_advertisement_manage/admin.user.add">添加</a></li>
			</ul>
		</div>
	{/if}
</div>