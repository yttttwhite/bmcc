{if( !user_api::auth("adReadonly") )}
    <a class="btn btn-squared btn-success" href="/baichuan_advertisement_manage/ad.plan.add?nav=1" style="width: 100%; background: #12C043;">新增广告计划</a>
{/if}
    {if(user_api::auth("system"))}<a class="btn btn-squared btn-success" style="width: 100%; color:#333333; background: #EFEFEF; border:1px solid #CCCCCC; {if( !user_api::auth("adReadonly") )} margin-top:5px;" {/if} onclick="$('.nav-no-plan').toggle(100)">显示/隐藏 空闲用户</a>{/if}
	<script type="text/javascript">
    $(document).ready(function(){
    
			/*
        $(".accordion h3[current=active]").addClass("active");
        $(".accordion .snav:not([current=active])").hide();

        $(".accordion h3").click(function(){
            $(this).next(".snav").slideToggle("fast")
            .siblings(".snav").slideUp("fast");
            $(this).toggleClass("active");
            $(this).siblings("h3").removeClass("active");
        });
		*/
	$(".checkall").change(function(){
		var ck=$(this).prop("checked");
		$(this).parents("table").find("input:checkbox").prop("checked",ck);
		});
    
    });
    </script>
	<style>
	.adInfo .aicon{
	padding-bottom:0px;
	}
	</style>
	
	<div class="accordion">
        <h2 {if($user_id == $my->uid)} class="left-nav-title-active" {/if} style="background: #1478DC;">
        	<span style="margin-right: 10px; color:#0D6FB8; font-weight:bold;">
        		<a href="/baichuan_advertisement_manage/ad.plan?status=1&uid={$my->uid}&nav=1" style="color:#FFFFFF; font-weight:normal;">
				 	我的广告
        		</a>
        	</span>
        	<span style="float:right;">
        		<a href="/baichuan_advertisement_manage/ad.plan?status=0&uid={$my->uid}&nav=1" style="color:#FFFFFF; font-weight:normal;">全部广告计划</a>
        	</span>
        </h2>
		{if( is_array($userPlans[$my->uid]) )}
			{foreach $userPlans[$my->uid] as $userPlan}
	        <h3 id="plan_{$userPlan->plan_id}" {if $plan_id == $userPlan->plan_id} class="bort active" current="active"{else} class="bort" {/if} onclick="location='/baichuan_advertisement_manage/ad.plan.list.{$userPlan->plan_id}?nav=1'" title="{$userPlan->plan_name}">{$userPlan->plan_name|wordbraek:20}</h3>
	        <div class="snav" style="display:block;" {if $plan_id == $userPlan->plan_id} class="active" current="active"{/if}>
	          <ul>
				{if($userPlan->plan_id == $plan_id)}
					{foreach $groups as $_group}
	            	<li {if($group_id == $_group->group_id)}class="sel"{/if}><a href="/ad.group.list.{$userPlan->plan_id}.{$_group->group_id}?nav=1" title="{$_group->name}">{$_group->name|wordbraek:20}</a></li>
					{/foreach}
				{/if}
	          </ul>
	        </div>
			{/foreach}
		{/if}
    </div>
	
	{foreach $users as $user}
		{if($user->uid != $my->uid)}
			<div class="accordion">
				{if(is_array($userPlans[$user->uid]) )}
			        <h2 {if($user_id == $user->uid)} class="left-nav-title-active" {/if} style="background: #1478DC;">
			        	<span style="margin-right: 10px; color:#1478DC; font-weight:bold;">
			        		<a href="/baichuan_advertisement_manage/ad.plan?status=1&uid={$user->uid}&nav=1" style="color:#FFFFFF; font-weight:normal;">
			        			{$user->user_name}
			        		</a>
			        	</span>
			        	<span style="float:right;">
			        		<a href="/baichuan_advertisement_manage/ad.plan?status=0&uid={$user->uid}&nav=1" style="color:#FFFFFF; font-weight:normal;">全部广告计划</a>
			        	</span>
			        </h2>
				{else}
					<h2 class="nav-no-plan {if($user_id == $user->uid)} left-nav-title-active{/if}" style="background: #eeeeee;">
			        	<span style="margin-right: 10px; color:#666666; font-weight:normal;">
			        		{$user->user_name}
			        	</span>
			        	<span style="float:right;">
			        		<a href="/baichuan_advertisement_manage/ad.plan?status=0&uid={$user->uid}&nav=1" style="color:#0D6FB8; font-weight:normal; font-size:12px;">全部广告计划</a>
			        	</span>
			        </h2>
				{/if}
				
				{if(is_array($userPlans[$user->uid]) )}
					{foreach $userPlans[$user->uid] as $userPlan}
			        <h3 id="plan_{$userPlan->plan_id}" {if $plan_id == $userPlan->plan_id} class="bort active" current="active"{else} class="bort" {/if} onclick="location='/baichuan_advertisement_manage/ad.plan.list.{$userPlan->plan_id}?nav=1'">{$userPlan->plan_name}</h3>
			        <div class="snav" style="display:block;" {if $plan_id == $userPlan->plan_id} class="active" current="active"{/if}>
			          <ul>
						{if($userPlan->plan_id == $plan_id)}
							{foreach $groups as $_group}
			            	<li {if($group_id == $_group->group_id)}class="sel"{/if}><a href="/ad.group.list.{$userPlan->plan_id}.{$_group->group_id}?nav=1">{$_group->name}</a></li>
							{/foreach}
						{/if}
			          </ul>
			        </div>
					{/foreach}
				{/if}
		    </div>
		{/if}
	{/foreach}
