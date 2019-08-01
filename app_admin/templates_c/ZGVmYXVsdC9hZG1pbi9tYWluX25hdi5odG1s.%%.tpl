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
	<h2>广告审核</h2>
	<h3 class="bort " <?php if(Tpl::$_tpl_vars["nav"]=="plan"){; ?>current="active"<?php }; ?>>广告计划审核</h3>
	<div class="snav" style="display:block;" <?php if(Tpl::$_tpl_vars["nav"]=="plan"){; ?>current="active"<?php }; ?>>
		<ul>
			<li <?php if(Tpl::$_tpl_vars["nav"]=="plan"&&Tpl::$_tpl_vars["nav_sub"]==1){; ?>class="sel"<?php }; ?>><a href="/baichuan_advertisement_manage/admin.shenhe.plan?type=1&nav=4"><b>待审核</b></a></li>
			<li <?php if(Tpl::$_tpl_vars["nav"]=="plan"&&Tpl::$_tpl_vars["nav_sub"]==3){; ?>class="sel"<?php }; ?>><a href="/baichuan_advertisement_manage/admin.shenhe.plan?type=3&nav=4">未通过</a></li>
			<li <?php if(Tpl::$_tpl_vars["nav"]=="plan"&&Tpl::$_tpl_vars["nav_sub"]==2){; ?>class="sel"<?php }; ?>><a href="/baichuan_advertisement_manage/admin.shenhe.plan?type=2&nav=4">已通过</a></li>
		</ul>
	</div>
	<!--<h3 class="bort " <?php if(Tpl::$_tpl_vars["nav"]=="stuff"){; ?>current="active"<?php }; ?>>广告素材审核</h3>-->
	<!--<div class="snav" style="display:block;" <?php if(Tpl::$_tpl_vars["nav"]=="stuff"){; ?>current="active"<?php }; ?>>-->
		<!--<ul>-->
			<!--<li <?php if(Tpl::$_tpl_vars["nav"]=="stuff"&&Tpl::$_tpl_vars["nav_sub"]==1){; ?>class="sel"<?php }; ?>><a href="/baichuan_advertisement_manage/admin.shenhe.stuff?type=1&nav=4"><b>待审核</b></a></li>-->
			<!--<li <?php if(Tpl::$_tpl_vars["nav"]=="stuff"&&Tpl::$_tpl_vars["nav_sub"]==3){; ?>class="sel"<?php }; ?>><a href="/baichuan_advertisement_manage/admin.shenhe.stuff?type=3&nav=4">未通过</a></li>-->
			<!--<li <?php if(Tpl::$_tpl_vars["nav"]=="stuff"&&Tpl::$_tpl_vars["nav_sub"]==2){; ?>class="sel"<?php }; ?>><a href="/baichuan_advertisement_manage/admin.shenhe.stuff?type=2&nav=4">已通过</a></li>-->
		<!--</ul>-->
	<!--</div>-->

	<!--<h3 class="bort " <?php if(Tpl::$_tpl_vars["nav"]=="lj_stuff"){; ?>current="active"<?php }; ?>><a href="/baichuan_advertisement_manage/admin.shenhe.AdxStuff?type=2&nav=4"><b>灵集广告素材审核结果</b></a></h3>-->
	<!--<div class="snav" style="display:block;" <?php if(Tpl::$_tpl_vars["nav"]=="lj_stuff"){; ?>current="active"<?php }; ?>>-->
		<!--<ul>-->
			<!--<li <?php if(Tpl::$_tpl_vars["nav"]=="lj_stuff" && Tpl::$_tpl_vars["nav_sub"]==1){; ?>class="sel"<?php }; ?>><a href="/baichuan_advertisement_manage/admin.shenhe.AdxStuff?type=2&nav=4"><b>审核结果  灵集广告素材审核结果</b></a></li>-->
		<!--</ul>-->
	<!--</div>-->

</div>
