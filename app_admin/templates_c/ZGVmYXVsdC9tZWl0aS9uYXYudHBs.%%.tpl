<?php if(Tpl::$_tpl_vars["nav"]=="media"){; ?>
<a class="btn btn-squared btn-success" href="/media.main.add?nav=2" style="width: 100%; background: #12C043;">创建媒体</a>
<br/><br/>
<?php }; ?>

<?php if(Tpl::$_tpl_vars["nav"]=="channel"){; ?>
<a class="btn btn-squared btn-success" href="/media.channel.add?nav=2" style="width: 100%; background: #12C043;">创建频道</a>
<br/><br/>
<?php }; ?>

<?php if(Tpl::$_tpl_vars["nav"]=="tag"){; ?>
<a class="btn btn-squared btn-success" href="/media.tag.add?nav=2" style="width: 100%; background: #12C043;">创建广告位分类</a>
<br/><br/>
<?php }; ?>

<?php if(Tpl::$_tpl_vars["nav"]=="position"){; ?>
<a class="btn btn-squared btn-success" href="/media.position.add?nav=2" style="width: 100%; background: #12C043;">创建位置</a>
<br/><br/>
<?php }; ?>


<div class="accordion" style="margin-top:0;">
	<h2>媒体管理</h2>
<?php if(user_api::auth("media") && Tpl::$_tpl_vars["config"]['dsp']['media']){; ?>
	<a href="/media?nav=2"><h3 class="bort <?php if(Tpl::$_tpl_vars["nav"]=="media"){; ?>active<?php }; ?>">媒体来源</h3></a>

	<a href="/media.channel?nav=2"><h3 class="bort <?php if(Tpl::$_tpl_vars["nav"]=="channel"){; ?>active<?php }; ?>">频道专题</h3></a>

    <a href="/media.tag?nav=2"> <h3 class="bort <?php if(Tpl::$_tpl_vars["nav"]=="tag"){; ?>active<?php }; ?>">广告位分类</h3></a>

    <a href="/media.position?nav=2"> <h3 class="bort <?php if(Tpl::$_tpl_vars["nav"]=="position"){; ?>active<?php }; ?>">广告位置</h3></a>
<?php }; ?>
    <a href="/media.schedule?nav=2" > <h3 class="bort <?php if(Tpl::$_tpl_vars["nav"]=="schedule"){; ?>active<?php }; ?>">广告位排期</h3></a>

</div>
