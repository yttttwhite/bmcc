<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?> 
  <script src="/baichuan_advertisement_manage/assets_admin/js/jquery.form.min.js"></script>
  <title>素材列表</title>
  <style type="text/css">
    table th,tr,td {
      text-align: center;text-align: center;
    }
    tr.selected{
      background-color: #ccc;
    }
    table.reportab tr.selected td{
      background-color: #ccc;
    }
    .font-po{
      margin:0 4px;
    }
  </style>
  <link rel="stylesheet" href="/baichuan_advertisement_manage/assets_admin/v5/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
  <script src="/baichuan_advertisement_manage/assets_admin/v5/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
</head> 
<body>
<div class="main">
  <div class="panel panel-white" style="border:1px solid #EEEEEE;">
    <div class="panel-heading border-light panel-head-md">
      <form method="get">
        <div class="fl">
          <input type="text"  placeholder="素材名称" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['stuff_name'], ENT_QUOTES); ?>" class="form-control ml-10 input-small" name="stuff_name" value="">
        </div>
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
              <th>审核状态</th>
              <th>创建者</th>
              <th>创建时间</th>
              <!--<th>审核管理</th>-->
          </tr>
          </thead>
          <tbody>
          <?php foreach(Tpl::$_tpl_vars["stuff_lib_list"] as Tpl::$_tpl_vars["_stuff"]){; ?>
          <tr item_id ="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->stuff_id, ENT_QUOTES); ?>" item_name="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->name, ENT_QUOTES); ?>" item_type="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->type, ENT_QUOTES); ?>" item_addr="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->addr, ENT_QUOTES); ?>"
             item_wh="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->width, ENT_QUOTES); ?>*<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->height, ENT_QUOTES); ?>" item_uid="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_stuff"]->uid, ENT_QUOTES); ?>">

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

          </tr>

          <?php }; ?>

          </tbody>
      </table>
        <div class="turnpage">
        </div>

    </div>
  </div>  
  </div>  
</div>
</body>
<script>
  function getSelected(){
    var $table = $('.reportab'),$tr = $table.find('tr.selected');
    var data = null;
    if($tr.length > 0) {
      data = new Object();
      data.id = $tr.attr("item_id");
      data.name = $tr.attr("item_name");
      data.type = $tr.attr("item_type");
      data.addr = $tr.attr("item_addr");
      data.wh = $tr.attr("item_wh");
      data.uid = $tr.attr("item_uid");
    }
    return data
  }
  $(document).ready(function(){
    var $table = $('.reportab')
    $table.on('click', 'tr', function(e){
      var ev = e || window.event,$this = $(this);
      ev.stopPropagation();
      $this.siblings().removeClass('selected');
      if($this.hasClass("selected"))$this.removeClass("selected");
      else $this.addClass("selected")
    })
    
  })
  
</script>
</html>
