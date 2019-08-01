<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?> 
  <script src="/baichuan_advertisement_manage/assets_admin/js/jquery.form.min.js"></script>
  <title>素材审核</title>
  <style type="text/css">
    table th,tr,td {
      text-align: center;text-align: center;
    }
    .font-po{
      margin:0 4px;
    }
  </style>
  <link rel="stylesheet" href="/baichuan_advertisement_manage/assets_admin/v5/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
  <script src="/baichuan_advertisement_manage/assets_admin/v5/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.ad"), ENT_QUOTES); ?>
<div class="main">
  <div class="side">
    <script type="text/javascript">
      $(document).ready(function(){
          $(".accordion h3[current=active]").addClass("active");
      });
    </script>
    <div class="accordion" style="margin-top:0;">
      <h2>素材库</h2>
      <h3 class="bort ">
        <a href="/baichuan_advertisement_manage/ad.stufflibrary.List?nav=8"><b>素材列表</b></a>
      </h3>
      <h3 class="bort" current="active">
        <a href="/baichuan_advertisement_manage/ad.stufflibrary.AuditedList?type=1&nav=8"><b>素材审核</b></a>
      </h3>
    </div>
  </div>
  <div class="mcon">
    <div class="toolbar-bc mb-10">
      <div class="fl sub-title sc-title">
         <a href="/baichuan_advertisement_manage/ad.stufflibrary.AuditedList?type=1&nav=8"> 素材库</a><i class="font-po fa fa-angle-double-right"></i><span>素材审核</span>
      </div>
      <div class="clear"></div>
    </div>
<!--搜索 start-->
  <div class="panel panel-white" style="border:1px solid #EEEEEE;">
    <div class="panel-heading border-light panel-head-md">
      <form method="get">
        <div class="fl">
          <select  name="audit_status" style="max-width: 130px;" class="input-small">
              <option value="">--审核状态--</option>
              <option <?php if(Tpl::$_tpl_vars["status"]==1){; ?>selected<?php }; ?> value="1">待审核</option>
              <option <?php if(Tpl::$_tpl_vars["status"]==2){; ?>selected<?php }; ?> value="2">通过</option>
              <option <?php if(Tpl::$_tpl_vars["status"]==3){; ?>selected<?php }; ?> value="3">不通过</option>
          </select>
        </div>
        <div class="fl">
          <input   type="text"  placeholder="素材名称" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['stuff_name'], ENT_QUOTES); ?>" class="form-control ml-10 input-small" name="stuff_name" value="">
        </div>
          <input type="hidden" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['nav'], ENT_QUOTES); ?>" name="nav">
        <div class="fl">
          <input class="btn btn-squared btn-sm btn-success ml-20" type="submit" value="查询" style="display: inline-block;margin-right: 15px;">
        </div>
        <span style="line-height:28px; position: relative; left: 20px;">共计：<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["total"],0), ENT_QUOTES); ?>条</span>
      </form>
    </div>


<!--搜索 end-->
    <div class="panel-body" style="overflow-x: auto;">
      <table class="reportab" width="100%" border="0" cellspacing="0" cellpadding="0">
          <thead>
          <tr>
              <th>ID</th>
              <th>素材名称</th>
              <th>素材内容</th>
              <th>素材类型</th>
              <th>素材尺寸</th>
              <th>本平台审核状态</th>
              <th>创建者</th>
              <th>提交时间</th>
              <!--<th>审核管理</th>-->
              <th>操作</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach(Tpl::$_tpl_vars["stuff_lib_list"] as Tpl::$_tpl_vars["_stuff"]){; ?>
          <tr stuffid="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->stuff_id, ENT_QUOTES); ?>", uid="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->uid, ENT_QUOTES); ?>" >
              <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->stuff_id, ENT_QUOTES); ?></td>
              <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->name, ENT_QUOTES); ?></td>
              <td>
                  <?php if(Tpl::$_tpl_vars["_stuff"]->type==2){; ?>
                  <embed src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" width="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->width, ENT_QUOTES); ?>" height="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->height, ENT_QUOTES); ?>" style="max-width:180px;max-height:80px"></embed>
                  <?php }elseif( Tpl::$_tpl_vars["_stuff"]->type==1){; ?>
                  <a href="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" target="_blank">
                      <img class="addr" style="max-width:180px;max-height:80px" src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" />
                  </a>
                  <?php }elseif((Tpl::$_tpl_vars["_stuff"]->type==6)){; ?>
                  <video width="320" controls="controls">
                      <source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" type="application/octet-stream" />
                      <source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" type="video/x-ms-asf" />
                      <source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" type="video/x-mplayer2" />
                      <source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" type="video/mp4" />
                      <source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" type="video/ogg" />
                      <source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" type="video/webm" />
                      <object data="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" width="320">
                          <embed src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" width="320"/>
                      </object>
                  </video>
                  <?php }elseif((Tpl::$_tpl_vars["_stuff"]->type ==10)){; ?>
                  <video width="320" controls="controls">
                      <source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" type="application/octet-stream" />
                      <source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" type="video/x-ms-asf" />
                      <source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" type="video/x-mplayer2" />
                      <source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" type="video/mp4" />
                      <source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" type="video/ogg" />
                      <source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" type="video/webm" />
                      <object data="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" width="320">
                          <embed src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>" width="320"/>
                      </object>
                  </video>
                  <?php }else{; ?>
                  <textarea readonly style="width:200px;height:100px" name="text[<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->adid, ENT_QUOTES); ?>]"><?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->text, ENT_QUOTES); ?></textarea>
                  <?php }; ?>
              </td>

              <td><?php if(Tpl::$_tpl_vars["_stuff"]->type==1){; ?>
                  图片
                  <?php }elseif((Tpl::$_tpl_vars["_stuff"]->type==2)){; ?>
                  Flash
                  <?php }elseif((Tpl::$_tpl_vars["_stuff"]->type==3)){; ?>
                  文字
                  <?php }elseif((Tpl::$_tpl_vars["_stuff"]->type==6)){; ?>
                  视频
                  <?php }else{; ?>
                  其它
                  <?php }; ?>
              </td>
              <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->width, ENT_QUOTES); ?>*<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->height, ENT_QUOTES); ?></td>
              <td><?php if(Tpl::$_tpl_vars["_stuff"]->verified_or_not ==1){; ?>待审
                  <?php }elseif( Tpl::$_tpl_vars["_stuff"]->verified_or_not ==2){; ?>通过
                  <?php }elseif( Tpl::$_tpl_vars["_stuff"]->verified_or_not ==3){; ?>未通过
                  <?php }; ?></td>
              <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["adSopnsorArray"][Tpl::$_tpl_vars["_stuff"]->uid], ENT_QUOTES); ?></td>
              <td><?php if(empty(Tpl::$_tpl_vars["_stuff"]->ctime)){; ?>未设置
                  <?php }else{; ?><?php echo htmlspecialchars(date("Y-m-d H:i:s",Tpl::$_tpl_vars["_stuff"]->ctime), ENT_QUOTES); ?>
                  <?php }; ?>
              </td>

              <td>
                  <a onclick="showWindow(<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->stuff_id, ENT_QUOTES); ?>)">查看详情</a>
                  <?php if(Tpl::$_tpl_vars["_stuff"]->verified_or_not ==1){; ?>
                  <a href="javascript:void(0)" onclick="setStatusById(2, this)">通过</a>
                  <a href="javascript:void(0)" onclick="setStatusById(3, this)">拒绝</a>
                  <?php }; ?>
              </td>
          </tr>
          <?php }; ?>

          </tbody>
      </table>
        <div class="turnpage">
            <?php echo tpl_function_turnpager(Tpl::$_tpl_vars["totalPage"]); ?>
        </div>

    </div>
  </div>  
  </div>  
</div>
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
</body>
<script>
  function showWindow(id){
        var w = window.open("baichuan_advertisement_manage/ad.stufflibrary.GetOne?stuff_id=" + id,"_blank","toolbar=yes, location=no, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=550, height=650");
    }

  $(".ibtnb").click(function(){
      var aList = getChecked();
      if($.isEmptyObject(aList)) return;
      ibtnb(aList);
  });
  $(".ibtng").click(function(){
      var aList = getChecked();
      if($.isEmptyObject(aList)) return;
      ibtng(aList);
  });

  $(".checkall").change(function(){
      var ck=$(this).prop("checked");
      $(this).parents("table").find("input:checkbox").prop("checked",ck);
  });

  function genSet(type, checke_list){
      $.ajax({
          type: "POST",
          url: "/ad.stufflibrary.UpdateStatus?type="+type,
          data: { 'data_list':checke_list },
          dataType:"json",
          success: function(data){
              layer.msg(data.msg);
              console.log('设置审核状态成功');
              location.reload();
          },
          error: function(){
              layer.msg("设置审核状态失败");
              location.reload();
          }
      });
  }

  var ibtnb = function(aList){
      layer.confirm('您确认【通过】素材审核？', function(){
          genSet(2, aList);
      });
  }
  var ibtng = function(aList){
      layer.confirm('您确认【拒绝】素材审核？', function(){
          genSet(3, aList);
      });
  }

  function setStatusById(type, obj){
      var uid = $(obj).parents('tr').attr('uid');
      var sid = $(obj).parents('tr').attr('stuffid');
      uid = parseInt(uid);
      var data_list = {  };
      data_list[uid] = [];
      data_list[uid].push(sid);
      return type==2? ibtnb(data_list): ibtng(data_list);
  }
  function getChecked(){
      var checked = $(".reportab input:checkbox:checked[value]");
      if(checked.size()<=0){
          alert("请选择");
          return [];
      }else{
          var data_list = { };
          var sid, uid, tr_tag;
          checked.each(function(i,item){
              tr_tag = $(this).parents('tr');
              sid = tr_tag.attr('stuffid');
              uid = tr_tag.attr('uid');
              if(!data_list.hasOwnProperty(uid)){
                  data_list[uid] = [];
              }
              data_list[uid].push(sid);
          });
      }
      return data_list;
  }
  $(".addr").mouseover(function(){
      var d='<img src="'+$(this).attr("src")+'">';
      var p=($(this).position());
      $("#addr_pre").html(d).css({ left:p.left,top:p.top+$(this).height()+20}).show();
  }).mouseout(function(){
      $("#addr_pre").hide();
  });

</script>
</html>
