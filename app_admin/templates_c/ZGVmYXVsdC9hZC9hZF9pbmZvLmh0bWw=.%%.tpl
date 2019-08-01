<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
<title></title>
</head>
<body style="height:100%; margin:0; overflow:hidden;">
	<script>
		$(document).ready(function(){
				$("#div_bidder_host").change(function(){
					var bidder_host = $("#bidder_host_select").val();
					var ad_url = "https://"+bidder_host+"/info.html";
					$("#ad_option_form").attr("action", ad_url);
				})
			}
		)
		
		function createClickLink(aid){
			var delay = $("#ad_option_input_delay").val();
			var bidder_host = $("#bidder_host_select").val();
			var ad_url = 'https://'+bidder_host+'/click.html'+'?aid='+aid+'&spid=sohu&pushid=0&src=0&action=redirect&click_delay='+delay;
			$("#ad_option_input_link").val(ad_url);
			
			var clickLinkHtml = '<a href="'+ad_url+'" target="_blank">'+ad_url+'</a>';
			$("#div_click_link").html(clickLinkHtml);
		}
	</script>
	<div id="ad_option" class="ad_option">
		<div class="ad_option_top">
			<div class="ad_option_top_left">
				<!--<iframe src="https://<?php echo htmlspecialchars(Tpl::$_tpl_vars["bidders"][0], ENT_QUOTES); ?>/info.html?sn=0&type=html&mobile=0&aid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['adid'], ENT_QUOTES); ?>&width=&height=&full=1"
				 style="border:none; overflow:hidden; width:<?php echo htmlspecialchars(Tpl::$_tpl_vars["iframe"]['width'], ENT_QUOTES); ?>px; height:<?php echo htmlspecialchars(Tpl::$_tpl_vars["iframe"]['height'], ENT_QUOTES); ?>px; margin-top:<?php echo htmlspecialchars(Tpl::$_tpl_vars["iframe"]['top'], ENT_QUOTES); ?>px;"></iframe>-->
				<iframe src="/baichuan_advertisement_manage/baichuan_advertisement_manage/ad.preview.entry.<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['adid'], ENT_QUOTES); ?>?aid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['adid'], ENT_QUOTES); ?>"
				 style="border:none; overflow:hidden; width:<?php echo htmlspecialchars(Tpl::$_tpl_vars["iframe"]['width'], ENT_QUOTES); ?>px; height:<?php echo htmlspecialchars(Tpl::$_tpl_vars["iframe"]['height'], ENT_QUOTES); ?>px; margin-top:<?php echo htmlspecialchars(Tpl::$_tpl_vars["iframe"]['top'], ENT_QUOTES); ?>px;"></iframe>
			</div>
			<div class="ad_option_top_right">
				<table class="table table-bordered table-hover" id="sample-table-1">
					<thead>
						<tr>
							<th class="center" style="min-width:65px;">项</th>
							<th class="center">值</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>ID</td>
							<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['adid'], ENT_QUOTES); ?></td>
						</tr>
						<tr>
							<td>名称</td>
							<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['adname'], ENT_QUOTES); ?></td>
						</tr>
						<tr>
							<td>展示类型</td>
							<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["viewType"][Tpl::$_tpl_vars["ad"]['adType']], ENT_QUOTES); ?></td>
						</tr>
						<tr>
							<td>展示位置</td>
							<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["position"][Tpl::$_tpl_vars["ad"]['colum1']], ENT_QUOTES); ?></td>
						</tr>
						<tr>
							<td>素材类型</td>
							<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffType"][Tpl::$_tpl_vars["ad"]['type']], ENT_QUOTES); ?></td>
						</tr>
						<tr>
							<td>宽度</td>
							<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['width'], ENT_QUOTES); ?></td>
						</tr>
						<tr>
							<td>高度</td>
							<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['height'], ENT_QUOTES); ?></td>
						</tr>
						<tr>
							<td>创建时间</td>
							<td><?php echo htmlspecialchars(date('Y-m-d H:i:s',Tpl::$_tpl_vars["ad"]['ctime']), ENT_QUOTES); ?></td>
						</tr>
						<tr>
							<td>最后修改</td>
							<td><?php echo htmlspecialchars(date('Y-m-d H:i:s',Tpl::$_tpl_vars["ad"]['mtime']), ENT_QUOTES); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="ad_option_bottom">
			<div class="row">
				<div class="col-xs-12">
					<form action="/baichuan_advertisement_manage/ad.preview.entry.<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['adid'], ENT_QUOTES); ?>" method="get" target="_blank">
						<label class="col-xs-2 control-label" for="bidder_host_select">广告预览：</label>
						<div class="col-xs-10 form-group">
							<input style="display:none;" type="text" name="aid" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['adid'], ENT_QUOTES); ?>"/>
							<label class="col-xs-1 control-label" for="ad_option_input_page">页面：</label>
							<div  class="col-xs-9"><input class="form-control input-sm" id="ad_option_input_page" type="text" name="url" placeholder="默认"/></div>
							<div  class="col-xs-1"><input class="btn btn-sm btn-squared btn-success" type="submit" value="预览"></div>
						</div>
					</form>
				</div>
				
				<hr style="width: 100%;">
				<div class="col-xs-12" id="div_bidder_host" style="padding-right: 43px;">
					<label class="col-xs-2 control-label" for="bidder_host_select">选择域名：</label>
					<div  class="col-xs-10 form-group">
						<select class="form-control input-sm" id="bidder_host_select" name="bidder_host">
							<?php foreach(Tpl::$_tpl_vars["bidders"] as Tpl::$_tpl_vars["index"] => Tpl::$_tpl_vars["bidder"]){; ?>
							<option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["bidder"], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["index"] == 0){; ?>selected="selected"<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["bidder"], ENT_QUOTES); ?></option>				
							<?php }; ?>							
						</select>
					</div>
				</div>
				
				<div class="col-xs-12">
					<!--<form id="ad_option_form" action="https://<?php echo htmlspecialchars(Tpl::$_tpl_vars["bidders"][0], ENT_QUOTES); ?>/info.html" method="get" target="_blank"> --!>
					<form id="ad_option_form" action="https://221.179.131.49:9988/ad.preview.entry.<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['adid'], ENT_QUOTES); ?>?aid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['adid'], ENT_QUOTES); ?>" method="get" target="_blank">
						<label class="col-xs-2 control-label" for="bidder_host_select">广告地址：</label>
						<div class="col-xs-10 form-group">
							<input style="display:none;" type="text" name="sn" value="0"/>
							<input style="display:none;" type="text" name="type" value="html"/>
							<input style="display:none;" type="text" name="mobile" value="0"/>
							<input style="display:none;" type="text" name="aid" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['adid'], ENT_QUOTES); ?>"/>
							
							<label class="col-xs-1 control-label" for="ad_option_input_width">宽度：</label>
							<div  class="col-xs-2"><input class="form-control input-sm" id="ad_option_input_width" type="text" name="width" placeholder="默认"/></div>
							
							<label class="col-xs-1 control-label" for="ad_option_input_height">高度：</label>
							<div  class="col-xs-2"><input class="form-control input-sm" id="ad_option_input_width" type="text" name="height" placeholder="默认"/></div>
							
							<label class="col-xs-1 control-label" for="ad_option_input_full">铺满：</label>
							<div  class="col-xs-3">
								<select class="form-control input-sm" id="ad_option_input_full" name="full">
									<option value="0">否</option>				
									<option value="1">是</option>				
								</select>
							</div>
							<div  class="col-xs-1"><input class="btn btn-sm btn-squared btn-blue" type="submit" value="打开"></div>
						</div>
					</form>
				</div>
				
				<div class="col-xs-12">
					<label class="col-xs-2 control-label" for="bidder_host_select">点击链接：</label>
					<div class="col-xs-10 form-group">
						<input style="display:none;" type="text" name="aid" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['adid'], ENT_QUOTES); ?>"/>
						
						<label class="col-xs-1 control-label" for="ad_option_input_delay">延迟：</label>
						<div  class="col-xs-2"><input class="form-control input-sm" id="ad_option_input_delay" type="text" name="delay" value="300"/></div>
						
						<label class="col-xs-1 control-label" for="ad_option_input_link">地址：</label>
						<div  class="col-xs-6"><input class="form-control input-sm" id="ad_option_input_link" type="text" name="link" placeholder="默认"/></div>
						<div  class="col-xs-1"><a class="btn btn-sm btn-squared btn-blue" href="#" onclick="createClickLink(<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['adid'], ENT_QUOTES); ?>)">生成</a></div>
					</div>
				</div>
			</div>
		</div>
		<div class="ad_option_address">
			素材地址：<a href="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['addr'], ENT_QUOTES); ?>" target="_blank"><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['addr'], ENT_QUOTES); ?></a>
			<br>
			跳转地址：<a href="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['landing_page'], ENT_QUOTES); ?>" target="_blank"><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]['landing_page'], ENT_QUOTES); ?></a>
		</div>
		<div id="div_click_link"></div>
	</div>
</body>
</html>
