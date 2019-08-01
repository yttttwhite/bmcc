<!DOCTYPE html>
<html>
<head>
<meta https-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.media"), ENT_QUOTES); ?>
<script>
$(document).ready(function(){
		$(".toufang").click(function(){
			var t=$(this).parents("td").find("textarea").text();
			$("#adcode_t").text(t);
			ShowDIV('pgetCode')
			event.preventDefault()
		});
});
</script>
<!--main-->

<!--main-->
<div class="main">
  <div class="side">
  <?php echo htmlspecialchars(tpl_function_part(("/media.main.nav.position.list")), ENT_QUOTES); ?> 
  </div>
  
  <!--mcon start-->
  <div class="mcon">
	<div class="toolbar-bc fl" style="margin-bottom:13px;">
    	<div class="fl sub-title sc-title">
    		<a href="/baichuan_advertisement_manage/media?nav=2">媒体管理</a>
			<i class="fa fa-angle-double-right"></i>
			广告位置
    	</div>
    <form action="/media.position?nav=2" method="get">
        <input name="nav" type="hidden" value="2">
    <div class="fl" >
      <div class="selMenu" style="margin-right:10px">
          <span class="iSearch">
                 <input id="channel_name" name="position_name" type="text" class="itxt fc7" placeholder="位置名称" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['position_name'], ENT_QUOTES); ?>" size="30" />
              </span>
        </div>

    </div>
    <div class="fr">
      <input type="submit" class="btn btn-squared btn-success" value="搜索">
    </div>
    </form>
	</div>
  
	<!--遮罩pop start-->
        <div id="BgDiv"></div>
        <div id="pgetCode" class="popdiv pop_getCode" style="display:none">
          <div class="dbg">
            <div class="pmain">
            <div class="ptit">
              <div class="ptname">获取投放代码</div>
              <div class="ptclose"><a href="javascript:;" id="btnClose" onClick="closeDiv('pgetCode')"><img src="/baichuan_advertisement_manage/assets_admin/img//i_close.png" alt="关闭" /></a></div>
            </div>
            <div class="dcon">
                
                <div class="gcform clear">
                投放代码：<br /><textarea id="adcode_t" class="gctxtea" name="" cols="80" rows="10"></textarea>
                </div>
                                 
                <div class="dpbtn">
                  <div class="fr">
                    <span class="sbtnb ml30"><input name="" type="button" class="ibtnb" value="复制" onClick="closeDiv('pgetCode')" /></span>
                    <span class="sbtng ml15"><input name="" type="button" class="ibtng" value="取消" onClick="closeDiv('pgetCode')" /></span>
                  </div>
                </div>
  
            </div>
            </div>
          </div>
        </div>
        <!--遮罩pop end-->
  
  <div class="clear"></div>
  <!--<div style="overflow: auto;">-->
    <!--toolbar start--> 
    <!--<table width="100%" border="0" cellspacing="0" cellpadding="0" class="reportab" style="white-space: nowrap;">-->
      <!--<div class="infoTable" style="width: 100%;height: 1300px;" >-->
         <!--<table class="table table-striped table-bordered table-hover">-->
      <!--<div class="panel-body" style="overflow-x: auto;" >-->
      <div style="overflow-x: auto;" >
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="reportab">
      <tr>
        <th class="tac">ID</th>
        <th>位置名称</th>
        <th>位置标识</th>
        <!--<th>所属频道</th>-->
        <!--<th>所属媒体</th>-->
        <th class="tac">位置信息</th>
        <!--<th>引用地址</th>-->
        <th>展示单价<br>(元/CPM)</th>
        <th>点击单价<br>(元/CPC)</th>
        <th>点击单价<br>(元/CPT)</th>
        <th>位置状态</th>
        <th>创建/更新时间</th>
        <th>操作账户</th>
        <th style="width: 105px;">操作</th>
      </tr>
<?php foreach(Tpl::$_tpl_vars["positions"] as Tpl::$_tpl_vars["item"]){; ?>
      <tr>
        <td class="tac"><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->id, ENT_QUOTES); ?></td>
        <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->position_name, ENT_QUOTES); ?></td>
        <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->position_identification, ENT_QUOTES); ?></td>
        <!--<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["id2channel"][Tpl::$_tpl_vars["item"]->channel_id]->channel_name, ENT_QUOTES); ?></td>-->
        <!--<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["id2media"][Tpl::$_tpl_vars["item"]->media_id]->media_name, ENT_QUOTES); ?></td>-->
        <td class="tac" nowrap style="padding: 0;">
            <span>形式：<?php if(Tpl::$_tpl_vars["item"]->first_screen==1){; ?>首屏<?php }else{; ?>非首屏<?php }; ?></span><br/>
            <span>素材：<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuff_types"][Tpl::$_tpl_vars["item"]->stuff_type], ENT_QUOTES); ?></span><br/>
            <span>尺寸：<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->width, ENT_QUOTES); ?>*<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->height, ENT_QUOTES); ?></span>
        </td>
        <!--<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["id2media"][Tpl::$_tpl_vars["item"]->media_id]->reference_addr, ENT_QUOTES); ?></td>-->
        <td>￥<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->cpm, ENT_QUOTES); ?></td>
        <td>￥<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->cpc, ENT_QUOTES); ?></td>
        <td>￥<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->cpt, ENT_QUOTES); ?></td>
        <td><?php if(Tpl::$_tpl_vars["item"]->status==1){; ?>启用<?php }else{; ?>停用<?php }; ?></td>
        <td nowrap>
        创:<?php echo htmlspecialchars(date("Y-m-d H:i:s",Tpl::$_tpl_vars["item"]->create_time), ENT_QUOTES); ?><br/>更:<?php echo htmlspecialchars(date("Y-m-d H:i:s",Tpl::$_tpl_vars["item"]->alter_time), ENT_QUOTES); ?>
        </td>
        <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["id2name"][Tpl::$_tpl_vars["item"]->creator_id], ENT_QUOTES); ?></td>
        <td>
            <a href="/baichuan_advertisement_manage/media.position.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->id, ENT_QUOTES); ?>?media_id=<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->media_id, ENT_QUOTES); ?>&channel_id=<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->channel_id, ENT_QUOTES); ?>&nav=2">编辑</a>
            <a class="btn_read" onclick='showWindow("/media.position.detail?position_id=<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->id, ENT_QUOTES); ?>&media_id=<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->media_id, ENT_QUOTES); ?>&channel_id=<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]->channel_id, ENT_QUOTES); ?>")'>
            查看详情
            </a>
        </td>
      </tr>
<?php }; ?>
    </table>
          <div class="turnpage">
              <?php echo tpl_function_turnpager(Tpl::$_tpl_vars["totalPage"]); ?>
          </div>

    </div>
    



  </div>
  <!--mcon end-->
</div>
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
</body>

<script>

    function showWindow(url){
        var w = window.open(url,"_blank","toolbar=yes, location=no, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=550, height=650");
    }

</script>
</html>
