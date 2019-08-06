<!DOCTYPE html>
<html>
<head>
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.admin"), ENT_QUOTES); ?>
<!--main-->
<div class="main">
    <!--side-->
    <div class="side">
        <?php echo htmlspecialchars(tpl_function_part(("/admin.user.left")), ENT_QUOTES); ?> 
    </div>
    <!--mcon start-->
    <div class="mcon">
        <div class="toolbar-bc fl mb-10">
            <div class="fl sub-title sc-title">
                <a href="/baichuan_advertisement_manage/admin.user.list?nav=5">高级管理</a>
                <i class="fa fa-angle-double-right" ></i>
                <a href="/baichuan_advertisement_manage/admin.user.list?nav=5">账户管理</a>
                <i class="fa fa-angle-double-right" ></i>
                <span><?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["roleList"][Tpl::$_tpl_vars["get"]['role']]['name'],'全部账户'), ENT_QUOTES); ?></span>
            </div>
        </div>
        <div class="clear"></div>
		<div class="panel panel-white" style="border:1px solid #EEEEEE;">
			<!--表头-->
			<div class="panel-heading border-light panel-head-md">
				<form id="queryFrom" action="<?php echo htmlspecialchars(Tpl::$_tpl_vars["url"]['date'], ENT_QUOTES); ?>" method="get">
					<input name="nav" type="hidden" value="5">
					<input name="role" type="hidden" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['role'], ENT_QUOTES); ?>">
                    <div class="fl">
						<input type="text" name="key" class="form-control input-small" placeholder="账户名称" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["get"]['key'], ENT_QUOTES); ?>"/>
				</div>
				
				<div class="fl">
                <select class="ml-10 input-small" name="account_type" style="max-width: 103px;">
                    <option  value="" >用户来源</option>
                    <option <?php if(Tpl::$_tpl_vars["get"]['account_type']==1){; ?>selected<?php }; ?> value="1">默认</option>
                    <option <?php if(Tpl::$_tpl_vars["get"]['account_type']==2){; ?>selected<?php }; ?> value="2">精准营销平台</option>
                    <option <?php if(Tpl::$_tpl_vars["get"]['account_type']==3){; ?>selected<?php }; ?> value="3">直真</option>
                    <option <?php if(Tpl::$_tpl_vars["get"]['account_type']==4){; ?>selected<?php }; ?> value="4">外部DSP</option>
                    <option <?php if(Tpl::$_tpl_vars["get"]['account_type']==5){; ?>selected<?php }; ?> value="5">哇棒</option>
                </select>
            </div>
            <div class="fl">
        		<select class="ml-10 input-small" name="status" style="max-width: 103px;">
            		<option  value="">状态</option>
            		<option <?php if(Tpl::$_tpl_vars["get"]['status']==1){; ?>selected<?php }; ?> value="1">启用</option>
            		<option <?php if(Tpl::$_tpl_vars["get"]['status']==2){; ?>selected<?php }; ?> value="2">禁用</option>
                </select>
            </div>
        <div class="fl" style="position: relative; left: 10px;">
						<input class="btn btn-squared btn-sm btn-success ml-10" type="submit" value="查询">
					</div>
					<span style="line-height:28px; position: relative; left: 20px;">共计：<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["total"],0), ENT_QUOTES); ?>条</span>
				</form>
				<ul class="panel-heading-tabs border-light" style="display:none;">
	                <div class="btn-group">
	                    <button type="button" class="btn btn-sm btn-squared btn-success w-140" data-toggle="dropdown">
	                    	筛选<span class="caret"></span>
	                    </button>
						<ul class="dropdown-menu" role="menu">
							<li>
	                        </li>
	                    </ul>
	                </div>
	            </ul>
			</div>
			<!--表头:结束-->
			<div class="panel-body" style="overflow-x: auto;">
				<table class="reportab" id="sample-table-2" width="100%">
					<thead>
						<tr>
							<th>用户ID</th>
					        <th>账户名</th>
							<th>状态</th>
							<th>类型</th>
							<th>联系方式</th>
					        <!--  <th>余额</th>--> 
					        <th>来源</th>
					        <th>创建/更新时间</th>
					        <th>所属账户</th>
					        <th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach(Tpl::$_tpl_vars["_users"] as Tpl::$_tpl_vars["_user"]){; ?>
						      <tr>
						        <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->uid, ENT_QUOTES); ?></td>
						        <td>
						        	<a onclick='showWindow("/admin.user.detail?uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->uid, ENT_QUOTES); ?>")'>
						        		<?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->user_name, ENT_QUOTES); ?>
									</a>
								</td>
                                <td>
                                    <?php if(user_api::auth(["system","admin"],"or")){; ?>
                                    <?php if(Tpl::$_tpl_vars["_user"]->account_status==1){; ?>
                                    <a href="#" onclick="deleteUserByUid('<?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->uid, ENT_QUOTES); ?>')"><span class="btn btn-squared btn-xs btn-success" title="点击禁用">启用</span></a>
                                    <?php }elseif( Tpl::$_tpl_vars["_user"]->account_status==2){; ?>
                                    <a href="#" onclick="refreshUserByUid('<?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->uid, ENT_QUOTES); ?>')"><span class="btn btn-squared btn-xs btn-warning" title="点击启用">已禁用</span></a>
                                    <?php }; ?>
                                    <?php }else{; ?>
                                    <?php if(Tpl::$_tpl_vars["_user"]->account_status==1){; ?>
                                    <span class="btn btn-squared btn-xs" title="点击禁用">启用</span>
                                    <?php }elseif( Tpl::$_tpl_vars["_user"]->account_status==2){; ?>
                                    <span class="btn btn-squared btn-xs" style="color: red;" title="点击启用">已禁用</span>
                                    <?php }; ?>
                                    <?php }; ?>
                                </td>
								<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["roleList"][Tpl::$_tpl_vars["_user"]->role_id]['name'], ENT_QUOTES); ?></td>
                                <td>
                                    <div>
                                        <span>名称: <?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->host, ENT_QUOTES); ?></span>
                                    </div>
                                    <div>
                                        <span>地址: <?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->address, ENT_QUOTES); ?></span>
                                    </div>
                                    <div>
                                        <span>电话: <?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->cell_phone, ENT_QUOTES); ?></span>

                                    </div>
                                </td>
						       <!-- <td><?php echo htmlspecialchars(sprintf("%.3f",Tpl::$_tpl_vars["_user"]->account), ENT_QUOTES); ?></td> --> 
                                <!--<td><?php if(Tpl::$_tpl_vars["_user"]->account_type==1){; ?>人工<?php }else{; ?>同步<?php }; ?></td>-->
                                <td><?php if(Tpl::$_tpl_vars["_user"]->source==1){; ?>默认
                                    <?php }elseif( (Tpl::$_tpl_vars["_user"]->source==2)){; ?>精准营销平台
                                    <?php }elseif( (Tpl::$_tpl_vars["_user"]->source==3)){; ?>直真
                                    <?php }elseif( (Tpl::$_tpl_vars["_user"]->source==4)){; ?>外部
                                    <?php }elseif( (Tpl::$_tpl_vars["_user"]->source==5)){; ?>哇棒
                                    <?php }else{; ?>未知
                                    <?php }; ?>

                                </td>
                                <td>
                                    <div>创: <?php echo htmlspecialchars(date('Y-m-d H:i:s',Tpl::$_tpl_vars["_user"]->reg_time), ENT_QUOTES); ?></div>
                                    <div>更: <?php echo htmlspecialchars(date('Y-m-d H:i:s',Tpl::$_tpl_vars["_user"]->up_time), ENT_QUOTES); ?></div>
                                </td>
                                <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["creator"][Tpl::$_tpl_vars["_user"]->creator_id], ENT_QUOTES); ?></td>
						        <td>
                                    <a class="btn btn-squared btn-xs btn-info"  onclick='showWindow("/admin.user.detail?uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->uid, ENT_QUOTES); ?>")'>查看</a>
                                    <?php if(user_api::auth(["system","admin"],"or")){; ?>
                                    <?php if(Tpl::$_tpl_vars["_user"]->edit==1){; ?>
                                    <a class="btn btn-squared btn-xs btn-success " href="/baichuan_advertisement_manage/admin.user.edit.<?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->uid, ENT_QUOTES); ?>?nav=5&role=<?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->role_id, ENT_QUOTES); ?>">编辑</a>
                                    <?php }; ?>
                                    <?php }; ?>
								</td>
						      </tr>
						<?php }; ?>
					</tbody>
				</table>
                <div class="turnpage">
                <?php echo tpl_function_turnpager(Tpl::$_tpl_vars["totalPage"]); ?>
                </div>
				<?php /*$pager*/?>

			</div>
		</div>
	</div>
</div>
<script>
function layerConfirmCb(msg,fn){
    $.layer({
        area: ['auto','auto'],
        offset: ['20%',''],
        shade: [0.6, '#000'],
        dialog: {
            msg: msg,
            btns: 2,                    
            type: 4,
            btn: ['确认','取消'],
            yes: function(id){
                layer.close(id);
                fn();
            },
            no: function(){
            }
        }
    });
}
function deleteUserByUid(uid){
    var msg = "确认禁用该用户？";
    var url = "/admin.user.delete";
    layerConfirmCb(msg,function(){
        $.ajax({
            method: "post",
            url: url,
            data: "uid="+uid,
            success: function(response){
                if(response==""){
                    layer.msg("成功",1,1);
                }else{
                    layer.msg(response, 1, 1);
                }
                location.reload();
            },
            error: function (argument) {
                layer.msg("操作失败");
            }

        });
    });
}
function refreshUserByUid(uid){
    var msg = "确认启用该用户？";
    var url = "/admin.user.refresh";
    layerConfirmCb(msg,function(){
        $.ajax({
            method: "post",
            url: url,
            data: "uid="+uid,
            success: function(response){
                if(response==""){
                    layer.msg("成功",1,1);
                }else{
                    layer.msg(response, 1, 1);
                }
                location.reload();
            },
            error: function (argument) {
                layer.msg("操作失败");
            }

        });
    });
}
function showWindow(url){
    var w = window.open(url,"_blank","toolbar=yes, location=no, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=550, height=650");
//    setTimeout(function(){ w.close()},1000*3);
}
</script>
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
</body>
</html>
