<!DOCTYPE html>
<html>
<head>
<meta https-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.main"), ENT_QUOTES); ?>

<style>
.selMenu ul{
	z-index:999;
}
</style>

<!--main-->
<div class="main">
  <div class="side">
    <div class="addad"><a href="#"></a></div>
    <div class="adInfo">
      <h1 class="aitit">广告主数据总览</h1>
      <div class="aicon">
         <p>今日花费：<strong class="hf">980</strong> 元</p>
         <p>账户余额：<strong class="ye">3,890</strong> 元</p>
         <p>预计消费天数：<strong>10</strong> 天</p>
         <p>推广广告计划个数：<strong>12</strong> 个</p>
      </div>
    </div>
  </div>
  
  <!--mcon start-->
  <div class="mcon">
  
    <!--toolbar start--> 
    <div class="toolbar">
      <div id="zhuantai" class="selMenu smzt">
        <span class="smtit">全部投放类型</span>
        <ul>
          <li><a href="javascript:;">所有状态</a></li>
          <li><a href="javascript:;">已启动</a></li>
          <li><a href="javascript:;">已暂停</a></li>
          <li><a href="javascript:;">已删除</a></li>
          <li><a href="javascript:;">已锁定</a></li>
          <li><a href="javascript:;">已暂停</a></li>
        </ul>
      </div>
      
      <div id="leixing" class="selMenu smlx ml10">
        <span class="smtit">全部广告计划</span>
        <ul>
          <li><a href="javascript:;">所有类型</a></li>
          <li><a href="javascript:;">品牌广告</a></li>
          <li><a href="javascript:;">效果广告</a></li>
        </ul>
      </div>
      
      <div class="selMenu ml30">
        <div class="smtbg">
          <input type="text" class="itxt_1 fl idate" value="2012-05-23" size="15" />
          <input type="text" class="itxt_1 fl idate" value="结束时间" size="15" />
        </div>
      </div>
      
      <div class="tbGroup ml10">
        <span class="tbgBtn">
          <a class="tbgba" href="#">今天</a>
          <a class="tbgba sel" href="#">昨天</a>
          <a class="tbgba" href="#">本周</a>
          <a class="tbgba" href="#">上周</a>
          <a class="tbgba" href="#">本月</a>
          <a class="tbgba nobr" href="#">上月</a>
        </span>
      </div><div class="clear"></div>
    </div>
    <!--toolbar end--> 
      <script>
      $(function () {
		      $('.chartShow').highcharts({
chart: {
type: 'line'
},
title: {
text: '统计报表'
},
subtitle: {
text: 'Source: 来源'
},
xAxis: {
categories: ['6月1日', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
},
yAxis: {
title: {
text: '显示次数'
}
},
tooltip: {
enabled: false,
formatter: function() {
	return '<b>'+ this.series.name +'</b><br/>'+
		this.x +': '+ this.y +'°C';
}
},
plotOptions: {
line: {
dataLabels: {
enabled: true
	    },
enableMouseTracking: false
      }
	     },
series: [{
name: '展示次数',
      data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
	}, {
name: '点击次数',
      data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
	}]
});
});
</script>  
    <div class="chartCon mt20">
      <div class="chartData">
        <div class="cdli">时间段：<strong>2013-05-14</strong> 至 <strong>2013-06-12</strong></div>
        <div class="cdli">展示次数：<strong>980</strong>次</div>
        <div class="cdli">点击次数：<strong>789</strong>次</div>
        <div class="cdli">点击率：<strong>32.5%</strong></div>
        <div class="cdli">费用：<strong>685</strong>元</span></div>
      </div>
      <div class="chartShow" id="chartShow"><?php /*<img src="/baichuan_advertisement_manage/assets_admin/img/tmp_chart.gif" />*/?></div>
    </div>
	<script>
	var paras={ };
	paras.start="<?php echo htmlspecialchars(Tpl::$_tpl_vars["start"], ENT_QUOTES); ?>";
	paras.end="<?php echo htmlspecialchars(Tpl::$_tpl_vars["end"], ENT_QUOTES); ?>";
	report("#chartShow",paras);
	</script>
    
    <div class="toolbar mt30">
      <div id="zhuantai" class="selMenu smzt">
        <span class="smtit">所有状态</span>
        <ul>
          <li><a href="javascript:;">所有状态</a></li>
          <li><a href="javascript:;">已启动</a></li>
          <li><a href="javascript:;">已暂停</a></li>
          <li><a href="javascript:;">已删除</a></li>
          <li><a href="javascript:;">已锁定</a></li>
          <li><a href="javascript:;">已暂停</a></li>
        </ul>
      </div>
      
      <div class="selMenu ml10">
        <div class="smtbg">
          <input type="text" class="itxt_1 idate fc7" value="2012-05-23" size="15" />
          <input type="text" class="itxt_1 idate fc7" value="结束时间" size="15" />
        </div>
      </div>
      
      <div class="tbGroup ml30">
        <span class="tbgBtn">
          <a class="tbgiba" href="#"><i class="iplay"></i></a>
          <a class="tbgiba nobr" href="#"><i class="ipause"></i></a>
        </span>
      </div>
      
      <div class="tbGroup ml10">
        <span class="tbgBtn">
          <a class="tbgiba" href="#"><i class="iset"></i></a>
          <a class="tbgiba" href="#"><i class="icopy"></i></a>
          <a class="tbgiba nobr" href="#"><i class="idel"></i></a>
        </span>
      </div>
    </div>
    <div class="clear"></div>
    
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
    
    <!--turnpage start-->
    <div class="turnpage">
      <a href="#"><em>&lt;</em> 上一页</a>
      <a href="#">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#">4</a>
      <a href="#">5</a>
      <span>...</span>
      <a href="#">65</a>
      <a href="#">下一页 <em>&gt;</em></a>
    </div>
    <!--turnpage end-->
    
    
    <div class="toolbar mt30">
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
    
    
  </div>
  <!--mcon end-->
  
</div>


<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>

</body>
</html>
