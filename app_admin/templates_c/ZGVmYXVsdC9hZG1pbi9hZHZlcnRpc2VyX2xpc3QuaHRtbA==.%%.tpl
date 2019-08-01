<!DOCTYPE html>
<html>
<head>
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.admin"), ENT_QUOTES); ?>
<!--main-->
<div class="main" >
	<nav class="side">
		<div class="accordion" style="margin-top: 0;">
			<h2 style="background: #1478DC;">账户类型</h2>
			<a href="/baichuan_advertisement_manage/admin.advertiser.list?admin=<?php echo htmlspecialchars(Tpl::$_tpl_vars["admin"], ENT_QUOTES); ?>&nav=3">
				<!--<h3 class="bort <?php if(!isset(Tpl::$_tpl_vars["GET"]['role'])){; ?>active<?php }; ?>">全部账户</h3>-->
				<h3 class="bort <?php if(empty(Tpl::$_tpl_vars["GET"]['role'])){; ?>active<?php }; ?>">全部账户</h3>
			</a>
			<?php foreach(Tpl::$_tpl_vars["roleList"] as Tpl::$_tpl_vars["roleId"]=>Tpl::$_tpl_vars["role"]){; ?>
				<a href="/baichuan_advertisement_manage/admin.advertiser.list?role=<?php echo htmlspecialchars(Tpl::$_tpl_vars["roleId"], ENT_QUOTES); ?>&admin=<?php echo htmlspecialchars(Tpl::$_tpl_vars["admin"], ENT_QUOTES); ?>&nav=3">
					<h3 class="bort <?php if(isset(Tpl::$_tpl_vars["GET"]['role'])&&Tpl::$_tpl_vars["GET"]['role']==Tpl::$_tpl_vars["roleId"]){; ?>active<?php }; ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["role"]['name'], ENT_QUOTES); ?></h3>
				</a>
			<?php }; ?>
		</div>
	</nav>
	
    <!--mcon start-->
    <div class="mcon">
        <div class="toolbar-bc fl mb-10">
            <div class="fl sub-title sc-title">
                <a href="/baichuan_advertisement_manage/admin.user.list?nav=3">广告报表</a>
                <i class="fa fa-angle-double-right" ></i>
                <a href="/baichuan_advertisement_manage/admin.advertiser.list?nav=3">投放概况</a>
                <i class="fa fa-angle-double-right" ></i>
				<span><?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["roleList"][Tpl::$_tpl_vars["GET"]['role']]['name'],'全部账户'), ENT_QUOTES); ?></span>
            </div>
        </div>
        <div class="clear"></div>
		<div id="user-info" class="panel panel-white panel-squared">
			<div class="panel-heading border-light">
				<h4 class="panel-title">可选操作</h4>
			</div>
			<div class="panel-body">
				<form action="" method="get">
					<div class="form-group">
						<div class="input-group">
							<input type="hidden" name="role" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['role'], ENT_QUOTES); ?>">
							<input type="text" class="form-control" name="key" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['key'], ENT_QUOTES); ?>" placeholder="用户名">
							<input type="hidden" name="nav" class="form-control input-small"  value="5"/>
							<span class="input-group-btn">
								<input class="btn btn-success btn-squared" type="submit" value="搜索">
							</span>
						</div>
					</div>
					
					<div>
						<a class="btn btn-xs btn-squared btn-default" href="/baichuan_advertisement_manage/admin.advertiser.list?nav=3&role=<?php echo htmlspecialchars(Tpl::$_tpl_vars["GET"]['role'], ENT_QUOTES); ?>">全部</a>
						<a class="btn btn-xs btn-squared btn-default" href="admin.advertiser.list?planStatus=1&nav=3&role=<?php echo htmlspecialchars(Tpl::$_tpl_vars["GET"]['role'], ENT_QUOTES); ?>">有广告投放</a>
						<a class="btn btn-xs btn-squared btn-default" href="admin.advertiser.list?planVerify=1&nav=3&role=<?php echo htmlspecialchars(Tpl::$_tpl_vars["GET"]['role'], ENT_QUOTES); ?>">有广告待审</a>
						<a class="btn btn-xs btn-squared btn-default" href="#" onclick="hideItem()">隐藏项目</a>
						<label class="radio-inline" style="margin-top: 10px !important;">
							<input type="radio" class="flat-red" name="keyType" value="name" <?php if(Tpl::$_tpl_vars["_GET"]['keyType']=="name" or empty(Tpl::$_tpl_vars["_GET"]['keyType'])){; ?>checked="checked"<?php }; ?>>  搜索用户
						</label>
						<label class="radio-inline" style="margin-top: 10px !important;">
							<input type="radio" class="flat-red" name="keyType" <?php if(Tpl::$_tpl_vars["_GET"]['keyType']=="company"){; ?>checked="checked"<?php }; ?> value="company">  搜索公司
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

		<table class="table table-striped table-hover table-bordered table-responsive" id="layoutActive">
			<thead>
				<tr>
					<th style="text-align:center;" width="40">UID</th>
					<th style="text-align:center;" width="200">用户名</th>
					<th style="text-align:center;" width="200">公司/姓名</th>
					<th style="text-align:center;" width="200" class="hidden-item">账号状态</th>
					<th style="text-align:center;" width="140" class="hidden-item">余额</th>
					<th style="text-align:center;" width="140" class="hidden-item">角色</th>
					<th style="text-align:center;" width="140">广告总数</th>
					<th style="text-align:center;" width="140">待审核</th>
					<th style="text-align:center;" width="140">已通过</th>
					<th style="text-align:center;" width="140">正在运行</th>
					<th style="text-align:center;" width="140">曝光总量（CPM）</th>
					<th style="text-align:center;" width="140">CPT总量（天）</th>
					<th style="text-align:center;" width="120">操作</th>
				</tr>
			</thead>
			<tfoot>
				<tr style="background-color: #EEEEEE; font-weight: bold;">
					<td style="text-align:center;" colspan="2">总计</td>
					<td></td>
					<td style="text-align:center;" class="hidden-item"></td>
					<td style="text-align:center;" class="hidden-item"></td>
					<td style="text-align:center;" class="hidden-item"></td>
					<td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["summary"]['total'], ENT_QUOTES); ?></td>
					<td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["summary"]['verify_1'], ENT_QUOTES); ?></td>
					<td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["summary"]['verify_2'], ENT_QUOTES); ?></td>
					<td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["summary"]['enable_1'], ENT_QUOTES); ?></td>
					<td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["sum_cpm"], ENT_QUOTES); ?></td>
					<td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["summary"]['total_cpt'], ENT_QUOTES); ?></td>
					<td style="text-align:center;"></td>
				</tr>
			</tfoot>
			<tbody>
				
				
				
			</tbody>
		</table>
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
<script>
	$(function(){
		var rowsTable={
			dataArr:[],            //将$list的php变量转化为json
			adArr:null,            //将$adList的php变量转化为json
			currentUid:"<?php echo htmlspecialchars(Tpl::$_tpl_vars["currentUser"]->uid, ENT_QUOTES); ?>", //当前登录平台的用户
			parentDom:$("#layoutActive tbody"), //需要动态渲染的上级dom
			/**
			 * 初始化
			 */
			init:function(){
				this.changeDataPhpRoleToObject();
				this.changeDataPhpToObject();
				this.layoutTable();
				this.initEvent();
			},
			/**
			 * 将$adList的php变量转化为json
			 */
			changeDataPhpRoleToObject:function(){
				this.adArr=new Object();
				<?php foreach(Tpl::$_tpl_vars["adList"] as Tpl::$_tpl_vars["key"]=>Tpl::$_tpl_vars["val"]){; ?>
					<?php if(is_array(Tpl::$_tpl_vars["val"])){; ?>var obj=new Object();<?php foreach(Tpl::$_tpl_vars["val"] as Tpl::$_tpl_vars["key1"]=>Tpl::$_tpl_vars["val1"]){; ?>obj["<?php echo htmlspecialchars(Tpl::$_tpl_vars["key1"], ENT_QUOTES); ?>"]="<?php echo htmlspecialchars(Tpl::$_tpl_vars["val1"], ENT_QUOTES); ?>";<?php }; ?>this.adArr["<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>"]=obj;<?php }else{; ?>this.adArr["<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>"]="<?php echo htmlspecialchars(Tpl::$_tpl_vars["val"], ENT_QUOTES); ?>";
					<?php }; ?>
				<?php }; ?>
			},
			/**
			 * 将$list的php变量转化为json
			 */
			changeDataPhpToObject:function(){
				<?php foreach(Tpl::$_tpl_vars["list"] as Tpl::$_tpl_vars["item"]){; ?>
					var dataObj= new Object();<?php foreach(Tpl::$_tpl_vars["item"] as Tpl::$_tpl_vars["key"]=>Tpl::$_tpl_vars["val"]){; ?>dataObj["<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>"]="<?php echo htmlspecialchars(Tpl::$_tpl_vars["val"], ENT_QUOTES); ?>";<?php }; ?>this.dataArr.push(dataObj);
				<?php }; ?>
			},
			/**
			 * 判断是否为上级
			 * @param <?php echo htmlspecialchars(Object, ENT_QUOTES); ?> uid
			 */
			isParent:function(uid){
				var that=this,bol=false;
				$.each(that.dataArr,function(n,m){
					if(uid==m.creator_id&&uid!=m.uid){
						bol=!bol;
						return false;
					}
				})
				return bol;
			},
			/**
			 * 
			 * @param <?php echo htmlspecialchars(Object, ENT_QUOTES); ?> data 当前数据
			 * @param <?php echo htmlspecialchars(Object, ENT_QUOTES); ?> bol  是否有分支
			 * @param <?php echo htmlspecialchars(Object, ENT_QUOTES); ?> index 当前分支级别
			 */
			layoutTr:function(data, bol ,index){
				return '<tr data-level='+index+' '+(index?("show-for="+data.creator_id):"")+' class='+(index?"hidden-item":"")+'>'+
				       '<td style="text-align:center;">'+data['uid']+'</td>'+
					   '<td style="text-indent:'+10*index+'px;">'+(this.isParent(data.uid)?'<i data-to="'+data.uid+'" class="fa fa-angle-down" style="display:inline;cursor:pointer;margin-right:5px;"></i>':'')+data['user_name']+'</td>'+
					   '<td>'+data['host']+'</td>'+
					   '<td class="hidden-item">'+(data['account_status']==1?'正常':'<span style="color:#CC0000;">禁用</span>')+'</td>'+
					   '<td style="text-align:center;" class="hidden-item">'+data['account']+'</td>'+
					   '<td style="text-align:center;">'+this.adArr[data.uid]["total"]+'</td>'+
					   '<td style="text-align:center;">'+this.adArr[data.uid]["verify_1"]+'</td>'+
					   '<td style="text-align:center;">'+this.adArr[data.uid]["verify_2"]+'</td>'+
					   '<td style="text-align:center;">'+this.adArr[data.uid]["enable_1"]+'</td>'+
					   '<td style="text-align:center;">'+data['cpm_show_num']+'</td>'+
					   '<td style="text-align:center;">'+(!this.adArr[data.uid]["total_cpt"]?0:this.adArr[data.uid]["total_cpt"])+'</td>'+
					   '<td style="text-align:center;">'+
					   '<a href="/baichuan_advertisement_manage/admin.plan.list?uid='+data['uid']+'&nav=3" style="margin-left:5px;" target="_blank">广告计划</a></td>'+
					   '</tr>';
			},
			/**
			 * 初始化渲染的表格事件
			 */
			initEvent:function(){
				$("[data-to]").on("click",function(e){
					var $that=$(this);
					if(e.StopIteration)e.StopIteration();
					if($(this).hasClass("fa-angle-down")){
						$(this).removeClass("fa-angle-down").addClass("fa-angle-up");
						$("[show-for="+$(this).attr("data-to")+"]").show();
					}
					else{
						$(this).removeClass("fa-angle-up").addClass("fa-angle-down");
						$("[show-for="+$(this).attr("data-to")+"]").hide();
						$(this).closest("tr").nextAll().each(function(i,o){
							$(o).hide();
							if($(o).find("[data-to]").length>0){
							  $(o).find("[data-to]").removeClass("fa-angle-up").addClass("fa-angle-down")
							}
							if($(o).attr("show-for")==$that.closest("tr").attr("show-for")){
								return false;
							}
						})
					}
				});
			},
			/**
			 * 获取角色数据
			 */
			getRoleData:function(){
				var roleData=[];
				$.each(that.dataArr,function(i,o){
					if(o.role_id===that.roleId){
						roleData.push(o);
					}
				});
				return roleData;
			},
			/**
			 * 递归渲染table
			 * @param <?php echo htmlspecialchars(Object, ENT_QUOTES); ?> uid
			 * @param <?php echo htmlspecialchars(Object, ENT_QUOTES); ?> index
			 */
			layoutTable:function(uid,index){
				var index_=index?index:0;
				var that=this;
				$.each(that.dataArr,function(i,o){
					if(uid && uid === o.creator_id && o.uid !=o.creator_id){
						that.parentDom.append($(that.layoutTr(o,that.isParent(o.uid),index_)))
						if(that.isParent(o.uid)){
							that.layoutTable(o.uid,index_+1);
						}
					}
					else if(!uid){
						if(o.uid===that.currentUid){
							that.parentDom.append($(that.layoutTr(o,that.isParent(o.uid),index_)));
							if(that.isParent(o.uid)){
								that.layoutTable(o.uid,index_+1);
							}
						}
						else if($("[name=role]").val() == o.role_id){
						  that.parentDom.append($(that.layoutTr(o,that.isParent(o.uid),index_)));
              if(that.isParent(o.uid)){
                that.layoutTable(o.uid,index_+1);
              }
						}
					}
				})
			}
		}
		rowsTable.init();
	});
</script>
<style>
 .table-striped>tbody>tr[data-level="1"]{
 	background: #e9e9e9;
 }
 .table-striped>tbody>tr[data-level="2"]{
 	background: #d9d9d9;
 }	
 .table-striped>tbody>tr[data-level="3"]{
 	background: #c9c9c9;
 }
 .table-striped>tbody>tr[data-level="4"]{
 	background: #b9b9b9;
 }
 .table-striped>tbody>tr[data-level="5"]{
 	background: #a9a9a9;
 }
</style>
</html>
