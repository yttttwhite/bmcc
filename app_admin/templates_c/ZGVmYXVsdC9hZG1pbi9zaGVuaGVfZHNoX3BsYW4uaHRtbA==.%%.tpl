<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="/baichuan_advertisement_manage/assets_admin/contractManagement_list.css" />
<head>
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
</head>

<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.admin"), ENT_QUOTES); ?>

<!--main-->
<div class="main">
  <!--side-->
  <div class="side">
  <?php echo htmlspecialchars(tpl_function_part(("/admin.main.nav.plan")), ENT_QUOTES); ?>
  </div>

  <!--mcon start-->
  <div class="mcon">
      <div class="toolbar-bc fl mb-10">
        <div class="fl sub-title  sc-title">
            <a href="javascript: void(0)">广告审核 </a>
            <i class="fa fa-angle-double-right" ></i>
            <a href="/baichuan_advertisement_manage/admin.shenhe.plan?nav=4">广告计划审核</a>
        </div>
    </div>
    <div class="clear"></div>

      <!--<form class="search" style="margin-left:265px;position: relative">-->
      <form class="search" style="margin-left:15px;width:90%;">
          <input name="nav" type="hidden" value="7">
          <input name="type" id="status" type="hidden" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['type'], ENT_QUOTES); ?>">
          <input name="ad_user_name" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['ad_user_name'], ENT_QUOTES); ?>" class="search_1" type="text"  placeholder="--请输入广告主名称--">
          <input name="plan_name" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['plan_name'], ENT_QUOTES); ?>" class="search_2" type="text"  placeholder="--请输入广告计划名称--">
          <input class="btn btn-squared btn-sm btn-success ml-10" type="submit" value="查询" style="display: inline-block;">
          <span style="line-height:28px; position: relative; left: 20px;">共计：<?php echo htmlspecialchars(Tpl::$_tpl_vars["total"], ENT_QUOTES); ?>条</span>
      </form>

    <!--toolbar start-->
    <div class="toolbar-45" style="display: none;">
       <span class="sbtnb"><a class="ibtnb" >通过</a></span>
       <span class="sbtng ml10"><a class="ibtng">拒绝</a></span>
      <div class="clear"></div>
    </div>

      <div class="infoTable" style="height: auto;margin-bottom:100px;" >
       <table class="table table-striped table-bordered table-hover">
      <tr>
        <!--<th><input class="checkall" type="checkbox"/></th>-->
        <th>ID</th>
        <th>广告主</th>
        <th>广告计划</th>
        <th>投放类型</th>
        <th>有效期</th>
        <!--<th>分类名</th>-->
        <th>设置优先级</th>
        <th>设置点击率</th>
        <th>状态</th>
        <th>审核状态</th>
		<th>最后修改</th>
        <th style="width: 130px;">操作</th>
      </tr>
<?php foreach(Tpl::$_tpl_vars["plans"] as Tpl::$_tpl_vars["_plan"]){; ?>
      <tr planid="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>" uid="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->uid, ENT_QUOTES); ?>">
        <!--<td><input class="plan_ids" type="checkbox" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>" /></td>-->
		<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?></td>
        <td>
        	<!--<a href="/baichuan_advertisement_manage/ad.plan?status=0&uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->bind_id, ENT_QUOTES); ?>" target="_blank">-->
        	<a onclick='showWindow("/admin.user.detail?uid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->bind_id, ENT_QUOTES); ?>")' target="_blank">
			<?php echo htmlspecialchars(Tpl::$_tpl_vars["adSopnsorArray"][Tpl::$_tpl_vars["_plan"]->bind_id], ENT_QUOTES); ?>
			</a>
			<br>
			<span style="color:#666666;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["adSopnsorList"][Tpl::$_tpl_vars["_plan"]->uid]->host, ENT_QUOTES); ?></span>
        </td>
        <td style="max-width: 200px;word-break: break-all;word-break: break-word;">
        	<!--<a href="ad.plan.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>" target="_blank">-->
        	<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_name, ENT_QUOTES); ?>
        	</a>
        </td>
        <td><?php if(Tpl::$_tpl_vars["_plan"]->billing_type==2){; ?>CPM<?php }elseif( Tpl::$_tpl_vars["_plan"]->billing_type==4){; ?>CPT<?php }; ?></td>
        <td><?php if(empty(Tpl::$_tpl_vars["_plan"]->start_date)){; ?>未设置<?php }else{; ?><?php echo htmlspecialchars(date("Y-m-d",Tpl::$_tpl_vars["_plan"]->start_date), ENT_QUOTES); ?><?php }; ?> - <?php if(empty(Tpl::$_tpl_vars["_plan"]->end_date)){; ?>未设置<?php }else{; ?><?php echo htmlspecialchars(date("Y-m-d",Tpl::$_tpl_vars["_plan"]->end_date), ENT_QUOTES); ?><?php }; ?></td>
        <!--<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->type_name, ENT_QUOTES); ?></td>-->
        <td>
<select name="release_type" onchange="changePlanRelease(this, <?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>);">
    <option <?php if(Tpl::$_tpl_vars["_plan"]->release_type==10){; ?>selected<?php }; ?> value="10">0级</option>
    <option <?php if(Tpl::$_tpl_vars["_plan"]->release_type==20){; ?>selected<?php }; ?> value="20">1级</option>
    <option <?php if(Tpl::$_tpl_vars["_plan"]->release_type==30){; ?>selected<?php }; ?> value="30">2级</option>
    <option <?php if(Tpl::$_tpl_vars["_plan"]->release_type==40){; ?>selected<?php }; ?> value="40">3级</option>
    <option <?php if(Tpl::$_tpl_vars["_plan"]->release_type==100){; ?>selected<?php }; ?> value="100">4级</option>
    <option <?php if(Tpl::$_tpl_vars["_plan"]->release_type==101){; ?>selected<?php }; ?> value="101">5级</option>
</select>

        </td>
        <td style="position:relative;width:90px;">
            <?php if(Tpl::$_tpl_vars["_plan"]->ctr_click_rate ==100){; ?>
            <span data-target="button">-- <a>设置</a></span>
            <input data-target="input" style="display:none;position:absolute;width:55px;height:22px;top:8px;left:7px;" name="ctr_click_rate" onchange="changePlanClickRate(this);" value="99.99" min="0.01" step="0.01" max="100" type="number"  <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?>/>
            <span  data-target="input" style="display:none;position:absolute;left:64px;top:10px;">%</span>
            <!--<span id="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>_noSet">未设置</span>-->
            <!--<a id="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>_setClickRate" onclick="setClickRate(1,<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>);">设置点击率</a>-->
            <!--<input style="position:absolute;width:55px;height:22px;top:8px;left:7px;display: none;"  id="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>_min_rate" name="ctr_click_rate" onchange="changePlanClickRate(this,<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>);" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->ctr_click_rate, ENT_QUOTES); ?>" min="0.01" step="0.01" max="100" type="number"  <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?>/>-->
            <!--<span id="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>_rate" style="position:absolute;left:64px;top:10px;display: none;">&#45;&#45;</span>-->
            <?php }else{; ?>
            <span data-target="button" style="display: none;">-- <a>设置</a></span>
            <input data-target="input" style="position:absolute;width:55px;height:22px;top:8px;left:7px;" name="ctr_click_rate" onchange="changePlanClickRate(this,<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>);" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->ctr_click_rate, ENT_QUOTES); ?>" min="0.01" step="0.01" max="100" type="number"  <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?>/>
            <span data-target="input" style="position:absolute;left:64px;top:10px;">%</span>
            <?php }; ?>
        </td>
        <td style="width: 45px;"><?php if(Tpl::$_tpl_vars["_plan"]->enable==1){; ?>正常<?php }elseif( Tpl::$_tpl_vars["_plan"]->enable==2){; ?>无效<?php }elseif( Tpl::$_tpl_vars["_plan"]->enable==3){; ?>过期<?php }elseif( Tpl::$_tpl_vars["_plan"]->enable==4){; ?>删除<?php }elseif( Tpl::$_tpl_vars["_plan"]->enable==5){; ?>冻结<?php }elseif( Tpl::$_tpl_vars["_plan"]->enable==6){; ?>预算暂停<?php }; ?></td>
        <td><?php if(Tpl::$_tpl_vars["_plan"]->verified_or_not==1){; ?>待审<?php }elseif( Tpl::$_tpl_vars["_plan"]->verified_or_not==2){; ?>通过<?php }elseif( Tpl::$_tpl_vars["_plan"]->verified_or_not==3){; ?>未通过<?php }; ?></td>
		<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->last_operator, ENT_QUOTES); ?></td>
      	<td>
      		<?php if(user_api::auth("shenhe")){; ?>
      			<?php if(Tpl::$_tpl_vars["currentStatus"] == 1 or Tpl::$_tpl_vars["currentStatus"] == 3){; ?>
      				<a href="javascript:void(0)" onclick="setStatusById(2, this)">通过</a>
      			<?php }; ?>
      			<?php if(Tpl::$_tpl_vars["currentStatus"] == 1 or Tpl::$_tpl_vars["currentStatus"] == 2){; ?>
      				<a href="javascript:void(0)" onclick="setStatusById(3, this)">拒绝</a>
      			<?php }; ?>
      		<?php }; ?>
            <a onclick='showWindow("/admin.shenhe.detail?plan_id=<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>&type=<?php echo htmlspecialchars(Tpl::$_tpl_vars["currentStatus"], ENT_QUOTES); ?>")'>
                查看详情
            </a>
      	</td>
      </tr>
<?php }; ?>
    </table>
          <div class="turnpage" style="margin-top:0px;">
              <?php echo tpl_function_turnpager(Tpl::$_tpl_vars["totalPage"]); ?>
          </div>
</div>


  </div>
  <!--mcon end-->

</div>
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
<script>


    function changePlanRelease(el,id) {
       var tr_tag = $(el).parents('tr');
       var pid = tr_tag.attr('planid');
       var uid = tr_tag.attr('uid');
      var data_list = [];
      data_list[uid] = [pid];

      $.ajax({
        type: 'post',
         url: '/admin.shenhe.prioritySet',
        data: {
          data_list: data_list,
          priority: $(el).val()
        },
        success: function(rep) {
          if(rep=='1'){
            return layer.msg('修改成功');
          }
          layer.msg(rep);
        },
        error: function(err){
          layer.msg('修改失败');
        }
      })
    }
    function changePlanClickRate(el,id) {
         var tr_tag = $(el).parents('tr');
         var pid = tr_tag.attr('planid');
         var uid = tr_tag.attr('uid');
         var data_list = [];
        data_list[uid] = [pid];

        $.ajax({
          type: 'post',
           url: '/admin.shenhe.clickrateSet',
          data: {
            data_list: data_list,
            clickrate: $(el).val()
          },
          success: function(rep) {
            if(rep=='1'){
            	if($(el).val()=="100"){
            		$(el).hide();
            		$(el).siblings("[data-target=input]").hide();
            		$(el).siblings("[data-target=button]").show();
            	}
              return layer.msg('修改成功');
            }
            layer.msg(rep);
          },
          error: function(err){
            layer.msg('修改失败');
          }
        })
      }

/***********/
	$("[data-target=button] a").on("click",function(e){
		if(e.stopPropagation)e.stopPropagation();
		$(this).parent().hide();
		$(this).parent().siblings("input").val(99.99);
		$(this).parent().siblings().show();
	});

/***********/

    $(".ibtnb").click(function(){
      var aList = getChecked();
      if($.isEmptyObject(aList)) return false;
      ibtnb(aList, true);
    });
    $(".ibtng").click(function(){
      var aList = getChecked();
      if($.isEmptyObject(aList)) return false;
      ibtng(aList);
    });



    $(".checkall").change(function(){
      var ck=$(this).prop("checked");
      $(this).parents("table").find("input:checkbox").prop("checked",ck);
    });

    function genSet(type, checke_list, ext){
        if(!checke_list) return;
        postData = { 'data_list':checke_list };
        var currentStatus = $("#status").val();
        if(ext){ $.extend(postData,ext) }
        $.ajax({
          type: "post",
          url: "/admin.shenhe.planSet?type="+type+"&currentStatus="+currentStatus,
            data: postData,
            dataType:"json",
          success: function(msg){
            location.reload();
          },
          error: function(){
            console.log('设置审核状态失败');
              location.reload();
          }
        });
    }

    var ibtnb = function(aList,batch){
      if(batch){
        layer.confirm('您确认批量进行【通过】吗？', function(id){
          genSet(2, aList);
          layer.close(id);
        });
      }else{
        layer.confirm('您确认【通过】广告审核？', function(id){
          genSet(2, aList);
          layer.close(id);
        });

        // $.layer({
        //   type: 1,
        //   // area: ['500px', '180px'],
        //   area: ['300px', '180px'],
        //   title: '设置投放优先级，并审核通过',
        //   btns: 2,
        //   btn:['确定','取消'],
        //   page: {
        //     html: '<div id="layer-release-type" style="padding: 20px 40px"><span>设置投放优先级别：</span> <select name="release_type"> <option value="10">品牌广告</option> <option selected value="20">普通</option> <option value="10">财经类</option> <option value="40">游戏类</option> <option value="50">长尾广告</option> <option value="100">其他类</option> <option value="101">内部支撑</option> </select> <br/> <br> <span>请确认设置该广告优先级，并确认通过该广告的审核吗？</span></div>'
        //   },
        //   yes: function(id){
        //     var res = $("#xubox_layer"+id).find("select[name='release_type']").val();
        //     console.debug(res);
        //     genSet(2, aList, { priority: res});
        //     layer.close(id);
        //   }
        // });
      }


    }
    var ibtng = function(aList){
      layer.confirm('您确认【拒绝】广告审核？', function(id){
        genSet(3, aList);
        layer.close(id);
      });
    }

    function setStatusById(type, obj){
      var uid = $(obj).parents('tr').attr('uid');
      var pid = $(obj).parents('tr').attr('planid');
      uid = parseInt(uid);
      var data_list = {  };
      data_list[uid] = [];
      data_list[uid].push(pid);
      return type==2? ibtnb(data_list,false): ibtng(data_list);
	 }
    function getChecked(){
      var checked = $(".reportab input:checkbox:checked[value]");
      if(checked.size()<=0){
        alert("请选择");
        return [];
      }else{
         var data_list = { };
         var pid, uid, tr_tag;
         checked.each(function(i,item){
           tr_tag = $(this).parents('tr');
           pid = tr_tag.attr('planid');
           uid = tr_tag.attr('uid');
           if(!data_list.hasOwnProperty(uid)){
              data_list[uid] = [];
           }
           data_list[uid].push(pid);
         });
       }
       return data_list;
    }

    function showWindow(url){
        var w = window.open(url,"_blank","toolbar=yes, location=no, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=550, height=650");
//    setTimeout(function(){ w.close()},1000*3);
    }

    function setClickRate(status,planId){
        if(status ==1){
             $("#"+planId+"_setClickRate").hide();
            $("#"+planId+"_min_rate").show();
            $("#"+planId+"_rate").show();
        }
    }




</script>
</body>
</html>
