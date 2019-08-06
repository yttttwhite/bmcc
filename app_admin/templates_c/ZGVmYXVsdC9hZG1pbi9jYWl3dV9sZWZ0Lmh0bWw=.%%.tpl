<div class="accordion" style="margin-top:0;">
	<h2>财务管理</h2>
	<a href="/baichuan_advertisement_manage/admin.caiwu.list?admin=<?php echo htmlspecialchars(Tpl::$_tpl_vars["admin"], ENT_QUOTES); ?>&menu=1&nav=5">
	    <h3 class="bort <?php if(Tpl::$_tpl_vars["_GET"]['menu'] ==1){; ?>active<?php }; ?>">用户账务</h3>
	</a>
	<a href="/baichuan_advertisement_manage/admin.caiwu.stream?admin=<?php echo htmlspecialchars(Tpl::$_tpl_vars["admin"], ENT_QUOTES); ?>&menu=2&nav=5">
	    <h3 class="bort <?php if(Tpl::$_tpl_vars["_GET"]['menu'] ==2){; ?>active<?php }; ?>">财务流水</h3>
	</a>
	<a href="/baichuan_advertisement_manage/admin.caiwu.userbill?admin=<?php echo htmlspecialchars(Tpl::$_tpl_vars["admin"], ENT_QUOTES); ?>&menu=3&nav=5" >
	    <h3 class="bort <?php if(Tpl::$_tpl_vars["_GET"]['menu'] ==3){; ?>active<?php }; ?>">用户账单【天】</h3>
	</a>
	<a href="/baichuan_advertisement_manage/admin.caiwu.planbill?admin=<?php echo htmlspecialchars(Tpl::$_tpl_vars["admin"], ENT_QUOTES); ?>&menu=4&nav=5" >
	    <h3 class="bort <?php if(Tpl::$_tpl_vars["_GET"]['menu'] ==4){; ?>active<?php }; ?>">广告计划账单【天】</h3>
	</a>
</div>
