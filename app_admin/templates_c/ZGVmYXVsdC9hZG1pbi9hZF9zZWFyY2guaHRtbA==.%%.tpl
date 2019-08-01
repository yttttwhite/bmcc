<!DOCTYPE html>
<html>
<head>
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.admin"), ENT_QUOTES); ?>
<!--main-->
<div class="main" style="position:relative; padding:0;">
    <!--mcon start-->
    <div>
    	<div class="block">
			<div id="user-info" class="panel panel-white panel-squared">
				<div class="panel-heading border-light">
					<h4 class="panel-title">可选操作</h4>
				</div>
				<div class="panel-body">
					<form action="" method="get">
						<div class="form-group">
							<div class="input-group">
								<input type="text" class="form-control" name="key" value="" placeholder="关键词">
								<span class="input-group-btn">
									<input class="btn btn-success btn-squared" type="submit" value="搜索">
								</span>
							</div>
						</div>
						
						<div>
							<label class="radio-inline" style="margin-top: 10px !important;">
								<input type="radio" class="flat-red" name="keyType" value="ad" checked="checked"> 广告ID
							</label>
							<label class="radio-inline" style="margin-top: 10px !important;">
								<input type="radio" class="flat-red" name="keyType" value="stuff"> 素材ID
							</label>
						</div>
						<style>
							.hidden-item { display:none; } 
						</style>
						<script>
							function hideItem(){
								$(".hidden-item").toggle();
							}
						</script>
					</form>
				</div>
			</div>
			<?php if(isset(Tpl::$_tpl_vars["result"]['ad'])){; ?>
			<table class="table table-striped table-hover table-bordered table-responsive">
				<thead>
					<tr>
						<th style="text-align:center;" width="40">广告ID</th>
						<th style="text-align:center;" width="200">广告名称</th>
						<th style="text-align:center;" width="100">宽度</th>
						<th style="text-align:center;" width="100">高度</th>
						<th style="text-align:center;" width="140">状态</th>
						<th style="text-align:center;" width="140">修改时间</th>
						<th style="text-align:center;" width="240">操作</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['ad']['adid'], ENT_QUOTES); ?></td>
						<td style="max-width: 200px;word-break: break-all;word-break: break-word;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['ad']['adname'], ENT_QUOTES); ?></td>
						<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['ad']['width'], ENT_QUOTES); ?></td>
						<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['ad']['height'], ENT_QUOTES); ?></td>
						<td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['ad']['play_status'], ENT_QUOTES); ?></td>
						<td style="text-align:center;"><?php echo htmlspecialchars(date("Y-m-d G:i:s",Tpl::$_tpl_vars["result"]['ad']['mtime']), ENT_QUOTES); ?></td>
						<td style="text-align:center;">
							<a class="btn btn-squared btn-xs btn-success ml10" target="_blank" href="/baichuan_advertisement_manage/ad.plan?status=0&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['ad']['uid'], ENT_QUOTES); ?>">广告主</a>
							<a class="btn btn-squared btn-xs btn-success ml10" target="_blank" href="/baichuan_advertisement_manage/ad.plan.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['ad']['plan_id'], ENT_QUOTES); ?>">广告计划</a>
							<a class="btn btn-squared btn-xs btn-success ml10" target="_blank" href="/baichuan_advertisement_manage/ad.group.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['ad']['plan_id'], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['ad']['group_id'], ENT_QUOTES); ?>">广告组</a>
						</td>
					</tr>
				</tbody>
				<tfoot></tfoot>
			</table>
			<?php }; ?>
			
			<?php if(isset(Tpl::$_tpl_vars["result"]['stuff'])){; ?>
			<table class="table table-striped table-hover table-bordered table-responsive">
				<thead>
					<tr>
						<th style="text-align:center;" width="40">素材ID</th>
						<th style="text-align:center;" width="200">名称</th>
						<th style="text-align:center;" width="200">宽度</th>
						<th style="text-align:center;" width="200">高度</th>
						<th style="text-align:center;" width="140">enabled</th>
						<th style="text-align:center;" width="140">landing_page</th>
						<th style="text-align:center;" width="140">text</th>
						<th style="text-align:center;" width="140">修改时间</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['stuff']['stuff_id'], ENT_QUOTES); ?></td>
						<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['stuff']['name'], ENT_QUOTES); ?></td>
						<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['stuff']['width'], ENT_QUOTES); ?></td>
						<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['stuff']['height'], ENT_QUOTES); ?></td>
						<td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['stuff']['enabled'], ENT_QUOTES); ?></td>
						<td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['stuff']['landing_page'], ENT_QUOTES); ?></td>
						<td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["result"]['stuff']['text'], ENT_QUOTES); ?></td>
						<td style="text-align:center;"><?php echo htmlspecialchars(date("Y-m-d h:i:s",Tpl::$_tpl_vars["result"]['stuff']['mtime']), ENT_QUOTES); ?></td>
					</tr>
				</tbody>
				<tfoot></tfoot>
			</table>
			<?php }; ?>
			<style>
				td { text-align:center; } 
			</style>
		</div>
	</div>
</div>
<script>
;
function deleteUserByUid(uid){
    var msg = "确认禁用该用户？";
    var url = "/admin.user.delete?uid=" + uid;
    layerConfirmGet(url, msg);
}
</script>
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
</body>
</html>
