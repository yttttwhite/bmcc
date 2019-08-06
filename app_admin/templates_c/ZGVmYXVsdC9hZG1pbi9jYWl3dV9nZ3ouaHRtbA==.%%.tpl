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
        <?php echo htmlspecialchars(tpl_function_part(("/admin.caiwu.left")), ENT_QUOTES); ?> 
    </div>
    <!--mcon start-->
    <div class="mcon">
        <div class="toolbar-bc fl mb-10">
            <div class="fl sub-title sc-title">
                <a href="/baichuan_advertisement_manage/admin.caiwu.list?nav=5&menu=1" >高级管理</a>
                <i class="fa fa-angle-double-right" ></i>
                用户账务
            </div>
        </div>
        <div class="clear"></div>
<?php /*  
    注释 权限说明
    10000   =>'name'=>"系统管理员",  
    1000    =>'name'=>"运营账户", 
    18      =>'name'=>"子运营账户",
    11      =>'name'=>"客服",  
    12      =>'name'=>"客户经理",
    13      =>'name'=>"广告主", 
    14      =>'name'=>"运维",  
    15      =>'name'=>"黑白名管理员",  
    16      =>'name'=>"稽核员", 
    17      =>'name'=>"产品经理",
*/?>
		<div class="panel panel-white" style="border:1px solid #EEEEEE;">
			<!--表头-->
			<div class="panel-heading border-light panel-head-md">
				<form id="queryFrom" action="<?php echo htmlspecialchars(Tpl::$_tpl_vars["url"]['date'], ENT_QUOTES); ?>" method="get">
                   <input name="menu" type="hidden" value="1">
                   <input name="nav" type="hidden" value="5">
                    <div class="fl" style="position: relative; left: 10px;">
						<input type="text" name="key" class="form-control input-small"  placeholder="账户名" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["get"]['key'], ENT_QUOTES); ?>"/>
					</div>
                    <div class="fl">
                        <select class="ml-10 input-small" name="options">
                            <option <?php if(Tpl::$_tpl_vars["get"]['options']=='全部'){; ?>selected<?php }; ?> value="全部">全部</option>
                            <option <?php if(Tpl::$_tpl_vars["get"]['options']=='指定'){; ?>selected<?php }; ?> value="指定">指定</option>
                            <option <?php if(Tpl::$_tpl_vars["get"]['options']=='所属'){; ?>selected<?php }; ?> value="所属">所属</option>
                        </select>
                    </div>
                    <div class="fl">
                        <select class="ml-10 input-small" name="role_id">
                            <option selected="" value="">全部账户类型</option>
                            <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000])){; ?><option <?php if(Tpl::$_tpl_vars["get"]['role_id']==10000){; ?>selected<?php }; ?> value="10000">管理员账户</option><?php }; ?>
                            <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000])){; ?><option <?php if(Tpl::$_tpl_vars["get"]['role_id']==1000){; ?>selected<?php }; ?> value="1000">运营账户</option><?php }; ?>
                            <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000])){; ?><option <?php if(Tpl::$_tpl_vars["get"]['role_id']==18){; ?>selected<?php }; ?> value="18">子运营账户</option><?php }; ?>
                            <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000,18])){; ?><option <?php if(Tpl::$_tpl_vars["get"]['role_id']==12){; ?>selected<?php }; ?> value="12">客户经理账户</option><?php }; ?>
                            <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000,18,17])){; ?><option <?php if(Tpl::$_tpl_vars["get"]['role_id']==13){; ?>selected<?php }; ?> value="13">广告主账户</option><?php }; ?>
                        </select>
                    </div>
					<div class="fl">
                        <select class="ml-10 input-small" name="status">
                            <option value="">--状态--</option>
                            <option <?php if(Tpl::$_tpl_vars["get"]['status']==1){; ?>selected<?php }; ?> value="1">启用</option>
                            <option <?php if(Tpl::$_tpl_vars["get"]['status']==2){; ?>selected<?php }; ?> value="2">禁用</option>
                        </select>
					</div>
                    <div class="fl" style="position: relative; left: 10px;">
                        <input class="btn btn-squared btn-sm btn-success ml-10" type="submit" value="查询">
                    </div>
					<span style="line-height:28px; position: relative; left: 20px;">共计：<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["total"]), ENT_QUOTES); ?>条</span>
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
				<table class="reportab" width="100%" id="sample-table-2">
					<thead>
						<tr>
							<th>用户ID</th>
					        <th>账户名</th>
							<th>状态</th>
							<th>类型</th>
                            <th>所属账户</th>
							<th>累计展示量</th>
					        <th>累计存款</th>
					        <th>累计花费</th>
					        <th>当前余额</th>
					        <th>操作</th>
						</tr>
					</thead>
                    <?php foreach(Tpl::$_tpl_vars["caiwu"] as Tpl::$_tpl_vars["_user"]){; ?>
					<tbody>
						      <tr>
						        <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->uid, ENT_QUOTES); ?></td>
						        <td>
                                    <a data-toggle="collapse"
                                       href=".collapseThree"><?php if(isset(Tpl::$_tpl_vars["_user"]->lower_level_user)){; ?><span class="showDetail" style="font-weight: bold;color: red;">+</span><?php }; ?></a>
						        	<a onclick='showWindow("/admin.caiwu.detail?uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->uid, ENT_QUOTES); ?>")'>
						        		<?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->user_name, ENT_QUOTES); ?>
									</a>
								</td>
                                <td>
                                    <span><?php if(Tpl::$_tpl_vars["_user"]->account_status==1){; ?>启用<?php }elseif( Tpl::$_tpl_vars["_user"]->account_status==2){; ?>禁用<?php }; ?></span>
                                </td>
                                <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->role_name, ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->createname, ENT_QUOTES); ?></td>
                                <td>
                                    <span><?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->show/1000, ENT_QUOTES); ?> CPM</span>
                                </td>
						        <td><span><strong class="ye">￥<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_user"]->allsavemoney,2), ENT_QUOTES); ?></strong></span></td>
                                <td><span><strong class="ye">￥<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_user"]->total_cost,2), ENT_QUOTES); ?></strong></span></td>
                                <td>
                                    <span><strong class="ye">￥<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_user"]->account,2), ENT_QUOTES); ?></strong></span>
                                </td>
						        <td>
                                    <div>
						        	<a href="/baichuan_advertisement_manage/admin.caiwu.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->uid, ENT_QUOTES); ?>?nav=5">【财务录入】</a>
                                    </div>
                                    <div>
									<a href="/baichuan_advertisement_manage/admin.caiwu.stream?uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->uid, ENT_QUOTES); ?>&nav=5&menu=2" >【查看流水】</a>
                                    </div>
<!--                                     <div>
									<a href="/baichuan_advertisement_manage/admin.user.detail?uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->uid, ENT_QUOTES); ?>" target="_blank">【查看账单】</a>
                                    </div>
 -->								</td>
						      </tr>
                              <?php if(isset(Tpl::$_tpl_vars["_user"]->lower_level_user)){; ?>
                        <?php foreach(Tpl::$_tpl_vars["_user"]->lower_level_user as Tpl::$_tpl_vars["lower_user"]){; ?>
                              <tr class="panel-collapse collapse" style="font-size: small;color: red;">
                                <td>
                                    <?php echo htmlspecialchars(Tpl::$_tpl_vars["lower_user"]->uid, ENT_QUOTES); ?>
                                </td>
                                <td>
                                    <a style="font-size: small;color: red;" onclick='showWindow("/admin.caiwu.detail?uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["lower_user"]->uid, ENT_QUOTES); ?>")'>
                                        <?php echo htmlspecialchars(Tpl::$_tpl_vars["lower_user"]->user_name, ENT_QUOTES); ?>
                                    </a>
                                </td>
                                <td>
                                    <span><?php if(Tpl::$_tpl_vars["lower_user"]->account_status==1){; ?>启用<?php }elseif( Tpl::$_tpl_vars["lower_user"]->account_status==2){; ?>禁用<?php }; ?></span>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars(Tpl::$_tpl_vars["lower_user"]->role_name, ENT_QUOTES); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars(Tpl::$_tpl_vars["lower_user"]->createname, ENT_QUOTES); ?>
                                </td>
                                <td>
                                    <span><?php echo htmlspecialchars(Tpl::$_tpl_vars["lower_user"]->show/1000, ENT_QUOTES); ?> CPM</span>
                                </td>
                                <td><span><strong class="ye">￥<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["lower_user"]->allsavemoney,2), ENT_QUOTES); ?></strong></span></td>
                                <td><span><strong class="ye">￥<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["lower_user"]->total_cost,2), ENT_QUOTES); ?></strong></span></td>
                                <td>
                                    <span><strong class="ye">￥<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["lower_user"]->account,2), ENT_QUOTES); ?></strong></span>
                                </td>
                                <td>
                                    <div>
                                        <a href="/baichuan_advertisement_manage/admin.caiwu.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["lower_user"]->uid, ENT_QUOTES); ?>?nav=5">【财务录入】</a>
                                    </div>
                                    <div>
                                        <a href="/baichuan_advertisement_manage/admin.caiwu.stream?uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["lower_user"]->uid, ENT_QUOTES); ?>?nav=5" >【查看流水】</a>
                                    </div>
                                </td>

                            </tr>

						<?php }; ?>
                    <?php }; ?>

					</tbody>
                    <?php }; ?>
				</table>
                <div class="turnpage">
                <?php echo tpl_function_turnpager(Tpl::$_tpl_vars["totalPage"]); ?>
                </div>
			</div>
		</div>
	</div>
</div>
<script>
function deleteUserByUid(uid){
    var msg = "确认禁用该用户？";
    var url = "/admin.user.delete?uid=" + uid;
    layerConfirmGet(url, msg);
}
function refreshUserByUid(uid){
    var msg = "确认启用该用户？";
    var url = "/admin.user.refresh?uid=" + uid;
    layerConfirmGet(url, msg);
}
function showWindow(url){
    var w = window.open(url,"_blank","toolbar=yes, location=no, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=550, height=650");
//    setTimeout(function(){ w.close()},1000*3);
}

    var xx =0;
$('.showDetail').on('click',function(){

    $(this).parent().parent().parent().siblings().collapse('toggle');
    xx++;
    if(xx%2 == 0){
        $(this).text('+');
    }
    else {
        $(this).text('-');
    }
})



//    $('.showDetail').click(function(){
////        if( $(this).hasClass('myclass')){
////
////            $(this).text('+');
////            $(this).removeClass('myclass')
////        }
////        else {
////
////            $(this).text('-');
////            $(this).addClass('myclass')
////        }
//
//})

</script>
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
</body>
</html>
