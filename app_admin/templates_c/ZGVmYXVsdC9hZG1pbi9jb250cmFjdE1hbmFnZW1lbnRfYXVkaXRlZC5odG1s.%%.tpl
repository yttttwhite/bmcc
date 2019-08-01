<!doctype html>
<html lang="ZH-CN">
<head>
    <title>广告投放管理平台</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta https-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link href="https://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/baichuan_advertisement_manage/assets_admin/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/baichuan_advertisement_manage/assets_admin/contractManagement_list.css" />
    <style type="text/css">
        .left_nav_5,.left_nav_4,.left_nav_3,.left_nav_2 {
           color: #fff;
            background: #eff6fd;
        }
        .left_nav_2 a {
            color:#337AB7;
        }
        .left_nav_5:hover,.left_nav_4:hover,.left_nav_3:hover {
            color: #fff;
            background: #666
        }
        .left_nav_3 a:hover {
            color: #fff;
        }
        .left_nav_4 a{
            /*background: #666666;*/
        }

        .left_nav ul li.active {
            background: #666
        }
        .left_nav ul li.active a {
            color:#fff ;
        }
    </style>
    <head>
        <?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
    </head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.ad"), ENT_QUOTES); ?>
<!--<div class="left_nav">-->
    <!--<ul>-->
        <!--<li class="left_nav_1" style="display: none;">合同管理</li>-->
        <!--<li class="left_nav_2 " style="background:#12C043;">-->
            <!--<span class="" aria-hidden="true"></span>-->
            <!--<a href="javascript:" style="margin-right: 10px; color:#fff; font-weight:bold;">-->
                <!--合同计划审核-->
            <!--</a>-->
        <!--</li>-->
            <!--&lt;!&ndash;<li class="left-nav-title-active left_nav_2" style="">&ndash;&gt;-->
        	<!--&lt;!&ndash;<span >&ndash;&gt;-->
        		<!--&lt;!&ndash;&ndash;&gt;-->
        	<!--&lt;!&ndash;</span>&ndash;&gt;-->
            <!--&lt;!&ndash;</li>&ndash;&gt;-->

         <!--<li class="left_nav_3"><a style="margin-left: -25px;display: inline-block;width: 176px;max-height: 35px;" href="/baichuan_advertisement_manage/admin.contract.Audited?type=1"><span> ▪ </span>待审核</a></li>-->
        <!--<li class="left_nav_4"><a style="margin-left: -25px;display: inline-block;width: 176px;max-height: 35px;" href="/baichuan_advertisement_manage/admin.contract.Audited?type=2"><span> ▪ </span>已通过</a></li>-->
        <!--<li class="left_nav_5"><a style="margin-left: -25px;display: inline-block;width: 176px;max-height: 35px;" href="/baichuan_advertisement_manage/admin.contract.Audited?type=3"><span class="dot1" > ▪ </span>未通过</a></li>-->
    <!--</ul>-->
<!--</div>-->
<div class="side" style="margin-top: 20px">
    <script type="text/javascript">
        $(document).ready(function(){
            $(".accordion h3[current=active]").addClass("active");
            $(".accordion .snav:not([current=active])").hide();

            $(".accordion h3").click(function(){
                $(this).next(".snav").slideToggle("fast")
                    .siblings(".snav").slideUp("fast");
                $(this).toggleClass("active");
                $(this).siblings("h3").removeClass("active");
            });
            $(".checkall").change(function(){
                var ck=$(this).prop("checked");
                $(this).parents("table").find("input:checkbox").prop("checked",ck);
            });

        });
    </script>
    <?php if(user_api::auth("createContract")){; ?>
    <a class="btn btn-squared btn-success" href="/baichuan_advertisement_manage/admin.contract.new?nav=7" style="width: 100%; background: #12C043;">创建合同</a>
    <br><br>
    <?php }; ?>
    <div class="accordion" style="margin-top:0;">
        <h2>合同管理</h2>
        <a href="/baichuan_advertisement_manage/admin.contract.list?nav=7"><h3 class="bort">合同列表</h3></a>
        <?php if(user_api::auth(["shenhe","shenheContract"],"or")){; ?>
        <h3 class="bort  active" current="active">合同审核</h3>
        <div class="snav" style="display:block;" current="active">
            <ul>
                <li class="sel"><a href="/baichuan_advertisement_manage/admin.contract.Audited?type=1"><b>待审核</b></a></li>
                <li><a href="/baichuan_advertisement_manage/admin.contract.Audited?type=3">未通过</a></li>
                <li><a href="/baichuan_advertisement_manage/admin.contract.Audited?type=2">已通过</a></li>
            </ul>
        </div>
        <?php }; ?>
        <!--<h3 class="bort ">广告素材审核</h3>-->
        <!--<div class="snav" style="display: none;">-->
            <!--<ul>-->
                <!--<li><a href="/baichuan_advertisement_manage/admin.shenhe.stuff?type=1"><b>待审核</b></a></li>-->
                <!--<li><a href="/baichuan_advertisement_manage/admin.shenhe.stuff?type=3">未通过</a></li>-->
                <!--<li><a href="/baichuan_advertisement_manage/admin.shenhe.stuff?type=2">已通过</a></li>-->
            <!--</ul>-->
        <!--</div>-->

    </div>
</div>
<div class="top_nav" style="margin-top: 20px">
    <a href="/baichuan_advertisement_manage/admin.contract.list?nav=7">合同管理</a>
    <span style="color:#3f3333;">>></span>
    <a href="/baichuan_advertisement_manage/admin.contract.audited?nav=7">合同审核</a>
    <!--合同管理 <span style="color:#3f3333;">>></span> 合同审核-->
    <!--<span class="CreateContract_btn" style="width: 174px;"><a  href="/baichuan_advertisement_manage/admin.contract.list">返回合同信息列表</a></span>-->
</div>
<input id="status" name="type" type="hidden" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['type'], ENT_QUOTES); ?>">
<div class="infoTable" style="margin-left: 265px;width: 80%;height: auto;margin-bottom: 100px;" >
    <!--<table width="1155px;" border="0" cellspacing="0" cellpadding="0" class="reportab"  style="font-size:12px;margin-left: 18.5%;width:81.5%; ">-->
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <!--<th><input class="checkall" type="checkbox"/></th>-->
            <th style="width: 50px;">合同ID</th>
            <th style="width: 50px;">合同序号</th>
            <th style="width: 50px;">合同名称</th>
            <th style="width: 50px;">合同类型</th>
            <th style="width: 50px;">客户公司名称</th>
            <th style="width: 50px;">客户经理所属分公司</th>
            <th style="width: 50px;">客户经理姓名</th>
            <th style="width: 50px;">合同金额</th>
            <th style="width: 50px;">花费金额</th>
            <th style="width: 50px;">剩余金额</th>
            <!--<th>广告单价</th>-->
            <!--<th>广告预算</th>-->
            <th style="width: 50px;">状态</th>
            <th style="width: 50px;">审核状态</th>
            <th style="width: 115px;">操作</th>
        </tr>
         <?php foreach(Tpl::$_tpl_vars["contractInfo"] as Tpl::$_tpl_vars["contractInfo"] => Tpl::$_tpl_vars["contract_Info"]){; ?>
        <tr contractId="<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_id'], ENT_QUOTES); ?>" uid="<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['create_uid'], ENT_QUOTES); ?>">
            <!--<td><input class="checkall" type="checkbox"/></td>-->
            <td style="width: 50px;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]["contract_id"], ENT_QUOTES); ?></td>
            <td style="width: 180px;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_num'], ENT_QUOTES); ?></td>
            <td style="width: 50px;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_name'], ENT_QUOTES); ?></td>
            <td>
                <?php if(Tpl::$_tpl_vars["contract_Info"]['contract_type'] =='1'){; ?>
                竞价制广告合同
                <?php }elseif( Tpl::$_tpl_vars["contract_Info"]['contract_type'] =='2'){; ?>
                合约制广告合同
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

            <!--<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['price'], ENT_QUOTES); ?></td>-->
            <!--<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['total_budget'], ENT_QUOTES); ?></td>-->
            <td style="width: 50px;">正常</td>
            <td style="width: 50px;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['verify_status'], ENT_QUOTES); ?></td>
            <td style="width: 100px;" >
                <?php if(user_api::auth(["shenhe","shenheContract"],"or")){; ?>
      			<?php if(Tpl::$_tpl_vars["contract_Info"]['verify_status'] == "待审核" or Tpl::$_tpl_vars["contract_Info"]['verify_status'] == "退回修改"){; ?>
      				<!--<a href="javascript:" onclick="pass('<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]["contract_id"], ENT_QUOTES); ?>')">通过</a>-->
      				<a href="javascript:" onclick="setStatusById(2,this)">通过</a>
      			<?php }; ?>
      			<?php if(Tpl::$_tpl_vars["contract_Info"]['verify_status'] == "待审核"){; ?>
      				<!--<a href="javascript:" onclick="notpass('<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]["contract_id"], ENT_QUOTES); ?>')">拒绝</a>-->
      				<a href="javascript:" onclick="setStatusById(3,this)">拒绝</a>
      			<?php }; ?>
      		<?php }; ?>

                <a onclick='showWindow("/admin.contract.detail?contract_id=<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract_Info"]['contract_id'], ENT_QUOTES); ?>")'>
                    查看详情
                </a>
                
            </td>
        </tr>
         <?php }; ?>
    </table>
    <div class="turnpage" style="margin-top:0px;">
        <?php echo tpl_function_turnpager(Tpl::$_tpl_vars["totalPage"]); ?>
    </div>
    <br><br>

				<?php /*$pager*/?>
</div>
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
</body>
</html>
<script>
    $(function() {
        $(".left_nav_2").click(function () {
            $(".left_nav_3").stop().toggle();
            $(".left_nav_4").stop().toggle();
            $(".left_nav_5").stop().toggle();

        });
//解决跳转bug
        var r = window.location.search;
        r = r.substring(r.indexOf("="), r.indexOf("&") > -1 ? r.indexOf("&") : (r.length + 1));


        if (r == '=1') {

            $(".snav ul li:nth-child(1)").addClass("sel");
            $(".snav ul li:nth-child(1)").siblings().removeClass("sel");
        }
        if (r == '=2') {

            $(".snav ul li:nth-child(3)").addClass("sel");
            $(".snav ul li:nth-child(3)").siblings().removeClass("sel");
        }
        if (r == '=3') {

            $(".snav ul li:nth-child(2)").addClass("sel");
            $(".snav ul li:nth-child(2)").siblings().removeClass("sel");
        }


    });

    function setStatusById(type, obj){
        var uid = $(obj).parents('tr').attr('uid');
        var cid = $(obj).parents('tr').attr('contractId');
        uid = parseInt(uid);
        var data_list = {  };
        data_list[uid] = [];
        data_list[uid].push(cid);
        return type==2? pass(data_list,cid,type): notpass(data_list,cid,type);
    }

    function  pass(check_list,contract_id,type){
        var currentStatus = $("#status").val();
        layer.confirm('您确认进行【通过】吗？', function(id){
            postData = { 'data_list':check_list };
            $.ajax({
                type: "POST",
                url: "/admin.contract.contractset?contract_id="+contract_id+"&type="+type+"&currentStatus="+currentStatus,
                data: postData,
                dataType:"json",
                success: function(msg){
                    if(msg){
                        layer.close(id);
                        location.reload();
                    }
                },
                error: function(){
                    console.log(arguments);
                    console.log(666);
//                    layer.confirm('审核失败', function(id){
//                    });
                }
            });
        });
    }

    function notpass(check_list,contract_id,type){
        var currentStatus = $("#status").val();
        layer.confirm('您确认【拒绝通过】吗？', function(id){
            post_data = { 'data_list':check_list };
            $.ajax({
                type: "POST",
                url: "/admin.contract.contractset?contract_id="+contract_id+"&type="+type+"&currentStatus="+currentStatus,
                data: post_data,
                dataType:"json",
                success: function(msg){
                    if(msg){
                        layer.close(id);
                        location.reload();
                    }
                },
                error: function(){
//                    layer.confirm('审核失败', function(id){
                        console.log(arguments);
                        console.log(555);
                        layer.close(id);
                        location.reload();
//                    });
                }
            });
        });
    }


    function showWindow(url){
        var w = window.open(url,"_blank","toolbar=yes, location=no, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=550, height=650");
//    setTimeout(function(){ w.close()},1000*3);
    }

</script>