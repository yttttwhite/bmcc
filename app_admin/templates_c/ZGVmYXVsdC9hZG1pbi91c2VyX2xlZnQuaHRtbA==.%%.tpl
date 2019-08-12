<?php if(user_api::auth(["system","admin"],"or")){; ?>
<div class="mb-10">
	<a class="btn btn-success btn-squared" style="width:235px;" href="/baichuan_advertisement_manage/admin.user.add?nav=5">创建用户</a>
</div>
<?php }; ?>
<div class="accordion" style="margin-top:0;">
	<h2>账户管理</h2>
    <?php if(Tpl::$_tpl_vars["admin"]){; ?>
		<a href="/baichuan_advertisement_manage/admin.user.list?nav=5">
			<!--<h3 class="bort <?php if(isset(Tpl::$_tpl_vars["get"]['role'])&&Tpl::$_tpl_vars["get"]['role']==Tpl::$_tpl_vars["roleId"]){; ?>active<?php }; ?>" >全部账户  </h3>-->
			<h3 class="bort <?php if(empty(Tpl::$_tpl_vars["get"]['role'])){; ?>active<?php }; ?>" >全部账户  </h3>
		</a>
    <?php }; ?>
	<?php foreach(Tpl::$_tpl_vars["roleList"] as Tpl::$_tpl_vars["roleId"]=>Tpl::$_tpl_vars["role"]){; ?>
		<a href="/baichuan_advertisement_manage/admin.user.list?role=<?php echo htmlspecialchars(Tpl::$_tpl_vars["roleId"], ENT_QUOTES); ?>&admin=<?php echo htmlspecialchars(Tpl::$_tpl_vars["admin"], ENT_QUOTES); ?>&nav=5">
			<h3 class="bort <?php if(isset(Tpl::$_tpl_vars["get"]['role'])&&Tpl::$_tpl_vars["get"]['role']==Tpl::$_tpl_vars["roleId"]){; ?>active<?php }; ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["role"]['name'], ENT_QUOTES); ?></h3>
		</a>
	<?php }; ?>
</div>
