<!DOCTYPE html>
<html>
<head>
<meta https-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.media"), ENT_QUOTES); ?>
<script src="/baichuan_advertisement_manage/assets_admin/highcharts/js/highcharts.js" ></script>
<!--main-->

<!--main-->
<div class="main">
  <div class="side">
  <?php echo htmlspecialchars(tpl_function_part(("/media.main.nav.media.list")), ENT_QUOTES); ?> 
  </div>
  
  <!--mcon start-->
  <div class="mcon">
  	<div class="toolbar-bc fl" style="margin-bottom:13px;">
    	<div class="fl sub-title sc-title">
    		<a href="/baichuan_advertisement_manage/media?nav=2">媒体管理</a>
			<i class="fa fa-angle-double-right"></i>
			媒体来源
    	</div>
    <form method="get">
        <input name="nav" type="hidden" value="2">
		<div class="fl" >
      <div class="selMenu" style="margin-right:10px">
          <span class="iSearch">
                 <input id="media_name" name="media_name" type="text" class="itxt fc7" placeholder="媒体名称" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['media_name'], ENT_QUOTES); ?>" size="30" />
              </span>
        </div>
        <div class="selMenu smzt ml-10" >
          <span class="iSearch">
            <select name="type" class="itxt fc7 ml-10" style="height: 34px;">
              <option value="">媒体类型</option>
              <?php foreach(array("website"=>"网站","app"=>"APP","adx"=>"ADX","inside"=>"内部","others"=>"其他") as Tpl::$_tpl_vars["_index1"]=>Tpl::$_tpl_vars["_type"]){; ?>
                <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_index1"], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["_GET"]['type']==Tpl::$_tpl_vars["_index1"]){; ?>selected<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["_type"], ENT_QUOTES); ?></option>
              <?php }; ?>
            </select>
          </span>
        </div>
		</div>
		<div class="fr">
			<input type="submit" class="btn btn-squared btn-success" value="搜索">
		</div>
    </form>
	</div>
  <div class="clear"></div>
  <div style="overflow: auto;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="reportab">
      <tr>
        <th>ID</th>
        <th>媒体名称</th>
        <th>媒体标识</th>
        <th>媒体类型</th>
        <th>行业类型</th>
        <th>引流地址</th>
        <th>媒体状态</th>
        <th>创建/更新时间</th>
        <th>操作账户</th>
        <th>操作</th>
      </tr>
<?php foreach(Tpl::$_tpl_vars["medias"] as Tpl::$_tpl_vars["_m"]){; ?>
      <tr>
        <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_m"]->id, ENT_QUOTES); ?></td>
        <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_m"]->media_name, ENT_QUOTES); ?></td>
        <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_m"]->identification, ENT_QUOTES); ?></td>
        <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["web_types"][Tpl::$_tpl_vars["_m"]->media_type], ENT_QUOTES); ?></td>
        <td>大类：<?php echo htmlspecialchars(Tpl::$_tpl_vars["types"][Tpl::$_tpl_vars["_m"]->career_type]->cate_name, ENT_QUOTES); ?><br/>小类：<?php echo htmlspecialchars(Tpl::$_tpl_vars["types"][Tpl::$_tpl_vars["_m"]->career_type]->type_name, ENT_QUOTES); ?></td>
        <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_m"]->reference_addr, ENT_QUOTES); ?></td>
        <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["m_status"][Tpl::$_tpl_vars["_m"]->media_status], ENT_QUOTES); ?></td>
        <td>
            创:<?php echo htmlspecialchars(date("Y-m-d H:i:s",Tpl::$_tpl_vars["_m"]->create_time), ENT_QUOTES); ?><br/>更:<?php echo htmlspecialchars(date("Y-m-d H:i:s",Tpl::$_tpl_vars["_m"]->alter_time), ENT_QUOTES); ?>
        </td>
        <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["id2name"][Tpl::$_tpl_vars["_m"]->creator_id], ENT_QUOTES); ?></td>
        <td>
            <a href="/baichuan_advertisement_manage/media.main.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["_m"]->id, ENT_QUOTES); ?>?nav=2">编辑  查看</a><br/>
            <a href="/baichuan_advertisement_manage/media.channel.add?media_id=<?php echo htmlspecialchars(Tpl::$_tpl_vars["_m"]->id, ENT_QUOTES); ?>&nav=2">创建频道</a><br/>
            <a href="/baichuan_advertisement_manage/media.channel.entry.<?php echo htmlspecialchars(Tpl::$_tpl_vars["_m"]->id, ENT_QUOTES); ?>?nav=2">查看频道</a>
        </td>
      </tr>
<?php }; ?>
    </table>
    </div>
    <div class="turnpage">
    <?php echo tpl_function_turnpager(Tpl::$_tpl_vars["totalPage"]); ?>
    </div>
    
    
  </div>
  <!--mcon end-->
  
</div>



<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>

</body>
</html>
