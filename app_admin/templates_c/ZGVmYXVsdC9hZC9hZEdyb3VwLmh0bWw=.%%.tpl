<!DOCTYPE html>
<html>
<head>
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.ad"), ENT_QUOTES); ?>
<div class="main">
  <div class="side">
<?php echo htmlspecialchars(tpl_function_part(("/ad.plan.listpart.".Tpl::$_tpl_vars["plan_id"].".".Tpl::$_tpl_vars["group_id"])), ENT_QUOTES); ?> 
  </div>
  
  <!--mcon start-->
  <div class="mcon">
    <div class="toolbar-bc fl">
    	<div class="fl sub-title">
			<a href="/baichuan_advertisement_manage/ad.plan.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->plan_id, ENT_QUOTES); ?>" title="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->plan_name, ENT_QUOTES); ?>"><?php echo htmlspecialchars(tpl_modifier_wordbraek(Tpl::$_tpl_vars["plan"]->plan_name,10), ENT_QUOTES); ?></a>
			<i class="fa fa-angle-double-right"></i>
			广告组列表
		</div>
       <script>
   $(document).ready(function(){
   // $(".idate").datepicker({ dateFormat: "yy-mm-dd" ,maxDate:1}); 
    var sd = $("#startdate").datepicker({ dateFormat: "yy-mm-dd"})
    var ed = $("#enddate").datepicker({ dateFormat: "yy-mm-dd"})
    if("<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["start"],0), ENT_QUOTES); ?>") ed.datepicker( "option", "minDate", "<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>" );
    if("<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["end"],0), ENT_QUOTES); ?>") sd.datepicker( "option", "maxDate", "<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>" );
   });
     </script>

        <div class="selMenu ml10">
            <div class="smtbg">
                <input type="text" class="itxt_1 fl idate" id="startdate" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["start"],'开始时间'), ENT_QUOTES); ?>" size="15" />
                <input type="text" class="itxt_1 fl idate" id="enddate" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["end"],'结束时间'), ENT_QUOTES); ?>" size="15" />
            </div>
        </div>
        <div class="tbGroup ml10">
            <style>
                .tbgBtn {
                    cursor: pointer;
                }
            </style>
            <span id="r_menu" class="tbgBtn"><a id="r_today" class="tbgba">今天</a><a id="r_yesterday" class="tbgba">昨天</a><a id="r_week" class="tbgba">本周</a><a id="r_lastweek" class="tbgba">上周</a><a id="r_month" class="tbgba">本月</a><a id="r_lastmoth" class="tbgba nobr">上月</a></span>
        </div>
		<div class="clear"></div>
	</div>
    <div class="chartCon mt10">
<?php /*
      <div class="chartData">
        <div class="cdli">时间段：<strong>2013-05-14</strong> 至 <strong>2013-06-12</strong></div>
        <div class="cdli">每日预算：<strong>不限预算</strong></div>
      </div>
	  */?>
      <div class="chartShow" style="height:400px" id="chartShow"><?php /*<img src="/baichuan_advertisement_manage/assets_admin/img/tmp_chart.gif" />*/?></div>
    </div>
	<script>
  var paras={ };
  paras.start="<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>";
  paras.end="<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>";
  paras.pid="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>";
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
	  location="/ad.plan.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>?start="+paras.start+"&end="+paras.end;
  }
	$("#r_menu a").click(function(){
			$(this).parent().find("A").removeClass("sel");
			$(this).addClass("sel");
	});
	$("#startdate").change(function(){
			paras.start=$(this).val();
			setV();
		//	report("#chartShow",paras);
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
    <div class="toolbar-bc mt10">
      <div class="fl">
      	<a class="btn btn-squared btn-blue" style="background:#157EE7;" href="/baichuan_advertisement_manage/ad.plan.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>">编辑广告计划</a>
		<a class="btn btn-squared btn-success" href="/baichuan_advertisement_manage/ad.group.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>">新增广告组</a>
		<?php if(Tpl::$_tpl_vars["currentUserName"] == admin){; ?>
			<?php if(Tpl::$_tpl_vars["plan"]->verified_or_not==2 or Tpl::$_tpl_vars["plan"]->verified_or_not==1){; ?>
				<a class="btn btn-squared btn-red" href="#" onclick="setPlanStatusById(<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>,3);">拒绝</a>
			<?php }; ?>
			<?php if(Tpl::$_tpl_vars["plan"]->verified_or_not==3 or Tpl::$_tpl_vars["plan"]->verified_or_not==1){; ?>
				<a class="btn btn-squared btn-success" href="#" onclick="setPlanStatusById(<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>,2);">通过</a>
			<?php }; ?>
		<?php }; ?>
      </div>
      <div id="zhuantai" class="selMenu smzt ml20">
        <span class="smtit">
			<?php if(Tpl::$_tpl_vars["status"]==1){; ?>已启动
			<?php }elseif( Tpl::$_tpl_vars["status"]==2){; ?>已暂停
			<?php }elseif( Tpl::$_tpl_vars["status"]==3){; ?>非投放时间
			<?php }elseif( Tpl::$_tpl_vars["status"]==4){; ?>删除
      <?php }elseif( Tpl::$_tpl_vars["status"]==5){; ?>冻结
			<?php }elseif( Tpl::$_tpl_vars["status"]==6){; ?>没预算
			<?php }else{; ?>所有状态<?php }; ?></span>
        <ul id="status">
          <li><a status="0">所有状态</a></li>
          <li><a status="1">已启动</a></li>
          <li><a status="2">已暂停</a></li>
          <li><a status="3">非投放时间</a></li>
          <!-- 
          <li><a status="4">已删除</a></li>
           -->
          <li><a status="5">冻结</a></li>
          <li><a status="6">没预算</a></li>
        </ul>
      </div>
	  <script>
	var paras2={ };
	paras2.start="<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>";
	paras2.end="<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>";
	paras2.status="<?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>";
	function reload(){
		location="/ad.plan.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>?start="+paras2.start+"&end="+paras2.end+"&status="+paras2.status;;
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
      
<?php /*
      <div id="leixing" class="selMenu smlx ml10">
        <span class="smtit">所有类型</span>
        <ul>
          <li><a href="javascript:;">所有类型</a></li>
          <li><a href="javascript:;">品牌广告</a></li>
          <li><a href="javascript:;">效果广告</a></li>
        </ul>
      </div>
	  */?>
      
      <div class="tbGroup ml10">
        <span class="tbgBtn">
<?php /*<a class="tbgiba" href="#" title="启动"><i class="iplay"></i></a>
          <a class="tbgiba nobr" href="#" title="暂停"><i class="ipause"></i></a>
		  */?>
          <a type="start" class="status-change tbgiba"  title="启动"><i class="fa fa-play"></i></a>
          <a type="stop" class="status-change tbgiba nobr"  title="暂停"><i class="fa fa-pause"></i></a>
          <a type="del" class="status-change tbgiba nobr" title="删除"><i class="fa fa-trash-o"></i></a>
        </span>
      </div>
      <script>
      $(document).ready(function(){
		$(".status-change").click(function(){
			var checked = $(".reportab input:checkbox:checked[value]");
			var type=$(this).attr("type");
			if(checked.size()<=0){
				alert("请选择");
			}else{
				 var planid=[];
				 checked.each(function(i,item){
					 planid.push($(item).val());
				 })
				 $.ajax({ 
					type: "POST", url: "/baichuan_advertisement_manage/ad.group.status."+type, data: { group_ids:planid }, dataType:"json",
					success: function(msg){ 
						location.reload();
					}
				});
			}
			return false;
		});
	});
      </script>
      
<?php /*
      <div class="tbGroup ml10">
        <span class="tbgBtn">
          <a class="tbgiba" href="#" title="锁定"><i class="ilock"></i></a>
          <a class="tbgiba" href="#" title="设置"><i class="iset"></i></a>
          <a class="tbgiba" href="#" title="复制"><i class="icopy"></i></a>
          <a class="tbgiba nobr" href="#" title="删除"><i class="idel"></i></a>
        </span>
      </div>
      */?>
	  <div class="selMenu fr">
			<?php if(Tpl::$_tpl_vars["plan"]->verified_or_not==2){; ?>
				<div class="btn btn-squared ml10" style="background:#EEEEEE;">已通过审核</div>
			<?php }elseif((Tpl::$_tpl_vars["plan"]->verified_or_not==3)){; ?>
				<div class="btn btn-squared btn-red ml10">已被驳回</div>
			<?php }else{; ?>
				<div class="btn btn-squared ml10" style="background:#EEEEEE;">待审核</div>
			<?php }; ?>
		</div>
      <div class="clear"></div>
    </div>
    <!--toolbar-bc end--> 
    
    <table id="report_dat" width="100%" border="0" cellspacing="0" cellpadding="0" class="reportab mt10">
      <tr>
        <th class="tac"><input class="checkall"  type="checkbox" /></th>
        <th>广告组</th>
        <th>状态</th>
        <th>出价</th>
        <th class="tac">展现数</th>      
        <th class="tac">点击数</th>
        <th class="tac">点击率</th>
        <th class="tac">总花费</th>
        <th class="tac">设置</th>
      </tr>
<?php foreach(Tpl::$_tpl_vars["groups_2"] as Tpl::$_tpl_vars["_group"]){; ?>
      <tr>
        <td class="tac"><input name="" type="checkbox" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_group"]->group_id, ENT_QUOTES); ?>" /></td>
        <td style="max-width: 200px;word-break: break-all;word-break: break-word;"><a href="/baichuan_advertisement_manage/ad.group.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->plan_id, ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["_group"]->group_id, ENT_QUOTES); ?>" title="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_group"]->name, ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["_group"]->name, ENT_QUOTES); ?></a></td>
        <td><?php if(Tpl::$_tpl_vars["_group"]->enabled==1){; ?>正常<?php }elseif( Tpl::$_tpl_vars["_group"]->enabled==2){; ?>暂停<?php }elseif( Tpl::$_tpl_vars["_group"]->enabled==3){; ?>非投放时间<?php }elseif( Tpl::$_tpl_vars["_group"]->enabled==4){; ?>已删除<?php }elseif( Tpl::$_tpl_vars["_group"]->enabled==5){; ?>冻结<?php }elseif( Tpl::$_tpl_vars["_group"]->enabled==6){; ?>没预算<?php }; ?></td>
        <td><?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_group"]->setting_price,2), ENT_QUOTES); ?>元</td>
        <td class="tac"><?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_group"]->report->show,1,".",","), ENT_QUOTES); ?></td>
        <td class="tac"><?php echo htmlspecialchars(Tpl::$_tpl_vars["_group"]->report->click, ENT_QUOTES); ?></td>
        <td class="tac"><?php if(!empty(Tpl::$_tpl_vars["_group"]->report->show)){; ?><?php echo htmlspecialchars(round(Tpl::$_tpl_vars["_group"]->report->click*100/Tpl::$_tpl_vars["_group"]->report->show,3), ENT_QUOTES); ?>%<?php }; ?></td>
        <td class="tac"><?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_group"]->report->cost,2,".",","), ENT_QUOTES); ?>元</td>
        <td class="tac"><a href="/baichuan_advertisement_manage/ad.group.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->plan_id, ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["_group"]->group_id, ENT_QUOTES); ?>">设置</a><?php /*<a href="#">导出</a>*/?></td>
      </tr>
<?php }; ?>
    </table>
    
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
    <div class="toolbar-bc mt30">
      <span class="sbtng fl"><a class="ibtng" href="#">查看已归档的广告计划</a></span>
      <div class="tbGroup ml30">
        <span class="tbgBtn"><a class="tbgiba nobor" href="#" title="启动"><i class="iplay"></i></a></span>
      </div><div class="clear"></div>
    </div>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="reportab mt20">
      <tr>
        <th class="tac"><input name="" type="checkbox" value="" /></th>
        <th>广告组</th>
        <th>状态</th>
        <th>定向方式</th>
        <th>媒体选择</th>
        <th class="tac">出价</th>
        <th class="tac">展现数</th>      
        <th class="tac">胜出率</th>
        <th class="tac">点击数</th>
        <th class="tac">点击率</th>
        <th class="tac">总花费</th>
        <th class="tac">点击价格</th>
        <th class="tac">报表</th>
      </tr>
      <tr>
        <td class="tac"><input name="" type="checkbox" value="" /></td>
        <td>农夫山泉推广</td>
        <td>暂停</td>
        <td>&nbsp;</td>
        <td class="tac">65</td>
        <td class="tac">27%</td>
        <td class="tac">185</td>
        <td class="tac">75%</td>
        <td class="tac">35%</td>
        <td class="tac">658</td>
        <td class="tac">98</td>
        <td class="tac">658</td>
        <td class="tac"><a href="#">查看</a><a href="#">导出</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>合计</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="tac">&nbsp;</td>
        <td class="tac">&nbsp;</td>
        <td class="tac">&nbsp;</td>
        <td class="tac">&nbsp;</td>
        <td class="tac">&nbsp;</td>
        <td class="tac">&nbsp;</td>
        <td class="tac">&nbsp;</td>
        <td class="tac">&nbsp;</td>
        <td class="tac">&nbsp;</td>
      </tr>
    </table>
    
    */?>
    
  </div>
  <!--mcon end-->
  
</div>
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
<script type="text/javascript">
function setPlanStatusById(id,type){
	$.ajax({ 
		type: "POST", url: "admin.shenhe.planSet."+id, data: { type:type }, dataType:"json",
		success: function(msg){ 
			location.reload();
		}
	});
	return false;
};
</script>
</body>
</html>
