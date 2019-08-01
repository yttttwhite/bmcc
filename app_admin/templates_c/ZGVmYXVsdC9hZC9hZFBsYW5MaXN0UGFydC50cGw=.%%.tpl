<?php if( !user_api::auth("adReadonly") ){; ?>
    <a class="btn btn-squared btn-success" href="/ad.plan.add?nav=1" style="width: 100%; background: #12C043;">新增广告计划</a>
<?php }; ?>
    <?php if(user_api::auth("system")){; ?><a class="btn btn-squared btn-success" style="width: 100%; color:#333333; background: #EFEFEF; border:1px solid #CCCCCC; <?php if( !user_api::auth("adReadonly") ){; ?> margin-top:5px;" <?php }; ?> onclick="$('.nav-no-plan').toggle(100)">显示/隐藏 空闲用户</a><?php }; ?>
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
        <h2 <?php if(Tpl::$_tpl_vars["user_id"] == Tpl::$_tpl_vars["my"]->uid){; ?> class="left-nav-title-active" <?php }; ?> style="background: #1478DC;">
        	<span style="margin-right: 10px; color:#0D6FB8; font-weight:bold;">
        		<a href="/ad.plan?status=1&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["my"]->uid, ENT_QUOTES); ?>&nav=1" style="color:#FFFFFF; font-weight:normal;">
				 	我的广告
        		</a>
        	</span>
        	<span style="float:right;">
        		<a href="/ad.plan?status=0&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["my"]->uid, ENT_QUOTES); ?>&nav=1" style="color:#FFFFFF; font-weight:normal;">全部广告计划</a>
        	</span>
        </h2>
		<?php if( is_array(Tpl::$_tpl_vars["userPlans"][Tpl::$_tpl_vars["my"]->uid]) ){; ?>
			<?php foreach(Tpl::$_tpl_vars["userPlans"][Tpl::$_tpl_vars["my"]->uid] as Tpl::$_tpl_vars["userPlan"]){; ?>
	        <h3 id="plan_<?php echo htmlspecialchars(Tpl::$_tpl_vars["userPlan"]->plan_id, ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["plan_id"] == Tpl::$_tpl_vars["userPlan"]->plan_id){; ?> class="bort active" current="active"<?php }else{; ?> class="bort" <?php }; ?> onclick="location='/baichuan_advertisement_manage/ad.plan.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["userPlan"]->plan_id, ENT_QUOTES); ?>?nav=1'" title="<?php echo htmlspecialchars(Tpl::$_tpl_vars["userPlan"]->plan_name, ENT_QUOTES); ?>"><?php echo htmlspecialchars(tpl_modifier_wordbraek(Tpl::$_tpl_vars["userPlan"]->plan_name,20), ENT_QUOTES); ?></h3>
	        <div class="snav" style="display:block;" <?php if(Tpl::$_tpl_vars["plan_id"] == Tpl::$_tpl_vars["userPlan"]->plan_id){; ?> class="active" current="active"<?php }; ?>>
	          <ul>
				<?php if(Tpl::$_tpl_vars["userPlan"]->plan_id == Tpl::$_tpl_vars["plan_id"]){; ?>
					<?php foreach(Tpl::$_tpl_vars["groups"] as Tpl::$_tpl_vars["_group"]){; ?>
	            	<li <?php if(Tpl::$_tpl_vars["group_id"] == Tpl::$_tpl_vars["_group"]->group_id){; ?>class="sel"<?php }; ?>><a href="/ad.group.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["userPlan"]->plan_id, ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["_group"]->group_id, ENT_QUOTES); ?>?nav=1" title="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_group"]->name, ENT_QUOTES); ?>"><?php echo htmlspecialchars(tpl_modifier_wordbraek(Tpl::$_tpl_vars["_group"]->name,20), ENT_QUOTES); ?></a></li>
					<?php }; ?>
				<?php }; ?>
	          </ul>
	        </div>
			<?php }; ?>
		<?php }; ?>
    </div>
	
	<?php foreach(Tpl::$_tpl_vars["users"] as Tpl::$_tpl_vars["user"]){; ?>
		<?php if(Tpl::$_tpl_vars["user"]->uid != Tpl::$_tpl_vars["my"]->uid){; ?>
			<div class="accordion">
				<?php if(is_array(Tpl::$_tpl_vars["userPlans"][Tpl::$_tpl_vars["user"]->uid]) ){; ?>
			        <h2 <?php if(Tpl::$_tpl_vars["user_id"] == Tpl::$_tpl_vars["user"]->uid){; ?> class="left-nav-title-active" <?php }; ?> style="background: #1478DC;">
			        	<span style="margin-right: 10px; color:#1478DC; font-weight:bold;">
			        		<a href="/ad.plan?status=1&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->uid, ENT_QUOTES); ?>&nav=1" style="color:#FFFFFF; font-weight:normal;">
			        			<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->user_name, ENT_QUOTES); ?>
			        		</a>
			        	</span>
			        	<span style="float:right;">
			        		<a href="/ad.plan?status=0&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->uid, ENT_QUOTES); ?>&nav=1" style="color:#FFFFFF; font-weight:normal;">全部广告计划</a>
			        	</span>
			        </h2>
				<?php }else{; ?>
					<h2 class="nav-no-plan <?php if(Tpl::$_tpl_vars["user_id"] == Tpl::$_tpl_vars["user"]->uid){; ?> left-nav-title-active<?php }; ?>" style="background: #eeeeee;">
			        	<span style="margin-right: 10px; color:#666666; font-weight:normal;">
			        		<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->user_name, ENT_QUOTES); ?>
			        	</span>
			        	<span style="float:right;">
			        		<a href="/ad.plan?status=0&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->uid, ENT_QUOTES); ?>&nav=1" style="color:#0D6FB8; font-weight:normal; font-size:12px;">全部广告计划</a>
			        	</span>
			        </h2>
				<?php }; ?>
				
				<?php if(is_array(Tpl::$_tpl_vars["userPlans"][Tpl::$_tpl_vars["user"]->uid]) ){; ?>
					<?php foreach(Tpl::$_tpl_vars["userPlans"][Tpl::$_tpl_vars["user"]->uid] as Tpl::$_tpl_vars["userPlan"]){; ?>
			        <h3 id="plan_<?php echo htmlspecialchars(Tpl::$_tpl_vars["userPlan"]->plan_id, ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["plan_id"] == Tpl::$_tpl_vars["userPlan"]->plan_id){; ?> class="bort active" current="active"<?php }else{; ?> class="bort" <?php }; ?> onclick="location='/baichuan_advertisement_manage/ad.plan.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["userPlan"]->plan_id, ENT_QUOTES); ?>?nav=1'"><?php echo htmlspecialchars(Tpl::$_tpl_vars["userPlan"]->plan_name, ENT_QUOTES); ?></h3>
			        <div class="snav" style="display:block;" <?php if(Tpl::$_tpl_vars["plan_id"] == Tpl::$_tpl_vars["userPlan"]->plan_id){; ?> class="active" current="active"<?php }; ?>>
			          <ul>
						<?php if(Tpl::$_tpl_vars["userPlan"]->plan_id == Tpl::$_tpl_vars["plan_id"]){; ?>
							<?php foreach(Tpl::$_tpl_vars["groups"] as Tpl::$_tpl_vars["_group"]){; ?>
			            	<li <?php if(Tpl::$_tpl_vars["group_id"] == Tpl::$_tpl_vars["_group"]->group_id){; ?>class="sel"<?php }; ?>><a href="/ad.group.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["userPlan"]->plan_id, ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["_group"]->group_id, ENT_QUOTES); ?>?nav=1"><?php echo htmlspecialchars(Tpl::$_tpl_vars["_group"]->name, ENT_QUOTES); ?></a></li>
							<?php }; ?>
						<?php }; ?>
			          </ul>
			        </div>
					<?php }; ?>
				<?php }; ?>
		    </div>
		<?php }; ?>
	<?php }; ?>