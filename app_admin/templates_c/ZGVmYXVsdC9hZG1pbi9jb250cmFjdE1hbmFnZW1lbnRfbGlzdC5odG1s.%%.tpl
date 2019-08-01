<!doctype html>
<html lang="ZH-CN">
<head>
    <title>广告投放管理平台</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta https-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link href="https://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/baichuan_advertisement_manage/assets_admin/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/baichuan_advertisement_manage/assets_admin/contractManagement_list.css" />
    <style type="text/css">
        .infoTable {
            /*border: 1px solid red;*/
        }
        .left_nav {
            left: 0;
        }
        .a-upload {
            padding: 4px 10px;

            line-height: 20px;
            position: relative;
            cursor: pointer;
            color: #888;
            background: #fafafa;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            display: inline-block;
            *display: inline;
            *zoom: 1;
            height: 28px;
            top: 10px;
            margin-left: 5px;
        }

        .a-upload  input {
            position: absolute;
            font-size: 100px;
            right: 0;
            top: 0;
            opacity: 0;
            filter: alpha(opacity=0);
            cursor: pointer
        }

        .a-upload:hover {
            color: #444;
            background: #eee;
            border-color: #ccc;
            text-decoration: none
        }
        .table-striped>tbody>tr.activity>td{
        	background-color:#caf8f8!important;
        }
    </style>
    <head>
        <?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
    </head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.ad"), ENT_QUOTES); ?>
<div class="left_nav">
    <!--<ul>-->

        <!--<li class="left_nav_1" style="background: #12c043;color: #fff;margin-bottom: 10px;"><a style="color: #fff;" href="/baichuan_advertisement_manage/admin.contract.new">+ 创建合同</a></li>-->
        <!--<li class="left_nav_1">合同审核</li>-->
        <!--<li class="left_nav_2" style="background: #666666;">-->
            <!--&lt;!&ndash;<span class="glyphicon glyphicon-star" aria-hidden="true"></span>&ndash;&gt;-->
            <!--<a href="javascript:;" style="color: #fff;">-->
              <!--合同计划审核-->
            <!--</a>-->
        <!--</li>-->
        <!--<li class="left_nav_3"><span style="color: #1182d1;" > ▪ </span>待审核</li>-->
        <!--<li class="left_nav_4"><a href=""><span style="color: #1182d1;" > ▪ </span>已通过</a></li>-->
        <!--<li class="left_nav_5"><a href=""><span style="color: #1182d1;" > ▪ </span>未通过</a></li>-->
    <!--</ul>-->
    <div class="side">
        <?php if(user_api::auth("createContract")){; ?>
        <a class="btn btn-squared btn-success" href="/baichuan_advertisement_manage/admin.contract.new?nav=7" style="width: 100%; background: #12C043;">创建合同</a>
        <br><br>
        <?php }; ?>
        <div class="accordion" style="margin-top:0;">
            <h2>合同管理</h2>
            <a href="/baichuan_advertisement_manage/admin.contract.list?nav=7"><h3 class="bort active">合同列表</h3></a>
            <?php if(user_api::auth(["shenhe","shenheContract"],"or")){; ?>
            <a href="/baichuan_advertisement_manage/admin.contract.audited?nav=7"><h3 class="bort">合同审核</h3></a>
            <?php }; ?>
            <!--<a href="/baichuan_advertisement_manage/media.tag"> <h3 class="bort ">广告位分类</h3></a>-->

            <!--<a href="/baichuan_advertisement_manage/media.position"> <h3 class="bort ">广告位置</h3></a>-->
            <!--<a href="/baichuan_advertisement_manage/media.schedule"> <h3 class="bort ">广告位排期</h3></a>-->

        </div>

    </div>
</div>

<div class="top_nav" style="margin-left:265px;width: 80%; ">
    <a href="/baichuan_advertisement_manage/admin.contract.list?nav=7">合同管理</a>
    <span style="color:#3f3333;">>></span>
    <a href="/baichuan_advertisement_manage/admin.contract.list?nav=7">合同列表</a>
    <!--合同管理 <span style="color:#3f3333">>></span> 合同列表-->
    <!--<span class="CreateContract_btn"><a href="/baichuan_advertisement_manage/admin.contract.new">+ 创建合同</a></span>-->
</div>


<!--搜索 start-->
<form class="search" style="margin-left:265px;position: relative">
            <!--<input  class="btn btn-squared btn-sm btn-success ml-5" style="height:28px; width: 0; padding-left: 54px;overflow: hidden;padding-right: 0px;margin-left: 5px;display: inline-block" type="file" value="导入">-->
            <!--<span style="position: absolute; left: 18px;top: 15px;color: white;">录入</span>-->
    <!--<a href="javascript:;" class="a-upload">-->
        <!--<input type="file" name="" id="">录入-->
    <!--</a>-->

    <input name="nav" type="hidden" value="7">
    <input name="contact_company_name" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['contact_company_name'], ENT_QUOTES); ?>" class="search_1" type="text"  placeholder="--请输入客户公司名称--">
 <input name="company_name" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['company_name'], ENT_QUOTES); ?>" class="search_2" type="text"  placeholder="--请输入所属分公司名称--">
 <input name="contract_num" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['contract_num'], ENT_QUOTES); ?>" class="search_3" type="text"  placeholder="--请输入合同序号--">
 <input class="btn btn-squared btn-sm btn-success ml-10" type="submit" value="查询" style="display: inline-block;">
    <span style="line-height:28px; position: relative; left: 20px;">共计：<?php echo htmlspecialchars(Tpl::$_tpl_vars["total"], ENT_QUOTES); ?>条</span>
    <!--<a href="/baichuan_advertisement_manage/admin.contract.audited"><span style="" class="glyphicon glyphicon-share-alt" aria-hidden="true">合同审核列表</span></a>-->
</form>
<!--搜索 end-->

<div class="infoTable" style="margin-left: 265px;width: 80%;height: auto;margin-bottom:100px;" >
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>合同ID</th>
            <th>合同序号</th>
            <th>合同名称</th>
            <th>合同类型</th>
            <th>客户公司名称</th>
            <th>客户经理所属分公司</th>
            <th>客户经理姓名</th>
            <th>合同折扣前总价</th>
            <th>花费金额</th>
            <th>剩余金额</th>
            <!--<th>工作地址</th>-->
            <!--<th>合同文件</th>-->
            <th>审核状态</th>
            <!--<th>广告单价</th>-->
            <!--<th>广告预算</th>-->
            <!--<th>备注</th>-->
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach(Tpl::$_tpl_vars["contractInfo"] as Tpl::$_tpl_vars["contractInfo"] => Tpl::$_tpl_vars["contract_Info"]){; ?>
        <tr>
            <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_id'], ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_num'], ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_name'], ENT_QUOTES); ?></td>
            <!--<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_type'], ENT_QUOTES); ?></td>-->
            <td style="width: 65px;">
                <?php if(Tpl::$_tpl_vars["contract_Info"]['contract_type'] =='1'){; ?>
                竞价制
                <?php }elseif( Tpl::$_tpl_vars["contract_Info"]['contract_type'] =='2'){; ?>
                合约制
                <?php }else{; ?>
                未知
                <?php }; ?>
            </td>
            <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contact_company_name'], ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['company_name'], ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['manager_name'], ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['total_budget'], ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['used_budget'], ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['access_budget'], ENT_QUOTES); ?></td>
            <!--<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['work_addr'], ENT_QUOTES); ?></td>-->
            <td width="50px;">
                <!--<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['verify_status'], ENT_QUOTES); ?>-->
                <?php if(Tpl::$_tpl_vars["contract_Info"]['verify_status']==1){; ?>待审核<?php }elseif( Tpl::$_tpl_vars["contract_Info"]['verify_status']==2){; ?>审核通过<?php }elseif( Tpl::$_tpl_vars["contract_Info"]['verify_status']==3){; ?>退回修改<?php }; ?>
            </td>
            <!--<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_file'], ENT_QUOTES); ?></td>-->
            <!--<td>-->
                <!--<input type="button" value="通过" style="display: none;width: ">-->
            <!--</td>-->
            <!--<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_remark'], ENT_QUOTES); ?></td>-->
            <td style="width: 145px;">
                <?php if(Tpl::$_tpl_vars["contract_Info"]['verify_status']==1){; ?><a class="btn_del" onclick="del('<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]["contract_id"], ENT_QUOTES); ?>')">删除</a><?php }elseif( Tpl::$_tpl_vars["contract_Info"]['verify_status']==2){; ?><a class="btn_del" style="background-color: grey;">删除</a><?php }elseif( Tpl::$_tpl_vars["contract_Info"]['verify_status']==3){; ?><a class="btn_del" onclick="del('<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]["contract_id"], ENT_QUOTES); ?>')">删除</a><?php }; ?>
                <?php if(Tpl::$_tpl_vars["contract_Info"]['verify_status']==1){; ?><a class="btn_edit"  href="/baichuan_advertisement_manage/admin.contract.editor.<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_id'], ENT_QUOTES); ?>/?nav=7" >编辑</a><?php }elseif( Tpl::$_tpl_vars["contract_Info"]['verify_status']==2){; ?><a class="btn_edit" style="background-color: grey;">编辑</a><?php }elseif( Tpl::$_tpl_vars["contract_Info"]['verify_status']==3){; ?><a class="btn_edit"  href="/baichuan_advertisement_manage/admin.contract.editor.<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_id'], ENT_QUOTES); ?>/?nav=7">编辑</a><?php }; ?>
                <!--<a class="btn_read" href="" onclick='showWindow("/admin.user.detail?uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["_user"]->uid, ENT_QUOTES); ?>")'>查看</a>-->
                <!--<a class="btn_edit"  href="/baichuan_advertisement_manage/admin.contract.editor.<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_id'], ENT_QUOTES); ?>" target="_blank">编辑</a>-->
                <span class="del_id"  style="display: none;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_id'], ENT_QUOTES); ?></span>
                <!--<a class="btn_jihua" href="" href="/baichuan_advertisement_manage/admin.contract.editor">生成计划</a>-->
                <a class="btn_read" onclick='showWindow("/admin.contract.detail?contract_id=<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_id'], ENT_QUOTES); ?>")'>
                查看详情
                </a>
            </td>
        </tr>
        <?php }; ?>
        </tbody>
    </table>
     <div class="turnpage" style="margin-top:0px;">
                <?php echo tpl_function_turnpager(Tpl::$_tpl_vars["totalPage"]); ?>
     </div>
				<?php /*$pager*/?>

</div>
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
</body>
</html>
<script>
    $(function(){



       $(".left_nav_2").click(function () {
          $(".left_nav_3").stop().toggle();
          $(".left_nav_4").stop().toggle();
          $(".left_nav_5").stop().toggle();

       });

       $("h3").click(function () {
           $(this).toggleClass('active')
       })
       
       $(".table tbody").on("click","tr",function(e){
       		e.stopPropagation();
       		if($(this).siblings(".activity").length>0)$(this).siblings(".activity").removeClass("activity");
       		if($(this).hasClass("activity"))$(this).removeClass("activity");
       		else $(this).addClass("activity");
       });

    });

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

    function del(contract_id){
        var msg = "确认删除该合同信息？";
        layerConfirmCb(msg,function(){
            $.ajax({
                type: "POST",
                url: "/admin.contract.del?contract_id="+contract_id+"&nav=7",
                dataType:"json",
                success: function(msg){
                    location.reload();
                },
                error: function(){
                    console.log('删除失败');
                }
            });
        });
    }

  /*  $(function () {
        $(".btn_del").click(function () {
            alert($(".del_id").text());
            var contract_id = $(".del_id").text();
            $.ajax({
                url:"/admin.contract.new?id="+contract_id,
                type: "get",
                success: function (res) {
//                $("#cId").val(returnValue);
                    alert(res);
                },
                error: function (returnValue) {
                    alert("对不起！删除失败！");
                }
            });
        });

    });*/

    function showWindow(url){
        var w = window.open(url,"_blank","toolbar=yes, location=no, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=550, height=650");
    }

</script>