<head>
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
<style>
    .msg-tr { font-size:12px; color: black; font-family:"Arial","Microsoft YaHei","黑体","宋体",sans-serif}
    .label-type { font-size:12px; font-weight:600px; }
</style>
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.ad"), ENT_QUOTES); ?>
<!--main-->

<div class="main">
  <div>
        <div class="block">
            <div id="user-info" class="panel panel-white panel-squared">
                <div class="panel-heading border-light">
                    <h4 class="panel-title">筛选</h4>
                </div>
                <div class="panel-body">
                    <form action="/baichuan_advertisement_manage/message" method="get">
                        <div class="form-group">
                            <label class="col-sm-1"><input type="radio"  name="msg_status" value="1" <?php if(Tpl::$_tpl_vars["status"] ==1){; ?>checked="checked"<?php }; ?>>未读</label>
                            <label class="col-sm-1"><input type="radio"  name="msg_status" value="0" <?php if(Tpl::$_tpl_vars["status"] ==0){; ?>checked="checked"<?php }; ?>>已读</label>
                            <label class="col-sm-1"><input type="radio"  name="msg_status" value="3" <?php if(Tpl::$_tpl_vars["status"] ==3){; ?>checked="checked"<?php }; ?>>全部</label>
                            <label class="col-sm-1"><input class="btn btn-success btn-squared" type="submit" value="查询"></label>
                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-striped table-hover table-bordered table-responsive">
                <thead>
                    <tr>
                        <th style="text-align:center;" >序号</th>
                        <th style="text-align:center;" >标题</th>
                        <th style="text-align:center;" >内容</th>
                        <th style="text-align:center;" >发送时间</th>
                        <th style="text-align:center;" >状态</th>
                        <th style="text-align:center;" >操作</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr style="background-color: #EEEEEE; font-weight: bold; display: none">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach(Tpl::$_tpl_vars["list"] as Tpl::$_tpl_vars["index"] => Tpl::$_tpl_vars["item"]){; ?>
                    <tr class="msg-tr">
                        <td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["index"] + 1, ENT_QUOTES); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]['title'], ENT_QUOTES); ?></td>
                        <td style="text-align:left; max-width:400px;" ><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]['content'], ENT_QUOTES); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars(date('Y-m-d H:i:s',Tpl::$_tpl_vars["item"]['send_time']), ENT_QUOTES); ?></td>
                        <td style="text-align:center;">
                            <?php if(Tpl::$_tpl_vars["item"]['msg_status'] == 0){; ?>
                                已读
                            <?php }else{; ?>
                                未读
                            <?php }; ?>
                        </td>
                        <td style="text-align:center;">
                            <?php if(Tpl::$_tpl_vars["item"]['msg_status'] == 1){; ?>
                                    <span class="btn btn-xs btn-primary" onclick="setMsg(<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]['msg_id'], ENT_QUOTES); ?>, 0, this)">标为已读</span>
                                <?php }else{; ?>
                                    <span class="btn btn-xs btn-info mr-10" onclick="setMsg(<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]['msg_id'], ENT_QUOTES); ?>, 1, this)">标为未读</span>
                            <?php }; ?>
                            <span class="btn btn-xs btn-warning mr-10" onclick="setMsg(<?php echo htmlspecialchars(Tpl::$_tpl_vars["item"]['msg_id'], ENT_QUOTES); ?>, 2, this)">删除</span>
                        </td>
                    </tr>
                    <?php }; ?>
                    
                </tbody>
            </table>
            <div class="turnpage">
                <a href="?&page=1"><em>&lt;</em> 首页</a>
                <?php for(Tpl::$_tpl_vars["p"]=1; Tpl::$_tpl_vars["totalPage"] >= Tpl::$_tpl_vars["p"] ;Tpl::$_tpl_vars["p"]++){; ?>
                <a href="?&page=<?php echo htmlspecialchars(Tpl::$_tpl_vars["p"], ENT_QUOTES); ?>" class="<?php if(Tpl::$_tpl_vars["p"]==Tpl::$_tpl_vars["page"]){; ?>sel<?php }; ?>"><em><b><?php echo htmlspecialchars(Tpl::$_tpl_vars["p"], ENT_QUOTES); ?></b></em></a>
                <?php }; ?>

                <a href="?&page=<?php echo htmlspecialchars(Tpl::$_tpl_vars["totalPage"], ENT_QUOTES); ?>">末页<em> &gt;</em></a>
            </div>
        </div>
  </div>
</div>
<script>
 function setMsg(msg_id, msg_status, obj) {
    $.ajax({
          type: "GET", 
          url: "/baichuan_advertisement_manage/message.main.msgset", 
          data: { 'msg_id':msg_id, 'msg_status':msg_status}, 
          dataType:"json",
          success: function(msg){ 
            var parent = $(obj).parents('tr');
            parent.remove();
          }
    });
 }
</script>
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>


</body>