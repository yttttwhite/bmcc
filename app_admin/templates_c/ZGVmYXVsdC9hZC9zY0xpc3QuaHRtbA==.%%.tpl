<!DOCTYPE html>
<html>
    <head>
        <?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
    </head>
    <body>
        <?php echo htmlspecialchars(tpl_function_part("/main.main.nav.ad"), ENT_QUOTES); ?>
		<div class="main">
		    <div class="side">
		        <?php echo htmlspecialchars(tpl_function_part(("/ad.plan.listpart.".Tpl::$_tpl_vars["plan_id"].".".Tpl::$_tpl_vars["group_id"])), ENT_QUOTES); ?>
		    </div>
		    <!--mcon-->
		    <div class="mcon">
			    <!--toolbar start-->
			    <div class="toolbar-bc fl" style="margin-bottom:13px;">
			    	<div class="fl sub-title sc-title">
			    		<a href="/baichuan_advertisement_manage/ad.plan.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->plan_id, ENT_QUOTES); ?>" title="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->plan_name, ENT_QUOTES); ?>"><?php echo htmlspecialchars(tpl_modifier_wordbraek(Tpl::$_tpl_vars["plan"]->plan_name), ENT_QUOTES); ?></a>
						<i class="fa fa-angle-double-right"></i>
						<a href="/baichuan_advertisement_manage/ad.group.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->plan_id, ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group"]->group_id, ENT_QUOTES); ?>" title="<?php echo htmlspecialchars(Tpl::$_tpl_vars["group"]->name, ENT_QUOTES); ?>"><?php echo htmlspecialchars(tpl_modifier_wordbraek(Tpl::$_tpl_vars["group"]->name), ENT_QUOTES); ?></a>
						<i class="fa fa-angle-double-right"></i>
						素材
			    	</div>
			    	<div class="fr">
						<a class="btn btn-squared btn-blue" href="/baichuan_advertisement_manage/ad.plan.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>">广告组列表</a>
					    <!--<a class="btn btn-squared btn-blue" href="/baichuan_advertisement_manage/ad.group.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>">素材列表</a>-->
					    <a class="btn btn-squared btn-blue" href="/baichuan_advertisement_manage/ad.group.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>">广告列表</a>
					    <!--<a class="btn btn-squared btn-red" href="/baichuan_advertisement_manage/ad.stuff.addExchangeStuff.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>">添加灵集素材</a>-->
					    <a class="btn btn-squared btn-default" href="/baichuan_advertisement_manage/ad.plan.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>">编辑广告计划</a>
					    <a class="btn btn-squared btn-default" href="/baichuan_advertisement_manage/ad.group.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>">编辑广告组</a>
					    <!--<a class="btn btn-squared btn-default" href="/baichuan_advertisement_manage/ad.stuff.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>">编辑素材</a>-->
					    <a class="btn btn-squared btn-default" href="/baichuan_advertisement_manage/ad.stuff.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>">编辑广告</a>
					</div>
				    <!--<div id="zhuantai" class="selMenu smzt ml10" style="margin:0 10px 0 0;">-->
				        <!--<span class="smtit">素材状态</span>-->
				        <!--<ul>-->
				            <!--<li>-->
				                <!--<a href="javascript:;">素材状态</a>-->
				            <!--</li>-->
				            <!--<li>-->
				                <!--<a href="javascript:;">正常</a>-->
				            <!--</li>-->
				            <!--<li>-->
				                <!--<a href="javascript:;">禁用</a>-->
				            <!--</li>-->
				        <!--</ul>-->
				    <!--</div>-->
				    <div class="tbGroup">
				        <span class="tbgBtn">
				        	<a type="start" class="status-change tbgiba" title="启动">
				        		<i class="fa fa-play"></i>
							</a>
							<a type="stop" class="status-change tbgiba nobr" title="暂停">
				        		<i class="fa fa-pause"></i>
							</a>
							<a type="del" class="status-del tbgiba nobr" title="删除">
				        		<i class="fa fa-trash-o"></i>
							</a>
						</span>
				    </div>
				  	<div style="position:absolute;top:33px;left:33px" id="addr_pre"></div>
			    </div>
			    <!--toolbar end-->
			    <div class="comForm clear" style="margin:0;">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listab fs14 font-size-12 table table-bordered  table-striped table-hover">
						<tr>
							<th width="30" class="center"><input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> class="checkall" type="checkbox" /></th>
							<th width="100">广告ID:素材ID</th>
							 <th width="100">广告位置信息</th>
							<th width="200">素材内容</th>
							<th width="80" style="text-align:center;">素材大小</th>
							<th width="80" class="narrow-hide">名称</th>
                            <?php if(Tpl::$_tpl_vars["plan"]->platform == 1){; ?>
                                <th width="200">素材标题</th>
                            <?php }; ?>
                            <?php if(Tpl::$_tpl_vars["plan"]->platform != 1){; ?>
                            <th width="100" scope="col" width="140px">展示类型<br>位置<br>素材类型</th>
                            <?php }; ?>
							<th width="80">状态</th>
							<th width="80">是否可达</th>
							<th width="80">审核状态</th>
							<th width="120">下载信息</th>
							<?php if(isset(Tpl::$_tpl_vars["_GET"]['more'])){; ?>
								<th width="100">上传时间</th>
								<th width="100">修改时间</th>
								<th width="80" class="tac narrow-hide">总花费数</th>
								<th width="80" class="tac narrow-hide">展现数</th>
								<th width="80" class="tac narrow-hide">点击数</th>
								<th width="80" class="tac narrow-hide">点击率</th>
							<?php }; ?>
							<th width="80" class="tac">操作</th>
						</tr>
						<?php foreach(Tpl::$_tpl_vars["ads"] as Tpl::$_tpl_vars["ad"]){; ?>
							<tr id="tr_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>">
								<td class="center" ><input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> name="" type="checkbox" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" /></td>

								<td class="tac" style="text-align: left !important;">
									<a href="/baichuan_advertisement_manage/ad.preview.entry.<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" target="_blank" title="预览"><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>:<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->stuff_id, ENT_QUOTES); ?></a>
								</td>
								<!-- 广告位置信息 -->
								<td class="center" > 形式：<?php if(Tpl::$_tpl_vars["adpostion"]->first_screen ==1){; ?>首屏<?php }else{; ?>非首屏<?php }; ?><br/>
									素材：<?php if(Tpl::$_tpl_vars["adpostion"]->stuff_type ='pic'){; ?>图片
									<?php }elseif( Tpl::$_tpl_vars["adpostion"]->stuff_type ='video'){; ?>视频
									<?php }elseif( Tpl::$_tpl_vars["adpostion"]->stuff_type ='pictxt'){; ?>图文
									<?php }elseif( Tpl::$_tpl_vars["adpostion"]->stuff_type ='txt'){; ?>文字
									<?php }else{ Tpl::$_tpl_vars["adpostion"]->stuff_type ='others'; ?>其他
									<?php }; ?>
									<br/>
									尺寸：<?php echo htmlspecialchars(Tpl::$_tpl_vars["adpostion"]->width, ENT_QUOTES); ?>*<?php echo htmlspecialchars(Tpl::$_tpl_vars["adpostion"]->height, ENT_QUOTES); ?></td>
								<td>
									<?php if(Tpl::$_tpl_vars["ad"]->stuff->type==2){; ?>
									<embed src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" width="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->width, ENT_QUOTES); ?>" height="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->height, ENT_QUOTES); ?>" style="max-width:180px;max-height:80px"></embed>
									<?php }elseif( Tpl::$_tpl_vars["ad"]->stuff->type==1){; ?>
									<a href="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" target="_blank">
										<img class="addr" style="max-width:180px;max-height:80px" src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" />
									</a>
									<?php }elseif((Tpl::$_tpl_vars["ad"]->stuff->type==6)){; ?>
									<video width="320" controls="controls">
										<source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" type="application/octet-stream" />
										<source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" type="video/x-ms-asf" />
										<source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" type="video/x-mplayer2" />
										<source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" type="video/mp4" />
										<source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" type="video/ogg" />
										<source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" type="video/webm" />
										<object data="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" width="320">
											<embed src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" width="320"/>
										</object>
									</video>
									<?php }elseif((Tpl::$_tpl_vars["ad"]->stuff->type==10)){; ?>
									<video width="320" controls="controls">
										<source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" type="application/octet-stream" />
										<source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" type="video/x-ms-asf" />
										<source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" type="video/x-mplayer2" />
										<source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" type="video/mp4" />
										<source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" type="video/ogg" />
										<source src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" type="video/webm" />
										<object data="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" width="320">
											<embed src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" width="320"/>
										</object>
									</video>
									<?php }else{; ?>
									<textarea readonly style="width:200px;height:100px" name="text[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->text, ENT_QUOTES); ?></textarea>
									<?php }; ?>
								</td>
								<td class="tac">
									<?php if(Tpl::$_tpl_vars["ad"]->stuff->type!=8){; ?>
										<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->width, ENT_QUOTES); ?>*<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->height, ENT_QUOTES); ?><br/>
									<?php }; ?>
								</td>
								<td class="narrow-hide">
									<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adname, ENT_QUOTES); ?>
								</td>
                                <?php if(Tpl::$_tpl_vars["plan"]->platform == 1){; ?>
                                <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->title, ENT_QUOTES); ?></td>
                                <?php }; ?>
                                <?php if(Tpl::$_tpl_vars["plan"]->platform != 1){; ?>
                                <td><?php echo htmlspecialchars(Tpl::$_tpl_vars["viewType"][Tpl::$_tpl_vars["ad"]->view_type], ENT_QUOTES); ?><br><?php echo htmlspecialchars(Tpl::$_tpl_vars["position"][Tpl::$_tpl_vars["ad"]->colum1], ENT_QUOTES); ?><br><?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffType"][Tpl::$_tpl_vars["ad"]->stuff->type], ENT_QUOTES); ?> </td>
                                <?php }; ?>
								<td><?php if(Tpl::$_tpl_vars["ad"]->play_status==1){; ?>正常<?php }else{; ?>无效<?php }; ?></td>
								<td><?php if(Tpl::$_tpl_vars["ad"]->stuff->landing_page_reachable==1){; ?>可达<?php }else{; ?>不可达<?php }; ?></td>
								<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["status"][Tpl::$_tpl_vars["ad"]->stuff->verified_or_not], ENT_QUOTES); ?></td>
								<td>应用类型：<?php if(Tpl::$_tpl_vars["ad"]->stuff->app_type ==0){; ?>Android <?php }else{; ?> IOS <?php }; ?><br/>
									应用包名称：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->packagename, ENT_QUOTES); ?><br/>
									应用名称：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->appname, ENT_QUOTES); ?><br/>
									<?php if(Tpl::$_tpl_vars["ad"]->stuff->app_type ==0){; ?>Android应用介绍URL：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->app_intro_url, ENT_QUOTES); ?><?php }; ?><br/>
									应用大小：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->app_size, ENT_QUOTES); ?><br/>
									应用版本：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->app_ver, ENT_QUOTES); ?><br/>
									<?php if(Tpl::$_tpl_vars["ad"]->stuff->app_type ==0){; ?>appid：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->app_id, ENT_QUOTES); ?> <?php }else{; ?> App Store ID：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->itunesId, ENT_QUOTES); ?><?php }; ?><br/>
								</td>
								<?php if(isset(Tpl::$_tpl_vars["_GET"]['more'])){; ?>
									<td class="tac narrow-hide"><?php echo htmlspecialchars(date("Y-m-d H:i:s",Tpl::$_tpl_vars["ad"]->ctime), ENT_QUOTES); ?></td>
									<td class="tac narrow-hide"><?php echo htmlspecialchars(date("Y-m-d H:i:s",Tpl::$_tpl_vars["ad"]->mtime), ENT_QUOTES); ?></td>
									<td class="tac narrow-hide"><?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["ad"]->report->cost,2,".",","), ENT_QUOTES); ?></td>
									<td class="tac narrow-hide"><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->report->show, ENT_QUOTES); ?></td>
									<td class="tac narrow-hide"><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->report->click, ENT_QUOTES); ?></td>
									<td class="tac narrow-hide"><?php if(!empty(Tpl::$_tpl_vars["ad"]->report->show)){; ?><?php echo htmlspecialchars(round(Tpl::$_tpl_vars["ad"]->report->click*100/Tpl::$_tpl_vars["ad"]->report->show,3), ENT_QUOTES); ?>%<?php }; ?></td>
								<?php }; ?>
								<td class="tac" style="text-align:center;">
									<a class="btn btn-squared btn-xs btn-primary" style="margin-right:0;" href="#tr_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>"  onclick="layerIframeNew('广告：#<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>','/ad.ad.info?aid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>',720,650)">快速操作</a><br>
									<a class="btn btn-squared btn-xs btn-default mt-10" style="margin-right:0;" href="/baichuan_advertisement_manage/ad.ad.info?aid=<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" target="_blank">查看详情</a>
								</td>
							</tr>
						<?php }; ?>
					</table>
				</div>
		  </div>
		</div>
		<div class="clear"></div>
		<script>
	        $(document).ready(function(){
	            $(".status-change").click(function(){
	                var checked = $(".listab input:checkbox:checked[value]");
	                var type = $(this).attr("type");
	                if (checked.size() <= 0) {
	                    alert("请选择");
	                }
	                else {
	                    var planid = [];
	                    checked.each(function(i, item){
	                        planid.push($(item).val());
	                    })
	                    $.ajax({
	                        type: "POST",
	                        url: "/ad.stuff.status." + type,
	                        data: {
	                            adids: planid
	                        },
	                        dataType: "json",
	                        success: function(msg){
	                            location.reload();
	                        },
	                        error: function(XMLHttpRequest, textStatus, errorThrown){
	                            alert(errorThrown);
	                        }
	                    });
	                }
	                return false;
	            });
	            $(".status-del").click(function(){
	                var checked = $(".listab input:checkbox:checked[value]");
	                var type = $(this).attr("type");
	                if (checked.size() <= 0) {
	                    alert("请选择");
	                }
	                else {
	                    var planid = [];
	                    checked.each(function(i, item){
	                        planid.push($(item).val());
	                    })
	                    $.ajax({
	                        type: "POST",
	                        url: "/ad.stuff.del." + type,
	                        data: {
	                            adids: planid
	                        },
	                        dataType: "json",
	                        success: function(msg){
	                            location.reload();
	                        },
	                        error: function(XMLHttpRequest, textStatus, errorThrown){
	                            alert(errorThrown);
	                        }
	                    });
	                }
	                return false;
	            });
	            $(".addr").mouseover(function(){
	                var d = '<img src="' + $(this).attr("src") + '">';
	                var p = ($(this).position());
	                $("#addr_pre").html(d).css({
	                    left: p.left,
	                    top: p.top + $(this).height() + 20
	                }).show();
	            }).mouseout(function(){
	                $("#addr_pre").hide();
	            });
	        });
	    </script>
		<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
	</body>
</html>
