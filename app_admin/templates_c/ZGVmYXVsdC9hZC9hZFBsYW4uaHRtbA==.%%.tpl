<!DOCTYPE html>
<html>
<head>
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.ad"), ENT_QUOTES); ?>
<!--main-->
<style>
.selMenu ul{
	z-index:999;
}
</style>
<div class="main">
  <div class="side">
<?php echo htmlspecialchars(tpl_function_part("/ad.plan.listpart"), ENT_QUOTES); ?>
  </div>
  <!--mcon start-->
  <div class="mcon">

    <!--toolbar-bc start-->
    <div class="toolbar-bc fl">
      <div id="leixing" class="selMenu smjh">
        <span class="smtit">所有广告计划</span>
        <ul>
<?php foreach(Tpl::$_tpl_vars["plans2"] as Tpl::$_tpl_vars["_plan"]){; ?>
          <li><a href="/baichuan_advertisement_manage/ad.plan.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_name, ENT_QUOTES); ?></a></li>
<?php }; ?>
        </ul>
      </div>
     <script>
	 $(document).ready(function(){
    var sd = $("#startdate").add("#startdate2").datepicker({ dateFormat: "yy-mm-dd"})
    var ed = $("#enddate").add("#enddate2").datepicker({ dateFormat: "yy-mm-dd"})
    if("<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["start"],0), ENT_QUOTES); ?>") ed.datepicker( "option", "minDate", "<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>" );
    if("<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["end"],0), ENT_QUOTES); ?>") sd.datepicker( "option", "maxDate", "<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>" );
	 });
     </script>
      <div class="selMenu ml10">
        <div class="smtbg bg-eee">
          <input type="text" class="itxt_1 fl idate" id="startdate" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["start"],'开始时间'), ENT_QUOTES); ?>" size="15" />
          <input type="text" class="itxt_1 fl idate" id="enddate" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["end"],'结束时间'), ENT_QUOTES); ?>" size="15" />
        </div>
      </div>

      <div class="tbGroup ml10">
	  <style>
	  .tbgBtn{
		cursor:pointer;
	  }</style>
        <span id="r_menu" class="tbgBtn">
          <a id="r_today" class="tbgba">今天</a>
          <a id="r_yesterday" class="tbgba">昨天</a>
          <a id="r_week" class="tbgba">本周</a>
          <a id="r_lastweek" class="tbgba">上周</a>
          <a id="r_month" class="tbgba">本月</a>
          <a id="r_lastmoth" class="tbgba nobr">上月</a>
        </span>
      </div>

      <div class="selMenu ml10">
        <div class="smtbg bg-eee">
        趋势指标：
          <label for="mrf">					<input name="rqxz" readonly checked id="mrf" type="checkbox" value="" /> 展示量</label>
          <label class="ml10"  for="mr">	<input name="rqxz" readonly checked id="mr" type="checkbox" value="" /> 点击量</label>
          <label class="ml10"  for="jpf">	<input name="rqxz" readonly checked id="jpf" type="checkbox" value="" /> 花费</label>
        </div>
      </div>

      <div class="clear"></div>
    </div>
    <!--toolbar-bc end-->

    <div class="chartCon" style="margin-top:12px;">
      <div class="chartShow" style="height:400px" id="chartShow"><?php /*<img src="/baichuan_advertisement_manage/assets_admin/img/tmp_chart.gif" />*/?></div>
    </div>

	<script>
	var paras={ };
	paras.start="<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>";
	paras.end="<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>";
    paras.id = "<?php echo htmlspecialchars(Tpl::$_tpl_vars["id"], ENT_QUOTES); ?>";
	//$(document).ready(function(){
		if(paras.start==paras.end && paras.end=="<?php echo htmlspecialchars(date('Y-m-d'), ENT_QUOTES); ?>"){
			$("#r_today").addClass('sel');
		}
		if(paras.start==paras.end && paras.end=="<?php echo htmlspecialchars(date('Y-m-d',time()-3600*24), ENT_QUOTES); ?>"){
			$("#r_yesterday").addClass('sel');
		}
		if(paras.start=="<?php echo htmlspecialchars(date('Y-m-d',strtotime('-1 week Monday')), ENT_QUOTES); ?>" && paras.end=="<?php echo htmlspecialchars(date('Y-m-d',strtotime('+0 week Sunday')), ENT_QUOTES); ?>"){
			$("#r_week").addClass("sel");
		}
		if(paras.start=="<?php echo htmlspecialchars(date('Y-m-d',strtotime('-2 week Monday')), ENT_QUOTES); ?>" && paras.end=="<?php echo htmlspecialchars(date('Y-m-d',strtotime('-1 week Sunday')), ENT_QUOTES); ?>"){
			$("#r_lastweek").addClass("sel");
		}
		if(paras.start=="<?php echo htmlspecialchars(date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y'))), ENT_QUOTES); ?>" && paras.end=="<?php echo htmlspecialchars(date('Y-m-d',time()), ENT_QUOTES); ?>"){
			$("#r_month").addClass("sel");
		}
		if(paras.start=="<?php echo htmlspecialchars(date('Y-m-d',mktime(0, 0 , 0,date('m')-1,1,date('Y'))), ENT_QUOTES); ?>" && paras.end=="<?php echo htmlspecialchars(date('Y-m-d',mktime(23,59,59,date('m') ,0,date('Y'))), ENT_QUOTES); ?>"){
			$("#r_lastmoth").addClass("sel");
		}

	//});
  function setV(){
	  $("#startdate").val(paras.start);
	  $("#enddate").val(paras.end);
	  location="/ad.plan?start="+paras.start+"&end="+paras.end+"&uid="+paras.id;
  }
	$("#r_menu a").click(function(){
			$(this).parent().find("A").removeClass("sel");
			$(this).addClass("sel");
	});
	$("#startdate").change(function(){
			paras.start=$(this).val();
			setV();
			//report("#chartShow",paras);
	});
	$("#enddate").change(function(){
			paras.end=$(this).val();
			setV();
			//report("#chartShow",paras);
	});
	$("#r_today").click(function(){
		paras.start="<?php echo htmlspecialchars(date('Y-m-d'), ENT_QUOTES); ?>";
		paras.end="<?php echo htmlspecialchars(date('Y-m-d'), ENT_QUOTES); ?>";
		setV();
		//report("#chartShow",paras);
	});
	$("#r_yesterday").click(function(){
		paras.start="<?php echo htmlspecialchars(date('Y-m-d',time()-3600*24), ENT_QUOTES); ?>";
		paras.end="<?php echo htmlspecialchars(date('Y-m-d',time()-3600*24), ENT_QUOTES); ?>";
		setV();
		//report("#chartShow",paras);
	});
	$("#r_week").click(function(){
		paras.start="<?php echo htmlspecialchars(date('Y-m-d',strtotime('-1 week Monday')), ENT_QUOTES); ?>";
		paras.end="<?php echo htmlspecialchars(date('Y-m-d',strtotime('+0 week Sunday')), ENT_QUOTES); ?>";
		setV();
		//report("#chartShow",paras);
	});
	$("#r_lastweek").click(function(){
		paras.start="<?php echo htmlspecialchars(date('Y-m-d',strtotime('-2 week Monday')), ENT_QUOTES); ?>";
		paras.end="<?php echo htmlspecialchars(date('Y-m-d',strtotime('-1 week Sunday')), ENT_QUOTES); ?>";
		setV();
		//report("#chartShow",paras);
	});
	$("#r_month").click(function(){
		paras.start="<?php echo htmlspecialchars(date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y'))), ENT_QUOTES); ?>";
		paras.end="<?php echo htmlspecialchars(date('Y-m-d',time()), ENT_QUOTES); ?>";
		setV();
		//report("#chartShow",paras);
	});
	$("#r_lastmoth").click(function(){
		paras.start="<?php echo htmlspecialchars(date('Y-m-d',mktime(0, 0 , 0,date('m')-1,1,date('Y'))), ENT_QUOTES); ?>";
		paras.end="<?php echo htmlspecialchars(date('Y-m-d',mktime(23,59,59,date('m') ,0,date('Y'))), ENT_QUOTES); ?>";
		setV();
		//report("#chartShow",paras);
	});
	//report("#chartShow",paras);
	report_echarts("chartShow",paras);
	</script>


    <!--toolbar-bc start-->
    <div class="toolbar-bc">

      <div id="zhuantai" class="selMenu smzt">
        <span class="smtit">
			<?php if(Tpl::$_tpl_vars["status"]==1){; ?>已启动
			<?php }elseif( Tpl::$_tpl_vars["status"]==2){; ?>已暂停
			<?php }elseif( Tpl::$_tpl_vars["status"]==3){; ?>非投放时间
			<?php }elseif( Tpl::$_tpl_vars["status"]==4){; ?>已删除
            <?php }elseif( Tpl::$_tpl_vars["status"]==5){; ?>冻结
			<?php }elseif( Tpl::$_tpl_vars["status"]==6){; ?>没预算
			<?php }elseif( Tpl::$_tpl_vars["status"]==7){; ?>已停止
			<?php }else{; ?>所有状态<?php }; ?></span>
        <ul id="status">
          <li><a status="0">所有状态</a></li>
          <li><a status="1">已启动</a></li>
          <li><a status="2">已暂停</a></li>
		  <li><a status="3">非投放时间</a></li>
		  <li><a status="4">已删除</a></li>
          <li><a status="5">冻结</a></li>
		  <li><a status="6">没预算</a></li>
		  <li><a status="7">已停止</a></li>
        </ul>
      </div>

      <div class="selMenu ml30">
        <div class="smtbg">
          <input type="text" class="itxt_1 fl idate" id="startdate2" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["start"],'开始时间'), ENT_QUOTES); ?>" size="15" />
          <input type="text" class="itxt_1 fl idate" id="enddate2" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["end"],'结束时间'), ENT_QUOTES); ?>" size="15" />
        </div>
      </div>
	  <script>
	var paras2={ };
	paras2.start="<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>";
	paras2.end="<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>";
	paras2.status="<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>";
	paras2.uid="<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>";
	function reload(){
		location="/ad.plan?start="+paras2.start+"&end="+paras2.end+"&status="+paras2.status+"&uid="+paras2.uid;
	}
	$("#status a").click(function(){
			paras2.status=$(this).attr("status");
			reload();
	});
	  $("#startdate2").change(function(){
			  paras2.start=$(this).val();
			  reload();
	});
	  $("#enddate2").change(function(){
			  paras2.end=$(this).val();
			  reload();
	});
	  </script>

      <div class="tbGroup ml30">
        <span class="tbgBtn">
          <a type="start" class="status-change tbgiba"  title="启动"><i class="fa fa-play"></i></a>
          <a type="stop" class="status-change tbgiba nobr"  title="暂停"><i class="fa fa-pause"></i></a>
          <a type="del" class="status-change tbgiba nobr" title="删除"><i class="fa fa-trash-o"></i></a>
          <a type="terminated" class="status-change tbgiba nobr" title="停止"><i class="glyphicon glyphicon-remove"></i></a>
        </span>
		</div>
      <div style="float:right" class="tbGroup ml30">
        <span >
		<a href="#"  style="padding-left:10px;padding-right:10px;height: 33px; line-height: 33px; font-size: 12px;" class="nobr" onclick="tableToExcel('report_dat','数据报表');return false;">导出</a>
        </span>
      </div>
      <script>
      $(document).ready(function(){
		$(".status-change").click(function(){
			var checked = $(".reportab input:checkbox:checked[value]");
			var type=$(this).attr("type");
			if(checked.size()<=0){
				layer.msg('请选择广告计划');
			}else{
			  var msg="确认执行此操作？";
			  if(type=="terminated"){
			    msg="点击停止按钮后该广告计划将终止投放,"+msg;
			  }
			  var planid=[],isAllstop = false,isAllStart=false;
			  checked.each(function(i,item){
          if(type === "terminated" && $(item).attr("data-type") === "7"){
            isAllstop = true;
            return false;
          }
          else if (type === "start" && $(item).attr("data-type") === "7"){
            isAllStart = true;
            return false;
          }
          planid.push($(item).val());
        })
        if(isAllstop){
          layer.msg("已停止的广告计划不能重复提交");
          return;
        }
        if(isAllStart){
          layer.msg("已停止的广告计划无法启动");
          return;
        }
				var index = layer.confirm(msg, function(){
					$.ajax({
						type: "POST",
						url: "/baichuan_advertisement_manage/ad.plan.status."+type,
						data: { plan_ids:planid },
						dataType:"json",
						success: function(msg){
							location.reload();
						},
						error:function(msg){
							alert('更新失败：请检查是否有权限。');
						}
					});
				});
			}
			return false;
		});
	});
      </script>
      <div class="clear"></div>
    </div>
    <!--toolbar-bc end-->

    <table id="report_dat" width="100%" border="0" cellspacing="0" cellpadding="0" class="reportab mt20">
      <tr>
        <th class="tac"><input name="" class="checkall" id="checkedAll" type="checkbox"/></th>
        <th>广告计划</th>
        <?php if(Tpl::$_tpl_vars["currentUserName"] == 'admin'){; ?>
        <th>创建者</th>
        <th>广告主</th>
        <?php }; ?>
        <th>总预算</th>
		<th>日预算</th>
        <th>状态</th>
		<th>审核</th>
        <th>类型</th>
        <th>有效期</th>
        <th class="tac">展现数</th>
        <th class="tac">点击数</th>
        <th class="tac">点击率</th>
        <!-- <th class="tac"> 差额</th> -->
        <th class="tac">总费用</th>
        <th class="tac">设置</th>
      </tr>
<?php foreach(Tpl::$_tpl_vars["plans2"] as Tpl::$_tpl_vars["_plan"]){; ?>
	<?php if(isset(Tpl::$_tpl_vars["_plan"]->billing_type) && Tpl::$_tpl_vars["_plan"]->billing_type == 1){; ?>
		<?php Tpl::$_tpl_vars["_plan"]->budget_total = Tpl::$_tpl_vars["_plan"]->total_cpc; ?>
	<?php }else{; ?>
		<?php Tpl::$_tpl_vars["_plan"]->budget_total = Tpl::$_tpl_vars["_plan"]->total_cpm; ?>
	<?php }; ?>
      <tr>
        <td class="tac"><input name="plan_id[]" type="checkbox" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>" data-type="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->enable, ENT_QUOTES); ?>"/></td>
        <!--<td style="max-width: 170px;overflow:hidden;word-wrap:break-word;word-break:break-all;white-space:normal;"><a href="/baichuan_advertisement_manage/ad.plan.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>" title="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_name, ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_name, ENT_QUOTES); ?></a></td>-->
        <td style="max-width: 135px;overflow:hidden;word-wrap:break-word;word-break:break-all;white-space:normal;"><a href="/baichuan_advertisement_manage/ad.plan.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>" title="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_name, ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_name, ENT_QUOTES); ?></a></td>
        <?php if(Tpl::$_tpl_vars["currentUserName"] == 'admin'){; ?>
        <td style="max-width: 70px;overflow:hidden;word-wrap:break-word;word-break:break-all;white-space:normal;"><span><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->creator_name, ENT_QUOTES); ?></span></td>
        <td style="max-width: 80px;overflow:hidden;word-wrap:break-word;word-break:break-all;white-space:normal;"><a href="/baichuan_advertisement_manage/ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->uid, ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->user_name, ENT_QUOTES); ?></a></td>
        <?php }; ?>
        <td><?php if(Tpl::$_tpl_vars["_plan"]->budget_total==-1){; ?>不限<?php }else{; ?><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->budget_total, ENT_QUOTES); ?><?php }; ?></td>
        <td><?php if(Tpl::$_tpl_vars["_plan"]->budget==-1){; ?>不限<?php }else{; ?><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->budget, ENT_QUOTES); ?><?php }; ?></td>
        <td><?php if(Tpl::$_tpl_vars["_plan"]->enable==1){; ?>已启动
          <?php }elseif( Tpl::$_tpl_vars["_plan"]->enable==2){; ?>已暂停
          <?php }elseif( Tpl::$_tpl_vars["_plan"]->enable==3){; ?>非投放时间
          <?php }elseif( Tpl::$_tpl_vars["_plan"]->enable==4){; ?>已删除
          <?php }elseif( Tpl::$_tpl_vars["_plan"]->enable==5){; ?>冻结
          <?php }elseif( Tpl::$_tpl_vars["_plan"]->enable==6){; ?>预算不足
          <?php }elseif( Tpl::$_tpl_vars["_plan"]->enable==7){; ?>已停止
          <?php }; ?></td>
		<td><?php if(Tpl::$_tpl_vars["_plan"]->verified_or_not==1){; ?>待审<?php }elseif( Tpl::$_tpl_vars["_plan"]->verified_or_not==2){; ?>通过<?php }elseif( Tpl::$_tpl_vars["_plan"]->verified_or_not==3){; ?>未通过<?php }else{; ?>未提交<?php }; ?></td>
        <td><?php if(Tpl::$_tpl_vars["_plan"]->billing_type==1){; ?>CPC<?php }else{; ?>CPM<?php }; ?></td>
        <td><?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["_plan"]->start_date,'未设置'), ENT_QUOTES); ?> - <?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["_plan"]->end_date,"未设置"), ENT_QUOTES); ?></td>
        <td class="tac"><?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_plan"]->report->show,1,".",","), ENT_QUOTES); ?></td>
        <td class="tac"><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->report->click, ENT_QUOTES); ?></td>
        <td class="tac"><?php if(!empty(Tpl::$_tpl_vars["_plan"]->report->show)){; ?><?php echo htmlspecialchars(round(Tpl::$_tpl_vars["_plan"]->report->click*100/Tpl::$_tpl_vars["_plan"]->report->show,3), ENT_QUOTES); ?>%<?php }; ?></td>
        <!--td class="tac"><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->report->push, ENT_QUOTES); ?></td-->
        <!-- <td class="tac"><?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_plan"]->report->cost-Tpl::$_tpl_vars["_plan"]->report->click * Tpl::$_tpl_vars["_plan"]->cpc，2,".",","), ENT_QUOTES); ?>元</td>  -->
        <td class="tac"><?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_plan"]->report->cost,2,".",","), ENT_QUOTES); ?>元</td>
        <td class="tac"><a href="/baichuan_advertisement_manage/ad.plan.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>">设置</a></td>
      </tr>
<?php }; ?>
    </table>

    <div class="cp-table-footer">
      <div style="color:black">每页显示</div>
      <select id="pageSel" class="pageSel">
        <option value="5"  <?php if(Tpl::$_tpl_vars["pageSel"]=="5"){; ?> selected <?php }; ?>>5</option>
        <option value="10" <?php if(Tpl::$_tpl_vars["pageSel"]=="10"){; ?> selected <?php }; ?>>10</option>
        <option value="20" <?php if(Tpl::$_tpl_vars["pageSel"]=="20"){; ?> selected <?php }; ?>  <?php if(!isset(Tpl::$_tpl_vars["pageSel"])){; ?> selected <?php }; ?>>20</option>
        <option value="50" <?php if(Tpl::$_tpl_vars["pageSel"]=="50"){; ?> selected <?php }; ?>>50</option>
        <option value="100" <?php if(Tpl::$_tpl_vars["pageSel"]=="100"){; ?> selected <?php }; ?>>100</option>
      </select>
      <div class="cp-page-select">
        <ul class="cp-page-ul">
          <?php if(Tpl::$_tpl_vars["pageNum"]<4){; ?>
          <li><a <?php if(Tpl::$_tpl_vars["pageNum"]==1){; ?>style="background:white;color:black" <?php }; ?> <?php if(!isset(Tpl::$_tpl_vars["pageNum"])){; ?>style="background:white;color:black" <?php }; ?> <?php if(Tpl::$_tpl_vars["maxPage"]<1){; ?>style="display:none;" <?php }; ?> href="ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=1&pageSel=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageSel"], ENT_QUOTES); ?>&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>">1</a></li>
          <li><a <?php if(Tpl::$_tpl_vars["pageNum"]==2){; ?>style="background:white;color:black" <?php }; ?> <?php if(Tpl::$_tpl_vars["maxPage"]<2){; ?>style="display:none;" <?php }; ?> href="ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=2&pageSel=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageSel"], ENT_QUOTES); ?>&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>">2</a></li>
          <li><a <?php if(Tpl::$_tpl_vars["pageNum"]==3){; ?>style="background:white;color:black" <?php }; ?> <?php if(Tpl::$_tpl_vars["maxPage"]<3){; ?>style="display:none;" <?php }; ?> href="ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=3&pageSel=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageSel"], ENT_QUOTES); ?>&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>">3</a></li>
          <li><a <?php if(Tpl::$_tpl_vars["pageNum"]==4){; ?>style="background:white;color:black" <?php }; ?> <?php if(Tpl::$_tpl_vars["maxPage"]<4){; ?>style="display:none;" <?php }; ?> href="ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=4&pageSel=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageSel"], ENT_QUOTES); ?>&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>">4</a></li>
          <li><a <?php if(Tpl::$_tpl_vars["pageNum"]==5){; ?>style="background:white;color:black" <?php }; ?> <?php if(Tpl::$_tpl_vars["maxPage"]<5){; ?>style="display:none;" <?php }; ?> href="ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=5&pageSel=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageSel"], ENT_QUOTES); ?>&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>">5</a></li>
          <li><a <?php if(Tpl::$_tpl_vars["maxPage"]<6){; ?>style="display:none;"<?php }; ?> href="ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageNum"]+1, ENT_QUOTES); ?>&pageSel=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageSel"], ENT_QUOTES); ?>&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>">&raquo;</a></li>
          <?php }else{; ?>
          <li><a  href="ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageNum"]-1, ENT_QUOTES); ?>&pageSel=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageSel"], ENT_QUOTES); ?>&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>">&laquo;</a></li>
          <li><a  href="ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageNum"]-2, ENT_QUOTES); ?>&pageSel=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageSel"], ENT_QUOTES); ?>&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["pageNum"]-2, ENT_QUOTES); ?></a></li>
          <li><a  href="ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageNum"]-1, ENT_QUOTES); ?>&pageSel=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageSel"], ENT_QUOTES); ?>&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["pageNum"]-1, ENT_QUOTES); ?></a></li>
          <li><a style="background:white;color:black"  <?php if(Tpl::$_tpl_vars["maxPage"]<Tpl::$_tpl_vars["pageNum"]){; ?>style="display:none;" <?php }; ?> href="ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageNum"], ENT_QUOTES); ?>&pageSel=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageSel"], ENT_QUOTES); ?>&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["pageNum"], ENT_QUOTES); ?></a></li>
          <li><a <?php if(Tpl::$_tpl_vars["maxPage"]<Tpl::$_tpl_vars["pageNum"]+1){; ?>style="display:none;" <?php }; ?> href="ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageNum"]+1, ENT_QUOTES); ?>&pageSel=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageSel"], ENT_QUOTES); ?>&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["pageNum"]+1, ENT_QUOTES); ?></a></li>
          <li><a <?php if(Tpl::$_tpl_vars["maxPage"]<Tpl::$_tpl_vars["pageNum"]+2){; ?>style="display:none;" <?php }; ?> href="ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageNum"]+2, ENT_QUOTES); ?>&pageSel=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageSel"], ENT_QUOTES); ?>&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["pageNum"]+2, ENT_QUOTES); ?></a></li>
          <li><a <?php if(Tpl::$_tpl_vars["maxPage"]<Tpl::$_tpl_vars["pageNum"]+1){; ?>style="display:none;" <?php }; ?> href="ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageNum"]+1, ENT_QUOTES); ?>&pageSel=<?php echo htmlspecialchars(Tpl::$_tpl_vars["pageSel"], ENT_QUOTES); ?>&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>">&raquo;</a></li>
          <?php }; ?>
        </ul>
      </div>
    </div>

    <!--turnpage start-->
<?php /*
    <div class="turnpage">
      <a href="#"><em>&lt;&lt;</em>上一页</a>
      <a href="#">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#">4</a>
      <a href="#">5</a>
      <span>...</span>
      <a href="#">65</a>
      <a href="#">下一页<em>&gt;&gt;</em></a>
    </div>
	*/?>
    <!--turnpage end-->
<?php /*
    <div class="toolbar-bc">
      <span class="sbtng fl"><a class="ibtng" href="#">查看已归档的广告计划</a></span>
      <div class="tbGroup ml30">
        <span class="tbgBtn"><a class="tbgiba nobor" href="#" title="启动"><i class="iplay"></i></a></span>
      </div><div class="clear"></div>
    </div>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="reportab mt20">
      <tr>
        <th class="tac"><input name="" type="checkbox" value="" /></th>
        <th>广告计划</th>
        <th>状态</th>
        <th>有效期</th>
        <th class="tac">日预算</th>
        <th class="tac">展现数</th>
        <th class="tac">点击数</th>
        <th class="tac">点击率</th>
        <th class="tac">总费用</th>
        <th class="tac">平均点击成本</th>
        <th class="tac">报表</th>
      </tr>
      <tr>
        <td class="tac"><input name="" type="checkbox" value="" /></td>
        <td>农夫山泉推广</td>
        <td>暂停</td>
        <td>2011.05.26 - 2012.07.15</td>
        <td class="tac">65</td>
        <td class="tac">27</td>
        <td class="tac">185</td>
        <td class="tac">75</td>
        <td class="tac">35%</td>
        <td class="tac">658</td>
        <td class="tac"><a href="#">下载</a></td>
      </tr>
      <tr>
        <td class="tac"><input name="" type="checkbox" value="" /></td>
        <td>巧乐兹促销</td>
        <td>暂停</td>
        <td>2011.05.26 - 2012.07.15</td>
        <td class="tac">65</td>
        <td class="tac">27</td>
        <td class="tac">185</td>
        <td class="tac">75</td>
        <td class="tac">35%</td>
        <td class="tac">658</td>
        <td class="tac"><a href="#">下载</a></td>
      </tr>
      <tr>
        <td class="tac"><input name="" type="checkbox" value="" /></td>
        <td>大众汽车推广</td>
        <td>启用</td>
        <td>2011.05.26 - 2012.07.15</td>
        <td class="tac">65</td>
        <td class="tac">27</td>
        <td class="tac">185</td>
        <td class="tac">75</td>
        <td class="tac">35%</td>
        <td class="tac">658</td>
        <td class="tac"><a href="#">下载</a></td>
      </tr>
      <tr>
        <td class="tac"><input name="" type="checkbox" value="" /></td>
        <td>加多宝品牌营销</td>
        <td>暂停</td>
        <td>2011.05.26 - 2012.07.15</td>
        <td class="tac">65</td>
        <td class="tac">27</td>
        <td class="tac">185</td>
        <td class="tac">75</td>
        <td class="tac">35%</td>
        <td class="tac">658</td>
        <td class="tac"><a href="#">下载</a></td>
      </tr>
    </table>
   */?>

  </div>
  <!--mcon end-->

</div>



<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
<script type="text/javascript">
// 控制report_dat的Theader在鼠标滚动时，固定在页面顶部
//	   $(document).ready(function(){
//			 var first  = $('#report_dat tr').eq(0);
//			 //theaderfixed后宽度改变了，需要通过其他tr的td负值给theader里的th
//			 var second = $('#report_dat tr').eq(1);
//				//  table宽度
//			 var w = $('#report_dat').width();
//
//		 	$(window).scroll( function() {
//		 		if($(document).scrollTop() > 600){
//					//  theader定位在top时th的宽度
//					 var changeWidth = second.children();
//					 changeWidth.each(function(i,v){
//						 //获取第一个theader里面的th
//					// console.log(first.children().eq(i));
//							first.children().eq(i).width( v.offsetWidth);
//							// console.log(v.offsetWidth)
//						})
//				first.css("position","fixed").css("top",0).css("width",w);
//		 		}else{
//					first.eq(0).css("position","static");
//				}
//		 	});
//		 });

//分页
$(function(){
  $("#pageSel").change(function(){
    var pageSel = $(this).children('option:selected').val();
    location="/ad.plan?start=<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>&end=<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>&status=<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["userId"], ENT_QUOTES); ?>&pageNum=1&pageSel="+pageSel+"&key=<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>";
  });
});
</script>
</body>
</html>
