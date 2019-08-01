<div id="pdomain_{$command_name}" class="popdiv pop_domain" style="display:block">
<form method="post" action="/dpc.main.add.{$collection}">
  <div class="dbg">
     <div class="pmain">
        <div class="ptit">
            <div class="ptname">{$command_name}</div>
            <div class="ptclose">
                <a id="btnClose{$command_name}" href="javascript:;" onClick="closeDiv('pdomain_{$command_name}')"> <img src="/baichuan_advertisement_manage/assets_dpc/img/i_close.png" alt="关闭"> </a>
            </div>
        </div>
        <div class="comForm clear">
            <div><h2>投放频次</h2></div>
            <div>
                <dl>
                    <dt>广告类型选择</dt>
                    <dd><select id="ad_type" name="ad_type">
                            <option {if $ad_max_success_push_arr[0] !='0'}selected="selected"{/if} value="1">背投浮窗</option>
                            {*<option {if $super_pop_under[0]['ad_type']=='2'}selected="selected"{/if} value="2">暗投</option>*}
                            <option value="3">重定向</option>
                        </select>
                    </dd>
                </dl>
                <dl>
                    <dt>最大投放次数</dt>
                    <dd><input type="hidden" id="collection" name="collection" value="{$collection}"></dd>
                    <dd><input type="hidden" id="command_name" name="command_name" value="{$command_name}"></dd>
                    <dd><input class="itxt" type="text" name="success_maxtimes" value="{$ad_max_success_push_arr[0]['keyword']}"></dd>
                </dl>
                <dl>
                    <dt>定义成功投放间隔秒单位(秒)</dt>
                    <dd><input class="itxt" type="text" name="succeed_interval" value="{$ad_max_success_push_arr[0]['value']}"></dd>
                </dl>
                <dl>
                    <dt>最大投放失败次数</dt>
                    <dd><input class="itxt" type="text" name="fail_maxtimes" value="{$ad_max_fail_push_arr[0]['keyword']}"></dd>
                </dl>
                <dl>
                    <dt>定义失败投放间隔秒单位(秒)</dt>
                    <dd><input class="itxt" type="text" name="fail_interval" value="{$ad_max_fail_push_arr[0]['value']}"></dd>
                </dl>
            </div>
            <div class="dpbtn">
                <div class="fr">
                    <span class="sbtnb m130">
                        <input class="ibtnb" type="submit" value="保存" />
                    </span>
                    <span class="sbtng m115">
                        <input class="ibtng" type="button" value="取消" onClick="closeDiv('pdomain_{$command_name}')"/>
                    </span>
                </div>
            </div>

        </div>
     
     </div>
   </div>
 </form>
<script type="text/javascript">
    $("#ad_type").change(function(){
        var ad_type=$(this).val();
            command_name=$("#command_name").val();
            collection=$("#collection").val();
        $.getJSON("/dpc.main.getAreaPushInterval?collection="+collection+"&command_name="+command_name+"&ad_type="+ad_type,
            function(data){
                var sm="";
                var si="";
                var fm="";
                var fi="";
                if(!data[0]){
                    sm="";
                    si="";
                    fm="";
                    fi="";
                }else{
                    sm=data[0][0].keyword;
                    si=data[0][0].value;
                    fm=data[1][0].keyword;
                    fi=data[1][0].value;
                }
                $("input[name='success_maxtimes']").val(sm);
                $("input[name='succeed_interval']").val(si);
                $("input[name='fail_maxtimes']").val(fm);
                $("input[name='fail_interval']").val(fi);
        });
                
    });
</script>
</div>
